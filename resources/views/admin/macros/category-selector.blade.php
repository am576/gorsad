@php
$categories = App\Category::all();
$selected = isset($product_category);
@endphp
<select name="category_id" id="category_id">
    @foreach($categories as $category)
        <option value="{{$category->id}}" @if($selected && $category->id==$product_category) selected="selected"@endif>{{$category->title}}</option>
    @endforeach
</select>
