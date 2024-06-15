@extends('layouts.organisation')
@push('head')

    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css"/>
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css"/>

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endpush
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Hunting Dashboard</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">CRM</a></li>
                                <li class="breadcrumb-item active"></li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">

                <!--end col-->
                <div class="col-xxl-12">
                    <div class="card">
                        <div class="card-header">

                            <h1>Dashboard - Species Allocation and Utilization Over Periods</h1>

                            @foreach($periods as $period)
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header">Data for {{ $period }}</div>
                                            <div class="card-body">
                                                <canvas id="chartPeriod{{ $period }}"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                        <!--end card-->
                    </div>


                </div>
                <!--end row-->

            </div>
            <!-- container-fluid -->
        </div>
        @endsection

        @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    @foreach($periods as $period)
                    var ctx = document.getElementById('chartPeriod{{ $period }}').getContext('2d');
                    var chartLabels = [];
                    var allocatedData = [];
                    var utilisedData = [];

                    @foreach($chartData[$period] as $district => $speciesData)
                    @foreach($speciesData as $speciesName => $data)
                    chartLabels.push("{{ $district }} - {{ $speciesName }}");
                    allocatedData.push({{ $data['allocated'] }});
                    utilisedData.push({{ $data['utilised'] }});
                    @endforeach
                    @endforeach

                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: chartLabels,
                            datasets: [
                                {
                                    label: 'Allocated',
                                    data: allocatedData,
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1
                                },
                                {
                                    label: 'Utilised',
                                    data: utilisedData,
                                    backgroundColor: 'rgba(255, 159, 64, 0.2)',
                                    borderColor: 'rgba(255, 159, 64, 1)',
                                    borderWidth: 1
                                }
                            ]
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
