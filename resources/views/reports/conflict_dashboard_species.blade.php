@extends('layouts.organisation')

@push('head')
    <!-- Chart.js and other necessary styles -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- Page Title and Breadcrumbs -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Human Wildlife Conflict Dashboard by Species</h4>
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

            <!-- Species Selection Form -->
            <form action="{{ route('conflict-dashboard-species', $organisation->slug) }}" method="GET" class="mb-4">
                <div class="form-group">
                    <label for="species_id">Select Species:</label>
                    <select id="species_id" name="species_id" class="form-control" onchange="this.form.submit()">
                        @foreach($species as $specie)
                            <option value="{{ $specie->id }}" {{ $selectedSpeciesId == $specie->id ? 'selected' : '' }}>{{ $specie->name }}</option>
                        @endforeach
                    </select>
                </div>
            </form>

            <!-- Species Name for Chart Titles -->
            @php
                $selectedSpeciesName = $species->firstWhere('id', $selectedSpeciesId)->name ?? 'Selected Species';
            @endphp

                <!-- Charts for Each Period -->
            @foreach($periods as $period)
                <div class="card mb-4">
                    <div class="card-header">Data for {{ $period }} - {{ $selectedSpeciesName }}</div>
                    <div class="card-body">
                        <canvas id="conflictChart{{ $period }}" height="500"></canvas> <!-- Increased height -->
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                @foreach($periods as $period)
                var ctx = document.getElementById('conflictChart{{ $period }}').getContext('2d');
                var dataForPeriod = @json($chartData[$period] ?? []);
                var labels = Object.keys(dataForPeriod);
                var datasets = [];
                var metrics = [
                    'crop_damage_cases',
                    'hectarage_destroyed', // Added new metric here
                    'human_injured',
                    'human_death',
                    'livestock_killed_injured',
                    'infrastructure_destroyed',
                    'threat_to_human_life'
                ];
                var colors = [
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(255, 159, 64, 0.6)', // New color for the added metric
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(153, 102, 255, 0.6)',
                    'rgba(201, 203, 207, 0.6)' // Additional color if needed
                ];

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
                                    stepSize: 10,
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
@endsection
