<div class="static-info-article">
    <?php
        $reverse = $reverse ?? 0;
    ?>
    @if($reverse)
        <article class="article-text">
            <h4 class="heading">{{$article_heading}}</h4>
            <div class="d-flex flex-column justify-content-between">
                <p class="static-article-description">{!! $article_text !!}</p>
                @if(isset($link))
                    <a href="{{$link['href']}}" class="italic-link-blue">{{$link['text']}}</a>
                @endif
            </div>
        </article>
        <img src="{{$image}}" alt="">
    @else
        <img src="{{$image}}" alt="">
        <article class="article-text">
            <h4 class="heading">{{$article_heading}}</h4>
            <div class="d-flex flex-column justify-content-between">
                <p class="static-article-description">{!! $article_text !!}</p>
                @if(isset($link))
                    <a href="{{$link['href']}}" class="italic-link-blue">{{$link['text']}}</a>
                @endif
            </div>
        </article>
    @endif
</div>
