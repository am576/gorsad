@extends('frontend.layouts.app')
@section('title', 'Gorsad')
@section('content')
<div class="container-fluid layout-spacing">
    <div class="row justify-content-center">
        <div class="col-md-12 p-0">
            <home-slider></home-slider>
            <div class="d-flex justify-content-center filter-small-wrapper">
                <filter-small :filter_attributes="{{$filter_attributes}}"></filter-small>
            </div>
            <div class="pt-3 border-bottom">
                <div class="home-text">
                    <div class="container">
                        <p style="font-size: 30px">
                            Преобразите свое пространство с помощью удобного каталога растений и профессиональных услуг
                            компании Городской Садовник. Наш каталог разработан для удобства использования как
                            новичками, так и специалистами из отдела ПТО, что позволяет вам выбрать идеальное растение
                            для любого пространства и условий выращивания.
                        </p>
                    </div>
                </div>
                <div style="margin-top: -25px">
                    <services-list></services-list>
                </div>
                <div class="home-partners">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="partners-title">Наши клиенты</div>
                        </div>
                        <div class="row pt-5 pb-5" style="justify-content: space-evenly">
                            <div>
                                <img src="/storage/images/public/partners/1.png" alt="">
                            </div>
                            <div>
                                <img src="/storage/images/public/partners/2.png" alt="">
                            </div>
                            <div>
                                <img src="/storage/images/public/partners/3.png" alt="">
                            </div>
                            <div>
                                <img src="/storage/images/public/partners/4.png" alt="">
                            </div>
                            <div>
                                <img src="/storage/images/public/partners/5.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="home-text2">
                    <div class="container">
                        <h3>Наши клиенты</h3>
                        <p style="font-size: 24px">
                            Наше стремление соблюдать отраслевые стандарты и постоянно двигаться к совершенству в нашей
                            работе не просто красивые слова. Мы инвестируем в постоянное обучение и развитие наших
                            сотрудников, а также используем передовые материалы и технологии для обеспечения высокого
                            уровня качества. Обращаясь в компанию Городской садовник, вы можете быть уверены, что
                            получите профессиональную консультацию, умело выполненную работу и высококачественные
                            растения. Наша приверженность в удовлетворении клиента подкрепляется нашей гарантией и
                            проверенным послужным списком, основанным на многолетнем опыте и многочисленных успешных
                            проектах.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
