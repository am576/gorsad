@extends('frontend.layouts.app')
@section('title', 'Gorsad - Дизайн - Кровли и конейнеры')
@section('content')
@push('styles')
    <link href="{{ asset('css/staticinfo_page.css') }}" rel="stylesheet">
@endpush
    <div class="container-fluid">
        <div class="row justify-content-center">
            @include('frontend.design.menu')
            <section class="page-bg col-md-12 p-0">
                <div class="page-img-main" style="background-image: url('/storage/images/public/design/roofs_bg.jpg'); ">
                    <h1 class="page-img-title" style="">Кровельное и контейнерное озеленение</h1>
                </div>
            </section>
            <div class="colorbar" style="background: #c19a80;"></div>
            <section class="page-content w-100">
                <div class="w-100 pt-5 pb-5 font-weight-lighter" style="background: #ecedd4;">
                    <div class="container">
                        <p>
                            Озеленение крыш и благоустройство территории с помощью контейнерных растений становится все
                            более популярной услугой в ландшафтном дизайне.
                            Это очень ценный компонент дизайна для городской среды, так как он значительно улучшает
                            экологию и эстетику заданной местности.
                            Одними из основных факторов обустройства садов на крыше с помощью контейнерных деревьев и
                            растений являются работы по управлению и обслуживанию процесса.
                        </p>
                    </div>
                </div>
                <div class="container pt-5 pb-5 font-weight-lighter">
                    <h2>Выбор дерева</h2>
                    <div class="d-flex">
                        <div class="mw-50 pr-4" style="border-right: 2px solid rgba(138,138,138,0.1); padding-right: 2rem;">
                            На крыше можно садить любые виды деревьев, но есть те виды, которые больше всего подходят для
                            данной посадки.
                            Если вы решили посадить на крыше дерево с массивными корнями, то для защиты поверхности вам
                            понадобится прочная защита от повреждений.
                            Деревья для посадки на крыше должны быть устойчивы к ветру и погодным условиям. Так как хрупкая
                            древесина дерева легко может сломаться при сильном ветре. Также следует учитывать и форму
                            дерева: высокие стволы нежелательны для посадки на крыше. А вот топиарные и многоствольные
                            станут отличным решением.
                        </div>
                        <div class="mw-50 pl-4" style="padding-left: 2rem;">
                            Проблема высокоствольных деревьев – это высокое расположение центра тяжести, что значительно
                            увеличивает риск его повреждения. Такие ситуации станут проблемой для заказчиков, так как любое
                            повреждение высокоствольных деревьев будет заметно для окружающих людей.
                            Топиарные деревья идеально подходят для посадки на крыше за счет среза кроны один раз в год.
                            Сломанная в кроне ветка легко устраняется во время очередного ежегодного среза. Специалисты
                            питомника «Натуралист» помогут вам подобрать подходящий ассортимент в кратчайшие сроки.
                        </div>
                    </div>
                </div>
                <div class="w-100 pt-5 pb-5 font-weight-lighter" style="background: #e8cece;">
                    <div class="container">
                        <h2>Посадка деревьев</h2>
                        <p>
                            Большинство деревьев в контейнерах и на крышах находятся в зоне повышенного риска: усиленные
                            порывы ветра и температурные колебания.
                            В контейнерах очень мало места для полноценного роста деревьев, поэтому они должны получать
                            необходимое количество воды и питательных элементов. Посадка деревьев на крышах зависит и от
                            месторасположения будущего сада. То есть прочные конструкции крыши парковок смогут выдержать
                            любую массу.
                            Выбирая виды деревьев для озеленения крыш и благоустройства территории с помощью
                            контейнерных растений учитывайте бюджет, который вы готовы направить на данную услугу.
                            Ведь дерево в контейнере или на крыше требует постоянного ухода и обслуживания, чем сильно
                            отличается от обычных деревьев, посаженных в грунте.
                        </p>
                    </div>
                </div>
                <div class="w-100 pt-5 pb-5 font-weight-lighter" style="background: #c3b49f;">
                    <div class="static-page-section container">
                        <h2>Деревья с множеством стволов для посадки в контейнерах и на крыше</h2>
                        <p>
                            Лучшим выбором для кровельного озеленения являются многоствольные деревья. Центр тяжести
                            таких деревьев расположен в нижней части за счет множества стволов, это позволит дереву
                            сохранить свою форму даже при сильном ветре.
                            Посадка многоствольных деревьев увеличивает обзор рассмотрения и улучшает эстетику
                            окружающего пространства. В нашем питомнике представлено множество видов многоствольных
                            деревьев.

                        </p>
                        <a href="" class="read-more-btn">Выбрать дерево для вашего ландшафта <i
                                class="mdi mdi-24px mdi-chevron-right-circle-outline ml-2"></i> </a>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
