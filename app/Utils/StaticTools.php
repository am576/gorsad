<?php


namespace App\Utils;


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
}
