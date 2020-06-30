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
  ],
  'per_page' => [
      'products' => 10
  ]
];
