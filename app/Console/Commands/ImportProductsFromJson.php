<?php

namespace App\Console\Commands;

use App\Attribute;
use App\Image;
use App\Product;
use App\ProductVariant;
use App\Utils\ImageUtils;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use function Symfony\Component\String\lower;

class ImportProductsFromJson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:import {--count=100}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $time_start = microtime(true);
        $IMPORT_LIMIT = $this->option('count');

        /*** Get attributes from DB and create an assoc array  ***/
        $attributes = Attribute::select('attributes.*', 'value', 'attributes_values.id as value_id')
            ->join('attributes_values', 'attributes.id', '=', 'attributes_values.attribute_id')
            ->get()
            ->groupBy(function ($item) {
                return $item->name;
            });

        $db_attributes = collect($attributes)->mapToGroups(function ($attribute) {
            return collect($attribute)->mapToGroups(function ($attrs) {
                return [
                    $attrs['name'] => [
                        'id' => $attrs['id'],
                        'values' =>
                            [
                                'value' => $attrs['value'],
                                'value_id' => $attrs['value_id']
                            ]
                    ]

                ];
            })->toArray();
        })->toArray();

        $image_files = scandir('./public/storage/images/products');
        $file_names = array_map('strtolower', $image_files);

        /*** Read JSON file ***/
        $products_data = file_get_contents('products.json');
        $json_products = json_decode($products_data, true);

        $json_products_variants =  $this->getReformattedVariantsJson();

        /*** Create products with variants ***/
        $product_index = 1;
        foreach ($json_products as $index => $json_product) {
            if ($product_index <= $IMPORT_LIMIT) {
                echo 'Запись товара #' . $product_index . " ... ";

                $product = $this->createProductFromJson($json_product);
                $this->writeProductVariants($product, $json_products_variants);

                /*** Write images ***/
                if(!empty($product->title_lat))
                {
                    $lat_name_mod = strtolower(rtrim(preg_replace('/[\s\'\"]+/', '_', $product->title_lat), '_'));
                    $match = preg_grep("/$lat_name_mod\_\d/",$file_names);
                    if(count($match))
                    {
                        foreach ($match as $index => $label) {
                            $path = 'products/' . $image_files[$index];
                            $filename = public_path(config('images.storage_path').'products/' . $image_files[$index]);
                            $image = new Image([
                                'label' => $label,
                                'mimetype' => 'image/jpeg',
                                'imageable_type' => 'App\Product',
                                'imageable_id' => $product->id,
                                'icon' => ImageUtils::createResizedImage('icon', $filename, 'products', config('images.size.icon'), config('images.size.icon')),
                                'small' => ImageUtils::createResizedImage('small', $filename, 'products',config('images.size.small'), config('images.size.icon')),
                                'medium' => ImageUtils::createResizedImage('medium', $filename, 'products',config('images.size.medium'), config('images.size.icon')),
                                'large' => $path,
                            ]);
                            $image->save();
                        }
                    }
                }

                /*** Write attributes ***/
                foreach ($json_product as $attribute_name => $product_attribute) {
                    if (isset($db_attributes[$attribute_name])) {
                        $db_attribute = Attribute::where('name', $attribute_name)->first();
                        if (true) {
                            if (!empty($product_attribute)) {
                                $json_attribute_values = explode('|', $product_attribute);
                                if ($db_attribute->type == 'range') {
                                    $ar = [];
                                    if (count($json_attribute_values) == 1) {
                                        array_push($ar, $json_attribute_values[0], $json_attribute_values[0]);
                                    } else {
                                        array_push($ar, min($json_attribute_values));
                                        array_push($ar, max($json_attribute_values));
                                    }
                                    $json_attribute_values = $ar;
                                }


                                $value_column = $db_attribute->type == 'color' ? 'ext_value' : 'value';
                                $db_attribute_values_id = DB::table('attributes_values')
                                    ->where('attribute_id', $db_attribute->id)
                                    ->whereIn($value_column, $json_attribute_values)
                                    ->get()
                                    ->pluck('id', 'value')
                                    ->toArray();

                                if ($db_attribute->type == 'range') {
                                    ksort($db_attribute_values_id);
                                }
                                $values_to_insert = [];
                                {
                                    foreach ($db_attribute_values_id as $value => $id) {
                                        array_push($values_to_insert, [
                                            'product_id' => $product->id,
                                            'attribute_id' => $db_attribute->id,
                                            'attribute_value_id' => $id
                                        ]);
                                    }
                                }

                                DB::table('products_attributes')->insert($values_to_insert);
                            }
                        }
                    }
                }
                echo "ОК\n";
                $product_index++;
            }
        }
        $time_end = microtime(true);
        $time = number_format((float)($time_end - $time_start), 2, '.', '');;
        echo "\n Импорт занял $time секунд\n";
    }

    private function getReformattedVariantsJson()
    {
        $json_string = file_get_contents('products_variants_raw.json');
        $json_data = json_decode($json_string, true);

        $products = [];

        $count = 0;
        foreach ($json_data as $index => $product) {
            $remove_keys = ['No.', 'Артикул', 'description', 'FIELD9', 'package_weight', 'FIELD9', 'FIELD10', 'FIELD12', 'FIELD13'];
            $product = array_diff_key($product, array_flip($remove_keys));

            if(!empty($product['name_rus']))
            {
                $product['variants'] = [];

                array_push($product['variants'],
                    [
                        "type" => $product['type'],
                        "width" => $product['width'],
                        "height" => $product['height'],
                        "price" => $product['price'],
                    ]);
                $product_name = $this->getTrimmedName($product['name_rus']);
                $remove_keys = ['type','width','height','price','name_rus','name_lat'];
                $product = array_diff_key($product, array_flip($remove_keys));

                $products[$product_name] = $product;
                $count++;
            }
            else
            {
                $remove_keys = ['name_rus','name_lat'];
                $product = array_diff_key($product, array_flip($remove_keys));
                array_push($products[array_key_last($products)]['variants'], $product);
            }
        }
        $products_variants_json = json_encode($products, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        file_put_contents('products_variants.json','');
        file_put_contents('products_variants.json', $products_variants_json);

        return $products;
    }

    private function createProductFromJson($json_product)
    {
        $product_name_rus = $this->getRusName($json_product);
        $product_name_lat = $this->getLatName($json_product);
        $product_description = $this->getProductDescription($json_product);

        $product = new Product([
            'category_id' => 2,
        ]);
        $product_name_rus ? $product->title = $product_name_rus : '';
        $product_name_lat ? $product->title_lat = $product_name_lat : '';
        $product_description ? $product->description = $product_description : '';

        $product->save();

        return $product;
    }

    private function writeProductVariants($product, $variants)
    {
        $trimmed_product_name = $this->getTrimmedName($product->title);

        if(isset($variants[$trimmed_product_name]))
        {
            foreach ($variants[$trimmed_product_name]['variants'] as $variant)
            {
                $new_variant = new ProductVariant(
                    [
                        'product_id' => $product->id,
                        'height' => $this->formatVariantValue($variant['height']),
                        'width' => $this->formatVariantValue($variant['width']),
                        'price' => $this->formatVariantPrice($variant['price']),
                        'type' => $this->formatVariantType($variant['type'])
                    ]
                );

                $new_variant->save();
            }
        }
    }

    private function getRusName($product)
    {
        preg_match('/([\p{Cyrillic}\s\-\'«»\"\.]+[^()]+)/u', $product['Title'], $match);
        if(isset($match[1]))
        {
            return $match[1];
        }
        return false;
    }
    private function getLatName($product)
    {
        preg_match('/\(([\w\s\'-`]+)\)/', $product['Title'], $match);
        if(isset($match[1]))
        {
            return $match[1];
        }

        return false;
    }
    private function getProductDescription($product)
    {
        if(!empty($product['Content']))
        {
            return $product['Content'];
        }

        return false;
    }

    private function getTrimmedName(string $product_name)
    {
        return rtrim(preg_replace('/[\'\"]+/', '', $product_name));
    }

    private function formatVariantValue(string $value)
    {
        return preg_replace('/[-]+/', ',', trim($value));
    }

    private function formatVariantPrice(string $price)
    {
        $price = str_replace(',', '.', $price);

        return preg_replace('/[^0-9.]/', '', $price);
    }

    private function formatVariantType(string $type)
    {
        return strtolower($type);
    }

}
