@extends('layouts.organisation')

@push('head')
    <!-- Chart.js and other necessary styles -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
    <div class="container-fluid">
        <!-- Page Title and Breadcrumbs -->
        <div class="page-title-box">
            <h4 class="page-title">Species Allocation and Utilization Dashboard</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
                <li class="breadcrumb-item active">Species Dashboard</li>
            </ol>
        </div>

        <!-- Species Selection Form -->
        <form action="{{ route('hunting-dashboard-species', $organisation->slug) }}" method="GET" class="mb-4">
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
                    <canvas id="chartPeriod{{ $period }}" height="100"></canvas>
                </div>
            </div>
        @endforeach
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                @foreach($periods as $period)
                var ctx = document.getElementById('chartPeriod{{ $period }}').getContext('2d');
                var chartData = @json($chartData[$period] ?? []);
                var labels = Object.keys(chartData);
                var allocatedData = labels.map(label => chartData[label].allocated);
                var utilisedData = labels.map(label => chartData[label].utilised);

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Allocated',
                            data: allocatedData,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }, {
                            label: 'Utilised',
                            data: utilisedData,
                            backgroundColor: 'rgba(255, 159, 64, 0.2)',
                            borderColor: 'rgba(255, 159, 64, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
                @endforeach
            });
        </script>
    @endpush

@endsection
