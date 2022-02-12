@extends('frontend.layouts.app')
@section('title', 'Gorsad')
@section('content')
<div class="container-fluid projects-all">
    <div class="row justify-content-center">
        <div class="col-md-12 p-0 projects-wrapper flex-column align-items-center">
            <projects-list :projects="{{$projects}}"></projects-list>
        </div>
        <div class="w-100" style="background-color: #efe4d8;">
            <div class="container" >
                <div class="projects-disclaimer">
                    <h4><strong>Lorem ipsum dolor</strong></h4>
                    sit amet, consectetur adipiscing elit. Sin autem est in ea, quod quidam
                    volunt, nihil impedit hanc nostram comprehensionem summi boni. Ego quoque, inquit, didicerim
                    libentius si quid attuleris, quam te reprehenderim. Estne, quaeso, inquam, sitienti in bibendo
                    voluptas? Duo Reges: constructio interrete. Quid est igitur, inquit, quod requiras? Quod autem
                    ratione actum est, id officium appellamus.
                </div>
            </div>
        </div>


    </div>
</div>
@endsection
