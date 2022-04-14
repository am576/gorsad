<?php

namespace App\Console\Commands;

use App\Attribute;
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

        $array = collect($attributes)->mapToGroups(function($attribute)  {
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

        /*** Get Rus name ***/
        /*$c = 0;
        foreach ($json_data as $product) {
            preg_match('/([\p{Cyrillic}\s\'\"\.]+)/u', $product['Title'], $match);
            if(isset($match[1]))
            {
                echo $match[1] . "\n";
                $c++;
            }
        }
        echo 'Товаров с русским названием: ' . $c . "\n";*/
        /*** End Latin name ***/

        /*** Get Latin name ***/
        /*$c = 0;
        foreach ($json_data as $product) {
            preg_match('/\(([\w\s\']+)\)/', $product['Title'], $match);
            if(isset($match[1]))
            {
                echo $match[1] . "\n";
                $c++;
            }
        }
        echo 'Товаров с латинским названием: ' . $c . "\n";*/
        /*** End Latin name ***/

        /*** Get Description ***/
       /* $c = 0;
        foreach ($json_data as $product) {
            if(!empty($product['Content']))
            {
                echo $product['Content'] . "\n\n";
                $c++;
            }
        }
        echo 'Товаров с описанием: ' . $c . "\n";*/
        /*** End Description ***/

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
        dd($array);
    }
}
