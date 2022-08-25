@extends('frontend.layouts.app')
@section('title', 'Gorsad - Дизайн')
@section('content')
    @push('styles')
        <link href="{{ asset('css/design.css') }}" rel="stylesheet">
    @endpush
    <div class="container-fluid">
        <div class="row justify-content-center">
            @include('frontend.design.menu')
            <section class="page-bg col-md-12 p-0">
                <div class="page-img-main"
                     style="background-image: url('/storage/images/public/design/design_bg.jpg'); ">
                    <h1 class="page-img-title">Красота и изящество зелени</h1>
                </div>
            </section>
            <div class="colorbar"></div>
            <section class="page-content col-md-12 p-0">
                <div id="balance" class="static-page-section">
                    <div class="section-details">
                        <div class="section-text">
                            <h3>Формирование природного единства и неповторимого баланса.</h3>
                            <p>
                            <span>
                                Дизайн внешнего пространства является результатом взаимодействия нескольких элементов,
                                среди
                                которых обязательная роль отводится выбору подходящего растения.
                                Основная цель питомника «Натуралист» – это выращивание уникальных растений с
                                неповторимыми
                                особенностями – формой, цветом и областью применения.
                                Так мы создаем идеальную атмосферу, благоприятствующую разнообразию флоры вашей жилой и
                                рабочей среды.
                            </span>
                                <a href="{{route('outdoor_design')}}" class="read-more-btn">Узнайте больше об ассортименте и особенностях
                                    природного баланса. <i
                                        class="mdi mdi-24px mdi-chevron-right-circle-outline ml-2"></i> </a>
                            </p>
                        </div>
                    </div>
                </div>
                <div id="styles" class="static-page-section">
                    <div class="section-details font-weight-lighter">
                        <div class="section-text mw-50 pr-4"
                             style="border-right: 2px solid rgba(138,138,138,0.1); padding-right: 2rem;">
                            <h3>Стили для дизайна ландшафта</h3>
                            <p>
                                <span>
                                    Натуральность и естественный стиль, точные геометрические формы, величественные парки
                                    в английском стиле пейзажа или минималистические японские сады. Это лишь некоторая доля различных
                                    стилей озеленения, которая создавалась в разных уголках мира на протяжении нескольких веков.
                                    Все они имеют свои особенности и тематический ассортимент.
                                </span>
                                <a href="{{route('design_styles')}}" class="read-more-btn">Подробно о стилях ландшафтного дизайна <i
                                        class="mdi mdi-24px mdi-chevron-right-circle-outline ml-2"></i> </a>
                            </p>
                        </div>
                        <div class="section-text mw-50" style="padding-left: 2rem">
                            <h3>Модернизация, развитие и экологические особенности дизайна</h3>
                            <p>
                                <span>
                                    С целью устойчивого развития жилых и рабочих открытых пространств используются все
                                    виды материалов и возможностей озеленения.Главная особенность дизайна – это умение видеть
                                    и быть едиными с природой.
                                </span>
                                <a href="{{route('ecology')}}" class="read-more-btn">Читать далее <i
                                        class="mdi mdi-24px mdi-chevron-right-circle-outline ml-2"></i></a>
                            </p>
                        </div>
                    </div>
                </div>
                <div id="roofs" class="static-page-section">
                    <div class="section-details">
                        <img class="mw-50" src="{{asset('storage/images/public/design/roofs.jpg')}}" alt="">
                        <div class="section-text pl-5">
                            <h3>Озеленение крыш и благоустройство территории с помощью контейнерных растений</h3>
                            <ul>
                                <li>Украшение территории ценными растениями.</li>
                                <li>Благоприятное воздействие на городской микроклимат.</li>
                                <li>Широкий ассортимент растений на выбор.</li>
                                <li>Обеспечение высокого уровня менеджмента и обслуживания на мероприятиях.</li>
                            </ul>
                            <a href="{{route('roofs')}}">Озеленение крыш и благоустройство территории с помощью контейнерных растений.</a>
                        </div>
                    </div>
                </div>
                <div id="street_profiles" class="static-page-section">
                    <div class="section-details font-weight-lighter">
                        <div class="section-text">
                            <h3>Поперечные уличные профили</h3>
                            <p>
                                Роскошные деревья на улицах города и вдоль аллей придадут среде особую утонченность с
                                неповторимым ощущением гармонии.
                                Но дизайн аллеи и улиц обязательно должен соответствовать перечню требований. Рост
                                населения городов приводит к стесненности улиц и аллей, поэтому посадка деревьев придаст
                                узким улицам более привлекательный вид.
                                Но одновременно с этим специалисты рекомендуют разнообразить дизайн различными
                                функциями, что обеспечит более привлекательный внешний вид. Это лучшее достижение.
                            </p>
                            <a href="{{route('street_profiles')}}" class="read-more-btn">Идеи от питомника «Натуралист» <i
                                    class="mdi mdi-24px mdi-chevron-right-circle-outline ml-2"></i></a>
                        </div>
                    </div>
                </div>
                <div id="lighting" class="static-page-section">
                    <div class="section-details font-weight-lighter">
                        <div class="section-text">
                            <h3>Деревья и освещение улиц</h3>
                            <p>
                                В процессе создания особенностей освещения на улице и установке фонарей, дизайнеры
                                должны учитывать особенности и параметры деревьев. При нарушении данного правила кроны
                                деревьев могут заслонять свечение фонарного столба, что приведет к обрезке или удалению
                                дерева. Это является ошибочной затратой финансов, которую легко предупредить на ранних
                                этапах озеленения.
                            </p>
                            <a href="{{route('street_lighting')}}" class="read-more-btn">Читать далее <i
                                    class="mdi mdi-24px mdi-chevron-right-circle-outline ml-2"></i></a>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

@endsection
