<!-- Modal -->
<div class="modal fade" id="delete_role{{ $role->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> {{trans('back.Delete_Role')}} </h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
            </div>
            <div class="modal-body">
                <h6>
                    {{trans('back.Are you sure to delete')}}
                    {{ $role->name }}
                </h6>

                <form action=" {{route('roles.destroy', $role->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('back.close')}} </button>
                        <button type="submit" class="btn btn-danger">{{trans('back.delete')}} </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
