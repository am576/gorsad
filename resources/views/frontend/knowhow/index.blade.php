@extends('frontend.layouts.knowhow')
@section('title', 'Горсад - Советы')
@section('page-title', 'Как ухаживать за деревьями')
@section('page-description')
    Мы собрали для вас передовой опыт в уходе за деревьями от передовых специалистов, а также разработали удобные гайды.
@endsection
@section('image')
    <img src="/storage/images/public/knowhow/knowhow_index_bg.jpg" alt="">
@endsection
@section('content')
    <div id="advices-links">
        <div class="advice-link">
            <img src="/storage/images/public/knowhow/planting_plan_thmb.jpg" alt="">
            <div>
                <div class="advice-title">
                    <a href="{{route('planning')}}">План посадки</a>
                    <img src="/storage/images/public/icons/arrow_right_up.png" alt="">
                </div>
                <div class="advice-description">
                    Деревья – это один из важнейших компонентов для создания атмосферы и структуры ландшафтного дизайна.
                    Поэтому с целью достижения определенного результата, специалисты рекомендуют обращать внимание на
                    несколько основных факторов, представленных ниже.
                </div>
            </div>
        </div>
        <div class="advice-link">
            <img src="/storage/images/public/knowhow/topiar_form_thmb.jpg" alt="">
            <div>
                <div class="advice-title">
                    <a href="">Топиарные и формованные деревья</a>
                    <img src="/storage/images/public/icons/arrow_right_up.png" alt="">
                </div>
                <div class="advice-description">
                    В данной инструкции отражены особенности выбора формованных деревьев. Вы получите всю информацию,
                    необходимую для сохранения одной формы дерева без постоянного участия человека.
                </div>
            </div>
        </div>
        <div class="advice-link">
            <img src="/storage/images/public/knowhow/tree_order_thmb.jpg" alt="">
            <div>
                <div class="advice-title">
                    <a href="">Заказ деревьев</a>
                    <img src="/storage/images/public/icons/arrow_right_up.png" alt="">
                </div>
                <div class="advice-description">
                    Заказ деревьев - это важный шаг в улучшении окружающей среды. Посадка деревьев способствует
                    увеличению кислорода, созданию зеленых зон и улучшению качества воздуха. Это также способствует
                    сохранению биоразнообразия и созданию природных арт-объектов. Поддержите инициативу заказа деревьев
                    и помогите нашей планете стать более здоровой и устойчивой
                </div>
            </div>
        </div>
    </div>
@endsection

