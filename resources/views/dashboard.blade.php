<x-app-layout>
    <x-slot name="header">
        {{ __('Dashboard') }}
    </x-slot>
    @if (session('user_email') == "christian.villamer@jakagroup.com")
    <div class="container-fluid">
        <div class="row">
            <div class="container mt-4">
                <div class="row g-3 mb-3">
                    <!-- Top Stats -->
                    <div class="col-md-3">
                        <div class="card shadow-sm text-center">
                            <div class="card-body">
                                <i class="bi bi-box h2 d-block mb-2"></i>
                                <h6>Total Assets</h6>
                                <h3>325</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card shadow-sm text-center">
                            <div class="card-body">
                                <i class="bi bi-people h2 d-block mb-2"></i>
                                <h6>Total Employees</h6>
                                <h3>112</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card shadow-sm text-center">
                            <div class="card-body">
                                <i class="bi bi-tools h2 d-block mb-2"></i>
                                <h6>Under Maintenance</h6>
                                <h3>12</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card shadow-sm text-center">
                            <div class="card-body">
                                <i class="bi bi-trash h2 d-block mb-2"></i>
                                <h6>Disposed Assets</h6>
                                <h3>18</h3>
                            </div>
                        </div>
                    </div>
                </div>
    
                <!-- Chart and Recent Activity -->
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h6>Assets by Category</h6>
                                <canvas id="barChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card shadow-sm">
                            <div class="card-body text-center">
                                <h6>Asset Status</h6>
                                <canvas id="donutChart" style="max-height: 180px;"></canvas>
                                <p class="mt-2 mb-0">45% Active</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h6>Recent Activities</h6>
                                <ul class="list-unstyled small">
                                    <li><span class="text-primary">●</span> Asset GR123 issued – <span class="text-muted">5:21PM</span></li>
                                    <li><span class="text-primary">●</span> Asset SC456 marked – <span class="text-muted">4:45PM</span></li>
                                    <li><span class="text-warning">●</span> Gatepass GP789 created – <span class="text-muted">2:30PM</span></li>
                                    <li><span class="text-success">●</span> Maintenance scheduled – <span class="text-muted">11:15AM</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
    
                <!-- Upcoming + Quick Actions -->
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h6>Upcoming Returns</h6>
                                <ul class="list-unstyled small">
                                    <li>📦 Monitor LM789 — <strong>Apr 25</strong></li>
                                    <li>💻 Laptop CD987 — <strong>Apr 27</strong></li>
                                    <li>📷 Camera UV543 — <strong>Apr 30</strong></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card shadow-sm">
                            <div class="card-body d-flex flex-wrap gap-2 justify-content-start">
                                <button href="/Asset/view" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Add Asset</button>
                                <button class="btn btn-success"><i class="bi bi-box-arrow-in-right"></i> Issue Asset</button>
                                <button class="btn btn-warning"><i class="bi bi-upc-scan"></i> Scan Asset</button>
                                <button class="btn btn-dark"><i class="bi bi-upc"></i> Print Barcode</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


        <!-- Chart.js CDN -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            new Chart(document.getElementById('barChart'), {
                type: 'bar',
                data: {
                    labels: ['Category 1', 'Category 2', 'Category 3', 'Reusage'],
                    datasets: [{
                        label: 'Assets',
                        data: [320, 230, 190, 130],
                        backgroundColor: '#0d6efd'
                    }]
                },
                options: {
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });

            new Chart(document.getElementById('donutChart'), {
                type: 'doughnut',
                data: {
                    labels: ['Active', 'Damaged', 'Other'],
                    datasets: [{
                        data: [45, 20, 15],
                        backgroundColor: ['#0d6efd', '#fd7e14', '#20c997']
                    }]
                },
                options: {
                    cutout: '70%'
                }
            });
        </script>
    @endif
    
</x-app-layout>
