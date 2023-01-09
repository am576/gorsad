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
                        <h4>Lorem ipsum dolor</h4>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sin autem est in ea, quod quidam
                            volunt, nihil impedit hanc nostram comprehensionem summi boni. Ego quoque, inquit, didicerim
                            libentius si quid attuleris, quam te reprehenderim. Estne, quaeso, inquam, sitienti in bibendo
                            voluptas? Duo Reges: constructio interrete. Quid est igitur, inquit, quod requiras? Quod autem
                            ratione actum est, id officium appellamus.
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
                        <h4>Lorem ipsum dolor</h4>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sin autem est in ea, quod quidam
                            volunt, nihil impedit hanc nostram comprehensionem summi boni. Ego quoque, inquit, didicerim
                            libentius si quid attuleris, quam te reprehenderim. Estne, quaeso, inquam, sitienti in bibendo
                            voluptas? Duo Reges: constructio interrete. Quid est igitur, inquit, quod requiras? Quod autem
                            ratione actum est, id officium appellamus.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
