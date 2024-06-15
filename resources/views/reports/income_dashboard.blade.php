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
                        <h4 class="mb-sm-0">Income Records Dashboard</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                                <li class="breadcrumb-item active">Income Records Dashboard</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Page Title -->

            <div class="row">
                @foreach ($incomeRecords as $period => $data)
                    <div class="col-12 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h5>Income Records for {{ $period }}</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="incomeChart{{ $period }}" height="400"></canvas>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                @foreach ($incomeRecords as $period => $data)
                var ctx = document.getElementById('incomeChart{{ $period }}').getContext('2d');
                var dataForPeriod = @json($data);

                var labels = Object.keys(dataForPeriod);
                var datasets = [];
                var metrics = ['rdc_share', 'community_share', 'ca_share'];
                var colors = ['rgba(255, 99, 132, 0.6)', 'rgba(54, 162, 235, 0.6)', 'rgba(75, 192, 192, 0.6)'];

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
                    type: 'line', // Changed to 'line' for trend analysis
                    data: {
                        labels: labels,
                        datasets: datasets
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
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
                                beginAtZero: true
                            }
                        },
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
@endsection
