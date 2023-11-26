@extends('frontend.layouts.design')
@section('title', 'Горсад - Дизайн | Стили ландшафтного дизайна')
@section('current-page-link')
    <a href="{{route('design_styles')}}">Стили ландшафтного дизайна</a>
@endsection
@section('content')
    <div class="body-bg static-page-content">
        @include('frontend.design.static-article-wide',
        [
            'image' => '/storage/images/public/design/styles/page_bg.jpg',
            'style_name' => 'Стили ландшафтного дизайна и ассортимент',
            'style_description' => 'Отношения человека и природы – это особая взаимосвязь, которая
                находила отражение в ландшафтах и садах, создаваемых людьми.
                Наблюдая за некоторыми стилями ландшафта можно увидеть, что в
                некоторых из них отчетливо проявляется борьба человека со своей природой, а
                в других можно ощутить истинную гармонию. Все стили ландшафтного
                дизайна отличаются собственным ассортиментом деревьев: неповторимые
                расцветки, отточенная геометрия или натуральные формы.'
        ])
        @include('frontend.design.static-article-wide',
        [
            'image' => '/storage/images/public/design/styles/medieval.jpg',
            'style_name' => 'Средневековый стиль',
            'style_description' => 'Ландшафтный дизайн сада в стиле средних веков – это зональное
                разделение территории на несколько частей, объединяемых дорожками. Там,
                где находится пересечение данных тропинок устанавливаются необычные
                объекты: фонтан, высадка уникального дерева или даже пруд. Территория сада
                в средневековом стиле ограниченна стенами, а каждое дерево и растение может
                быть использовано для приготовления лекарств и пищи. За пределами стен,
                возле клумб с кустарниками и многолетниками дизайнеры рекомендуют
                высаживать деревья, которые отбрасывают величественную тень.'
        ])
        @include('frontend.design.static-article-wide',
        [
            'image' => '/storage/images/public/design/styles/barocco.jpg',
            'style_name' => 'Стиль Барокко',
            'style_description' => 'Данный стиль сочетает в себе сдержанный дизайн и симметрию по
                отношению к центру оси. В стиле Барокко можно заметить визуальную
                глубину, которую можно достичь с помощью искажения перспективы и видов.
                Основа стиля зависит от посадочного материала и симметрии. В этом стиле
                кроны всех деревьев подстрижены, а сами деревья высаживаются вдоль
                определенной линии. Их изящество дополняется берсо и топиариями.
                Вокруг клумб устанавливаются бордюры из самшита, все кустарники
                имеют определенный рост, не превышающий 60 см. Стиль отличается
                сдержанными цветами: белый, серый и зеленый.'
        ])
        @include('frontend.design.static-article-wide',
        [
            'image' => '/storage/images/public/design/styles/renessans.jpg',
            'style_name' => 'Стиль Ренессанс (Возрождение)',
            'style_description' => 'Данный стиль сочетает в себе простоту геометрических форм и прямые
                линии, которые создают атмосферу простоты и спокойствия. Живые изгороди позволяют разделять
                территорию на «пространства»
                с клумбами и газонами. В стиле Ренессанс очень часто устанавливаются цветочные арки, которые создают
                визуальный образ окон.
                Центральная фигура этого стиля – фонтан в виде скульптуры. В стиле
                Ренессанс используются сдержанные и утонченные цвета.'
        ])
        @include('frontend.design.static-article-wide',
        [
            'image' => '/storage/images/public/design/styles/english.jpg',
            'style_name' => 'Английский пейзажный стиль',
            'style_description' => 'Ландшафт с холмами, водоемами, милыми дорожками, деревьями,
                которые могут расти в своей естественной форме – это описание особенностей английского пейзажного стиля. Этот ландшафт
                подразумевает свободу и простор за счет лужаек с
                величественными деревьями и незамысловатыми кустарниками. Деревья и кустарники в английском стиле сдержанны в плане
                плодоношения и цветения, преимущество отдается габитусу и цвету.'
        ])
        @include('frontend.design.static-article-wide',
        [
            'image' => '/storage/images/public/design/styles/victorian.jpg',
            'style_name' => 'Викторианский стиль',
            'style_description' => 'Когда началась революция в промышленном мире, на территорию Европы
                доставили большое количество необычных видов растений из Африки.
                Началась популяризация теплиц и оранжерей, а люди начали пробовать
                высаживать множество необычных растений.
                Некоторые отдавали предпочтение пышным видам растений и огромным
                клумбам с цветами. Со временем использование клумб с многолетниками стало очень модной тенденцией.
                Викторианский стиль для ландшафтного дизайна – это сочетание красоты и игривости. А каждое растение обладает
                необычайной пышностью, яркостью и разнообразием цвета. С целью создания спокойной атмосферы в викторианском
                стиле используются хвойники.'
        ])
        @include('frontend.design.static-article-wide',
        [
            'image' => '/storage/images/public/design/styles/country.jpg',
            'style_name' => 'Деревенский стиль',
            'style_description' => 'Деревенский стиль – это абсолютная романтика и легкость, которая
                сочетает в себе сочные цвета и яркие краски. Этот стиль был создан в трудные
                времена, когда единственным способом людского пропитания являлся свой сад.
                А многие люди не хотели выделяться своими плодовыми деревьями и начали
                высаживать множество красивых цветов.
                Со временем садоводы взяли на вооружение методы обычных людей и
                начали создавать новые и необычные сорта растений.
                Деревенский стиль отражает в себе разделенные участки, пересекаемые
                узкими тропинками.'
        ])
        @include('frontend.design.static-article-wide',
        [
            'image' => '/storage/images/public/design/styles/chinese.jpg',
            'style_name' => 'Китайский стиль',
            'style_description' => 'В данном стиле применяются натуральные материалы и используются
                линии с плавным переходом.
                Инь и Ян – это знак и элементы, которые сочетают в себе воду – женскую
                энергетику и камни – мужскую энергетику. Именно на этом основаны
                особенности китайского стиля.
                Высадка ароматных кустарников и деревьев придает территории особое
                ощущение глубины и идеально маскирует недостатки.
                Предпочтение отдается растениям и деревьям с утонченной структурой.
                Цвета обязательно должны быть приглушены, а цветовая гамма должна
                находиться в пределах бледных оттенков: серый и зеленый.'
        ])
        @include('frontend.design.static-article-wide',
        [
            'image' => '/storage/images/public/design/styles/japanese.jpg',
            'style_name' => 'Японский стиль',
            'style_description' => 'Японский стиль – это уважение и любовь к природе. Использование
                природных атрибутов обеспечивает уникальную неповторимость для создания
                данного стиля. Времена года – это символ перемен и гармонии различных
                элементов, а значит в японском стиле должны быть абсолютно разные
                компоненты с символическим значением. Перспектива создается с помощью
                деревьев, которые обрезают и подвязывают для создания определенного
                внешнего вида. Очень часто применяются растения, кустарники и деревья с
                необычной формой листьев.'
        ])
        @include('frontend.design.static-article-wide',
        [
            'image' => '/storage/images/public/design/styles/mauretan.jpg',
            'style_name' => 'Мавританский стиль',
            'style_description' => 'В данном стиле сочетаются правильные геометрические линии и точные
                формы. Территория делится на четыре части, ограниченные тропинками или
                водотоками, пересекаемыми в центре сада, где установлен водный элемент
                дизайна. По краям территории высаживаются деревья с неплотной кроной, а для
                создания перспективы дизайнеры рекомендуют отдавать предпочтение видам с
                колоновидной формой кроны.
                 Кроме того, в мавританском стиле используются цветущие однолетние и
                многолетние растения, а клумбы украшаются самшитом.'
        ])
    </div>
@endsection
