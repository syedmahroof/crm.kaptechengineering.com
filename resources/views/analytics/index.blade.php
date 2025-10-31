<x-app-layout>
    <x-slot name="title">Lead Analytics</x-slot>
    <x-slot name="subtitle">Comprehensive insights and trends for your lead pipeline</x-slot>

    <!-- Key Metrics Grid -->
    <div class="row g-4 mb-5">
        <!-- Total Leads -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);">
                    <i class="bi bi-people-fill text-white"></i>
                </div>
                <div class="stat-label">Total Leads</div>
                <div class="stat-value">{{ $totalLeads }}</div>
                <span class="stat-change positive">
                    <i class="bi bi-arrow-up"></i> {{ $leadsGrowth }}% this month
                </span>
            </div>
        </div>

        <!-- Conversion Rate -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                    <i class="bi bi-graph-up-arrow text-white"></i>
                </div>
                <div class="stat-label">Conversion Rate</div>
                <div class="stat-value">{{ $conversionRate }}%</div>
                <span class="stat-change positive">
                    <i class="bi bi-arrow-up"></i> +2.5% vs last month
                </span>
            </div>
        </div>

        <!-- Avg Response Time -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                    <i class="bi bi-clock-history text-white"></i>
                </div>
                <div class="stat-label">Avg Response Time</div>
                <div class="stat-value">{{ $avgResponseTime }}h</div>
                <span class="stat-change" style="background: #fef3c7; color: #92400e;">
                    <i class="bi bi-dash"></i> Same as before
                </span>
            </div>
        </div>

        <!-- Active Leads -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
                    <i class="bi bi-fire text-white"></i>
                </div>
                <div class="stat-label">Active Leads</div>
                <div class="stat-value">{{ $activeLeads }}</div>
                <span class="stat-change positive">
                    <i class="bi bi-arrow-up"></i> {{ $activeLeadsGrowth }}% increase
                </span>
            </div>
        </div>
    </div>

    <!-- Charts Row 1 -->
    <div class="row g-4 mb-5">
        <!-- Lead Status Distribution -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5>Lead Status Distribution</h5>
                    <small class="text-muted">Current pipeline breakdown</small>
                </div>
                <div class="card-body">
                    <canvas id="statusChart" height="280"></canvas>
                </div>
            </div>
        </div>

        <!-- Lead Trend (Last 30 Days) -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5>Lead Trend (Last 30 Days)</h5>
                    <small class="text-muted">Daily lead generation overview</small>
                </div>
                <div class="card-body">
                    <canvas id="trendChart" height="280"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row 2 -->
    <div class="row g-4 mb-5">
        <!-- Leads by Source -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5>Leads by Source</h5>
                    <small class="text-muted">Acquisition channels</small>
                </div>
                <div class="card-body">
                    <canvas id="sourceChart" height="250"></canvas>
                </div>
            </div>
        </div>

        <!-- Top Performing Users -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5>Top Performing Users</h5>
                    <small class="text-muted">Leads closed this month</small>
                </div>
                <div class="card-body">
                    <canvas id="usersChart" height="250"></canvas>
                </div>
            </div>
        </div>

        <!-- Lead Categories -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5>Leads by Product Category</h5>
                    <small class="text-muted">Product interest breakdown</small>
                </div>
                <div class="card-body">
                    <canvas id="categoryChart" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Stats Row -->
    <div class="row g-4 mb-5">
        <!-- Monthly Comparison -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5>Monthly Lead Comparison</h5>
                    <small class="text-muted">Last 6 months performance</small>
                </div>
                <div class="card-body">
                    <canvas id="monthlyChart" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="col-lg-4">
            <div class="card" style="height: 100%;">
                <div class="card-header">
                    <h5>Quick Statistics</h5>
                    <small class="text-muted">Key performance indicators</small>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="fw-bold">Hot Leads</span>
                            <span class="badge bg-danger">{{ $hotLeads }}</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-danger" style="width: {{ $totalLeads > 0 ? ($hotLeads / $totalLeads) * 100 : 0 }}%"></div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="fw-bold">Warm Leads</span>
                            <span class="badge bg-warning">{{ $warmLeads }}</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-warning" style="width: {{ $totalLeads > 0 ? ($warmLeads / $totalLeads) * 100 : 0 }}%"></div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="fw-bold">Cold Leads</span>
                            <span class="badge bg-info">{{ $coldLeads }}</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-info" style="width: {{ $totalLeads > 0 ? ($coldLeads / $totalLeads) * 100 : 0 }}%"></div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="fw-bold">Closed Won</span>
                            <span class="badge bg-success">{{ $closedWon }}</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" style="width: {{ $totalLeads > 0 ? ($closedWon / $totalLeads) * 100 : 0 }}%"></div>
                        </div>
                    </div>

                    <div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="fw-bold">Closed Lost</span>
                            <span class="badge bg-secondary">{{ $closedLost }}</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-secondary" style="width: {{ $totalLeads > 0 ? ($closedLost / $totalLeads) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Lead Performance by Branch</h5>
                    <small class="text-muted">Detailed breakdown by location</small>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Branch</th>
                                    <th>Total Leads</th>
                                    <th>Converted</th>
                                    <th>In Progress</th>
                                    <th>Lost</th>
                                    <th>Conversion Rate</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($branchStats as $stat)
                                <tr>
                                    <td><strong>{{ $stat['name'] }}</strong></td>
                                    <td>{{ $stat['total'] }}</td>
                                    <td><span class="badge bg-success">{{ $stat['converted'] }}</span></td>
                                    <td><span class="badge bg-warning">{{ $stat['inProgress'] }}</span></td>
                                    <td><span class="badge bg-danger">{{ $stat['lost'] }}</span></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress me-2" style="width: 100px; height: 8px;">
                                                <div class="progress-bar bg-success" style="width: {{ $stat['rate'] }}%"></div>
                                            </div>
                                            <span class="fw-bold">{{ $stat['rate'] }}%</span>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Status Distribution Chart
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        new Chart(statusCtx, {
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
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: { padding: 20, font: { size: 12, weight: 600 } }
                    }
                },
                cutout: '65%'
            }
        });

        // Trend Chart
        const trendCtx = document.getElementById('trendChart').getContext('2d');
        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($trendLabels) !!},
                datasets: [{
                    label: 'Leads Created',
                    data: {!! json_encode($trendData) !!},
                    borderColor: '#6366f1',
                    backgroundColor: 'rgba(99, 102, 241, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                    x: { grid: { display: false } }
                }
            }
        });

        // Source Chart
        const sourceCtx = document.getElementById('sourceChart').getContext('2d');
        new Chart(sourceCtx, {
            type: 'pie',
            data: {
                labels: ['Website', 'Referral', 'Social Media', 'Email', 'Direct'],
                datasets: [{
                    data: [35, 25, 20, 15, 5],
                    backgroundColor: ['#6366f1', '#8b5cf6', '#ec4899', '#f59e0b', '#10b981']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { padding: 15, font: { size: 11 } } }
                }
            }
        });

        // Users Chart
        const usersCtx = document.getElementById('usersChart').getContext('2d');
        new Chart(usersCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($topUsers->pluck('name')) !!},
                datasets: [{
                    label: 'Leads Closed',
                    data: {!! json_encode($topUsers->pluck('closed_leads')) !!},
                    backgroundColor: 'rgba(99, 102, 241, 0.8)',
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                    x: { grid: { display: false } }
                }
            }
        });

        // Category Chart
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        new Chart(categoryCtx, {
            type: 'polarArea',
            data: {
                labels: {!! json_encode($categoryData->pluck('name')) !!},
                datasets: [{
                    data: {!! json_encode($categoryData->pluck('count')) !!},
                    backgroundColor: [
                        'rgba(99, 102, 241, 0.7)',
                        'rgba(139, 92, 246, 0.7)',
                        'rgba(236, 72, 153, 0.7)',
                        'rgba(245, 158, 11, 0.7)',
                        'rgba(16, 185, 129, 0.7)'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { padding: 10, font: { size: 11 } } }
                }
            }
        });

        // Monthly Comparison Chart
        const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
        new Chart(monthlyCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($monthlyLabels) !!},
                datasets: [
                    {
                        label: 'New Leads',
                        data: {!! json_encode($monthlyNew) !!},
                        backgroundColor: 'rgba(99, 102, 241, 0.8)',
                        borderRadius: 6
                    },
                    {
                        label: 'Converted',
                        data: {!! json_encode($monthlyConverted) !!},
                        backgroundColor: 'rgba(16, 185, 129, 0.8)',
                        borderRadius: 6
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top', labels: { padding: 20, font: { size: 12, weight: 600 } } }
                },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                    x: { grid: { display: false } }
                }
            }
        });
    </script>
    @endpush
</x-app-layout>

