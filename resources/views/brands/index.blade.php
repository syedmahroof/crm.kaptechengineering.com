<x-app-layout>
    <x-slot name="title">Brands</x-slot>
    <x-slot name="subtitle">Manage product brands and manufacturers</x-slot>

    <!-- Action Bar -->
    <div class="d-flex justify-content-end mb-4">
        <a href="{{ route('brands.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Add Brand
        </a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Products</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($brands as $brand)
                        <tr>
                            <td>{{ $brand->name }}</td>
                            <td>{{ Str::limit($brand->description, 50) }}</td>
                            <td><span class="badge bg-info">{{ $brand->products_count }}</span></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('brands.edit', $brand) }}" class="btn btn-outline-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('brands.destroy', $brand) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Are you sure?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                No brands found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($brands->hasPages())
        <div class="card-footer">
            {{ $brands->links() }}
        </div>
        @endif
    </div>
</x-app-layout>

