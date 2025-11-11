<x-app-layout>
    <x-slot name="title">{{ $leadSource->name }}</x-slot>
    <x-slot name="subtitle">Lead Source Details</x-slot>

    <div class="d-flex justify-content-between mb-4">
        <a href="{{ route('lead-sources.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to Lead Sources
        </a>
        <div>
            <a href="{{ route('lead-sources.edit', $leadSource) }}" class="btn btn-warning">
                <i class="bi bi-pencil me-2"></i>Edit
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Lead Source Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%">Name:</th>
                            <td><strong>{{ $leadSource->name }}</strong></td>
                        </tr>
                        <tr>
                            <th>Color:</th>
                            <td>
                                @if($leadSource->color_code)
                                    <span class="badge" style="background-color: {{ $leadSource->color_code }}; color: white; padding: 8px 12px;">
                                        {{ $leadSource->color_code }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary">No color set</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Description:</th>
                            <td>{{ $leadSource->description ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>
                                @if($leadSource->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Total Leads:</th>
                            <td><span class="badge bg-info">{{ $leads->count() }}</span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        @if($leads->count() > 0)
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Leads Using This Source</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @foreach($leads->take(10) as $lead)
                        <a href="{{ route('leads.show', $lead) }}" class="list-group-item list-group-item-action">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $lead->name }}</strong>
                                    @if($lead->company_name)
                                        <br><small class="text-muted">{{ $lead->company_name }}</small>
                                    @endif
                                </div>
                                <span class="badge bg-secondary">{{ $lead->status->name ?? 'N/A' }}</span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    @if($leads->count() > 10)
                        <div class="mt-3 text-center">
                            <a href="{{ route('leads.index', ['source' => $leadSource->name]) }}" class="btn btn-sm btn-primary">
                                View All {{ $leads->count() }} Leads
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>
</x-app-layout>

