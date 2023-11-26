@extends('frontend.layouts.design')
@section('title', 'Горсад - Дизайн | Освещение')
@section('current-page-link')
    <a href="{{route('street_lighting')}}">Освещение</a>
@endsection
@section('content')
    <div class="body-bg static-page-n">
        <div class="container-pd">
            @include('frontend.design.static-info-article',
            [
                'image' => '/storage/images/public/design/lighting/1.jpg',
                'article_heading' => 'Наружное освещение и деревья',
                'article_text' => 'В большинстве случаев фонарные столбы и деревья устанавливаются поочередно на одной
                    линии. Такое близкое расположение очень неудобно за счет корней дерева и разросшихся кронов. Ведь при
                    ремонте подземных компонентов могут быть задеты корни деревьев. А сильно разросшиеся кроны мешают
                    попаданию солнечного света. С целью предупреждения данных проблем в процессе разработки следует
                    рассчитывать размеры корней и кронов взрослого дерева. А затем подбирать другие варианты посадки и планировки.'
            ])
            @include('frontend.design.static-info-article',
            [
                'image' => '/storage/images/public/design/lighting/2.jpg',
                'article_heading' => 'Размеры деревьев',
                'article_text' => 'Размеры деревьев определяются на основе нескольких факторов: вида, скорости развития
                    и времени нахождения в одном месте.
                    Если дерево посажено в открытом пространстве с учетом всех требований к долгосрочному развитию, то
                    у сортов деревьев есть необходимое место для роста и достижения определенных размеров. Использование
                    базовых принципов дизайна позволит добиться точного расчета размеров дерева в будущем.',
                'reverse' => true,
                'link' => [
                    'text' => 'Скачать «Описание размеров деревьев»',
                    'href' => '/design/trees-size'
                ]
            ])
            @include('frontend.design.static-info-article',
            [
                'image' => '/storage/images/public/design/lighting/3.jpg',
                'article_heading' => 'Установка фонарей и деревьев',
                'article_text' => 'Посадка деревьев с целью создания определенного дизайна открытого пространства должна
                    быть реализовано согласно требованиям установки фонарей. Это поможет предотвратить негативное
                    воздействие данных элементов друг на друга в будущем времени. Фонари должны устанавливаться таким
                    образом, чтобы все коммуникации под землей находились вне доступа корневой системы дерева.
                    При определении дистанции между фонарем и деревьями применяются следующие параметры – высота фонаря,
                    ствола и кроны.',
                'link' => [
                    'text' => '«Правильный расчет расстояния между деревьями и фонарями»',
                    'href' => '/design/trees-and-streetlights'
                ]
            ])
            @include('frontend.design.static-info-article',
            [
                'image' => '/storage/images/public/design/lighting/4.jpg',
                'article_heading' => 'Альтернативное планирование',
                'article_text' => 'Альтернативные варианты в планировании зависят от поперечного
                    профиля улицы и используются таким образом, чтобы фонари и деревья не мешали друг другу.
                    Специалисты выделили следующие способы альтернативного планирования: установка источников света на фасадах;
                    линейные способы освещения; установка фонарей и деревьев на разных сторонах дороги; установка
                    фонарей по обе стороны дорог, а посадка деревьев на полосе, которая разделяет проезжую часть;
                    использование навесного освещения.',
                'reverse' => true,
            ])
        </div>
    </div>
@endsection
