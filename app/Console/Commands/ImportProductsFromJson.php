<?php

namespace App\Console\Commands;

use App\Attribute;
use App\Product;
use Illuminate\Console\Command;

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
//        dd($array);
//        dd($array['Скорость роста'][0]);
//        dd($json_data);
        $mesto = [];
        foreach ($json_data as $index => $json_product) {
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

            /*foreach ($json_product as $attribute_name => $product_attr) {
                if(isset($db_attributes[$attribute_name]))
                {
                    if($attribute_name == 'Дополнительная ценность')
                    {
//                        echo $attr_name . "\n";
//                        print_r(explode('|',$product_attr));
//                        $mesto = array_merge($mesto,explode('|',$product_attr));
                    }

                }
            }*/
        }
        $mesto = array_unique($mesto);
        dd($mesto);
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
