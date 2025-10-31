<x-app-layout>
    <x-slot name="title">Leads Management</x-slot>
    <x-slot name="subtitle">Manage and track all your leads in one place</x-slot>

    <!-- Inline Stats Row -->
    <div class="row g-3 mb-4">
        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-6">
            <div class="stat-card">
                <div class="stat-card-inline">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);">
                        <i class="bi bi-people-fill text-white"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-label">Total Leads</div>
                        <div class="stat-value">{{ $totalLeads }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-6">
            <div class="stat-card">
                <div class="stat-card-inline">
                    <div class="stat-icon" style="background: #10b98120; color: #10b981;">
                        <i class="bi bi-check2-circle"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-label">Converted</div>
                        <div class="stat-value">{{ $convertedLeads }}</div>
                        <span class="badge" style="background:#10b98120; color:#10b981;">
                            {{ $totalLeads > 0 ? round(($convertedLeads / $totalLeads) * 100) : 0 }}%
                        </span>
                    </div>
                </div>
            </div>
        </div>

        

        @foreach($leadsByStatus->take(4) as $status)
        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-6">
            <div class="stat-card">
                <div class="stat-card-inline">
                    <div class="stat-icon" style="background: {{ $status->color_code }}20; color: {{ $status->color_code }};">
                        <i class="bi bi-circle-fill"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-label">{{ $status->name }}</div>
                        <div class="stat-value">{{ $status->leads_count }}</div>
                        <span class="badge" style="background: {{ $status->color_code }}20; color: {{ $status->color_code }};">
                            {{ $totalLeads > 0 ? round(($status->leads_count / $totalLeads) * 100) : 0 }}%
                        </span>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Action Bar with Filters -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">
                <div class="d-flex align-items-center gap-2">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%); color: white;">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">All Leads</h5>
                        <small class="text-muted">Server-side processing enabled</small>
                    </div>
                </div>
                <a href="{{ route('leads.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Add New Lead
                </a>
            </div>

            <!-- Filters Row -->
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label small fw-semibold text-muted mb-1">
                        <i class="bi bi-flag-fill me-1"></i>Status
                    </label>
                    <select id="statusFilter" class="form-select form-select-sm">
                        <option value="">All Statuses</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status->name }}">{{ $status->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-semibold text-muted mb-1">
                        <i class="bi bi-tag-fill me-1"></i>Lead Type
                    </label>
                    <select id="leadTypeFilter" class="form-select form-select-sm">
                        <option value="">All Types</option>
                        <option value="Hot Lead">Hot Lead</option>
                        <option value="Warm Lead">Warm Lead</option>
                        <option value="Cold Lead">Cold Lead</option>
                        <option value="New Inquiry">New Inquiry</option>
                        <option value="Referral">Referral</option>
                        <option value="Returning Customer">Returning Customer</option>
                        <option value="Qualified">Qualified</option>
                        <option value="Unqualified">Unqualified</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-semibold text-muted mb-1">
                        <i class="bi bi-person-fill me-1"></i>Assigned To
                    </label>
                    <select id="assignedFilter" class="form-select form-select-sm">
                        <option value="">All Users</option>
                        @foreach($users as $user)
                            <option value="{{ $user->name }}">{{ $user->name }}</option>
                        @endforeach
                        <option value="Unassigned">Unassigned</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-semibold text-muted mb-1">
                        <i class="bi bi-funnel-fill me-1"></i>Source
                    </label>
                    <select id="sourceFilter" class="form-select form-select-sm">
                        <option value="">All Sources</option>
                        <option value="Website">Website</option>
                        <option value="Email Campaign">Email Campaign</option>
                        <option value="Social Media">Social Media</option>
                        <option value="Phone Call">Phone Call</option>
                        <option value="Walk-in">Walk-in</option>
                        <option value="Referral">Referral</option>
                        <option value="Trade Show">Trade Show</option>
                        <option value="Online Ad">Online Ad</option>
                        <option value="Partner">Partner</option>
                        <option value="Direct Marketing">Direct Marketing</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Leads Table -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="leadsTable" class="table table-striped table-hover table-sm align-middle mb-0" style="width:100%">
                    <thead>
                        <tr>
                            <th><i class="bi bi-hash me-1"></i>ID</th>
                            <th><i class="bi bi-person-fill me-1"></i>Name</th>
                            <th><i class="bi bi-telephone-fill me-1"></i>Phone</th>
                            <th><i class="bi bi-flag-fill me-1"></i>Status</th>
                            <th><i class="bi bi-calendar-fill me-1"></i>Created</th>
                            <th class="text-center noVis"><i class="bi bi-gear-fill me-1"></i>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    @push('styles')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
    
    <style>
        /* DataTables Custom Styling */
        .dataTables_wrapper {
            padding: 20px;
        }
        
        .dataTables_length,
        .dataTables_filter,
        .dataTables_info,
        .dataTables_paginate {
            padding: 12px 0;
        }
        
        .dataTables_length label,
        .dataTables_filter label {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
            font-size: 14px;
            color: #64748b;
        }
        
        .dataTables_length select {
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 6px 12px;
            font-weight: 600;
            color: #334155;
            margin: 0 8px;
        }
        
        .dataTables_filter input {
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            padding: 8px 16px;
            font-weight: 500;
            margin-left: 10px;
            transition: all 0.2s;
        }
        
        .dataTables_filter input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
            outline: none;
        }
        
        .dataTables_paginate .pagination {
            gap: 4px;
        }
        
        .dataTables_paginate .page-link {
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            color: #64748b;
            font-weight: 600;
            padding: 8px 14px;
            margin: 0 2px;
            transition: all 0.2s;
        }
        
        .dataTables_paginate .page-link:hover {
            background: #f8fafc;
            border-color: var(--primary);
            color: var(--primary);
            transform: translateY(-2px);
        }
        
        .dataTables_paginate .page-item.active .page-link {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            border-color: var(--primary);
            color: white;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }
        
        .dataTables_paginate .page-item.disabled .page-link {
            opacity: 0.5;
        }
        
        .dataTables_info {
            color: #64748b;
            font-weight: 600;
            font-size: 14px;
        }
        
        table.dataTable thead th {
            border-bottom: 2px solid #e2e8f0 !important;
            font-weight: 700;
            color: #475569;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.8px;
            white-space: nowrap;
        }
        
        table.dataTable thead th.sorting:before,
        table.dataTable thead th.sorting:after,
        table.dataTable thead th.sorting_asc:before,
        table.dataTable thead th.sorting_asc:after,
        table.dataTable thead th.sorting_desc:before,
        table.dataTable thead th.sorting_desc:after {
            opacity: 0.3;
        }
        
        table.dataTable tbody tr:hover {
            background: #f8fafc !important;
        }
        
        /* Export Buttons */
        .dt-buttons {
            margin-bottom: 16px;
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        
        .dt-button {
            background: white !important;
            border: 2px solid #e2e8f0 !important;
            border-radius: 10px !important;
            color: #64748b !important;
            font-weight: 600 !important;
            padding: 10px 20px !important;
            transition: all 0.2s !important;
            font-size: 14px !important;
        }
        
        .dt-button:hover {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%) !important;
            border-color: var(--primary) !important;
            color: white !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3) !important;
        }
        
        .dt-button i {
            margin-right: 6px;
        }
        
        /* Loading indicator */
        .dataTables_processing {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            border-radius: 10px;
            padding: 20px;
            font-weight: 600;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .dataTables_wrapper {
                padding: 12px;
            }
            
            .dataTables_length,
            .dataTables_filter {
                margin-bottom: 12px;
            }
        }
    </style>
    @endpush

    @push('scripts')
    <!-- DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>
    
    <script>
        $(document).ready(function() {
            var table = $('#leadsTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: false,
                ajax: {
                    url: '{{ route("leads.index") }}',
                    data: function(d) {
                        d.status = $('#statusFilter').val();
                        d.lead_type = $('#leadTypeFilter').val();
                        d.assigned_to = $('#assignedFilter').val();
                        d.source = $('#sourceFilter').val();
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'phone', name: 'phone' },
                    { data: 'status', name: 'status.name', orderable: false },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
                ],
                responsive: true,
                pageLength: 25,
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                order: [[0, 'desc']],
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                     '<"row"<"col-sm-12"B>>' +
                     '<"row"<"col-sm-12"tr>>' +
                     '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                buttons: [
                    {
                        extend: 'copy',
                        text: '<i class="bi bi-clipboard"></i> Copy',
                        className: 'btn-sm'
                    },
                    {
                        extend: 'excel',
                        text: '<i class="bi bi-file-earmark-excel"></i> Excel',
                        className: 'btn-sm',
                        title: 'Leads Export - ' + new Date().toLocaleDateString()
                    },
                    {
                        extend: 'csv',
                        text: '<i class="bi bi-filetype-csv"></i> CSV',
                        className: 'btn-sm'
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="bi bi-file-earmark-pdf"></i> PDF',
                        className: 'btn-sm',
                        orientation: 'landscape'
                    },
                    {
                        extend: 'print',
                        text: '<i class="bi bi-printer"></i> Print',
                        className: 'btn-sm'
                    },
                    {
                        extend: 'colvis',
                        text: '<i class="bi bi-eye"></i> Columns',
                        className: 'btn-sm',
                        columns: ':not(.noVis)'
                    }
                ],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search leads...",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ leads",
                    infoEmpty: "No leads available",
                    infoFiltered: "(filtered from _MAX_ total leads)",
                    zeroRecords: "No matching leads found",
                    processing: "Loading...",
                    paginate: {
                        first: '<i class="bi bi-chevron-double-left"></i>',
                        previous: '<i class="bi bi-chevron-left"></i>',
                        next: '<i class="bi bi-chevron-right"></i>',
                        last: '<i class="bi bi-chevron-double-right"></i>'
                    }
                }
            });

            // Filter change handlers
            $('#statusFilter, #leadTypeFilter, #assignedFilter, #sourceFilter').on('change', function() {
                table.ajax.reload();
            });

            // Delete confirmation with event delegation
            $(document).on('click', '.delete-btn', function(e) {
                e.preventDefault();
                const form = $(this).closest('form');
                
                if (confirm('Are you sure you want to delete this lead? This action cannot be undone.')) {
                    form.submit();
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
