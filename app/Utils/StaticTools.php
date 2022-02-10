<?php


namespace App\Utils;


use Illuminate\Database\Eloquent\Model;
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

                    $object->images()->create([
                        'label' => $object->title . '_0' . $index,
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
}
