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
    protected $signature = 'products:import';

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
        /**** Get attributes from DB and create an assoc array  ****/
        $attributes = Attribute::select('attributes.*','value','attributes_values.id as value_id')
            ->join('attributes_values','attributes.id','=','attributes_values.attribute_id')
            ->get()
            ->groupBy(function($item) {
                return $item->name;
            });

        $db_attributes = collect($attributes)->mapToGroups(function($attribute)  {
            return collect($attribute)->mapToGroups(function($attrs) {
                return [
                    $attrs['name'] =>[
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

        /**** Parse JSON file ****/
        $json_string = file_get_contents('products.json');
        $json_data = json_decode($json_string, true);


        /*** End Latin name ***/

        /*** Get Latin name ***/
        /*$c = 0;
        foreach ($json_data as $product) {

        }
        echo 'Товаров с латинским названием: ' . $c . "\n";*/
        /*** End Latin name ***/

        /*** Parse Attributes ***/

        /*foreach ($json_data as $product) {
            if (!empty($product['Цвет листьев']))
            {
                echo $product['Цвет листьев'] . "\n";
            }
        }*/
        /** Colors **/
        /* Зеленый
         * Желтый
         * Красный
         * Пестрый лист
         * Фиолетовый
         * Коричневый
         * Кремово-белый
         * Серый
         * Белый
         * Синий
         * Розовый
         * */

        /*
         * Range - first and last
         * Text - everything
         * Color -
         * Icon -
         * */

        $product_index = 1;
        foreach ($json_data as $index => $json_product) {
            echo 'Запись товара #' . $product_index . " ... ";
            $product_name_rus = $this->getRusName($json_product);
            $product_name_lat = $this->getLatName($json_product);
            $product_description = $this->getProductDescription($json_product);
            $product_attributes = [];

            $product = new Product([
                'category_id'=> 2,
            ]);
            $product_name_rus ? $product->title = $product_name_rus : '';
            $product_name_lat ? $product->title_lat = $product_name_lat: '' ;
            $product_description ? $product->description = $product_description: '';

            $product->save();

            foreach ($json_product as $attribute_name => $product_attribute) {
                if(isset($db_attributes[$attribute_name]))
                {
                    $db_attribute = Attribute::where('name', $attribute_name)->first();
                    if($db_attribute->type == 'text' && !empty($product_attribute))
                    {
                        $json_attribute_values = explode('|', $product_attribute);
                        $db_attribute_values_id = DB::table('attributes_values')
                            ->whereIn('value', $json_attribute_values)
                            ->get()
                            ->pluck('id')
                            ->toArray();

                        $values_to_insert = [];
                        foreach ($db_attribute_values_id as $db_attribute_value_id) {
                            array_push($values_to_insert, [
                                'product_id' => $product->id,
                                'attribute_id' => $db_attribute->id,
                                'attribute_value_id' => $db_attribute_value_id
                            ]);
                        }

                        DB::table('products_attributes')->insert($values_to_insert);
                    }
                }
            }
            echo "ОК\n";
            $product_index++;
        }
    }

    private function getRusName($product)
    {
        preg_match('/([\p{Cyrillic}\s\'\"\.]+)/u', $product['Title'], $match);
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
