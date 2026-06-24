<a href="{{ route('administration.pages.militants.show', $militant) }}" class="btn btn-sm btn-info">
    <i class="fas fa-eye"></i> Voir
</a>
@if($militant->status === 'pending')
<div class="btn-group ml-1">
    <form action="{{ route('administration.pages.militants.update-status', $militant) }}" method="POST" class="d-inline">
        @csrf
        @method('PATCH')
        <input type="hidden" name="status" value="approved">
        <button type="submit" class="btn btn-sm btn-success">
            <i class="fas fa-check"></i> Approuver
        </button>
    </form>
    <form action="{{ route('administration.pages.militants.update-status', $militant) }}" method="POST" class="d-inline ml-1">
        @csrf
        @method('PATCH')
        <input type="hidden" name="status" value="rejected">
        <button type="submit" class="btn btn-sm btn-danger">
            <i class="fas fa-times"></i> Rejeter
        </button>
    </form>
</div>
@endif
<form action="{{ route('administration.pages.militants.destroy', $militant) }}" method="POST" class="d-inline ml-1 js-delete-militant">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-danger">
        <i class="fas fa-trash"></i> Supprimer
    </button>
</form>
