@extends('frontend.layouts.design')
@section('title', 'Горсад - Дизайн | Экология')
@section('current-page-link')
    <a href="{{route('ecology')}}">Экология</a>
@endsection
@section('content')
    <div class="body-bg static-page-n">
        <div class="container-pd">
            @include('frontend.design.static-info-article',
            [
                'image' => '/storage/images/public/design/ecology/1.jpg',
                'article_heading' => 'Экология и устойчивое развитие',
                'article_text' => 'Деревья и другие виды устойчивых элементов ландшафта являются
                    основополагающими частями природного баланса в человеческой среде. Деревья значительно снижают
                    эффект локального перегрева в городском климате. Они улучшают влажность воздуха за счет водяного
                    пара, снижают его температуру и минимизируют содержание углекислого газа. Деревья необходимы для
                    больших городов, дорог и промышленных районов с целью улучшения качества воздуха.'
            ])
            @include('frontend.design.static-info-article',
            [
                'image' => '/storage/images/public/design/ecology/2.jpg',
                'article_heading' => 'Дизайн, ориентированный на будущее и выбор посадочного
                                      материала',
                'article_text' => 'С целью устойчивого развития жилых и рабочих открытых пространств используются все
                     виды материалов и возможностей озеленения. Главная особенность дизайна – это умение видеть и быть
                     едиными с природой. Необходимо стремиться к такому балансу, когда природа будет самостоятельно
                     поддерживать собственное развитие. Так, особенности и разнообразие видов природы станут началом
                     данной модернизации. К примеру, выбирая дерево или растение, дизайнеры должны ориентироваться на
                     естественные условия роста и форму.
                     Это обеспечит жизнеспособность зеленых насаждений на долгие годы, а человек сохранит природный баланс.',
                'reverse' => true
            ])
            @include('frontend.design.static-info-article',
            [
                'image' => '/storage/images/public/design/ecology/3.jpg',
                'article_heading' => 'Деревья и экология',
                'article_text' => 'Ландшафтный дизайн – это сложный процесс, который требует особого внимания к
                    экологическим факторам. Ведь большинство видов деревьев имеют огромное значение для живых существ: животных, птиц и других организмов. Посадка деревьев, необходимых для безопасного существования живых
                    существ – это возможность для создания безопасной среды их
                    жизнедеятельности в любой местности. Специалисты рекомендуют быть внимательными к подбору ассортимента деревьев, что
                    обеспечит максимальный природный баланс. Например, клены,
                    каштаны и плодовые деревья необходимы для пчел, а ива поллард нужна для жизнедеятельности белок, уток, пчел и насекомых.
                    Посадка буков и дубов обеспечивает животных пищей.',
                'link' => [
                    'text' => 'Деревья для жизнедеятельности пчёл',
                    'href' => '/design/trees_for_bees'
                ]
            ])
            @include('frontend.design.static-info-article',
            [
                'image' => '/storage/images/public/design/ecology/4.jpg',
                'article_heading' => 'Чем лучше деревья, тем лучше среда',
                'article_text' => 'Многие мировые компании и организации говорят о необходимости
                    устойчивого развития окружающей среды. Общая площадь питомника
                    «Натуралист» равна ____, и нашим основным принципом работы является устойчивое развитие природного баланса.
                    Выращивание растений в естественных условиях обеспечивает
                    возможность их самостоятельной защиты и хороший рост при окончательной посадке. Основные принципы
                    нашей работы – это применение органических удобрений и других биологических средств защиты.
                    Мы максимально снижаем количество используемых пестицидов за счет засева трав и цветов между
                    выращиваемыми деревьями. Мы собираем поливную и дождевую воду с целью повторного применения.',
                'reverse' => true,
                'link' => [
                    'text' => 'Читать дальше',
                    'href' => '/design/trees_for_ecology'
                ]
            ])
        </div>
    </div>
@endsection
