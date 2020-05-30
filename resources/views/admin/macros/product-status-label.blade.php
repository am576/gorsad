@php
if($product->status == 0)
    $class = 'text-danger';
elseif($product->status == 1)
    $class = 'text-success';
@endphp
<span class="{{$class}}">{{\App\Product::getStatusName($product->status)}}</span>
