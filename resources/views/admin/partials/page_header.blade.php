@php
$entity_config = config('admin.menu.'.$entity);
$title = '';
if (isset($mode))
{
    $submenu = isset($entity_config['submenu']) && $mode == 'index' ? $entity_config['submenu'] : [];
    if($mode == 'index')
    {
        $title = Str::ucfirst($entity_config['title']);
    }
    elseif ($mode == 'edit')
    {
        $title = 'Редактирование ' . $entity_config['genitive'];
    }
    elseif ($mode == 'create')
    {
        $title = 'Создание ' . $entity_config['genitive'];
    }
}
@endphp
<div class="table-header">
    <div class="table-header-caption">
        <h1 class="page-title">
            <i class="mdi mdi-{{ $entity_config['icon'] }}"></i>
            {{$title}}
        </h1>
        @if($with_buttons ?? '')
            <a href="{{ route($entity_config['route'].'.create') }}" class="btn btn-rounded btn-green btn-add-new">
                <i class="mdi mdi-plus"></i>
                <span>Создать</span>
            </a>
            {{--<a href="#" class="btn btn-danger" id="bulk_delete_btn">
                <i class="mdi mdi-trash-can-outline"></i>
                <span>Удалить выбранное</span>
            </a>--}}
        @endif
        @if($create_group ?? '')
            <a href="{{ route($entity_config['route'].'.create_group') }}" class="btn btn-green btn-add-new">
                <i class="mdi mdi-plus"></i>
                <span>Создать группу</span>
            </a>
        @endif
    </div>
    @foreach($submenu as $menu_item)
    <div class="table-header-link">
        <a class="page-title" href="{{route($menu_item['route'].'.index')}}">
            {{Str::ucfirst($menu_item['title'])}}
        </a>
    </div>
    @endforeach
</div>
