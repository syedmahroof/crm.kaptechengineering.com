<x-app-layout>
    <x-slot name="title">Dashboard</x-slot>
    <x-slot name="subtitle">Welcome back, {{ Auth::user()->name }}! Here's your overview</x-slot>

    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-xxl-2 col-xl-3 col-lg-3 col-md-4 col-sm-6">
            <div class="stat-card">
                <div class="stat-card-inline">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);">
                        <i class="bi bi-people-fill text-white"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-label">Total Leads</div>
                        <div class="stat-value">{{ $totalLeads }}</div>
                        <span class="stat-change positive">
                            <i class="bi bi-arrow-up"></i> 12% this month
                        </span>
                    </div>
                </div>
            </div>
        </div>

        
    </div>

    <!-- Quick Actions & Analytics Link -->
    <div class="row g-4 mb-5">
        <div class="col-lg-12">
            <div class="card" style="background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%); border: none;">
                <div class="card-body py-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5 class="text-white mb-2 fw-bold">
                                <i class="bi bi-graph-up me-2"></i>Lead Analytics Dashboard
                            </h5>
                            <p class="text-white mb-0 opacity-75">View comprehensive analytics, trends, and insights for your leads</p>
                        </div>
                        <div class="col-md-4 text-end">
                            <a href="{{ route('analytics.index') }}" class="btn btn-light btn-lg">
                                <i class="bi bi-bar-chart-line me-2"></i>View Full Analytics
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Recent Leads -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5>Recent Leads</h5>
                        <small class="text-muted">Latest lead activities and updates</small>
                    </div>
                    <a href="{{ route('leads.index') }}" class="btn btn-primary btn-sm">
                        View All <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Lead</th>
                                    <th>Status</th>
                                    <th>Assigned To</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentLeads as $lead)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                <div style="width: 44px; height: 44px; border-radius: 12px; background: {{ $status->color_code ?? '#6366f1' }}15; display: flex; align-items: center; justify-content: center;">
                                                    <i class="bi bi-person-fill" style="color: {{ $lead->status->color_code }}; font-size: 20px;"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="fw-bold">{{ $lead->name }}</div>
                                                <small class="text-muted">{{ $lead->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge" style="background: {{ $lead->status->color_code }}; border: none;">
                                            {{ $lead->status->name }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div style="width: 32px; height: 32px; border-radius: 10px; background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 12px; font-weight: 700; margin-right: 10px;">
                                                {{ strtoupper(substr($lead->assignedUser->name ?? 'UN', 0, 2)) }}
                                            </div>
                                            <span style="font-weight: 600;">{{ $lead->assignedUser->name ?? 'Unassigned' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <small class="text-muted fw-medium">{{ $lead->created_at->diffForHumans() }}</small>
                                    </td>
                                    <td>
                                        <a href="{{ route('leads.show', $lead) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div style="opacity: 0.3;">
                                            <i class="bi bi-inbox display-3 d-block mb-3"></i>
                                            <p class="fw-bold">No leads found</p>
                                        </div>
                                        <a href="{{ route('leads.create') }}" class="btn btn-primary mt-2">
                                            <i class="bi bi-plus-circle me-2"></i>Create Your First Lead
                                        </a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Sidebar -->
        <div class="col-lg-4">
            <!-- Upcoming Follow-ups -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Upcoming Follow-ups</h5>
                    <small class="text-muted">Next scheduled activities</small>
                </div>
                <div class="card-body" style="max-height: 420px; overflow-y: auto;">
                    @forelse($recentFollowups->take(5) as $followup)
                    <div class="d-flex align-items-start mb-3 pb-3" style="border-bottom: 1px solid #f1f5f9;">
                        <div class="me-3">
                            <div style="width: 52px; height: 52px; border-radius: 14px; background: #f8fafc; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-calendar-event-fill" style="color: #64748b; font-size: 22px;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-2 fw-bold">{{ $followup->lead->name }}</h6>
                            <div class="text-muted small mb-2 fw-medium">
                                <i class="bi bi-clock-fill me-1"></i>
                                {{ $followup->followup_date->format('M d, Y H:i') }}
                            </div>
                            <span class="badge bg-{{ $followup->status == 'pending' ? 'warning' : ($followup->status == 'completed' ? 'success' : 'danger') }}">
                                {{ ucfirst($followup->status) }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4" style="opacity: 0.5;">
                        <i class="bi bi-calendar-x display-5 d-block mb-3"></i>
                        <p class="mb-0 fw-medium">No follow-ups scheduled</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <h5>Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        <a href="{{ route('leads.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i> Create New Lead
                        </a>
                        <a href="{{ route('products.create') }}" class="btn btn-outline-primary">
                            <i class="bi bi-box-seam me-2"></i> Add Product
                        </a>
                        <a href="{{ route('calendar.index') }}" class="btn btn-outline-primary">
                            <i class="bi bi-calendar-event me-2"></i> View Calendar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row g-4 mt-3">
        <!-- Lead Status Chart -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5>Lead Distribution by Status</h5>
                    <small class="text-muted">Visual breakdown of your lead pipeline</small>
                </div>
                <div class="card-body">
                    <div style="max-height: 350px; position: relative;">
                        <canvas id="leadsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Lead Trend -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5>Lead Trend (Last 7 Days)</h5>
                    <small class="text-muted">Daily lead generation</small>
                </div>
                <div class="card-body">
                    <div style="max-height: 350px; position: relative;">
                        <canvas id="trendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Lead Status Chart
        const ctx = document.getElementById('leadsChart').getContext('2d');
        const leadsChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($leadsByStatus->pluck('name')) !!},
                datasets: [{
                    data: {!! json_encode($leadsByStatus->pluck('leads_count')) !!},
                    backgroundColor: {!! json_encode($leadsByStatus->pluck('color_code')) !!},
                    borderWidth: 0,
                    hoverOffset: 20
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            padding: 20,
                            font: {
                                size: 14,
                                family: "'Plus Jakarta Sans', sans-serif",
                                weight: 600
                            },
                            usePointStyle: true,
                            pointStyle: 'circle',
                            generateLabels: function(chart) {
                                const data = chart.data;
                                if (data.labels.length && data.datasets.length) {
                                    return data.labels.map((label, i) => {
                                        const value = data.datasets[0].data[i];
                                        const total = data.datasets[0].data.reduce((a, b) => a + b, 0);
                                        const percentage = ((value / total) * 100).toFixed(1);
                                        return {
                                            text: `${label} (${value} - ${percentage}%)`,
                                            fillStyle: data.datasets[0].backgroundColor[i],
                                            hidden: false,
                                            index: i
                                        };
                                    });
                                }
                                return [];
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        padding: 16,
                        titleFont: {
                            size: 15,
                            family: "'Plus Jakarta Sans', sans-serif",
                            weight: 700
                        },
                        bodyFont: {
                            size: 14,
                            family: "'Plus Jakarta Sans', sans-serif",
                            weight: 600
                        },
                        cornerRadius: 12,
                        displayColors: true,
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((context.parsed / total) * 100).toFixed(1);
                                return ` ${context.label}: ${context.parsed} leads (${percentage}%)`;
                            }
                        }
                    }
                },
                cutout: '65%'
            }
        });

        // Trend Chart (Last 7 Days)
        const trendCtx = document.getElementById('trendChart').getContext('2d');
        const today = new Date();
        const trendLabels = [];
        const trendData = [];
        
        // Generate mock data for last 7 days
        for (let i = 6; i >= 0; i--) {
            const date = new Date(today);
            date.setDate(date.getDate() - i);
            trendLabels.push(date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' }));
            trendData.push(Math.floor(Math.random() * 15) + 5); // Mock data
        }
        
        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: trendLabels,
                datasets: [{
                    label: 'Leads',
                    data: trendData,
                    borderColor: '#6366f1',
                    backgroundColor: 'rgba(99, 102, 241, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    pointBackgroundColor: '#6366f1',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        padding: 12,
                        titleFont: {
                            size: 14,
                            family: "'Plus Jakarta Sans', sans-serif",
                            weight: 700
                        },
                        bodyFont: {
                            size: 13,
                            family: "'Plus Jakarta Sans', sans-serif",
                            weight: 600
                        },
                        cornerRadius: 8
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f1f5f9',
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                family: "'Plus Jakarta Sans', sans-serif",
                                weight: 600
                            },
                            color: '#64748b'
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                family: "'Plus Jakarta Sans', sans-serif",
                                weight: 600
                            },
                            color: '#64748b'
                        }
                    }
                }
            }
        });
    </script>
    @endpush
</x-app-layout>
