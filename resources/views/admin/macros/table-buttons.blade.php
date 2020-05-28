<a href="{{$entity->getTable()}}/{{$entity->id}}/edit" title="Изменить" class="btn btn-sm btn-primary pull-right edit">
    <i class="mdi mdi-lead-pencil"></i> <span class="hidden-xs hidden-sm">Изменить</span>
</a>
<form class="table-delete-entity" action="{{$entity->getTable()}}/{{$entity->id}}" method="post">
@csrf
@method('DELETE')
<input type="submit" title="Удалить" class="btn btn-sm btn-danger pull-right delete hidden-xs hidden-sm" value="Удалить">
</form>
