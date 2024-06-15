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
                <!-- Charts -->
                <div class="col-xxl-12">
                    <div class="card">
                        <div class="card-header">
                            <h1>Dashboard - Income Records Over Periods</h1>
                            @foreach($incomeRecords as $period => $data)
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header">Data for {{ $period }}</div>
                                            <div class="card-body">
                                                <canvas id="incomeChart{{ $period }}" height="500"></canvas>
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

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                @foreach($incomeRecords as $period => $data)
                var ctx = document.getElementById('incomeChart{{ $period }}').getContext('2d');
                var labels = @json(array_keys($data->toArray()));
                var rdcShareData = @json(array_column($data->toArray(), 'rdc_share'));
                var communityShareData = @json(array_column($data->toArray(), 'community_share'));
                var caShareData = @json(array_column($data->toArray(), 'ca_share'));

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'RDC Share',
                                data: rdcShareData,
                                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Community Share',
                                data: communityShareData,
                                backgroundColor: 'rgba(153, 102, 255, 0.6)',
                                borderColor: 'rgba(153, 102, 255, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'CA Share',
                                data: caShareData,
                                backgroundColor: 'rgba(255, 159, 64, 0.6)',
                                borderColor: 'rgba(255, 159, 64, 1)',
                                borderWidth: 1
                            }
                        ]
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
                                    stepSize: 10000,
                                    max: 200000 // Adjust according to your data range
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
@endsection
