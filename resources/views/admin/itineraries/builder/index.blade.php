@extends('layouts.admin')

@section('title', 'Itinerary Builder')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Itinerary Builder</h1>
            <p class="text-muted-foreground mt-1">
                Create and customize your travel itinerary step by step
            </p>
        </div>
        <a href="{{ route('itineraries.show', $itinerary->id) }}" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400">
            <i class="fas fa-eye mr-1"></i>View Itinerary
        </a>
    </div>

    @if(session('success'))
        <div class="p-4 bg-green-50 border border-green-200 rounded-md text-green-800 dark:bg-green-900/20 dark:border-green-800 dark:text-green-200">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 bg-red-50 border border-red-200 rounded-md text-red-800 dark:bg-red-900/20 dark:border-red-800 dark:text-red-200">
            <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Sidebar with Stepper -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 sticky top-4">
                <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-4">Steps</h3>
                
                <div class="space-y-2">
                    @php
                        $steps = [
                            1 => ['label' => 'Basic Information', 'icon' => 'fa-file-alt'],
                            2 => ['label' => 'Day Planner', 'icon' => 'fa-calendar'],
                            3 => ['label' => 'Terms & Conditions', 'icon' => 'fa-file-check'],
                            4 => ['label' => 'Inclusions & Exclusions', 'icon' => 'fa-list-check'],
                            5 => ['label' => 'SEO Settings', 'icon' => 'fa-search'],
                            6 => ['label' => 'Preview & Publish', 'icon' => 'fa-eye'],
                        ];
                    @endphp

                    @foreach($steps as $stepNum => $step)
                        @php
                            $isCompleted = in_array($stepNum, $completedSteps ?? []);
                            $isActive = $currentStep == $stepNum;
                            $canNavigate = $isCompleted || $stepNum <= $currentStep;
                        @endphp
                        
                        <a href="{{ route('itineraries.builder.edit', ['itinerary' => $itinerary->id, 'step' => $stepNum]) }}" 
                           class="flex items-center px-3 py-2 rounded-md text-sm transition-colors {{ $isActive ? 'bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 font-medium' : ($canNavigate ? 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' : 'text-gray-400 dark:text-gray-600 cursor-not-allowed') }}">
                            <i class="fas {{ $step['icon'] }} w-5 mr-2"></i>
                            <span>{{ $step['label'] }}</span>
                            @if($isCompleted && !$isActive)
                                <i class="fas fa-check-circle ml-auto text-green-500"></i>
                            @endif
                        </a>
                    @endforeach
                </div>

                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <div class="text-sm text-gray-600 dark:text-gray-400">
                        Progress: {{ round((count($completedSteps ?? []) / 6) * 100) }}%
                    </div>
                    <div class="mt-2 w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" 
                             style="width: {{ round((count($completedSteps ?? []) / 6) * 100) }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="lg:col-span-3">
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-6">
                @if($currentStep == 6)
                    {{-- Step 6: Preview & Publish - No form wrapper needed --}}
                    @include('admin.itineraries.builder.steps.step6')
                @else
                    <form id="itineraryBuilderForm" method="POST" 
                          action="{{ route('itineraries.builder.update', $itinerary->id) }}" 
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="step" value="{{ $currentStep }}">

                        @if($currentStep == 1)
                            @include('admin.itineraries.builder.steps.step1')
                        @elseif($currentStep == 2)
                            @include('admin.itineraries.builder.steps.step2')
                        @elseif($currentStep == 3)
                            @include('admin.itineraries.builder.steps.step3')
                        @elseif($currentStep == 4)
                            @include('admin.itineraries.builder.steps.step4')
                        @elseif($currentStep == 5)
                            @include('admin.itineraries.builder.steps.step5')
                        @endif

                        <!-- Navigation Buttons -->
                        <div class="flex justify-between mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                            @if($currentStep > 1)
                                <a href="{{ route('itineraries.builder.edit', ['itinerary' => $itinerary->id, 'step' => $currentStep - 1]) }}" 
                                   class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-600">
                                    <i class="fas fa-chevron-left mr-2"></i>Previous
                                </a>
                            @else
                                <div></div>
                            @endif
                            
                            <div class="flex gap-3">
                                @if($currentStep == 5)
                                    <button type="button" onclick="skipSeoStep()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-600">
                                        <i class="fas fa-forward mr-2"></i>Skip
                                    </button>
                                @endif
                                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Save & Next
                                    <i class="fas fa-chevron-right ml-2"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize jQuery Validation
    const form = $('#itineraryBuilderForm');
    
    // Custom validation rules
    $.validator.addMethod("dateAfterStart", function(value, element) {
        const startDate = $('#start_date').val();
        if (!startDate || !value) return true;
        return new Date(value) >= new Date(startDate);
    }, "End date must be after or equal to start date");

    // Define validation rules based on current step
    let validationRules = {};
    let validationMessages = {};

    @if($currentStep == 1)
        // Check if master checkbox is checked initially
        const initialIsMaster = $('#is_master').is(':checked');
        
        validationRules = {
            name: { required: true },
            duration_days: { required: true, min: 1, max: 365 },
            country_id: { required: true },
            destination_id: { required: true }
        };
        
        // Add lead_id validation only if not master
        if (!initialIsMaster) {
            validationRules.lead_id = { required: true };
        }
        
        // Add date validation only if not master
        if (!initialIsMaster) {
            validationRules.start_date = { required: true, date: true };
            validationRules.end_date = { required: true, date: true, dateAfterStart: true };
        }
        
        validationMessages = {
            name: { required: "Trip name is required" },
            duration_days: { 
                required: "Duration is required",
                min: "Duration must be at least 1 day",
                max: "Duration cannot exceed 365 days"
            },
            country_id: { required: "Please select a country" },
            destination_id: { required: "Please select a destination" }
        };
        
        // Add lead_id message only if not master
        if (!initialIsMaster) {
            validationMessages.lead_id = { required: "Please select a lead" };
        }
        
        // Add date messages only if not master
        if (!initialIsMaster) {
            validationMessages.start_date = { required: "Start date is required", date: "Please enter a valid date" };
            validationMessages.end_date = { 
                required: "End date is required",
                date: "Please enter a valid date",
                dateAfterStart: "End date must be after or equal to start date"
            };
        }
    @elseif($currentStep == 3)
        validationRules = {
            terms_conditions: { required: true, minlength: 10 },
            cancellation_policy: { required: true, minlength: 10 }
        };
        validationMessages = {
            terms_conditions: { 
                required: "Terms & Conditions is required",
                minlength: "Terms & Conditions must be at least 10 characters"
            },
            cancellation_policy: { 
                required: "Cancellation Policy is required",
                minlength: "Cancellation Policy must be at least 10 characters"
            }
        };
    @elseif($currentStep == 5)
        validationRules = {
            meta_title: { maxlength: 60 },
            meta_description: { maxlength: 160 }
        };
        validationMessages = {
            meta_title: { 
                maxlength: "Meta title cannot exceed 60 characters"
            },
            meta_description: { 
                maxlength: "Meta description cannot exceed 160 characters"
            }
        };
    @endif

    // Initialize jQuery Validation
    form.validate({
        rules: validationRules,
        messages: validationMessages,
        errorClass: 'text-red-600 text-sm',
        errorElement: 'p',
        highlight: function(element) {
            $(element).addClass('border-red-500').removeClass('border-gray-300');
        },
        unhighlight: function(element) {
            $(element).removeClass('border-red-500').addClass('border-gray-300');
        },
        errorPlacement: function(error, element) {
            error.insertAfter(element);
        },
        submitHandler: function(form) {
            // Show loading state
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
            }
            form.submit();
        }
    });

    // Handle duration days change and auto-calculate end date
    const durationInput = document.getElementById('duration_days');
    const startDateInputElement = document.getElementById('start_date');
    const endDateInputElement = document.getElementById('end_date');
    
    if (durationInput && startDateInputElement && endDateInputElement) {
        function calculateEndDate() {
            // Only calculate if date fields are required (not master itinerary)
            const isMaster = $('#is_master').is(':checked');
            if (isMaster) {
                return; // Don't auto-calculate for master itineraries
            }
            
            if (startDateInputElement.value && durationInput.value) {
                const startDate = new Date(startDateInputElement.value);
                const days = parseInt(durationInput.value) - 1;
                startDate.setDate(startDate.getDate() + days);
                endDateInputElement.value = startDate.toISOString().split('T')[0];
                
                // Re-validate end date after calculation
                if (form.valid()) {
                    $('#end_date').valid();
                }
            }
        }
        
        $(durationInput).on('change', calculateEndDate);
        $(startDateInputElement).on('change', calculateEndDate);
        
        // Watch for master checkbox changes to enable/disable auto-calculation
        @if($currentStep == 1)
        $('#is_master').on('change', function() {
            if (!$(this).is(':checked')) {
                // Re-enable calculation if master is unchecked
                calculateEndDate();
            }
        });
        @endif
    }

    // Filter destinations based on selected country
    const countrySelect = $('#country_id');
    const destinationSelect = $('#destination_id');
    
    if (countrySelect.length && destinationSelect.length) {
        const allDestinations = Array.from(destinationSelect[0].options).map(opt => ({
            value: opt.value,
            text: opt.text,
            countryId: opt.getAttribute('data-country-id')
        }));
        
        countrySelect.on('change', function() {
            const selectedCountryId = this.value;
            destinationSelect.html('<option value="">Select a destination...</option>');
            
            allDestinations.forEach(dest => {
                if (!dest.countryId || dest.countryId === selectedCountryId) {
                    destinationSelect.append(`<option value="${dest.value}">${dest.text}</option>`);
                }
            });
            
            // Re-validate destination
            destinationSelect.valid();
        });
    }

    // Handle Master Itinerary checkbox toggle
    @if($currentStep == 1)
    const masterCheckbox = $('#is_master');
    const leadContainer = $('#lead-selection-container');
    const leadSelect = $('#lead_id');
    const startDateInput = $('#start_date');
    const endDateInput = $('#end_date');
    const startDateContainer = $('#start-date-container');
    const endDateContainer = $('#end-date-container');
    const startDateRequired = $('#start_date_required');
    const endDateRequired = $('#end_date_required');
    
    function toggleLeadField() {
        const isMaster = masterCheckbox.is(':checked');
        
        if (isMaster) {
            // Hide lead field and make it optional
            leadContainer.hide();
            leadSelect.prop('required', false);
            leadSelect.val(''); // Clear the value
            
            // Remove validation rule
            if (leadSelect.rules()) {
                leadSelect.rules('remove', 'required');
            }
        } else {
            // Show lead field and make it required
            leadContainer.show();
            leadSelect.prop('required', true);
            
            // Add validation rule
            leadSelect.rules('add', {
                required: true,
                messages: {
                    required: "Please select a lead"
                }
            });
        }
        
        // Re-validate the lead field
        leadSelect.valid();
    }
    
    function toggleDateFields() {
        const isMaster = masterCheckbox.is(':checked');
        
        if (isMaster) {
            // Make date fields optional
            startDateInput.prop('required', false);
            endDateInput.prop('required', false);
            
            // Hide required asterisks
            startDateRequired.hide();
            endDateRequired.hide();
            
            // Remove validation rules
            if (startDateInput.rules()) {
                startDateInput.rules('remove', 'required');
            }
            if (endDateInput.rules()) {
                endDateInput.rules('remove', 'required');
            }
        } else {
            // Make date fields required
            startDateInput.prop('required', true);
            endDateInput.prop('required', true);
            
            // Show required asterisks
            startDateRequired.show();
            endDateRequired.show();
            
            // Add validation rules
            startDateInput.rules('add', {
                required: true,
                messages: {
                    required: "Start date is required"
                }
            });
            endDateInput.rules('add', {
                required: true,
                messages: {
                    required: "End date is required"
                }
            });
        }
        
        // Re-validate date fields
        startDateInput.valid();
        endDateInput.valid();
    }
    
    // Initialize on page load (after validation is set up)
    if (masterCheckbox.length && leadContainer.length) {
        // Wait for validation to be initialized
        setTimeout(function() {
            toggleLeadField();
            toggleDateFields();
            masterCheckbox.on('change', function() {
                toggleLeadField();
                toggleDateFields();
            });
        }, 100);
    }
    
    // Update validation rules dynamically on form submission
    form.on('submit', function() {
        const isMaster = masterCheckbox.is(':checked');
        if (isMaster) {
            // Remove lead_id from validation and set it to null
            $('#lead_id').val('').prop('required', false);
            if (leadSelect.rules()) {
                leadSelect.rules('remove', 'required');
            }
            // Remove date requirements
            startDateInput.prop('required', false);
            endDateInput.prop('required', false);
            if (startDateInput.rules()) {
                startDateInput.rules('remove', 'required');
            }
            if (endDateInput.rules()) {
                endDateInput.rules('remove', 'required');
            }
        }
    });
    @endif

    // Real-time validation feedback
    form.on('blur', 'input[required], select[required], textarea[required]', function() {
        $(this).valid();
    });
});

// Skip SEO Step function
function skipSeoStep() {
    if (confirm('Are you sure you want to skip SEO settings? You can add them later.')) {
        // Create a form to submit skip action
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("itineraries.builder.update", $itinerary->id) }}';
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);
        
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'PUT';
        form.appendChild(methodField);
        
        const stepField = document.createElement('input');
        stepField.type = 'hidden';
        stepField.name = 'step';
        stepField.value = '5';
        form.appendChild(stepField);
        
        const skipField = document.createElement('input');
        skipField.type = 'hidden';
        skipField.name = 'skip_seo';
        skipField.value = '1';
        form.appendChild(skipField);
        
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endpush

