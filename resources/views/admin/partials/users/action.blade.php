<div class="btn-group">
    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit">
        <i class="fa fa-pencil-alt"></i>
    </a>
    <button type="button" class="btn btn-sm btn-danger delete" data-toggle="tooltip" title="Delete">
        <i class="fa fa-times"></i>
    </button>
</div>