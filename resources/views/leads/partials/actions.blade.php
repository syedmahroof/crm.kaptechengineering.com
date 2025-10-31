<div class="d-flex justify-content-center gap-1">
    <a href="{{ route('leads.show', $lead) }}" 
       class="btn btn-sm btn-outline-primary" 
       title="View Lead"
       style="padding: 6px 12px; border-radius: 8px;">
        <i class="bi bi-eye-fill"></i>
    </a>
    <a href="{{ route('leads.edit', $lead) }}" 
       class="btn btn-sm btn-outline-warning" 
       title="Edit Lead"
       style="padding: 6px 12px; border-radius: 8px;">
        <i class="bi bi-pencil-fill"></i>
    </a>
    <form action="{{ route('leads.destroy', $lead) }}" method="POST" class="d-inline delete-form">
        @csrf
        @method('DELETE')
        <button type="submit" 
                class="btn btn-sm btn-outline-danger delete-btn" 
                title="Delete Lead"
                style="padding: 6px 12px; border-radius: 8px;">
            <i class="bi bi-trash-fill"></i>
        </button>
    </form>
</div>

