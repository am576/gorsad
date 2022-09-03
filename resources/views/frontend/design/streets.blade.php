@extends('frontend.layouts.app')
@section('title', 'Gorsad - Дизайн - Дизайн улиц и аллей')
@section('content')
@push('styles')
    <link href="{{ asset('css/staticinfo_page.css') }}" rel="stylesheet">
@endpush
    <div class="container-fluid">
        <div class="row justify-content-center">
            @include('frontend.design.menu')
            <section class="page-bg col-md-12 p-0">
                <div class="page-img-main" style="background-image: url('/storage/images/public/design/streets_bg.jpg'); ">
                    <h1 class="page-img-title" style="">Дизайн улиц и аллей</h1>
                </div>
            </section>
            <div class="colorbar" style="background: #727070;"></div>
            <section class="page-content w-100">
                <div class="container pt-5 pb-5 font-weight-lighter">
                    <p>
                        При оформлении ландшафтного дизайна улиц и аллей специалисты должны обращать внимание на
                        требования к эстетике и комфорту в использовании.
                        Несмотря на увеличение стесненности в пространстве над и под землей, перед людьми стоит основная
                        задача во внедрении функционального дизайна.
                        И это действительно подвиг мастеров своего дела. Так как в таких случаях очень трудно проявить
                        оригинальность, что и обуславливает схожую планировку улиц в большинстве городов.
                    </p>
                </div>
                <div class="w-100 pt-5 pb-5 font-weight-lighter" style="background: #efefef;">
                    <div class="container">
                        <div class="d-flex">
                            <img src="{{asset('storage/images/public/design/streets1.jpg')}}" style="height: max-content;" alt="">
                            <div class="pl-5">
                                <h2>Природный баланс на улицах</h2>
                                <p style="line-height: 30px;">
                                    Величественные деревья вдоль аллей – это истинная красота и индивидуальность
                                    природы, реализованная на улицах города. У некоторых городов есть «собственные»
                                    деревья, благодаря которым о них знает весь мир. Платаны – это природный символ
                                    Парижа, Гаага – это каштаны, Берлин славится липами и т.д. Но в настоящее время
                                    заметна следующая тенденция – посадка одинаковых сортов на улицах города. Это
                                    приводит к тому, что у городов больше не остается собственной индивидуальности и
                                    особенной атмосферы. Если изучить историю определенного города, то можно найти те
                                    неповторимые виды деревьев, которые являлись символом данного населенного пункта.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-100 font-weight-lighter" style="background: #ecedd4;">
                    <div class="static-page-section  container font-weight-lighter">
                        <h2>Структура, текстура и окрас </h2>
                        <div class="d-flex">
                            <div class="mw-50 pr-4" style="border-right: 2px solid rgba(138,138,138,0.1); padding-right: 2rem;">
                                Правильное применение уникальных структур, форм и окраса деревьев позволит достичь
                                неповторимой индивидуальности в дизайне улиц и аллей.
                                Если вы посадите платан, то любая местность получит солидное оформление и создаст
                                атмосферу уверенности. А вот размеры
                                робинии напоминают платан, но имеют совершенно другие особенности.
                            </div>
                            <div class="mw-50 pl-4" style="padding-left: 2rem;">
                                 Робиния очень
                                утонченная, немного причудлива, а ее структура и листья создают воздушную крону.
                                Специалисты питомника «Натуралист» помогут Вам сделать правильный выбор.
                                <a href="/contacts" class="mt-2 read-more-btn">Свяжитесь с нами<i
                                        class="mdi mdi-24px mdi-chevron-right-circle-outline ml-2"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container pt-5 pb-5 font-weight-lighter">
                    <div class="d-flex">
                        <img src="{{asset('storage/images/public/design/streets2.jpg')}}" style="height: max-content;" alt="">
                        <div class="pl-5">
                            <h2><strong style="font-size: 26px;">Биологические особенности и устойчивость к болезням </strong></h2>
                            <p>
                                Наша команда занимается активным культивированием различных видов деревьев с целью
                                снижения заболеваемости и увеличения устойчивости к болезням.
                                Посадки для аллеи состоят из нескольких сортов, схожих по внешним параметрам, размерам и
                                условиям ухода.
                                Только представьте, вы видите красивый бульвар из нескольких сортов дерева и можете
                                наблюдать за великолепными изменениями осенью и весной.
                                Смешение генетических видов увеличивает разнообразие выбора и улучшает устойчивость
                                каждой единицы.
                            </p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
