@extends('layouts.organisation')

@push('head')
    <!-- Datatable CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endpush

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- Start Page Title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Hunting Dashboard</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">CRM</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Page Title -->

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Dashboard - Species Allocation and Utilization Over Periods By District</h4>
                    <form action="{{ route('hunting-dashboard-district', $organisation->slug) }}" method="GET">
                        <div class="mb-3">
                            <label for="organisation_id" class="form-label">Select District</label>
                            <select class="form-select" name="organisation_id" onchange="this.form.submit()">
                                @foreach ($organisations as $organisation)
                                    <option value="{{ $organisation->id }}" {{ $selectedOrganisationId == $organisation->id ? 'selected' : '' }}>
                                        {{ $organisation->name }}
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
                            <canvas id="chartPeriod{{ $period }}" height="100"></canvas>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @foreach ($periods as $period)
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
                        backgroundColor: 'rgba(255, 99, 132, 0.6)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }, {
                        label: 'Utilised',
                        data: utilisedData,
                        backgroundColor: 'rgba(153, 102, 255, 0.6)',
                        borderColor: 'rgba(153, 102, 255, 1)',
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
