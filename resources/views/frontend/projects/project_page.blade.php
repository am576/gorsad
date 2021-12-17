@extends('frontend.layouts.app')
@section('title', 'Gorsad')
@section('content')
<div class="container-fluid project-page">
    <div class="row justify-content-center">
        <div class="col-md-12 p-0">
           <div class="project-img-main" style="background-image: url('/storage/images/projects/project-05.jpg');">
               <p class="project-name">Деревья в Центральном парке</p>
           </div>
            <div class="row justify-content-center flex-column align-items-center">
                <div class="project-details text-left">
                    <p class="project-description">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sin autem est in ea, quod quidam
                        volunt, nihil impedit hanc nostram comprehensionem summi boni. Ego quoque, inquit, didicerim
                        libentius si quid attuleris, quam te reprehenderim. Estne, quaeso, inquam, sitienti in bibendo
                        voluptas? Duo Reges: constructio interrete. Quid est igitur, inquit, quod requiras? Quod autem
                        ratione actum est, id officium appellamus.
                    </p>
                    <div class="row project-params flex-column justify-content-center">
                        <div class="row">
                            <div class="col-6">Место</div>
                            <div class="col-6">ул. Аэропортная</div>
                        </div>
                        <div class="row">
                            <div class="col-6">Площадь</div>
                            <div class="col-6">2000 м<sup>2</sup></div>
                        </div>
                        <div class="row">
                            <div class="col-6">Заказчик</div>
                            <div class="col-6">ООО ТВ-Строй</div>
                        </div>
                        <div class="row">
                            <div class="col-6">Растения</div>
                            <div class="col-6">
                                <a class="plant-tag" href="/products/1" target="_blank">клён остролистный</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">Благоустройство</div>
                            <div class="col-6">Городской садовник, ООО</div>
                        </div>
                    </div>
                </div>
                <div class="images-wrapper row w-100 justify-content-center" style="background-color: #efefef;">
                    <project-images></project-images>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection
