@extends('layouts.admin')

@section('title', $itinerary->name)

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="p-4 bg-green-50 border border-green-200 rounded-md text-green-800 dark:bg-green-900/20 dark:border-green-800 dark:text-green-200">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif

    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <div class="flex items-center gap-3 flex-wrap">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $itinerary->name }}</h1>
                @if($itinerary->is_master)
                    <span class="inline-flex items-center px-3 py-1 text-sm font-semibold rounded-full bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300">
                        <i class="fas fa-star mr-1.5"></i>Master Itinerary
                    </span>
                @elseif($itinerary->is_custom)
                    <span class="inline-flex items-center px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                        <i class="fas fa-user-cog mr-1.5"></i>Custom Itinerary
                    </span>
                @endif
            </div>
            @if($itinerary->tagline)
                <p class="text-gray-600 dark:text-gray-400 mt-1">{{ $itinerary->tagline }}</p>
            @endif
        </div>
        <div class="flex gap-2 flex-wrap">
            <a href="{{ route('itineraries.builder.edit', $itinerary->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <a href="{{ route('itineraries.index') }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">Back</a>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">Actions</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">Download, share, or view the itinerary</p>
            </div>
            <div class="flex gap-3 flex-wrap">
                <!-- Download PDF -->
                <a href="{{ route('itineraries.pdf', $itinerary->id) }}" 
                   target="_blank"
                   class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-500 to-pink-600 hover:from-red-600 hover:to-pink-700 text-white border-0 shadow-lg hover:shadow-xl transition-all duration-300 rounded-lg text-sm font-medium">
                    <i class="fas fa-file-pdf mr-2"></i>Download PDF
                </a>
                
                @if($itinerary->lead && ($itinerary->lead->email || $itinerary->lead->phone))
                    <!-- Share to WhatsApp -->
                    @if($itinerary->lead->phone)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $itinerary->lead->phone) }}?text={{ urlencode('Here is your itinerary: ' . $itinerary->name . '. View online: ' . route('itineraries.show', $itinerary->id)) }}" 
                           target="_blank"
                           class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white border-0 shadow-lg hover:shadow-xl transition-all duration-300 rounded-lg text-sm font-medium">
                            <i class="fab fa-whatsapp mr-2"></i>Share to WhatsApp
                        </a>
                    @endif
                    
                    <!-- Share to Email -->
                    @if($itinerary->lead->email)
                        <a href="mailto:{{ $itinerary->lead->email }}?subject={{ urlencode($itinerary->name . ' - Itinerary') }}&body={{ urlencode('Hello,\n\nPlease find attached your itinerary: ' . $itinerary->name . '\n\nView online: ' . route('itineraries.show', $itinerary->id) . '\n\nBest regards') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white border-0 shadow-lg hover:shadow-xl transition-all duration-300 rounded-lg text-sm font-medium">
                            <i class="fas fa-envelope mr-2"></i>Share to Email
                        </a>
                    @endif
                @else
                    <!-- Share to WhatsApp (without lead) -->
                    <button onclick="shareToWhatsApp()" 
                            type="button"
                            class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white border-0 shadow-lg hover:shadow-xl transition-all duration-300 rounded-lg text-sm font-medium">
                        <i class="fab fa-whatsapp mr-2"></i>Share to WhatsApp
                    </button>
                    
                    <!-- Share to Email (without lead) -->
                    <button onclick="shareToEmail()" 
                            type="button"
                            class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white border-0 shadow-lg hover:shadow-xl transition-all duration-300 rounded-lg text-sm font-medium">
                        <i class="fas fa-envelope mr-2"></i>Share to Email
                    </button>
                @endif
            </div>
        </div>
    </div>

    <!-- Itinerary Details -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 space-y-6">
        <!-- Basic Info -->
        <div>
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Overview</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @if($itinerary->duration_days)
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Duration</p>
                        <p class="font-medium text-gray-900 dark:text-white">{{ $itinerary->duration_days }} days</p>
                    </div>
                @endif
                @if($itinerary->start_date && $itinerary->end_date)
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Dates</p>
                        <p class="font-medium text-gray-900 dark:text-white">
                            {{ $itinerary->start_date->format('M d, Y') }} - {{ $itinerary->end_date->format('M d, Y') }}
                        </p>
                    </div>
                @endif
                @if($itinerary->country)
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Country</p>
                        <p class="font-medium text-gray-900 dark:text-white">{{ $itinerary->country->name }}</p>
                    </div>
                @endif
                @if($itinerary->destination)
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Destination</p>
                        <p class="font-medium text-gray-900 dark:text-white">{{ $itinerary->destination->name }}</p>
                    </div>
                @endif
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Status</p>
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                        {{ $itinerary->status === 'published' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200' }}">
                        {{ ucfirst($itinerary->status) }}
                    </span>
                </div>
                @if($itinerary->lead)
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Lead</p>
                        <p class="font-medium text-gray-900 dark:text-white">{{ $itinerary->lead->name }}</p>
                    </div>
                @endif
                @if($itinerary->adult_count || $itinerary->child_count || $itinerary->infant_count)
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Travel Party</p>
                        <p class="font-medium text-gray-900 dark:text-white">
                            @if($itinerary->adult_count) {{ $itinerary->adult_count }} Adult(s) @endif
                            @if($itinerary->child_count) {{ $itinerary->child_count }} Child(ren) @endif
                            @if($itinerary->infant_count) {{ $itinerary->infant_count }} Infant(s) @endif
                        </p>
                    </div>
                @endif
                @if($itinerary->hotel_category)
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Hotel Category</p>
                        <p class="font-medium text-gray-900 dark:text-white">{{ ucfirst(str_replace('_', ' ', $itinerary->hotel_category)) }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Progress/Steps Status -->
        @if($itinerary->completed_steps)
            <div>
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Completion Progress</h2>
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Progress</span>
                        <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $itinerary->getProgressPercentage() }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $itinerary->getProgressPercentage() }}%"></div>
                    </div>
                    <div class="flex flex-wrap gap-2 mt-2">
                        @for($i = 1; $i <= 5; $i++)
                            <span class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $itinerary->isStepCompleted($i) ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400' }}">
                                <i class="fas {{ $itinerary->isStepCompleted($i) ? 'fa-check-circle' : 'fa-circle' }} mr-1"></i>
                                Step {{ $i }}
                            </span>
                        @endfor
                    </div>
                </div>
            </div>
        @endif

        <!-- Description -->
        @if($itinerary->description)
            <div>
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Description</h2>
                <div class="prose dark:prose-invert max-w-none">
                    <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $itinerary->description }}</p>
                </div>
            </div>
        @endif

        <!-- Days & Itinerary - Enhanced Day Planner -->
        @if($itinerary->days && $itinerary->days->count() > 0)
            <div>
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Day Planner</h2>
                <div class="space-y-6">
                    @foreach($itinerary->days->sortBy('day_number') as $day)
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                        Day {{ $day->day_number }}: {{ $day->title }}
                                    </h3>
                                    @if($day->description)
                                        <p class="text-gray-600 dark:text-gray-400 mt-2">{{ $day->description }}</p>
                                    @endif
                                </div>
                            </div>
                            
                            @if($day->meals && is_array($day->meals) && count($day->meals) > 0)
                                <div class="mb-4">
                                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Meals Included:</p>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($day->meals as $meal)
                                            <span class="px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300">
                                                <i class="fas fa-utensils mr-1"></i>{{ ucfirst($meal) }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if($day->items && $day->items->count() > 0)
                                <div class="space-y-4 mt-4">
                                    <h4 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wide">Activities & Schedule</h4>
                                    @foreach($day->items->sortBy('sort_order') as $item)
                                        <div class="border-l-4 border-blue-500 dark:border-blue-400 pl-4 py-2 bg-gray-50 dark:bg-gray-700/50 rounded-r-lg">
                                            <div class="flex items-start justify-between flex-wrap gap-2">
                                                <div class="flex-1">
                                                    <div class="flex items-center gap-2 flex-wrap mb-1">
                                                        <span class="font-semibold text-gray-900 dark:text-white">{{ $item->title }}</span>
                                                        @if($item->type)
                                                            <span class="px-2 py-0.5 text-xs rounded bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                                                {{ ucfirst($item->type) }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                    @if($item->description)
                                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">{{ $item->description }}</p>
                                                    @endif
                                                    <div class="flex flex-wrap gap-4 text-xs text-gray-500 dark:text-gray-400">
                                                        @if($item->start_time)
                                                            <span><i class="fas fa-clock mr-1"></i>{{ $item->start_time->format('h:i A') }}</span>
                                                        @endif
                                                        @if($item->end_time)
                                                            <span><i class="fas fa-stopwatch mr-1"></i>Until {{ $item->end_time->format('h:i A') }}</span>
                                                        @endif
                                                        @if($item->duration_minutes)
                                                            <span><i class="fas fa-hourglass-half mr-1"></i>{{ $item->duration_minutes }} min</span>
                                                        @endif
                                                        @if($item->location)
                                                            <span><i class="fas fa-map-marker-alt mr-1"></i>{{ $item->location }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Inclusions -->
        @if($itinerary->inclusions && is_array($itinerary->inclusions) && count($itinerary->inclusions) > 0)
            <div>
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                    <i class="fas fa-check-circle text-green-600 dark:text-green-400 mr-2"></i>Inclusions
                </h2>
                <ul class="space-y-2">
                    @foreach($itinerary->inclusions as $inclusion)
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check text-green-600 dark:text-green-400 mt-1"></i>
                            <span class="text-gray-700 dark:text-gray-300">{{ $inclusion }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Exclusions -->
        @if($itinerary->exclusions && is_array($itinerary->exclusions) && count($itinerary->exclusions) > 0)
            <div>
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                    <i class="fas fa-times-circle text-red-600 dark:text-red-400 mr-2"></i>Exclusions
                </h2>
                <ul class="space-y-2">
                    @foreach($itinerary->exclusions as $exclusion)
                        <li class="flex items-start gap-2">
                            <i class="fas fa-times text-red-600 dark:text-red-400 mt-1"></i>
                            <span class="text-gray-700 dark:text-gray-300">{{ $exclusion }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Terms and Conditions -->
        @if($itinerary->terms_conditions)
            <div>
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                    <i class="fas fa-file-contract text-blue-600 dark:text-blue-400 mr-2"></i>Terms and Conditions
                </h2>
                <div class="prose dark:prose-invert max-w-none">
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
                        <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $itinerary->terms_conditions }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Cancellation Policy -->
        @if($itinerary->cancellation_policy)
            <div>
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                    <i class="fas fa-ban text-orange-600 dark:text-orange-400 mr-2"></i>Cancellation Policy
                </h2>
                <div class="prose dark:prose-invert max-w-none">
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
                        <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $itinerary->cancellation_policy }}</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    function shareToWhatsApp() {
        const phone = prompt('Enter phone number (with country code):');
        if (phone) {
            const phoneNumber = phone.replace(/[^0-9]/g, '');
            const message = encodeURIComponent('Here is your itinerary: {{ $itinerary->name }}. View online: {{ route("itineraries.show", $itinerary->id) }}');
            window.open(`https://wa.me/${phoneNumber}?text=${message}`, '_blank');
        }
    }
    
    function shareToEmail() {
        const email = prompt('Enter email address:');
        if (email) {
            const subject = encodeURIComponent('{{ $itinerary->name }} - Itinerary');
            const body = encodeURIComponent(`Hello,\n\nPlease find attached your itinerary: {{ $itinerary->name }}\n\nView online: {{ route("itineraries.show", $itinerary->id) }}\n\nBest regards`);
            window.location.href = `mailto:${email}?subject=${subject}&body=${body}`;
        }
    }
</script>
@endpush
@endsection

