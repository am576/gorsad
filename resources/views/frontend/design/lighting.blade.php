@extends('frontend.layouts.app')
@section('title', 'Gorsad - Дизайн - Наружное освещение')
@section('content')
@push('styles')
    <link href="{{ asset('css/staticinfo_page.css') }}" rel="stylesheet">
@endpush
    <div class="container-fluid">
        <div class="row justify-content-center">
            @include('frontend.design.menu')
            @include('frontend.design.mmenu')
            <section class="page-bg col-md-12 p-0">
                <div class="page-img-main" style="background-image: url('/storage/images/public/design/lighting_bg.jpg'); ">
                    <h1 class="page-img-title" style="">Наружное освещение и деревья</h1>
                </div>
            </section>
            <div class="colorbar" style="background: #486b24;"></div>
            <section class="page-content w-100">
                <div class="container pt-5 pb-5 font-weight-lighter">
                    <p>
                        В большинстве случаев фонарные столбы и деревья устанавливаются поочередно на одной линии.
                        Такое близкое расположение очень неудобно за счет корней дерева и разросшихся кронов. Ведь при
                        ремонте подземных компонентов могут быть задеты корни деревьев. А сильно разросшиеся кроны
                        мешают попаданию солнечного света.
                        С целью предупреждения данных проблем в процессе разработки следует рассчитывать размеры корней
                        и кронов взрослого дерева. А затем подбирать другие варианты посадки и планировки.
                    </p>
                </div>
                <div class="w-100 font-weight-lighter" style="background: #efefef;">
                    <div class="static-page-section container font-weight-lighter">
                        <div class="d-flex">
                            <div class="mw-50" style="border-right: 2px solid rgba(138,138,138,0.1); padding-right: 3rem;">
                                <h2>Размеры деревьев</h2>
                                Размеры деревьев определяются на основе нескольких факторов: вида, скорости развития и
                                времени нахождения в одном месте.
                                Если дерево посажено в открытом пространстве с учетом всех требований к долгосрочному
                                развитию, то у сортов деревьев есть необходимое место для роста и достижения
                                определенных размеров.
                                Использование базовых принципов дизайна позволит добиться точного расчета размеров
                                дерева в будущем.
                                <a href="" class="w-100 mt-2 read-more-btn">Скачать «Описание размеров деревьев»<i
                                        class="mdi mdi-24px mdi-chevron-right-circle-outline ml-2"></i> </a>
                            </div>
                            <div class="mw-50" style="padding-left: 3rem;">
                                <h2>Установка фонарей и деревьев </h2>
                                Посадка деревьев с целью создания определенного дизайна открытого пространства должна
                                быть реализовано согласно требованиям установки фонарей.
                                Это поможет предотвратить негативное воздействие данных элементов друг на друга в
                                будущем времени.
                                Фонари должны устанавливаться таким образом, чтобы все коммуникации под землей
                                находились вне доступа корневой системы дерева.
                                При определении дистанции между фонарем и деревьями применяются следующие параметры –
                                высота фонаря, ствола и кроны.
                                <a href="" class="w-100 mt-2 read-more-btn">Скачать «Правильный расчет расстояния между деревьями и фонарями». <i
                                        class="mdi mdi-24px mdi-chevron-right-circle-outline ml-2"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-100 font-weight-lighter pt-5 pb-5" style="background: #ecedd4;">
                    <div class="container font-weight-lighter">
                        <h2>Альтернативное планирование</h2>
                        <p>
                            Альтернативные варианты в планировании зависят от поперечного профиля улицы и используются
                            таким образом, чтобы фонари и деревья не мешали друг другу.
                            Специалисты выделили следующие способы альтернативного планирования:
                        </p>
                        <ul class="pl-2">
                            <li>установка источников света на фасадах;</li>
                            <li>линейные способы освещения;</li>
                            <li>установка фонарей и деревьев на разных сторонах дороги;</li>
                            <li>установка фонарей по обе стороны дорог, а посадка деревьев на полосе, которая разделяет проезжую часть;</li>
                            <li>использование навесного освещения.</li>
                        </ul>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
