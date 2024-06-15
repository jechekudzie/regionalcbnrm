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
                        <h4 class="mb-sm-0">Human Wildlife Conflict Dashboard</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                                <li class="breadcrumb-item active">Human Wildlife Conflict Dashboard</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Page Title -->

            <!-- Trend Analysis Charts -->
            <div class="row">
                @foreach (['Species Allocation and Utilization Over Periods' => $formattedHuntingRecords, 'Human Wildlife Conflict Over Periods' => $formattedConflictRecords, 'Problem Animal Control Cases' => $formattedControlCases] as $title => $data)
                    <div class="col-12 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h5>{{ $title }}</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="{{ Str::slug($title) }}Chart" height="400"></canvas>
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
                @foreach (['Species Allocation and Utilization Over Periods' => $formattedHuntingRecords, 'Human Wildlife Conflict Over Periods' => $formattedConflictRecords, 'Problem Animal Control Cases' => $formattedControlCases] as $title => $data)
                var ctx = document.getElementById('{{ Str::slug($title) }}Chart').getContext('2d');
                var dataForChart = @json($data);

                var labels = Object.keys(dataForChart);
                var datasets = [];
                var speciesNames = new Set();

                // Gather all species names
                Object.values(dataForChart).forEach(periodData => {
                    Object.keys(periodData).forEach(species => speciesNames.add(species));
                });

                // Create datasets for each species with combined metrics
                speciesNames.forEach(function (species) {
                    var speciesData = labels.map(function (period) {
                        return dataForChart[period][species] || { allocated: 0, utilised: 0, crop_damage_cases: 0, human_injured: 0, human_death: 0, livestock_killed_injured: 0, infrastructure_destroyed: 0, threat_to_human_life: 0, cases: 0, killed: 0, scared: 0, relocated: 0 };
                    });

                    var combinedData = speciesData.map(function (data) {
                        return Object.values(data).reduce((sum, value) => sum + value, 0);
                    });

                    datasets.push({
                        label: species,
                        data: combinedData,
                        fill: false,
                        borderColor: 'rgba(' + Math.floor(Math.random() * 255) + ', ' + Math.floor(Math.random() * 255) + ', ' + Math.floor(Math.random() * 255) + ', 0.6)',
                        tension: 0.1
                    });
                });

                new Chart(ctx, {
                    type: 'line',
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
