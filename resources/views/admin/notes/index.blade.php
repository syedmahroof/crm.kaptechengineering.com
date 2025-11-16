@extends('layouts.admin')

@section('title', 'Notes')

@section('content')
<div class="space-y-6" x-data="{ 
    showAddModal: false, 
    showEditModal: false, 
    editingNote: null,
    formData: { title: '', content: '', category: '', is_pinned: false }
}">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Notes</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Manage your personal notes</p>
        </div>
        <button @click="showAddModal = true; formData = { title: '', content: '', category: '', is_pinned: false }" 
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            <i class="fas fa-plus mr-2"></i>New Note
        </button>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <form method="GET" action="{{ route('notes.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Search notes..." 
                   class="px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
            <select name="category" class="px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                <option value="">All Categories</option>
                @foreach($categories as $key => $label)
                    <option value="{{ $key }}" {{ ($filters['category'] ?? '') == $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            <select name="pinned" class="px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                <option value="">All Notes</option>
                <option value="1" {{ ($filters['pinned'] ?? '') == '1' ? 'selected' : '' }}>Pinned Only</option>
                <option value="0" {{ ($filters['pinned'] ?? '') == '0' ? 'selected' : '' }}>Not Pinned</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Filter</button>
        </form>
    </div>

    <!-- Notes Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($notes as $note)
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg transition-all duration-200 {{ $note->is_pinned ? 'ring-2 ring-yellow-400 dark:ring-yellow-600' : '' }}">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex-1">
                        <div class="flex items-center space-x-2 mb-2">
                            @if($note->is_pinned)
                                <i class="fas fa-thumbtack text-yellow-500"></i>
                            @endif
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $note->title }}</h3>
                        </div>
                        @if($note->category)
                            <span class="inline-block px-2 py-1 text-xs font-medium rounded-full bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                                {{ $categories[$note->category] ?? $note->category }}
                            </span>
                        @endif
                    </div>
                    <div class="flex items-center space-x-2">
                        <button @click="
                            fetch('/notes/{{ $note->id }}/toggle-pin', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name=\"csrf-token\"]')?.getAttribute('content')
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    window.location.reload();
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('Failed to toggle pin. Please try again.');
                            });
                        " 
                                class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400" 
                                title="{{ $note->is_pinned ? 'Unpin' : 'Pin' }}">
                            <i class="fas fa-thumbtack {{ $note->is_pinned ? '' : 'opacity-50' }}"></i>
                        </button>
                        <button @click="
                            fetch('/notes/{{ $note->id }}')
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        editingNote = data.note;
                                        formData = {
                                            title: data.note.title,
                                            content: data.note.content,
                                            category: data.note.category || '',
                                            is_pinned: data.note.is_pinned || false
                                        };
                                        showEditModal = true;
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    alert('Failed to load note. Please refresh the page.');
                                });
                        " 
                                class="text-blue-600 hover:text-blue-900 dark:text-blue-400" 
                                title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form action="{{ route('notes.destroy', $note->id) }}" method="POST" class="inline" 
                              data-confirm="Are you sure you want to delete this note?">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <p class="text-gray-600 dark:text-gray-300 mb-4 line-clamp-3">{{ $note->content }}</p>
                <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                    <span>{{ $note->created_at->diffForHumans() }}</span>
                    <span>{{ $note->user->name ?? 'N/A' }}</span>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <i class="fas fa-sticky-note text-4xl text-gray-400 dark:text-gray-600 mb-4"></i>
                <p class="text-gray-500 dark:text-gray-400">No notes found. Create your first note!</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($notes->hasPages())
        <div class="flex justify-center">
            {{ $notes->links() }}
        </div>
    @endif

    <!-- Add Note Modal -->
    <div x-show="showAddModal" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto" 
         style="display: none;"
         @click.away="showAddModal = false">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" @click="showAddModal = false"></div>
            <div class="relative bg-white dark:bg-gray-800 rounded-xl shadow-2xl border border-gray-200 dark:border-gray-700 w-full max-w-2xl" @click.stop>
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Create New Note</h3>
                    <button @click="showAddModal = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
                <form @submit.prevent="
                    fetch('{{ route('notes.store') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=\"csrf-token\"]')?.getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            title: formData.title,
                            content: formData.content,
                            category: formData.category || null,
                            is_pinned: formData.is_pinned || false
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.reload();
                        } else {
                            alert('Failed to save note. Please try again.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Failed to save note. Please try again.');
                    });
                " class="p-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Title *</label>
                            <input type="text" x-model="formData.title" required
                                   class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Content *</label>
                            <textarea x-model="formData.content" rows="6" required
                                      class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white"></textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Category</label>
                                <select x-model="formData.category"
                                        class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                                    <option value="">Select category...</option>
                                    @foreach($categories as $key => $label)
                                        <option value="{{ $key }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex items-end">
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input type="checkbox" x-model="formData.is_pinned"
                                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="text-sm text-gray-700 dark:text-gray-300">Pin this note</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3 mt-6 border-t border-gray-200 dark:border-gray-700 pt-4">
                        <button type="button" @click="showAddModal = false"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600">
                            Cancel
                        </button>
                        <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                            <i class="fas fa-save mr-2"></i>Save Note
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Note Modal -->
    <div x-show="showEditModal" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto" 
         style="display: none;"
         @click.away="showEditModal = false">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" @click="showEditModal = false"></div>
            <div class="relative bg-white dark:bg-gray-800 rounded-xl shadow-2xl border border-gray-200 dark:border-gray-700 w-full max-w-2xl" @click.stop>
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Edit Note</h3>
                    <button @click="showEditModal = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
                <template x-if="editingNote">
                    <form @submit.prevent="
                        fetch(`/notes/${editingNote.id}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name=\"csrf-token\"]')?.getAttribute('content'),
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                title: formData.title,
                                content: formData.content,
                                category: formData.category || null,
                                is_pinned: formData.is_pinned || false
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                window.location.reload();
                            } else {
                                alert('Failed to update note. Please try again.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Failed to update note. Please try again.');
                        });
                    " class="p-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Title *</label>
                                <input type="text" x-model="formData.title" required
                                       class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Content *</label>
                                <textarea x-model="formData.content" rows="6" required
                                          class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white"></textarea>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Category</label>
                                    <select x-model="formData.category"
                                            class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white">
                                        <option value="">Select category...</option>
                                        @foreach($categories as $key => $label)
                                            <option value="{{ $key }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="flex items-end">
                                    <label class="flex items-center space-x-2 cursor-pointer">
                                        <input type="checkbox" x-model="formData.is_pinned"
                                               class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <span class="text-sm text-gray-700 dark:text-gray-300">Pin this note</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end space-x-3 mt-6 border-t border-gray-200 dark:border-gray-700 pt-4">
                            <button type="button" @click="showEditModal = false; editingNote = null"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                                <i class="fas fa-save mr-2"></i>Update Note
                            </button>
                        </div>
                    </form>
                </template>
            </div>
        </div>
    </div>
</div>

@endsection

