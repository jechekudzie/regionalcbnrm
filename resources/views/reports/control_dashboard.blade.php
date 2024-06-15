@extends('layouts.organisation')

@push('head')
    <!-- Chart.js CSS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- Page Title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Control Cases Dashboard</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                                <li class="breadcrumb-item active">Control Cases Dashboard</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Page Title -->

            <div class="row">
                <!-- Charts -->
                <div class="col-xxl-12">
                    <div class="card">
                        <div class="card-header">
                            <h1>Dashboard - Control Cases Over Periods</h1>
                            @foreach($periods as $period)
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header">Data for {{ $period }}</div>
                                            <div class="card-body">
                                                <canvas id="controlChart{{ $period }}" height="500"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @foreach($periods as $period)
            var ctx = document.getElementById('controlChart{{ $period }}').getContext('2d');
            var dataForPeriod = @json($chartData[$period] ?? []);
            var labels = Object.keys(dataForPeriod);
            var datasets = [];
            var metrics = ['cases', 'killed', 'scared', 'relocated'];
            var colors = ['rgba(255, 99, 132, 0.6)', 'rgba(54, 162, 235, 0.6)', 'rgba(255, 206, 86, 0.6)', 'rgba(75, 192, 192, 0.6)'];

            metrics.forEach(function (metric, index) {
                var metricData = labels.map(function (label) {
                    return dataForPeriod[label][metric] || 0;
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
                                stepSize: 100,
                                max: 500
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

