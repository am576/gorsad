@extends('frontend.layouts.knowhow')
@section('title', 'Горсад - Советы | Топиарные и формованные деревья')
@section('current-page-link')
    /<a href="{{route('shape_trees')}}">Топиарные и формованные деревья</a>
@endsection
@section('page-title')
    <div class="topiar-title">Топиарные и формованные деревья</div>
@endsection
@section('image')
    <img src="/storage/images/public/knowhow/shape_trees_bg.jpg" alt="">
@endsection
@section('banner-class', 'banner-pc')
@section('body-bg')
    <div id="topiar-types">
        <div class="heading">Топиарные виды</div>
        <div class="shape-icons">
            <div>
                <div class="topiar-icon">
                    <img src="/storage/images/public/knowhow/icons/stvol_bez.png" alt="">
                    <div class="type-name">Со стволами и без</div>
                </div>
                <div class="topiar-icon">
                    <img src="/storage/images/public/knowhow/icons/arcs.png" alt="">
                    <div class="type-name">Арки из живых растений и цветов</div>
                </div>
                <div class="topiar-icon">
                    <img src="/storage/images/public/knowhow/icons/spherical.png" alt="">
                    <div class="type-name">Фигуры в виде следующих форм: шар, чаша, цилиндр, куб и т.д.</div>
                </div>
                <div class="topiar-icon">
                    <img src="/storage/images/public/knowhow/icons/candel.png" alt="">
                    <div class="type-name">Деревья-канделябр</div>
                </div>
                <div class="topiar-icon">
                    <img src="/storage/images/public/knowhow/icons/roof.png" alt="">
                    <div class="type-name">Форма в виде крыши</div>
                </div>
            </div>
            <div>
                <div class="topiar-icon">
                    <img src="/storage/images/public/knowhow/icons/spaler.png" alt="">
                    <div class="type-name">Деревья, установленные на шпалеру</div>
                </div>
                <div class="topiar-icon">
                    <img src="/storage/images/public/knowhow/icons/pollard.png" alt="">
                    <div class="type-name">Поллард – метод обрезки деревьев для контроля их размера и формы</div>
                </div>
                <div class="topiar-icon">
                    <img src="/storage/images/public/knowhow/icons/screen.png" alt="">
                    <div class="type-name">Деревья в виде экрана</div>
                </div>
                <div class="topiar-icon">
                    <img src="/storage/images/public/knowhow/icons/manystems.png" alt="">
                    <div class="type-name">Деревья крышевидных и зонтичных форм с множеством стволов</div>
                </div>
                <div class="topiar-icon">
                    <img src="/storage/images/public/knowhow/icons/liveizg.png" alt="">
                    <div class="type-name">Живая изгородь</div>
                </div>
            </div>
            <a href="" class="italic-link text-center">Посмотреть инструкцию</a>
        </div>
    </div>
    <div id="form-types">
        <div class="heading">Формованные деревья</div>
        <div class="shape-icons">
            <div>
                <div class="topiar-icon">
                    <img src="/storage/images/public/knowhow/icons/multistem.png" alt="">
                    <div class="type-name">Многоствольные варианты</div>
                </div>
                <div class="topiar-icon">
                    <img src="/storage/images/public/knowhow/icons/shorthigh.png" alt="">
                    <div class="type-name">С невысоким стволом и высокоствольные сорта</div>
                </div>
                <div class="topiar-icon">
                    <img src="/storage/images/public/knowhow/icons/unusual.png" alt="">
                    <div class="type-name">С необычной «прямой» кроной – колоновидные сорта</div>
                </div>
                <div class="topiar-icon">
                    <img src="/storage/images/public/knowhow/icons/weeping.png" alt="">
                    <div class="type-name">Со свисающими, поникающими ветвями – плакучие сорта</div>
                </div>
            </div>
            <div class="d-flex justify-content-center" style="gap: inherit">
                <div class="topiar-icon">
                    <img src="/storage/images/public/knowhow/icons/round.png" alt="">
                    <div class="type-name">С шаровидной кроной</div>
                </div>
                <div class="topiar-icon">
                    <img src="/storage/images/public/knowhow/icons/central.png" alt="">
                    <div class="type-name">С ветвлением от земли и центральным стволом</div>
                </div>
            </div>
            <a href="" class="italic-link text-center">Посмотреть инструкцию</a>
        </div>
    </div>
@endsection
