<?php

return [
  'url' => 'http://127.0.0.1:8000/admin',
  'menu' => [
      'product' => [
          'title' => 'товары',
          'singular' => 'товар',
          'genitive' => 'товара',
          'route' => 'products',
          'icon'  => 'cart'
      ],
      'service' => [
          'title' => 'услуги',
          'singular' => 'услуга',
          'genitive' => 'услуги',
          'route' => 'services',
          'icon'  => 'bulldozer',
          'submenu' => [
              'service_group' => [
                  'title' => 'группы услуг',
                  'singular' => 'группа услуг',
                  'genitive' => 'группы услуг',
                  'route'=> 'service_groups',
                  'icon'  => 'bulldozer'
              ]
          ]
      ],
      'category' => [
          'title' => 'категории',
          'singular' => 'категория',
          'genitive' => 'категории',
          'route' => 'categories',
          'icon'  => 'format-list-bulleted-square'
      ],
      'attribute'=>[
          'title' => 'атрибуты',
          'singular' => 'атрибут',
          'genitive' => 'атрибута',
          'route' => 'attributes',
          'icon'  => 'google-circles-extended',
          'submenu' => [
              'attributes_group' => [
                  'title' => 'группы атрибутов',
                  'singular' => 'группа атрибутов',
                  'genitive' => 'группы атрибутов',
                  'route' => 'attributes_groups',
                  'icon'  => 'menu-right-outline'
              ],
              'icon_set' => [
                  'title' => 'наборы иконок',
                  'singular' => 'набор иконок',
                  'genitive' => 'набора иконок',
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
          'genitive' => 'заказа',
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
          'genitive' => 'проекта',
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
