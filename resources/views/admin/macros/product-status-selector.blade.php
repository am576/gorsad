<select name="status" id="status">
    @foreach(\App\Product::statuses() as $i=>$status)
        <option value="{{$i}}"@if(isset($value) && $value==$i) selected="selected"@endif>{{$status}}</option>
    @endforeach
</select>
