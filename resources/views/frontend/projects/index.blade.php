@extends('frontend.layouts.app')
@section('title', 'Gorsad - Проекты')
@section('content')
<div class="container-fluid projects-index">
    <div class="row justify-content-center">
        <div class="col-md-12 p-0">
            <projects-map :projects="{{$projects}}"></projects-map>
            <div class="pt-3 border-bottom">
                <div class="home-text">
                    <div class="container">
                        <h4><strong>Lorem ipsum dolor</strong></h4>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sin autem est in ea, quod quidam
                            volunt, nihil impedit hanc nostram comprehensionem summi boni. Ego quoque, inquit, didicerim

                        </p>
                    </div>
                </div>
                <div class="project-row">
                    <div class="col-2 mobile-hide"></div>
                    <div class="col-md-4 col-sm-12 project-image" style="background-image: url('/storage/images/projects/project-01.jpg')">
                        ул. Аэропортная
                    </div>
                    <div class="col-md-6 col-sm-12 project-description">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eget sapien sed nisi luctus
                            tempus vitae quis lacus. Proin quis facilisis est. Sed egestas ex purus, sit amet
                            dapibus
                            enim condimentum faucibus. Integer nec luctus tellus, ac faucibus turpis. Aliquam
                            scelerisque vehicula luctus.
                        </p>
                        <button class="project-button">Перейти</button>
                    </div>
                </div>
                <div class="project-row">
                    <div class="col-2 mobile-hide"></div>
                    <div class="col-md-4 col-sm-12 project-image" style="background-image: url('/storage/images/projects/project-02.jpg')">
                        Рудник К-Поташ Сервис
                    </div>
                    <div class="col-md-6 col-sm-12 project-description">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eget sapien sed nisi luctus
                            tempus vitae quis lacus. Proin quis facilisis est. Sed egestas ex purus, sit amet
                            dapibus
                            enim condimentum faucibus. Integer nec luctus tellus, ac faucibus turpis. Aliquam
                            scelerisque vehicula luctus.
                        </p>
                        <button class="project-button">Перейти</button>
                    </div>
                </div>
                <div class="project-row mb-0">
                    <div class="col-2 mobile-hide"></div>
                    <div class="col-md-4 col-sm-12 project-image" style="background-image: url('/storage/images/projects/project-03.jpg')">
                        Деревья в Центральном парке
                    </div>
                    <div class="col-md-6 col-sm-12 project-description">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eget sapien sed nisi luctus
                            tempus vitae quis lacus. Proin quis facilisis est. Sed egestas ex purus, sit amet
                            dapibus
                            enim condimentum faucibus. Integer nec luctus tellus, ac faucibus turpis. Aliquam
                            scelerisque vehicula luctus.
                        </p>
                        <button class="project-button">Перейти</button>
                    </div>
                </div>
                <div class="show-all-projects">
                    <a href="/projects/all" class="pr-3 pl-3">
                        Посмотреть все проекты
                        <span class="mdi mdi-arrow-right-bold-circle-outline"></span>
                    </a>
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
