@extends('frontend.layouts.master')
@section('title', 'Gorsad')
@push('head')
    <link href="{{ asset('css/home-page.css') }}" rel="stylesheet">
@endpush
@section('body')
    <div id="home-page">
        <div id="home-top-block-wr">
            <div id="home-top-block-inner" class="container-pd">
                <div id="main-text">
                    Саженцы деревьев и кустарников в Калининграде и области
                </div>
                <div id="desc-text">
                    Преобразите свое пространство с помощью профессиональных услуг и широкого ассортимента деревьев и
                    кустарников компании «Городской Садовник»
                </div>
                <button class="btn-green">Перейти в каталог</button>
            </div>
        </div>
        <div class="body-bg">
            <div id="suited-for" class="container-pd">
                <div id="suited-for-caption">
                    Подходят<br>
                    для разных целей
                </div>
                <div id="suited-for-list">
                    <div id="industrial" class="suited-for-item">
                        <span class="suited-for-icon"></span>
                        <h4>Промышленные объекты</h4>
                        <div class="suited-for-description">Подходит для таких-то объектов, которые сталкиваются с тем
                            что,
                            короткое описание
                        </div>
                    </div>
                    <div id="schools" class="suited-for-item">
                        <span class="suited-for-icon"></span>
                        <h4>Школы</h4>
                        <div class="suited-for-description">Подходит для таких-то объектов, которые сталкиваются с тем
                            что,
                            короткое описание
                        </div>
                    </div>
                    <div id="private" class="suited-for-item">
                        <span class="suited-for-icon"></span>
                        <h4>Частные проекты</h4>
                        <div class="suited-for-description">Подходит для таких-то объектов, которые сталкиваются с тем
                            что,
                            короткое описание
                        </div>
                    </div>
                    <div id="complex" class="suited-for-item">
                        <span class="suited-for-icon"></span>
                        <h4>Комплексное озеленение</h4>
                        <div class="suited-for-description">Подходит для таких-то объектов, которые сталкиваются с тем
                            что,
                            короткое описание
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="home-landing-form1">
            <div class="home-landing-form1-inner container-pd">
                <div><input type="text" placeholder="Имя"></div>
                <div><input type="text" placeholder="Телефон"></div>
                <div><input type="text" placeholder="E-mail"></div>
                <button class="btn-green no-border-radius">Обсудить проект</button>
            </div>
        </div>
        <div class="body-bg">
            <div id="catalog-block" class="home-block container-pd">
                <div class="block-description">
                    <div class="d-flex flex-column">
                        <h4>Наш каталог</h4>
                        <div class="fz18">
                            Каталог разработан для удобства использования как новичками,
                            так и специалистами из отдела ПТО, что позволяет вам выбрать идеальное растение для любого
                            пространства и условий выращивания.
                        </div>
                    </div>
                    <div>
                        <img src="/storage/images/public/homepage/catalog-trees.png" alt="">
                    </div>
                </div>
                <span class="italic-link">В каталог</span>
                <div id="catalog-links" class="links-list">
                    <div id="list-trees" class="catalog-link home-shop-link">
                        <div class="catalog-link-title link-title">
                            Лиственные деревья
                            и кустарники
                        </div>
                    </div>
                    <div id="hvoy-trees" class="catalog-link home-shop-link">
                        <div class="catalog-link-title link-title">
                            Хвойные деревья
                        </div>
                    </div>
                    <div id="form-trees" class="catalog-link home-shop-link">
                        <div class="catalog-link-title link-title">
                            Формовые деревья
                        </div>
                    </div>
                    <div id="fruit-trees" class="catalog-link home-shop-link">
                        <div class="catalog-link-title link-title">
                            Фруктовые деревья
                        </div>
                    </div>
                </div>
            </div>
            <div id="services-block" class="home-block container-pd">
                <div class="block-description">
                    <div class="d-flex flex-column">
                        <h4>Какие услуги мы оказываем?</h4>
                        <div class="fz18">
                            Дополнительно мы можем предоставить вам различные услуги по проектированию, планировочным
                            работам, озеленению, устройству газонов и дорожек, обслуживанию и бесплатным консультациям!
                        </div>
                    </div>
                    <div>
                        <img src="/storage/images/public/homepage/services-trees.png" alt="">
                    </div>
                </div>
                <span class="italic-link">Наши услуги</span>
                <div id="services-links" class="links-list">
                    <div id="planting" class="service-link home-shop-link">
                        <div class="service-link-title link-title">
                            <h4>Высадка деревьев</h4>
                            <div>Ищете, кто может помочь в высадке/ пересадке деревьев?</div>
                            <button class="btn-green w-100 no-border-radius">1000 &#8381;</button>
                        </div>
                    </div>
                    <div id="landscaping" class="service-link home-shop-link">
                        <div class="service-link-title link-title">
                            <h4>Озеленение</h4>
                            <div>Ищете, кто может помочь в высадке/ пересадке деревьев?</div>
                            <button class="btn-green w-100 no-border-radius">1000 &#8381;</button>
                        </div>
                    </div>
                    <div id="leveling" class="service-link home-shop-link">
                        <div class="service-link-title link-title">
                            <h4>Выравнивание участка</h4>
                            <div>Ищете, кто может помочь в высадке/ пересадке деревьев?</div>
                            <button class="btn-green w-100 no-border-radius">1000 &#8381;</button>
                        </div>
                    </div>
                    <div id="cutting" class="service-link home-shop-link">
                        <div class="service-link-title link-title">
                            <h4>Удаление поросли</h4>
                            <div>Ищете, кто может помочь в высадке/ пересадке деревьев?</div>
                            <button class="btn-green w-100 no-border-radius">1000 &#8381;</button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="helpful" class="container-pd">
                <div class="heading">Это может быть полезно</div>
                <div id="tree-care" class="info-block">
                    <div class="info-block-text-wr">
                        <div class="info-block-text">
                            <div class="heading">
                                Как ухаживать за деревьями
                            </div>
                            <div>
                                Мы собрали для вас передовой опыт в уходе за деревьями от передовых специалистов, а также
                                разработали удобные гайды.
                            </div>
                        </div>
                        <span class="italic-link">Советы</span>
                    </div>

                    <img src="/storage/images/public/homepage/tree-care-bg.jpg" alt="">
                </div>
                <div id="styles">
                    <div class="info-block">
                        <img src="/storage/images/public/homepage/styles-bg.jpg" alt="">
                        <div class="info-block-text-wr">
                            <div class="info-block-text">
                                <div class="heading">
                                    Стили в ландшафтном дизайне
                                </div>
                                <div>
                                    Познакомьтесь со всеми основными стилями ландшафтного дизайна и выберите лучшего
                                    специалиста для себя и своего дома или другого пространства.
                                </div>
                            </div>
                            <span class="italic-link">Дизайн</span>
                        </div>
                    </div>
                </div>
            </div>
            <div id="vacancies" class="container-pd">
                <div id="vacancies-form">
                    <div class="text-center">
                        <div class="heading">Вакансии</div>
                        <div class="form-description">
                            Ищем рабочих для ландшафтных работ и ландшафтных дизайнеров
                        </div>
                    </div>
                    <form action="">
                        <input type="text" placeholder="Ваше имя">
                        <input type="text" placeholder="E-mail">
                        <input type="text" placeholder="Комментарий">
                        <button type="submit" class="btn-green no-border-radius">Отправить</button>
                    </form>
                </div>
            </div>
            <div id="clients" class="container-pd">
                <div class="heading">Наши клиенты</div>
                <div id="clients-slider">
                    <div class="client-block">
                        <img src="/storage/images/public/homepage/clients/oooksk.png" alt="">
                    </div>
                    <div class="client-block">
                        <img src="/storage/images/public/homepage/clients/delta.png" alt="">
                    </div>
                    <div class="client-block">
                        <img src="/storage/images/public/homepage/clients/rzd.png" alt="">
                    </div>
                </div>
            </div>
        </div>
        <div id="landing-form-wr">
            <div id="landing-form" class="container-pd">
                <div id="form-description-wr">
                    <div class="heading">Остались вопросы?</div>
                    <div class="form-description">
                        Оставьте свои контакты, и мы перезвоним вам или напишем в ближайшее время!
                    </div>
                </div>
                <form action="">
                    <input type="text" name="" id="" placeholder="Имя">
                    <input type="text" name="" id="" placeholder="Телефон">
                    <input type="text" name="" id="" placeholder="E-mail">
                    <div id="checkboxes">
                        <label class="checkbox-container">Позвоните мне
                            <input type="checkbox" name="" id="" checked="checked">
                            <span class="checkmark"></span>
                        </label>
                        <label class="checkbox-container">Напишите мне
                            <input type="checkbox" name="" id="">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                    <button type="submit" class="btn-green no-border-radius w-75">Отправить</button>
                </form>
            </div>
        </div>
    </div>
@endsection
