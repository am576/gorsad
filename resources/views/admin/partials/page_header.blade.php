@php
$entity_config = config('admin.menu.'.$entity);
if (isset($mode))
{
    if($mode == 'index')
    {
        $title = Str::ucfirst($entity_config['title']);
    }
    elseif ($mode == 'edit')
    {
        $title = 'Изменить ' . $entity_config['singular'];
    }
}
else
{
    $title = '';
}
@endphp
<div class="container-fluid">
    <h1 class="page-title">
        <i class="mdi mdi-{{ $entity_config['icon'] }}"></i>
        {{$title}}
    </h1>
</div>
