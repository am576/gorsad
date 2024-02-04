<?php


namespace App\Utils;


use App\AttributesGroup;
use App\Image;
use App\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as InterventionImage;

class StaticTools
{
    public static function literalOrderDate($order_date)
    {
        $months_names = [
            '01' => 'января',
            '02' => 'февраля',
            '03' => 'марта',
            '04' => 'апреля',
            '05' => 'мая',
            '06' => 'июня',
            '07' => 'июля',
            '08' => 'августа',
            '09' => 'сентября',
            '10' => 'октября',
            '11' => 'ноября',
            '12' => 'декабря',
        ];

        return date('d', strtotime($order_date)) . ' ' . $months_names[date('m', strtotime($order_date))] . ' ' . date('Y', strtotime($order_date)) . ' г.';
    }

    public static function saveImages($images, Model $object, string $subfolder)
    {
        if(isset($images))
        {
            foreach ($images as $index => $file) {
                $fullname = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $filename = str_replace(' ', '_', $fullname);
                $icon_path =  $file->storeAs($subfolder, $filename . '_icon.' . $file->getClientOriginalExtension(), 'images');
                $small_path = $file->storeAs($subfolder, $filename . '_small.' . $file->getClientOriginalExtension(), 'images');
                $medium_path = $file->storeAs($subfolder, $filename . '_medium.' . $file->getClientOriginalExtension(), 'images');
                $large_path = $file->storeAs($subfolder, $filename . '_large.' . $file->getClientOriginalExtension(), 'images');

                if($icon_path && $small_path && $medium_path && $large_path)
                {
                    $icon = public_path('storage/images/' . $icon_path);
                    $small = public_path('storage/images/' . $small_path);
                    $medium = public_path('storage/images/' . $medium_path);

                    $img_icon = InterventionImage::make($icon)->resize(100,100, function($constraint) {
                        $constraint->aspectRatio();
                    });

                    $img_small = InterventionImage::make($small)->resize(200,200, function($constraint) {
                        $constraint->aspectRatio();
                    });

                    $img_medium = InterventionImage::make($medium)->resize(300,300, function($constraint) {
                        $constraint->aspectRatio();
                    });

                    $img_icon->save($icon);
                    $img_small->save($small);
                    $img_medium->save($medium);

                    $object_label = isset($object->title) ? $object->title : $object->name;

                    $object->images()->create([
                        'label' => $object_label . '_0' . $index,
                        'icon' => $icon_path,
                        'small' => $small_path,
                        'medium' => $medium_path,
                        'large' => $large_path,
                        'mimetype' => $file->getClientMimeType()
                    ]);
                }
            }
        }
    }

    public static function deleteImages($images)
    {
        $images_paths = array();
        foreach ($images as $image_id) {
            $images_paths = array_values(Image::select('icon', 'small', 'medium', 'large')
                ->where('id', $image_id)->get()->toArray()[0]);
            foreach ($images_paths as $image_path) {
                unlink(Storage::disk('images')->path('').$image_path);
            }
        }
        Image::whereIn('id', $images)
            ->delete();
    }

    public static function deleteEntityImage(Model $entity)
    {
        unlink(Storage::disk('images')->path('').$entity->image);
        $entity->image = null;
        $entity->save();
    }

    public static function filterProducts($product_name, $filter, $page)
    {
        $perPage = config('shop.paginate');
        $filter_values = [];
        foreach ($filter as $filter_item) {
            $filter_values = array_merge($filter_values, $filter_item);
        }

        return Product::where(function ($query) use ($product_name) {
            if(!empty($product_name)) {
                $query->where('title','like', '%'.$product_name.'%');
            }
            })
            ->where('status', '=', 1)
            ->select(['products.id','title', 'title_lat'])
            ->join('products_attributes', 'products.id','=','products_attributes.product_id')
            ->where(function ($query) use ($filter_values) {
                if(count($filter_values)) {
                    $query->whereIn('attribute_value_id', $filter_values);
                }
            })
            ->with(['image:medium,imageable_id'])
            ->groupBy('product_id')
            ->paginate($perPage, ['*'], 'page', $page);
    }

    public static function getAttributesByGroup()
    {
        return AttributesGroup::has('attributes')
            ->with(['attributes','attributes.values:id,value,attribute_id,ext_value','attributes.values.icon.image:icon,id'])
            ->get()
            ->map(function ($group) {
                return [
                    'group_id' => $group->id,
                    'group_name' => $group->title,
                    'attributes' => $group->attributes->map(function($attribute) {
                        return [
                            'id' => $attribute->id,
                            'name' => $attribute->name,
                            'type' => $attribute->type,
                            'group_id' => $attribute->group_id,
                            'category_id' => $attribute->category_id,
                            'use_fo_filter' => $attribute->use_fo_filter,
                            'values' => $attribute->values->map(function($value) {
                                $new_value = [
                                    'id' => $value->id,
                                    'value' => $value->value,
                                ];
                                if($value->ext_value) $new_value['ext_value'] = $value->ext_value;
                                if($value->icon) $new_value['icon'] = $value->icon->image->icon;

                                return $new_value;
                            })->toArray()
                        ];
                    })->toArray()
                ];
            });
    }
}
