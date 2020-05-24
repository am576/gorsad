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
    @if($with_buttons)
        <a href="{{ route($entity_config['route'].'.create') }}" class="btn btn-success btn-add-new">
            <i class="mdi mdi-plus"></i>
            <span>Создать</span>
        </a>
        <a href="#" class="btn btn-danger" id="bulk_delete_btn">
            <i class="mdi mdi-trash-can-outline"></i>
            <span>Удалить выбранное</span>
        </a>
    @endif
</div>
