@extends('layouts.admin')

@section('title', 'Create Quotation')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Create New Quotation</h1>
        <a href="{{ route('quotations.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
            <i class="fas fa-arrow-left mr-2"></i>Back
        </a>
    </div>

    <form action="{{ route('quotations.store') }}" method="POST" class="bg-white dark:bg-white rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm space-y-6">
        @csrf

        <!-- Basic Information Section -->
        <div class="space-y-4">
            <div class="flex items-center space-x-2 mb-4">
                <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-info-circle text-indigo-600 dark:text-indigo-600"></i>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-900">Basic Information</h2>
                    <p class="text-xs text-gray-500 dark:text-gray-500">Quotation details and reference information</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div>
                    <label for="quotation_number" class="block text-sm font-medium text-gray-700 dark:text-gray-700 mb-2">
                        <i class="fas fa-hashtag mr-2 text-gray-400"></i>Quotation Number <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="quotation_number" id="quotation_number" value="{{ old('quotation_number', $quotationNumber) }}" required
                           class="w-full px-4 py-2.5 border rounded-lg border-gray-300 dark:border-gray-300 dark:bg-white dark:text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('quotation_number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="quotation_date" class="block text-sm font-medium text-gray-700 dark:text-gray-700 mb-2">
                        <i class="fas fa-calendar-alt mr-2 text-gray-400"></i>Quotation Date <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="quotation_date" id="quotation_date" value="{{ old('quotation_date', date('Y-m-d')) }}" required
                           class="w-full px-4 py-2.5 border rounded-lg border-gray-300 dark:border-gray-300 dark:bg-white dark:text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('quotation_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="valid_until" class="block text-sm font-medium text-gray-700 dark:text-gray-700 mb-2">
                        <i class="fas fa-calendar-check mr-2 text-gray-400"></i>Valid Until
                    </label>
                    <input type="date" name="valid_until" id="valid_until" value="{{ old('valid_until') }}"
                           class="w-full px-4 py-2.5 border rounded-lg border-gray-300 dark:border-gray-300 dark:bg-white dark:text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('valid_until')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-700 mb-2">
                        <i class="fas fa-tag mr-2 text-gray-400"></i>Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status" id="status" required
                            class="w-full px-4 py-2.5 border rounded-lg border-gray-300 dark:border-gray-300 dark:bg-white dark:text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="sent" {{ old('status') == 'sent' ? 'selected' : '' }}>Sent</option>
                        <option value="accepted" {{ old('status') == 'accepted' ? 'selected' : '' }}>Accepted</option>
                        <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        <option value="expired" {{ old('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                        <option value="converted" {{ old('status') == 'converted' ? 'selected' : '' }}>Converted</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="currency" class="block text-sm font-medium text-gray-700 dark:text-gray-700 mb-2">
                        <i class="fas fa-dollar-sign mr-2 text-gray-400"></i>Currency
                    </label>
                    <select name="currency" id="currency"
                            class="w-full px-4 py-2.5 border rounded-lg border-gray-300 dark:border-gray-300 dark:bg-white dark:text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="USD" {{ old('currency', 'USD') == 'USD' ? 'selected' : '' }}>USD</option>
                        <option value="EUR" {{ old('currency') == 'EUR' ? 'selected' : '' }}>EUR</option>
                        <option value="GBP" {{ old('currency') == 'GBP' ? 'selected' : '' }}>GBP</option>
                        <option value="INR" {{ old('currency') == 'INR' ? 'selected' : '' }}>INR</option>
                    </select>
                    @error('currency')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Linked Entities Section -->
        <div class="space-y-4">
            <div class="flex items-center space-x-2 mb-4">
                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-link text-blue-600 dark:text-blue-600"></i>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-900">Link to Entities</h2>
                    <p class="text-xs text-gray-500 dark:text-gray-500">Associate this quotation with a customer, lead, or project</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="customer_id" class="block text-sm font-medium text-gray-700 dark:text-gray-700 mb-2">
                        <i class="fas fa-users mr-2 text-green-500"></i>Customer
                    </label>
                    <select name="customer_id" id="customer_id"
                            class="w-full px-4 py-2.5 border rounded-lg border-gray-300 dark:border-gray-300 dark:bg-white dark:text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Select a customer...</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                        @endforeach
                    </select>
                    @error('customer_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="lead_id" class="block text-sm font-medium text-gray-700 dark:text-gray-700 mb-2">
                        <i class="fas fa-user-tie mr-2 text-blue-500"></i>Lead
                    </label>
                    <select name="lead_id" id="lead_id"
                            class="w-full px-4 py-2.5 border rounded-lg border-gray-300 dark:border-gray-300 dark:bg-white dark:text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Select a lead...</option>
                        @foreach($leads as $lead)
                            <option value="{{ $lead->id }}" {{ old('lead_id') == $lead->id ? 'selected' : '' }}>{{ $lead->name }}</option>
                        @endforeach
                    </select>
                    @error('lead_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="project_id" class="block text-sm font-medium text-gray-700 dark:text-gray-700 mb-2">
                        <i class="fas fa-project-diagram mr-2 text-purple-500"></i>Project
                    </label>
                    <select name="project_id" id="project_id"
                            class="w-full px-4 py-2.5 border rounded-lg border-gray-300 dark:border-gray-300 dark:bg-white dark:text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Select a project...</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                        @endforeach
                    </select>
                    @error('project_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Quotation Items Section -->
        <div class="space-y-4">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-2">
                    <div class="w-10 h-10 bg-orange-100 dark:bg-orange-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-list text-orange-600 dark:text-orange-600"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-900">Quotation Items</h2>
                        <p class="text-xs text-gray-500 dark:text-gray-500">Add products or services to this quotation</p>
                    </div>
                </div>
                <button type="button" onclick="addItem()" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
                    <i class="fas fa-plus mr-2"></i>Add Item
                </button>
            </div>

            <div id="itemsContainer" class="space-y-4">
                <!-- Items will be added here dynamically -->
            </div>

            @error('items')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Pricing & Discounts Section -->
        <div class="space-y-4">
            <div class="flex items-center space-x-2 mb-4">
                <div class="w-10 h-10 bg-green-100 dark:bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calculator text-green-600 dark:text-green-600"></i>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-900">Pricing & Discounts</h2>
                    <p class="text-xs text-gray-500 dark:text-gray-500">Set tax and discount rates</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="tax_rate" class="block text-sm font-medium text-gray-700 dark:text-gray-700 mb-2">
                        <i class="fas fa-percent mr-2 text-gray-400"></i>Tax Rate (%)
                    </label>
                    <input type="number" name="tax_rate" id="tax_rate" value="{{ old('tax_rate', 0) }}" step="0.01" min="0" max="100"
                           class="w-full px-4 py-2.5 border rounded-lg border-gray-300 dark:border-gray-300 dark:bg-white dark:text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('tax_rate')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="discount_rate" class="block text-sm font-medium text-gray-700 dark:text-gray-700 mb-2">
                        <i class="fas fa-tag mr-2 text-gray-400"></i>Discount Rate (%)
                    </label>
                    <input type="number" name="discount_rate" id="discount_rate" value="{{ old('discount_rate', 0) }}" step="0.01" min="0" max="100"
                           class="w-full px-4 py-2.5 border rounded-lg border-gray-300 dark:border-gray-300 dark:bg-white dark:text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('discount_rate')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Additional Information Section -->
        <div class="space-y-4">
            <div class="flex items-center space-x-2 mb-4">
                <div class="w-10 h-10 bg-purple-100 dark:bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-file-alt text-purple-600 dark:text-purple-600"></i>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-900">Additional Information</h2>
                    <p class="text-xs text-gray-500 dark:text-gray-500">Notes and terms & conditions</p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-700 mb-2">
                        <i class="fas fa-sticky-note mr-2 text-gray-400"></i>Notes
                    </label>
                    <textarea name="notes" id="notes" rows="4"
                              class="w-full px-4 py-2.5 border rounded-lg border-gray-300 dark:border-gray-300 dark:bg-white dark:text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                              placeholder="Additional notes about this quotation...">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="terms_conditions" class="block text-sm font-medium text-gray-700 dark:text-gray-700 mb-2">
                        <i class="fas fa-file-contract mr-2 text-gray-400"></i>Terms & Conditions
                    </label>
                    <textarea name="terms_conditions" id="terms_conditions" rows="4"
                              class="w-full px-4 py-2.5 border rounded-lg border-gray-300 dark:border-gray-300 dark:bg-white dark:text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                              placeholder="Terms and conditions for this quotation...">{{ old('terms_conditions') }}</textarea>
                    @error('terms_conditions')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Summary Section -->
        <div class="bg-gray-50 dark:bg-gray-100 rounded-lg p-6 border border-gray-200 dark:border-gray-300">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-900 mb-4">Summary</h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-500 mb-1">Subtotal</label>
                    <p class="text-xl font-bold text-gray-900 dark:text-gray-900" id="summarySubtotal">0.00</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-500 mb-1">Discount</label>
                    <p class="text-xl font-bold text-red-600 dark:text-red-600" id="summaryDiscount">0.00</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-500 mb-1">Tax</label>
                    <p class="text-xl font-bold text-gray-900 dark:text-gray-900" id="summaryTax">0.00</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-500 mb-1">Total Amount</label>
                    <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-600" id="summaryTotal">0.00</p>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-300">
            <a href="{{ route('quotations.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-100 dark:text-gray-700 dark:border-gray-300">
                Cancel
            </a>
            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <i class="fas fa-save mr-2"></i>Create Quotation
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    let itemIndex = 0;
    const products = @json($products);

    function addItem(itemData = null) {
        const container = document.getElementById('itemsContainer');
        const index = itemIndex++;
        
        const itemHtml = `
            <div class="item-row bg-gray-50 dark:bg-gray-100 rounded-lg p-4 border border-gray-200 dark:border-gray-300" data-index="${index}">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-sm font-semibold text-gray-900 dark:text-gray-900">Item #${index + 1}</h4>
                    <button type="button" onclick="removeItem(this)" class="text-red-600 hover:text-red-800">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="lg:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-700 mb-1">Product</label>
                        <select name="items[${index}][product_id]" class="item-product w-full px-3 py-2 border rounded-lg border-gray-300 dark:border-gray-300 dark:bg-white dark:text-gray-900" onchange="updateItemFromProduct(this, ${index})">
                            <option value="">Select a product...</option>
                            ${products.map(p => `<option value="${p.id}" ${itemData?.product_id == p.id ? 'selected' : ''}>${p.name}</option>`).join('')}
                        </select>
                    </div>
                    
                    <div class="lg:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-700 mb-1">Item Name <span class="text-red-500">*</span></label>
                        <input type="text" name="items[${index}][item_name]" value="${itemData?.item_name || ''}" required
                               class="item-name w-full px-3 py-2 border rounded-lg border-gray-300 dark:border-gray-300 dark:bg-white dark:text-gray-900"
                               placeholder="Enter item name">
                    </div>
                    
                    <div class="lg:col-span-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-700 mb-1">Description</label>
                        <textarea name="items[${index}][description]" rows="2"
                                  class="w-full px-3 py-2 border rounded-lg border-gray-300 dark:border-gray-300 dark:bg-white dark:text-gray-900"
                                  placeholder="Item description...">${itemData?.description || ''}</textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-700 mb-1">Quantity <span class="text-red-500">*</span></label>
                        <input type="number" name="items[${index}][quantity]" value="${itemData?.quantity || 1}" required min="1"
                               class="item-quantity w-full px-3 py-2 border rounded-lg border-gray-300 dark:border-gray-300 dark:bg-white dark:text-gray-900"
                               onchange="calculateTotals()">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-700 mb-1">Unit</label>
                        <input type="text" name="items[${index}][unit]" value="${itemData?.unit || ''}"
                               class="w-full px-3 py-2 border rounded-lg border-gray-300 dark:border-gray-300 dark:bg-white dark:text-gray-900"
                               placeholder="e.g., pcs, kg, hrs">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-700 mb-1">Unit Price <span class="text-red-500">*</span></label>
                        <input type="number" name="items[${index}][unit_price]" value="${itemData?.unit_price || 0}" required step="0.01" min="0"
                               class="item-unit-price w-full px-3 py-2 border rounded-lg border-gray-300 dark:border-gray-300 dark:bg-white dark:text-gray-900"
                               onchange="calculateTotals()">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-700 mb-1">Discount (%)</label>
                        <input type="number" name="items[${index}][discount_rate]" value="${itemData?.discount_rate || 0}" step="0.01" min="0" max="100"
                               class="item-discount w-full px-3 py-2 border rounded-lg border-gray-300 dark:border-gray-300 dark:bg-white dark:text-gray-900"
                               onchange="calculateTotals()">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-700 mb-1">Tax (%)</label>
                        <input type="number" name="items[${index}][tax_rate]" value="${itemData?.tax_rate || 0}" step="0.01" min="0" max="100"
                               class="item-tax w-full px-3 py-2 border rounded-lg border-gray-300 dark:border-gray-300 dark:bg-white dark:text-gray-900"
                               onchange="calculateTotals()">
                    </div>
                </div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', itemHtml);
        calculateTotals();
    }

    function removeItem(button) {
        const row = button.closest('.item-row');
        row.remove();
        calculateTotals();
    }

    function updateItemFromProduct(select, index) {
        const productId = select.value;
        const product = products.find(p => p.id == productId);
        
        if (product) {
            const row = select.closest('.item-row');
            row.querySelector('.item-name').value = product.name;
            if (product.price) {
                row.querySelector('.item-unit-price').value = product.price;
            }
            calculateTotals();
        }
    }

    function calculateTotals() {
        const items = document.querySelectorAll('.item-row');
        let subtotal = 0;
        
        items.forEach(item => {
            const quantity = parseFloat(item.querySelector('.item-quantity').value) || 0;
            const unitPrice = parseFloat(item.querySelector('.item-unit-price').value) || 0;
            const discountRate = parseFloat(item.querySelector('.item-discount').value) || 0;
            const taxRate = parseFloat(item.querySelector('.item-tax').value) || 0;
            
            const itemSubtotal = quantity * unitPrice;
            const itemDiscount = itemSubtotal * discountRate / 100;
            const itemAfterDiscount = itemSubtotal - itemDiscount;
            const itemTax = itemAfterDiscount * taxRate / 100;
            
            subtotal += itemAfterDiscount + itemTax;
        });
        
        const discountRate = parseFloat(document.getElementById('discount_rate').value) || 0;
        const taxRate = parseFloat(document.getElementById('tax_rate').value) || 0;
        
        const discountAmount = subtotal * discountRate / 100;
        const afterDiscount = subtotal - discountAmount;
        const taxAmount = afterDiscount * taxRate / 100;
        const total = afterDiscount + taxAmount;
        
        document.getElementById('summarySubtotal').textContent = subtotal.toFixed(2);
        document.getElementById('summaryDiscount').textContent = discountAmount.toFixed(2);
        document.getElementById('summaryTax').textContent = taxAmount.toFixed(2);
        document.getElementById('summaryTotal').textContent = total.toFixed(2);
    }

    // Add event listeners for tax and discount rate changes
    document.getElementById('tax_rate').addEventListener('input', calculateTotals);
    document.getElementById('discount_rate').addEventListener('input', calculateTotals);

    // Add first item on page load
    document.addEventListener('DOMContentLoaded', function() {
        addItem();
    });
</script>
@endpush
@endsection

