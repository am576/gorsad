@extends('frontend.layouts.knowhow')
@section('title', 'Горсад - Советы')
@section('current-page-link')
    /<a href="{{route('planning')}}">Шаги посадки</a>
@endsection
@section('page-title', 'Шаги посадки')
@section('page-description')
    Деревья – это один из важнейших компонентов для создания атмосферы и структуры ландшафтного дизайна. Поэтому
    с целью достижения определенного результата, специалисты рекомендуют обращать внимание на несколько основных
    факторов, представленных ниже.
@endsection
@section('image')
    <img src="/storage/images/public/knowhow/planting_plan_bg.jpg" alt="">
@endsection
@section('content')
    <img id="planting-condition" src="/storage/images/public/knowhow/planting_condition.jpg" alt="">
    <div id="planning-points">
        <div class="planning-point">
            <div class="point-title heading">
                <div>Дизайн</div>
            </div>
            <div class="point-description">
                <p>Визуализация дизайнера: вид, форма, структура, параметры размера, цвет, особенности времен года и климат.</p>
                <p>Функции деревьев: элемент детской площадки, функция защиты экологии, часть истории и культуры.</p>
                <p class="p-0">
                    После окончания выбора вида дерева специалисты рекомендуют выделить их на плане с учетом всех
                    размеров взрослого вида. Так вы сможете определить, насколько выбранный вид дерева подойдет для
                    обустройства вашей территории и может ли это привести к проблемам в будущем (фонарные столбы,
                    канализация и т.д.).
                </p>
            </div>
        </div>
        <div class="planning-point">
            <div class="point-title heading">
                <div class="w-75">Выбор дерева и бюджет</div>
            </div>
            <div class="point-description">
                <p>
                    Для правильного выбора видового ассортимента следует помнить о желаемых затратах для последующего
                    ухода за деревьями. То есть, если дизайнер подготовил план бульвара с красиво подстриженными
                    деревьями, кроны которых будут восхищать правильностью форм, а вы не рассчитываете бюджет на работу
                    садовника, то это неосуществимо в будущем. А кроме того, следует помнить, что обычное обслуживание
                    дерева (защита от насекомых, осыпание листьев) также требуют финансовых затрат.
                </p>
            </div>
        </div>
        <div class="planning-point">
            <div class="point-title heading">
                <div>Как выбрать дерево в питомнике?</div>
            </div>
            <div class="point-description">
                <p>
                    А вы хотите найти свою музу среди деревьев для озеленения вашей территории? Наш питомник полон
                    уникальных деревьев, которые станут центральной частью и эстетикой вашего проекта. Наши
                    профессионалы не просто поработают, но и помогут выбрать лучшее дерево для выбранного места в
                    соответствии с вашим видением и мечтой. Главные деревья, определяющие внешний вид вашего дизайна
                    (бульварные варианты, деревья с множеством стволов, солитеры и т.д.) рекомендуется выбирать в самом
                    питомнике «Городской садовник». Наш дизайнер поможет сделать правильный выбор с учетом ваших
                    желаний, климата местности и предполагаемого бюджета.
                </p>
            </div>
        </div>
    </div>
@endsection
