@extends('frontend.layouts.design')
@section('title', 'Горсад - Дизайн')
@section('page-title')
    <div class="design-title">Стили ландшафтного дизайна</div>
@endsection
@section('page-description')
    Натуральность и естественный стиль, точные геометрические формы, величественные парки в английском стиле пейзажа или
    минималистические японские сады. Это лишь некоторая доля различных стилей озеленения, которая создавалась в разных
    уголках мира на протяжении нескольких веков.
    Все они имеют свои особенности и тематический ассортимент.
@endsection
@section('image')
    <img src="/storage/images/public/design/design_index_bg.jpg" alt="">
@endsection
@section('top-banner','1')
@section('banner-class', 'banner-pdl')
@section('content')
    <div class="container-pd">
        <div class="point-links design-point-links">
            <div class="point-link">
                <img src="/storage/images/public/design/outdoor_design_thmb.jpg" alt="">
                <div>
                    <div class="point-title design-point-title">
                        <a href="{{route('outdoor_design')}}">Внешнее пространство</a>
                        <img src="/storage/images/public/icons/arrow_right_up.png" alt="">
                    </div>
                    <div class="point-description">
                        Внешний ландшафт - это не просто фон, а ключевой элемент, который придает уникальный характер и
                        эмоциональное воздействие на окружающее пространство.
                    </div>
                </div>
            </div>
            <div class="point-link">
                <img src="/storage/images/public/design/ecology_thmb.jpg" alt="">
                <div>
                    <div class="point-title design-point-title">
                        <a href="{{route('ecology')}}">Экология</a>
                        <img src="/storage/images/public/icons/arrow_right_up.png" alt="">
                    </div>
                    <div class="point-description">
                        Деревья и другие виды устойчивых элементов ландшафта являются основополагающими частями
                        природного
                        баланса в человеческой среде. Деревья значительно снижают эффект локального перегрева в
                        городском
                        климате. Они улучшают влажность воздуха за счет водяного пара, снижают его температуру и
                        минимизируют
                        содержание углекислого газа.
                        Деревья необходимы для больших городов, дорог и промышленных районов с целью улучшения качества
                        воздуха
                    </div>
                </div>
            </div>
            <div class="point-link">
                <img src="/storage/images/public/design/roofs_thmb.jpg" alt="">
                <div>
                    <div class="point-title design-point-title">
                        <a href="{{route('roofs')}}">Кровля и контейнеры</a>
                        <img src="/storage/images/public/icons/arrow_right_up.png" alt="">
                    </div>
                    <div class="point-description">
                        Озеленение крыш и благоустройство территории с помощью контейнерных растений становится все
                        более
                        популярной услугой в ландшафтном дизайне.
                        Это очень ценный компонент дизайна для городской среды, так как он значительно улучшает экологию
                        и
                        эстетику заданной местности.
                        Одними из основных факторов обустройства садов на крыше с помощью контейнерных деревьев и
                        растений
                        являются работы по управлению и обслуживанию процесса.
                    </div>
                </div>
            </div>
        </div>
        <div class="point-links mt-0">
            <div class="point-link flex-1">
                <img src="/storage/images/public/design/street_profiles_thmb.jpg" alt="">
                <div>
                    <div class="point-title design-point-title">
                        <a href="{{route('street_profiles')}}">Улицы и аллеи</a>
                        <img src="/storage/images/public/icons/arrow_right_up.png" alt="">
                    </div>
                    <div class="point-description">
                        При оформлении ландшафтного дизайна улиц и аллей специалисты должны обращать внимание на
                        требования
                        к эстетике и комфорту в использовании.
                        Несмотря на увеличение стесненности
                        в пространстве над и под землей, перед людьми стоит основная задача во внедрении функционального
                        дизайна.
                        И это действительно подвиг мастеров своего дела. Так как в таких случаях очень трудно проявить
                        оригинальность, что и обуславливает схожую планировку улиц в большинстве городов.

                    </div>
                </div>
            </div>
            <div class="point-link flex-1">
                <img src="/storage/images/public/design/lighting_thmb.jpg" alt="">
                <div>
                    <div class="point-title design-point-title">
                        <a href="{{route('street_lighting')}}">Освещение</a>
                        <img src="/storage/images/public/icons/arrow_right_up.png" alt="">
                    </div>
                    <div class="point-description">
                        В большинстве случаев фонарные столбы и деревья устанавливаются поочередно на одной линии.
                        Такое близкое расположение очень неудобно за счет корней дерева и разросшихся кронов. Ведь при
                        ремонте подземных компонентов могут быть задеты корни деревьев. А сильно разросшиеся кроны
                        мешают
                        попаданию солнечного света.
                        С целью предупреждения данных проблем в процессе разработки следует рассчитывать размеры корней
                        и
                        кронов взрослого дерева. А затем подбирать другие варианты посадки и планировки.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
