@extends('frontend.knowhow.layout')
@section('title', 'Gorsad - Советы')
@section('page')
<div class="container-fluid">
    <div class="row justify-content-center">
        @include('frontend.knowhow.menu')
        @include('frontend.knowhow.mmenu')
        <section class="page-bg col-md-12 p-0">
            <div class="page-img-main" style="background-image: url('/storage/images/public/knowhowbg.jpg'); ">
                <h1 class="page-img-title">Посадка деревьев и менеджмент озеленения</h1>
            </div>

        </section>
        <div class="colorbar"></div>
        <section class="page-content col-md-12 p-0">
            <div id="planning" class="static-page-section">
                <div class="section-details">
                    <div class="section-text col-md-6 col-sm-12">
                        <h3>Посадочный план: особенности посадки деревьев</h3>
                        <p>
                            <span class="section-description">
                                Деревья – это незаменимые элементы ландшафтного дизайна, которые являются основным
                                украшением и
                                центром озеленения территории. Деревья придают окружающей среде особый акцент красоты и
                                природного
                                баланса в человеческом масштабе.
                                План посадок определяется на основе форм, структур, текстур, высоты, ширины, цвета
                                деревьев
                                и в
                                зависимости от смены времен года.
                            </span>
                            <a href="{{route('planning')}}" class="read-more-btn">Читать далее <i class="mdi mdi-24px mdi-chevron-right-circle-outline ml-2"></i> </a>
                        </p>
                    </div>
                    <div class="section-image col-md-6 col-sm-12">
                        <img src="{{asset('storage/images/public/knowhow/planning.jpg')}}" alt="" style="width: 100%">
                    </div>
                </div>
            </div>
            <div id="ordering" class="static-page-section">
                <div class="section-details">
                    <div class="section-text">
                        <h3>Как выделить выбранные деревья в ТЗ (техническом задании)?</h3>
                        <p>
                            <span class="section-description">
                                Для реализации задуманного дизайна заказчику рекомендуется точно определить качество
                                дерева для будущего ландшафтного проекта.
                                С целью 100% уверенности в сделанном выборе, достаточно просто приехать в питомник
                                «Натуралист» и выбрать деревья самостоятельно.
                            </span>
                            <a href="{{route('trees_ordering')}}" class="read-more-btn">Читать далее <i class="mdi mdi-24px mdi-chevron-right-circle-outline ml-2"></i> </a>
                        </p>
                    </div>
                </div>
            </div>
            <div id="topiary" class="static-page-section">
                <div class="section-details">
                    <img src="{{asset('storage/images/public/knowhow/topiary.jpg')}}" alt="">
                    <div class="section-text">
                        <h3>Топиарные и формованные деревья</h3>
                        <p>
                            <span class="section-description">
                                Топиарные деревья отличаются способностью к сохранению специфической формы за счет
                                постоянного ухода, формовки и стрижки.
                                Формованные – это те виды деревьев, которые могут сохранять свою форму без обязательного
                                ухода и стрижки со стороны человека.
                                Выбор между топиарным или формованным деревом зависит от вида дизайна и бюджета для
                                контроля обслуживания.
                            </span>

                            <a href="{{route('shape_trees')}}">Применение топиарных и формованных деревьев в ландшафтном дизайне. Основные виды.</a>
                        </p>
                    </div>
                </div>
            </div>
            <div id="transport" class="static-page-section">
                <div class="section-details">
                    <div class="section-text">
                        <h3>Погрузка, транспортировка и разгрузка товара</h3>
                        <p>
                            <span class="section-description">
                                Выбор подходящего оборудования является гарантией безопасности в процессе перемещения дерева к
                                назначенному месту.
                                Питомник «Натуралист» сочетает в себе деревья высочайшего качества, специализированное оборудование
                                и опытных профессионалов, которые бережно транспортируют деревья к вашему участку для озеленения.
                            </span>
                            <a class="mt-4" href="{{route('trees_transport')}}">Безопасная доставка из питомника «Натуралист»</a>
                        </p>
                    </div>
                </div>
            </div>
            {{--UNCOMMENT WHENT LINKS ARE PROVIDED BY CLIENT--}}
            {{--<div id="planting" class="static-page-section">
                <div class="section-details">
                    <div class="section-text">
                        <h3>Основные правила посадки</h3>
                        <div class="section-list">
--}}{{--                            <img src="{{asset('storage/images/public/knowhow/planting.png')}}" alt="">--}}{{--
                            <div class="d-flex flex-column">
                                <span>Идеальное место для посадки.</span>
                                <span>Узнать всё об улучшении почвы и подготовке земли></span>
                            </div>
                            <div class="d-flex flex-column">
                                <span>Как садить деревья?</span>
                                <span>Подробности посадки></span>
                            </div>
                            <div class="d-flex flex-column">
                                <span>Что выбрать: анкер или деревянные колышки?</span>
                                <span>Читать подробнее ></span>
                            </div>
                            <div class="d-flex flex-column">
                                <span>Уход за деревьями.</span>
                                <span>Узнать больше о поливе, подрезах и удобрении ></span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>--}}
            <div id="pruning" class="static-page-section">
                <div class="section-details">

                    <div class="section-text">
                        <h3><img src="{{asset('storage/images/public/knowhow/pruning.png')}}" alt=""> Руководство по обрезке</h3>
                        <p>
                            <span class="section-description">
                                Определяющие факторы для правильной обрезки деревьев – это форма, сорт и место посадки. Мы создали
                                профессиональное руководстве по обрезке, в котором вы найдете всю информацию о формовке дерева с
                                применением обрезки: особенности работы с топиарными и формованными деревьями. Также мы написали все
                                о правильном проведении санитарной обрезки.
                            </span>
                            <a href="{{route('guide', ['guide_name' => 'pruning'])}}" target="_blank">Прочитать больше об обрезке</a>
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
