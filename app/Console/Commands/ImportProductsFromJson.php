<?php

namespace App\Console\Commands;

use App\Attribute;
use App\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

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

        /*** Read JSON file ***/
        $json_string = file_get_contents('products.json');
        $json_data = json_decode($json_string, true);

        /*
         * Range - first and last
         * Text - everything
         * Color -
         * Icon -
         * */

        /*** Create products ***/
        $product_index = 1;
        foreach ($json_data as $index => $json_product) {
            if ($product_index <= $IMPORT_LIMIT) {
                echo 'Запись товара #' . $product_index . " ... ";

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

                foreach ($json_product as $attribute_name => $product_attribute) {
                    if (isset($db_attributes[$attribute_name])) {
                        $db_attribute = Attribute::where('name', $attribute_name)->first();
                        if ($db_attribute->type != 'icon') {
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
    }

    private function getRusName($product)
    {
        preg_match('/([\p{Cyrillic}\s\'«»\"\.]+)/u', $product['Title'], $match);
        if(isset($match[1]))
        {
            return $match[1];
        }
        return false;
    }
    private function getLatName($product)
    {
        preg_match('/\(([\w\s\']+)\)/', $product['Title'], $match);
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
}
