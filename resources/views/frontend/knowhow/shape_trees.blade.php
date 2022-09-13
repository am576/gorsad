@extends('frontend.layouts.app')
@section('title', 'Gorsad - Советы - Формовые и топиарные деревья')
@section('content')
@push('styles')
    <link href="{{ asset('css/staticinfo_page.css') }}" rel="stylesheet">
@endpush
    <div class="container-fluid">
        <div class="row justify-content-center">
            @include('frontend.knowhow.menu')
            <section class="page-bg col-md-12 p-0">
                <div class="page-img-main" style="background-image: url('/storage/images/public/knowhow/topiary_bg.jpg'); ">
                    <h1 class="page-img-title" style="">Топиарные и формованные виды деревьев</h1>
                </div>
            </section>
            <div class="colorbar" style="background: #b3c5ed;"></div>
            <section class="page-content w-100">
                <div class="container pt-5 pb-5">
                    <h2>Топиарные виды</h2>
                    <ul>
                        <li>Со стволами и без.</li>
                        <li>Арки из живых растений и цветов.</li>
                        <li>Фигуры в виде следующих форм: шар, чаша, цилиндр, куб и т.д.</li>
                        <li>Деревья-канделябр</li>
                        <li>Форма в виде крыши.</li>
                        <li>Деревья, установленные на шпалеру.</li>
                        <li>Поллард – метод обрезки деревьев для контроля их зрелого размера и формы.</li>
                        <li>Деревья в виде экрана.</li>
                        <li>Живая изгородь.</li>
                        <li>Деревья крышевидных и зонтичных форм с множеством стволов.</li>
                    </ul>
                    <a href="{{route('guide', ['guide_name' => 'topiar'])}}" target="_blank">Просмотреть инструкцию о Топиарных Деревьях</a>
                </div>
                <div class="container pb-5">
                    <h2>Формованные виды</h2>
                    <ul>
                        <li>Многоствольные варианты.</li>
                        <li>Полустандарт – деревья с невысоким стволом и высокоствольные сорта.</li>
                        <li>Деревья со свисающими, поникающими ветвями – плакучие сорта.</li>
                        <li>Деревья с ветвлением от земли и центральным стволом.</li>
                        <li>Деревья с необычной «прямой» кроной – колоновидные сорта.</li>
                        <li>Деревья с шаровидной кроной.</li>
                    </ul>
                    <a href="{{route('guide', ['guide_name' => 'shape'])}}" target="_blankqq">Просмотреть инструкцию о Формованных Деревьях</a>
                </div>
                <div class="container">
                    <div class="d-flex">
                        <img src="{{asset('storage/images/public/knowhow/multistem.jpg')}}" style="height: max-content;" alt="">
                        <div class="pt-3 pl-5">
                            <h2>Деревья с множеством стволов</h2>

                            Питомник «Натуралист» включает в себя множество разнообразных видов многоствольных деревьев
                            для посадки на любой территории. Мы предоставим для вашего доступа книгу «Многоствольные
                            деревья», которая вдохновит Вас на создание своего видения идеального ландшафта.

                            <a href="">Просмотр</a>
                        </div>
                    </div>
                </div>
                <div class="container pt-5 pb-5">
                    <h2>«Живые» скульптуры</h2>
                    <p>
                        Кроме стандартных правильных форм в питомнике «Натруалист» представлены деревья с эксклюзивными
                        формами. Количество данных экземпляров ограничено. Для получения дополнительной информации о
                        деревьях, просто позвоните по указанному телефону или оставьте заявку на сайте.
                    </p>

                </div>
            </section>
        </div>
    </div>
@endsection
