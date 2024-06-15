@extends('layouts.organisation')

@push('head')
    <!-- Datatable CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- Start Page Title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Control Cases Dashboard by District</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
                                <li class="breadcrumb-item active">Control Cases Dashboard</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Page Title -->

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Dashboard - Control Cases By District</h4>
                    <form action="{{ route('control-dashboard-district', $organisation->slug) }}" method="GET">
                        <div class="mb-3">
                            <label for="organisation_id" class="form-label">Select District</label>
                            <select class="form-select" name="organisation_id" onchange="this.form.submit()">
                                @foreach ($districts as $district)
                                    <option value="{{ $district->id }}" {{ $selectedOrganisationId == $district->id ? 'selected' : '' }}>
                                        {{ $district->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                @foreach ($periods as $period)
                    <div class="card mb-4">
                        <div class="card-header">Data for {{ $period }}</div>
                        <div class="card-body">
                            <canvas id="chartPeriod{{ $period }}" height="500"></canvas>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @foreach ($periods as $period)
            var ctx = document.getElementById('chartPeriod{{ $period }}').getContext('2d');
            var chartData = @json($chartData[$period] ?? []);
            var speciesNames = @json($speciesNames);
            var labels = Object.keys(chartData).map(function(speciesId) {
                return speciesNames[speciesId];
            });
            var datasets = [];

            var metrics = ['cases', 'killed', 'scared', 'relocated'];
            var colors = ['rgba(75, 192, 192, 0.6)', 'rgba(255, 99, 132, 0.6)', 'rgba(54, 162, 235, 0.6)', 'rgba(255, 206, 86, 0.6)'];

            metrics.forEach(function (metric, index) {
                var metricData = Object.keys(chartData).map(function(speciesId) {
                    return chartData[speciesId][metric] || 0;
                });
                datasets.push({
                    label: metric.replace(/_/g, ' ').toUpperCase(),
                    data: metricData,
                    backgroundColor: colors[index],
                    borderColor: colors[index],
                    borderWidth: 1
                });
            });

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: datasets
                },
                options: {
                    scales: {
                        x: {
                            beginAtZero: true,
                            ticks: {
                                autoSkip: false,
                                maxRotation: 90,
                                minRotation: 45
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 100, // Set the step size to 100
                                max: 500 // Set the maximum value to 500
                            }
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                    tooltips: {
                        mode: 'index',
                        intersect: false
                    },
                    legend: {
                        position: 'top',
                    }
                }
            });
            @endforeach
        });
    </script>
@endpush
