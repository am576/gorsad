<?php

return [
  'menu' => [
      'product' => [
          'title' => 'товары',
          'singular' => 'товар',
          'route' => 'products',
          'icon'  => 'cart'
      ],
      'category' =>[
          'title' => 'категории',
          'singular' => 'категория',
          'route' => 'categories',
          'icon'  => 'format-list-bulleted-square'
      ],
      'attribute'=>[
          'title' => 'атрибуты',
          'singular' => 'атрибут',
          'route' => 'attributes',
          'icon'  => 'google-circles-extended'
      ],
      'order' => [
          'title' => 'заказы',
          'singular' => 'заказ',
          'route' => 'orders',
          'icon' => 'currency-usd-circle-outline'
      ],
      'clients' => [
          'title' => 'клиенты',
          'singular' => 'клиенты',
          'route' => 'clients',
          'icon' => 'human-handsdown'
      ]
  ],
  'per_page' => [
      'products' => 10
  ]
];
