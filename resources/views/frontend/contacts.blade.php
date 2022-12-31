@extends('frontend.layouts.app')
@section('title', 'Gorsad')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="contacts-header w-100 text-center mb-4" style="background-color: #d9dfe1; padding: 70px">
                <h1>Свяжитесь с нами</h1>
                <p>Спасибо за ваш интерес к компании Городской садовник! Пожалуйста, заполните форму или
                    отправьте email на
                    <a href="mailto:mail@gorsad39.ru">mail@gorsad39.ru</a>
                </p>
            </div>
            <div class="col-md-5 p-0">
                <contact-form></contact-form>
            </div>
        </div>
    </div>
@endsection
