@php
$categories = App\Category::all();
if($children_only ?? '')
{
    $categories = App\Category::getChildrenOnly();
}
if($exclude_self ?? '')
{
}
@endphp
<select name="{{$input_name ?? 'category_id'}}" id="{{$input_name ?? 'category_id'}}">
        <option value="0">-</option>
        @foreach($categories as $category)
        <option value="{{$category->id}}" @if(isset($selected_category) && $category->id==$selected_category) selected="selected"@endif>{{$category->title}}</option>
        @endforeach
</select>
