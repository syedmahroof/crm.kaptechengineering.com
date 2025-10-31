<x-app-layout>
    <x-slot name="title">Product Analytics</x-slot>
    <x-slot name="subtitle">Comprehensive insights and trends for your product catalog</x-slot>

    <!-- Key Metrics Grid -->
    <div class="row g-4 mb-5">
        <!-- Total Products -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);">
                    <i class="bi bi-box-seam text-white"></i>
                </div>
                <div class="stat-label">Total Products</div>
                <div class="stat-value">{{ $totalProducts }}</div>
                <span class="stat-change {{ $productsGrowth >= 0 ? 'positive' : '' }}">
                    <i class="bi bi-arrow-{{ $productsGrowth >= 0 ? 'up' : 'down' }}"></i> {{ abs($productsGrowth) }}% this month
                </span>
            </div>
        </div>

        <!-- Active Products -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                    <i class="bi bi-check-circle-fill text-white"></i>
                </div>
                <div class="stat-label">Active Products</div>
                <div class="stat-value">{{ $activeProducts }}</div>
                <span class="stat-change positive">
                    <i class="bi bi-arrow-up"></i> {{ $totalProducts > 0 ? round(($activeProducts / $totalProducts) * 100, 1) : 0 }}% of total
                </span>
            </div>
        </div>

        <!-- Average Price -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                    <i class="bi bi-currency-dollar text-white"></i>
                </div>
                <div class="stat-label">Average Price</div>
                <div class="stat-value">${{ number_format($avgPrice, 0) }}</div>
                <span class="stat-change" style="background: #fef3c7; color: #92400e;">
                    <i class="bi bi-info-circle"></i> Across all products
                </span>
            </div>
        </div>

        <!-- Engagement Rate -->
        <div class="col-xl-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
                    <i class="bi bi-graph-up-arrow text-white"></i>
                </div>
                <div class="stat-label">Engagement Rate</div>
                <div class="stat-value">{{ $engagementRate }}%</div>
                <span class="stat-change positive">
                    <i class="bi bi-people-fill"></i> {{ $productsWithLeads }} products with leads
                </span>
            </div>
        </div>
    </div>

    <!-- Charts Row 1 -->
    <div class="row g-4 mb-5">
        <!-- Products by Status -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5>Products by Status</h5>
                    <small class="text-muted">Active vs Inactive breakdown</small>
                </div>
                <div class="card-body">
                    <canvas id="statusChart" height="280"></canvas>
                </div>
            </div>
        </div>

        <!-- Product Trend (Last 30 Days) -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5>Product Trend (Last 30 Days)</h5>
                    <small class="text-muted">Daily product additions</small>
                </div>
                <div class="card-body">
                    <canvas id="trendChart" height="280"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row 2 -->
    <div class="row g-4 mb-5">
        <!-- Products by Category -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5>Products by Category</h5>
                    <small class="text-muted">Category distribution</small>
                </div>
                <div class="card-body">
                    <canvas id="categoryChart" height="250"></canvas>
                </div>
            </div>
        </div>

        <!-- Products by Brand -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5>Products by Brand</h5>
                    <small class="text-muted">Brand distribution</small>
                </div>
                <div class="card-body">
                    <canvas id="brandChart" height="250"></canvas>
                </div>
            </div>
        </div>

        <!-- Price Distribution -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5>Price Distribution</h5>
                    <small class="text-muted">Products by price range</small>
                </div>
                <div class="card-body">
                    <canvas id="priceChart" height="250"></canvas>
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
                    <h5>Monthly Product Comparison</h5>
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
                            <span class="fw-bold">Active Products</span>
                            <span class="badge bg-success">{{ $activeProducts }}</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" style="width: {{ $totalProducts > 0 ? ($activeProducts / $totalProducts) * 100 : 0 }}%"></div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="fw-bold">Inactive Products</span>
                            <span class="badge bg-secondary">{{ $inactiveProducts }}</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-secondary" style="width: {{ $totalProducts > 0 ? ($inactiveProducts / $totalProducts) * 100 : 0 }}%"></div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="fw-bold">With Leads</span>
                            <span class="badge bg-primary">{{ $productsWithLeads }}</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-primary" style="width: {{ $totalProducts > 0 ? ($productsWithLeads / $totalProducts) * 100 : 0 }}%"></div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="fw-bold">Without Leads</span>
                            <span class="badge bg-warning">{{ $productsWithoutLeads }}</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-warning" style="width: {{ $totalProducts > 0 ? ($productsWithoutLeads / $totalProducts) * 100 : 0 }}%"></div>
                        </div>
                    </div>

                    <div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="fw-bold">Total Value</span>
                            <span class="badge bg-info">${{ number_format($totalValue, 2) }}</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-info" style="width: 100%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Products Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Top Products by Lead Engagement</h5>
                    <small class="text-muted">Products with most associated leads</small>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Category</th>
                                    <th>Brand</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Lead Count</th>
                                    <th>Engagement</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topProducts as $product)
                                <tr>
                                    <td><strong>{{ $product->name }}</strong></td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>{{ $product->brand->name }}</td>
                                    <td>${{ number_format($product->price ?? 0, 2) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $product->status == 'active' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($product->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $product->leads_count }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress me-2" style="width: 100px; height: 8px;">
                                                @php
                                                    $maxLeads = $topProducts->max('leads_count') ?: 1;
                                                    $percentage = ($product->leads_count / $maxLeads) * 100;
                                                @endphp
                                                <div class="progress-bar bg-primary" style="width: {{ $percentage }}%"></div>
                                            </div>
                                            <span class="fw-bold small">{{ round($percentage, 1) }}%</span>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        No products found.
                                    </td>
                                </tr>
                                @endforelse
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
                labels: ['Active', 'Inactive'],
                datasets: [{
                    data: [{{ $activeProducts }}, {{ $inactiveProducts }}],
                    backgroundColor: ['#10b981', '#6b7280'],
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
                        labels: { 
                            padding: 20, 
                            font: { size: 12, weight: 600 },
                            generateLabels: function(chart) {
                                const data = chart.data;
                                const total = data.datasets[0].data.reduce((a, b) => a + b, 0);
                                return data.labels.map((label, i) => {
                                    const value = data.datasets[0].data[i];
                                    const percentage = ((value / total) * 100).toFixed(1);
                                    return {
                                        text: `${label} (${value} - ${percentage}%)`,
                                        fillStyle: data.datasets[0].backgroundColor[i],
                                        hidden: false,
                                        index: i
                                    };
                                });
                            }
                        }
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
                    label: 'Products Added',
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

        // Category Chart
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        new Chart(categoryCtx, {
            type: 'pie',
            data: {
                labels: {!! json_encode($productsByCategory->pluck('name')) !!},
                datasets: [{
                    data: {!! json_encode($productsByCategory->pluck('count')) !!},
                    backgroundColor: [
                        '#6366f1', '#8b5cf6', '#ec4899', '#f59e0b', 
                        '#10b981', '#06b6d4', '#f97316', '#84cc16'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { 
                        position: 'bottom', 
                        labels: { padding: 15, font: { size: 11 } } 
                    }
                }
            }
        });

        // Brand Chart
        const brandCtx = document.getElementById('brandChart').getContext('2d');
        new Chart(brandCtx, {
            type: 'polarArea',
            data: {
                labels: {!! json_encode($productsByBrand->pluck('name')) !!},
                datasets: [{
                    data: {!! json_encode($productsByBrand->pluck('count')) !!},
                    backgroundColor: [
                        'rgba(99, 102, 241, 0.7)',
                        'rgba(139, 92, 246, 0.7)',
                        'rgba(236, 72, 153, 0.7)',
                        'rgba(245, 158, 11, 0.7)',
                        'rgba(16, 185, 129, 0.7)',
                        'rgba(6, 182, 212, 0.7)',
                        'rgba(249, 115, 22, 0.7)',
                        'rgba(132, 204, 22, 0.7)'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { 
                        position: 'bottom', 
                        labels: { padding: 10, font: { size: 11 } } 
                    }
                }
            }
        });

        // Price Distribution Chart
        const priceCtx = document.getElementById('priceChart').getContext('2d');
        new Chart(priceCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($priceRanges)) !!},
                datasets: [{
                    label: 'Products',
                    data: {!! json_encode(array_values($priceRanges)) !!},
                    backgroundColor: 'rgba(99, 102, 241, 0.8)',
                    borderRadius: 8
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

        // Monthly Comparison Chart
        const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
        new Chart(monthlyCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($monthlyLabels) !!},
                datasets: [
                    {
                        label: 'New Products',
                        data: {!! json_encode($monthlyNew) !!},
                        backgroundColor: 'rgba(99, 102, 241, 0.8)',
                        borderRadius: 6
                    },
                    {
                        label: 'Active Products',
                        data: {!! json_encode($monthlyActive) !!},
                        backgroundColor: 'rgba(16, 185, 129, 0.8)',
                        borderRadius: 6
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { 
                        position: 'top', 
                        labels: { padding: 20, font: { size: 12, weight: 600 } } 
                    }
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

