@extends('frontend.layouts.app')
@section('title', 'Gorsad - Дизайн - Внешнее пространство')
@section('content')
@push('styles')
    <link href="{{ asset('css/staticinfo_page.css') }}" rel="stylesheet">
@endpush
    <div class="container-fluid">
        <div class="row justify-content-center">
            @include('frontend.design.menu')
            @include('frontend.design.mmenu')
            <section class="page-bg col-md-12 p-0">
                <div class="page-img-main" style="background-image: url('/storage/images/public/design/outdoor_bg.jpg'); ">
                    <h1 class="page-img-title" style="">Натуральная красота и неповторимость</h1>
                </div>
            </section>
            <div class="colorbar" style="background: #c76e2b;"></div>
            <section class="page-content w-100">
                <div class="container pt-5 pb-5 font-weight-lighter">
                    <p>
                        Дизайн внешнего пространства является результатом взаимодействия нескольких элементов, среди
                        которых
                        обязательная роль отводится выбору подходящего растения.
                        Деревья и множество других растений позволяют создавать бесконечное число возможностей для
                        улучшения
                        открытой местности, где будет идеальная гармония баланса и функциональности.
                        Применение нашего опыта и знаний специалистами питомника «Городской садовник» поможет вам сделать
                        правильный
                        выбор и продемонстрирует особенности наших деревьев для Вашего дизайна.
                    </p>
                </div>
                <div class="w-100 pt-4 pt-5 pb-5 font-weight-lighter" style="background: #efefef;">
                    <div class="container">
                        <div class="d-flex">
                            <img src="{{asset('storage/images/public/design/outdoor1.jpg')}}" style="height: max-content;" alt="">
                            <div class="pl-5">
                                <h2>Натуральный баланс от природы</h2>
                                <p style="line-height: 30px;">
                                    Довольно часто можно увидеть изменения предпочтений от монокультурных садов в
                                    определенном стиле к смешанному типу, когда у каждого дерева есть собственное место для
                                    роста и развития в природной среде.
                                    Именно этот подход позволяет добиться баланса природы в стандартных городских условиях.
                                    И, если дерево не будет ограничено в своем развитии и росте, то это обеспечит создание
                                    красивого и неповторимого габитуса, удобного для долгосрочного обслуживания.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="pt-5 pb-5">
                        <h2>Деревья, у которых есть свои особенности и характер</h2>
                        <p>
                            Питомник «Городской садовник» занимается выращиванием деревьев с применением собственного опыта и
                            взаимодействия в садовом и ландшафтном дизайне.
                            В своей работе мы используем творческий подход и постоянно стремимся к внедрению инновации в
                            дизайне, цвете и применении деревьев с учетом их индивидуальных характеристик.
                            Кто-то обращает внимание на необычную форму и считает это причиной для выбора, а кому-то
                            может быть интересен цвет или неповторимый купол.
                            Такой подход в работе позволяет выращивать неповторимые деревья, у которых будет свой
                            характер. Так наша работа улучшит атмосферу вашего открытого пространства, обеспечит баланс
                            природы в рамках человеческого взгляда.
                            В питомнике «Городской садовник» представлено множество деревьев для парков, бульваров, а также
                            различные виды кустарников. Каждое дерево, выращенное нами имеет свой характер, вы
                            обязательно это почувствуете, просто посетив наш питомник.
                        </p>
                    </div>
                </div>
                <div class="w-100 pt-4 pt-5 pb-5 font-weight-lighter" style="background: #efefef;">
                    <div class="container">
                        <div class="d-flex">
                            <img src="{{asset('storage/images/public/design/outdoor1.jpg')}}" style="height: max-content;" alt="">
                            <div class="pl-5">
                                <h2>Деревья с множеством стволов</h2>
                                <p>
                                    Деревья с множеством стволов создают идеальный контраст со стандартными образами и профилями
                                    городской среды. Они придают пространству неповторимую атмосферу комфорта и баланса за счет
                                    собственных особенностей и интересных форм.
                                </p>
                                <a href="">Получите свою дозу вдохновения прямо сейчас! (буклет)</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
