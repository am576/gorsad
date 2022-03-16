<?php

return [
  'menu' => [
      'product' => [
          'title' => 'товары',
          'singular' => 'товар',
          'route' => 'products',
          'icon'  => 'cart'
      ],
      'service' => [
          'title' => 'услуги',
          'singular' => 'услуга',
          'route' => 'services',
          'icon'  => 'bulldozer',
          'submenu' => [
              [
                  'title' => 'группы услуг',
                  'singular' => 'группа услуг',
                  'route'=> 'service_groups',
                  'icon'  => 'bulldozer'
              ]
          ]
      ],
      'category' => [
          'title' => 'категории',
          'singular' => 'категория',
          'route' => 'categories',
          'icon'  => 'format-list-bulleted-square'
      ],
      'attribute'=>[
          'title' => 'атрибуты',
          'singular' => 'атрибут',
          'route' => 'attributes',
          'icon'  => 'google-circles-extended',
          'submenu' => [
              [
                  'title' => 'группы атрибутов',
                  'singular' => 'группа атрибутов',
                  'route' => 'attributes_groups',
                  'icon'  => 'menu-right-outline'
              ],
              [
                  'title' => 'наборы иконок',
                  'singular' => 'набор иконок',
                  'route' => 'icon_sets',
                  'icon'  => 'image'
              ]
          ]
      ],
      'filter' => [
          'title' => 'фильтр',
          'singular' => 'фильтр',
          'route' => 'filter',
          'icon'  => 'filter'
      ],
      'order' => [
          'title' => 'заказы',
          'singular' => 'заказ',
          'route' => 'orders',
          'icon' => 'download-box'
      ],
      'price' => [
          'title' => 'наценка',
          'singular' => 'заказ',
          'route' => 'prices',
          'icon' => 'currency-usd-circle-outline'
      ],
      'client' => [
          'title' => 'клиенты',
          'singular' => 'клиенты',
          'route' => 'clients',
          'icon' => 'human-handsdown'
      ],
      'project' => [
          'title' => 'проекты',
          'singular' => 'проект',
          'route' => 'projects',
          'icon' => 'map-check-outline'
      ]
  ],
  'per_page' => [
      'products' => 10
  ],
  'attributes_types' => [
      'text' => 'Текст',
      'list' => 'Список',
      'range' => 'Слайдер',
      'bool' => 'Да/Нет',
      'color' => 'Цвет',
      'icon' => 'Иконка'
  ],
];
