<img src="{{$image}}" alt="">
<article class="design-style-article">
    <h4 class="heading">{{$style_name}}</h4>
    <p class="style-description">
        {{$style_description}}
    </p>
    @if(isset($link))
        <a href="{{$link['href']}}" class="italic-link-blue static-article-link">{{$link['text']}}</a>
    @endif
</article>
