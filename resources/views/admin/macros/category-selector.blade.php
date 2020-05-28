@php
$categories = App\Category::all();
if($children_only ?? '')
{
    $categories = App\Category::getChildrenOnly();
}
@endphp
<select name="{{$input_name ?? 'category_id'}}" id="{{$input_name ?? 'category_id'}}">
    @foreach($categories as $category)
        <option value="{{$category->id}}" @if(isset($product_category) && $category->id==$product_category) selected="selected"@endif>{{$category->title}}</option>
    @endforeach
</select>
