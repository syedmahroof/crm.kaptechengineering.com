@extends('layouts.admin')

@section('title', 'Flight Ticket Details')

@section('content')
<div class="flex flex-col gap-6 rounded-xl">
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-100 dark:from-gray-800 dark:to-gray-900 rounded-xl p-6 mb-6">
        <div class="flex justify-between items-center flex-wrap gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                    <i class="fas fa-plane mr-2"></i>Flight Ticket Details
                </h1>
                <div class="flex items-center space-x-3 flex-wrap">
                    @php
                        $statusColors = [
                            'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                            'quoted' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
                            'booked' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                            'confirmed' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300',
                            'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                        ];
                        $statusColor = $statusColors[$flightTicket->status ?? 'pending'] ?? 'bg-gray-100 text-gray-800';
                        $statusName = $statuses[$flightTicket->status ?? 'pending'] ?? 'Unknown';
                    @endphp
                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColor }}">
                        {{ $statusName }}
                    </span>
                    <span class="text-sm text-gray-600 dark:text-gray-400 flex items-center">
                        <i class="far fa-clock mr-1"></i>
                        Created {{ $flightTicket->created_at->diffForHumans() }}
                    </span>
                </div>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('flight-tickets.edit', $flightTicket->id) }}" 
                   class="px-4 py-2 text-sm font-medium text-indigo-600 bg-white border border-indigo-600 rounded-lg hover:bg-indigo-50 dark:bg-gray-800 dark:text-indigo-400 dark:border-indigo-400">
                    <i class="fas fa-pencil mr-2"></i>Edit
                </a>
                @if($flightTicket->lead)
                <a href="{{ route('leads.show', $flightTicket->lead->id) }}" 
                   class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Lead
                </a>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Flight Details Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Flight Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Route</label>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white mt-1">
                            {{ $flightTicket->departure_airport }} → {{ $flightTicket->arrival_airport }}
                        </p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Departure Date</label>
                        <p class="text-gray-900 dark:text-white mt-1 flex items-center">
                            <i class="fas fa-calendar-alt mr-2 text-gray-400"></i>
                            {{ $flightTicket->departure_date->format('F d, Y') }}
                        </p>
                    </div>
                    @if($flightTicket->return_date)
                    <div>
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Return Date</label>
                        <p class="text-gray-900 dark:text-white mt-1 flex items-center">
                            <i class="fas fa-calendar-check mr-2 text-gray-400"></i>
                            {{ $flightTicket->return_date->format('F d, Y') }}
                        </p>
                    </div>
                    @endif
                    <div>
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Passengers</label>
                        <p class="text-gray-900 dark:text-white mt-1 flex items-center">
                            <i class="fas fa-users mr-2 text-gray-400"></i>
                            {{ $flightTicket->passenger_count }} {{ Str::plural('passenger', $flightTicket->passenger_count) }}
                        </p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Class Type</label>
                        <p class="text-gray-900 dark:text-white mt-1">
                            {{ $classTypes[$flightTicket->class_type] ?? $flightTicket->class_type }}
                        </p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Budget Range</label>
                        <p class="text-gray-900 dark:text-white mt-1">
                            {{ $budgetRanges[$flightTicket->budget_range] ?? $flightTicket->budget_range }}
                        </p>
                    </div>
                    @if($flightTicket->airline_preference)
                    <div>
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Airline Preference</label>
                        <p class="text-gray-900 dark:text-white mt-1">
                            {{ $flightTicket->airline_preference }}
                        </p>
                    </div>
                    @endif
                </div>

                @if($flightTicket->special_requests)
                <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Special Requests</label>
                    <p class="text-gray-900 dark:text-white mt-1">{{ $flightTicket->special_requests }}</p>
                </div>
                @endif
            </div>

            <!-- Booking Details -->
            @if($flightTicket->booking_reference || $flightTicket->total_cost)
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Booking Details</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if($flightTicket->booking_reference)
                    <div>
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Booking Reference</label>
                        <p class="text-gray-900 dark:text-white mt-1 font-mono">
                            {{ $flightTicket->booking_reference }}
                        </p>
                    </div>
                    @endif
                    @if($flightTicket->total_cost)
                    <div>
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Cost</label>
                        <p class="text-gray-900 dark:text-white mt-1 text-lg font-semibold">
                            {{ $flightTicket->currency ?? 'USD' }} {{ number_format($flightTicket->total_cost, 2) }}
                        </p>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Lead Information -->
            @if($flightTicket->lead)
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Lead Information</h3>
                <div class="space-y-3">
                    <div>
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Name</label>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">
                            <a href="{{ route('leads.show', $flightTicket->lead->id) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400">
                                {{ $flightTicket->lead->name }}
                            </a>
                        </p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</label>
                        <p class="text-sm text-gray-900 dark:text-white">{{ $flightTicket->lead->email }}</p>
                    </div>
                    @if($flightTicket->lead->phone)
                    <div>
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Phone</label>
                        <p class="text-sm text-gray-900 dark:text-white">{{ $flightTicket->lead->phone }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Actions -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Actions</h3>
                <div class="space-y-2">
                    @if($flightTicket->lead)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $flightTicket->lead->phone) }}?text={{ urlencode('Flight Ticket Details for ' . $flightTicket->departure_airport . ' to ' . $flightTicket->arrival_airport) }}" 
                       target="_blank"
                       class="block w-full px-4 py-2 text-sm font-medium text-center text-green-600 bg-green-50 border border-green-200 rounded-lg hover:bg-green-100 dark:bg-green-900/20 dark:text-green-400">
                        <i class="fab fa-whatsapp mr-2"></i>Send via WhatsApp
                    </a>
                    <a href="mailto:{{ $flightTicket->lead->email }}?subject=Flight Ticket Details&body={{ urlencode('Flight Details:\nRoute: ' . $flightTicket->departure_airport . ' to ' . $flightTicket->arrival_airport . '\nDate: ' . $flightTicket->departure_date->format('M d, Y') . '\nPassengers: ' . $flightTicket->passenger_count) }}" 
                       class="block w-full px-4 py-2 text-sm font-medium text-center text-blue-600 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 dark:bg-blue-900/20 dark:text-blue-400">
                        <i class="fas fa-envelope mr-2"></i>Send via Email
                    </a>
                    @endif
                    <form action="{{ route('flight-tickets.destroy', $flightTicket->id) }}" method="POST" data-confirm="Are you sure you want to delete this flight ticket?">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-4 py-2 text-sm font-medium text-red-600 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 dark:bg-red-900/20 dark:text-red-400 dark:border-red-800">
                            <i class="fas fa-trash mr-2"></i>Delete Flight Ticket
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Attachments Section -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 mt-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white flex items-center">
                <i class="fas fa-paperclip mr-2 text-blue-600"></i>Attachments
            </h2>
            <button onclick="document.getElementById('fileUploadForm').classList.toggle('hidden')" 
                    class="px-3 py-1.5 text-sm font-medium text-blue-600 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 dark:bg-blue-900/20 dark:text-blue-400">
                <i class="fas fa-plus mr-1"></i>Upload Files
            </button>
        </div>
        
        <!-- Upload Form -->
        <form id="fileUploadForm" class="hidden mb-4" enctype="multipart/form-data" onsubmit="uploadFiles(event)">
            @csrf
            <div class="space-y-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Select Files</label>
                    <input type="file" name="attachments[]" id="fileInput" multiple required 
                           class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-white"
                           accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif,.zip,.rar">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">You can select multiple files. Max file size: 10MB per file. Supported: PDF, DOC, DOCX, Images, ZIP, RAR</p>
                </div>
                <div id="fileDescriptionsContainer" class="space-y-2">
                    <!-- File description inputs will be added dynamically -->
                </div>
                <div class="flex justify-end">
                    <button type="button" onclick="document.getElementById('fileUploadForm').classList.add('hidden'); document.getElementById('fileInput').value = ''; clearFileDescriptions();" 
                            class="px-3 py-1.5 text-sm text-gray-600 dark:text-gray-400 mr-2">Cancel</button>
                    <button type="submit" 
                            class="px-3 py-1.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                        <i class="fas fa-upload mr-1"></i>Upload
                    </button>
                </div>
            </div>
        </form>

        <!-- Files List -->
        <div class="space-y-3" id="filesContainer">
            @forelse($flightTicket->files as $file)
                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600" data-file-id="{{ $file->id }}">
                    <div class="flex items-center space-x-3 flex-1">
                        @php
                            $icon = 'fa-file';
                            $mimeType = $file->mime_type ?? '';
                            if (str_contains($mimeType, 'pdf')) {
                                $icon = 'fa-file-pdf text-red-600';
                            } elseif (str_contains($mimeType, 'image')) {
                                $icon = 'fa-file-image text-green-600';
                            } elseif (str_contains($mimeType, 'word') || str_contains($mimeType, 'document')) {
                                $icon = 'fa-file-word text-blue-600';
                            } elseif (str_contains($mimeType, 'zip') || str_contains($mimeType, 'rar')) {
                                $icon = 'fa-file-archive text-yellow-600';
                            }
                        @endphp
                        <i class="fas {{ $icon }} text-xl"></i>
                        <div class="flex-1 min-w-0">
                            <a href="{{ route('flight-tickets.files.download', [$flightTicket->id, $file->id]) }}" 
                               class="text-sm font-medium text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 truncate block">
                                {{ $file->name }}
                            </a>
                            <div class="flex items-center space-x-2 mt-1">
                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ number_format($file->size / 1024, 2) }} KB
                                </span>
                                @if($file->description)
                                <span class="text-xs text-gray-500 dark:text-gray-400">•</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $file->description }}</span>
                                @endif
                                <span class="text-xs text-gray-500 dark:text-gray-400">•</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                    Uploaded {{ $file->created_at->diffForHumans() }}
                                </span>
                                @if($file->user)
                                <span class="text-xs text-gray-500 dark:text-gray-400">by {{ $file->user->name }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <button onclick="deleteFile({{ $file->id }})" 
                            class="ml-3 px-2 py-1 text-sm text-red-600 hover:text-red-800 dark:text-red-400">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            @empty
                <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                    <i class="fas fa-paperclip text-4xl mb-2 opacity-50"></i>
                    <p>No attachments yet. Click "Upload Files" to add files.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<script>
    // Handle file input change to show description fields
    document.getElementById('fileInput')?.addEventListener('change', function() {
        const container = document.getElementById('fileDescriptionsContainer');
        container.innerHTML = '';
        
        if (this.files.length > 0) {
            Array.from(this.files).forEach((file, index) => {
                const div = document.createElement('div');
                div.innerHTML = `
                    <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">
                        Description for "${file.name}" (Optional)
                    </label>
                    <input type="text" 
                           name="attachment_descriptions[]" 
                           placeholder="Add a description..."
                           class="w-full px-3 py-2 text-sm border rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                `;
                container.appendChild(div);
            });
        }
    });

    function clearFileDescriptions() {
        document.getElementById('fileDescriptionsContainer').innerHTML = '';
    }

    async function uploadFiles(event) {
        event.preventDefault();
        const form = event.target;
        const formData = new FormData(form);
        const fileInput = document.getElementById('fileInput');
        
        if (!fileInput.files.length) {
            alert('Please select at least one file to upload.');
            return;
        }
        
        const submitButton = form.querySelector('button[type="submit"]');
        const originalText = submitButton.innerHTML;
        submitButton.disabled = true;
        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Uploading...';
        
        try {
            const response = await fetch(`{{ route('flight-tickets.files.store', $flightTicket->id) }}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: formData
            });
            
            const data = await response.json();
            
            if (response.ok && data.success) {
                // Add files to container
                const container = document.getElementById('filesContainer');
                
                // Remove empty message if exists
                const emptyMessage = container.querySelector('.text-center');
                if (emptyMessage) {
                    emptyMessage.remove();
                }
                
                data.files.forEach(file => {
                    const icon = getFileIcon(file.mime_type);
                    const fileSize = (file.size / 1024).toFixed(2);
                    const uploadedBy = file.user ? file.user.name : 'Unknown';
                    const description = file.description ? `• ${file.description}` : '';
                    
                    const fileDiv = document.createElement('div');
                    fileDiv.className = 'flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600';
                    fileDiv.setAttribute('data-file-id', file.id);
                    fileDiv.innerHTML = `
                        <div class="flex items-center space-x-3 flex-1">
                            <i class="fas ${icon} text-xl"></i>
                            <div class="flex-1 min-w-0">
                                <a href="/flight-tickets/{{ $flightTicket->id }}/files/${file.id}/download" 
                                   class="text-sm font-medium text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 truncate block">
                                    ${file.name}
                                </a>
                                <div class="flex items-center space-x-2 mt-1">
                                    <span class="text-xs text-gray-500 dark:text-gray-400">${fileSize} KB</span>
                                    ${description ? `<span class="text-xs text-gray-500 dark:text-gray-400">${description}</span>` : ''}
                                    <span class="text-xs text-gray-500 dark:text-gray-400">• Just now</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">by ${uploadedBy}</span>
                                </div>
                            </div>
                        </div>
                        <button onclick="deleteFile(${file.id})" 
                                class="ml-3 px-2 py-1 text-sm text-red-600 hover:text-red-800 dark:text-red-400">
                            <i class="fas fa-trash"></i>
                        </button>
                    `;
                    container.appendChild(fileDiv);
                });
                
                // Reset form
                form.classList.add('hidden');
                fileInput.value = '';
                clearFileDescriptions();
                
                // Show success message
                alert(data.message || 'Files uploaded successfully.');
            } else {
                alert(data.message || 'Failed to upload files. Please try again.');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while uploading files. Please try again.');
        } finally {
            submitButton.disabled = false;
            submitButton.innerHTML = originalText;
        }
    }

    function getFileIcon(mimeType) {
        if (!mimeType) return 'fa-file';
        if (mimeType.includes('pdf')) return 'fa-file-pdf text-red-600';
        if (mimeType.includes('image')) return 'fa-file-image text-green-600';
        if (mimeType.includes('word') || mimeType.includes('document')) return 'fa-file-word text-blue-600';
        if (mimeType.includes('zip') || mimeType.includes('rar')) return 'fa-file-archive text-yellow-600';
        return 'fa-file';
    }

    async function deleteFile(fileId) {
        if (!confirm('Are you sure you want to delete this file?')) {
            return;
        }
        
        try {
            const response = await fetch(`/flight-tickets/{{ $flightTicket->id }}/files/${fileId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
            });
            
            const data = await response.json();
            
            if (response.ok && data.success) {
                const fileElement = document.querySelector(`[data-file-id="${fileId}"]`);
                if (fileElement) {
                    fileElement.remove();
                }
                
                // Show empty message if no files left
                const container = document.getElementById('filesContainer');
                if (container.children.length === 0) {
                    container.innerHTML = `
                        <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                            <i class="fas fa-paperclip text-4xl mb-2 opacity-50"></i>
                            <p>No attachments yet. Click "Upload Files" to add files.</p>
                        </div>
                    `;
                }
            } else {
                alert(data.message || 'Failed to delete file. Please try again.');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while deleting the file. Please try again.');
        }
    }
</script>
@endsection


