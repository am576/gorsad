@php
$categories = App\Category::all();
@endphp
<select name="category_id" id="category_id">
    @foreach($categories as $category)
        <option value="{{$category->id}}">{{$category->title}}</option>
    @endforeach
</select>
