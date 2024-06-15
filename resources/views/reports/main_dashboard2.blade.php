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

            <div class="row">
                <!-- Hunting Records Chart -->
                <div class="col-xxl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Species Allocation and Utilization Overview</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="huntingRecordsChart" height="100"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Conflict Data Chart -->
                <div class="col-xxl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Human Wildlife Conflict Over Periods Overview</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="conflictDataChart" height="100"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Control Cases Chart -->
                <div class="col-xxl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Problem Animal Control Cases Overview</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="controlCasesChart" height="100"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Hunting Records Chart
                var ctxHunting = document.getElementById('huntingRecordsChart').getContext('2d');
                var huntingRecordsData = @json($huntingRecords);
                var huntingLabels = Object.keys(huntingRecordsData);
                var huntingDatasets = [];
                Object.keys(huntingRecordsData[huntingLabels[0]]).forEach(function (species, index) {
                    var allocatedData = huntingLabels.map(period => huntingRecordsData[period][species].allocated);
                    var utilisedData = huntingLabels.map(period => huntingRecordsData[period][species].utilised);

                    huntingDatasets.push({
                        label: species + ' - Allocated',
                        data: allocatedData,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    });

                    huntingDatasets.push({
                        label: species + ' - Utilised',
                        data: utilisedData,
                        backgroundColor: 'rgba(255, 99, 132, 0.6)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    });
                });

                new Chart(ctxHunting, {
                    type: 'bar',
                    data: {
                        labels: huntingLabels,
                        datasets: huntingDatasets
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                // Conflict Data Chart
                var ctxConflict = document.getElementById('conflictDataChart').getContext('2d');
                var conflictRecordsData = @json($conflictRecords);
                var conflictLabels = Object.keys(conflictRecordsData);
                var conflictDatasets = [];
                Object.keys(conflictRecordsData[conflictLabels[0]]).forEach(function (species, index) {
                    var cropDamageData = conflictLabels.map(period => conflictRecordsData[period][species].crop_damage_cases);
                    var humanInjuredData = conflictLabels.map(period => conflictRecordsData[period][species].human_injured);
                    var humanDeathData = conflictLabels.map(period => conflictRecordsData[period][species].human_death);
                    var livestockKilledInjuredData = conflictLabels.map(period => conflictRecordsData[period][species].livestock_killed_injured);
                    var infrastructureDestroyedData = conflictLabels.map(period => conflictRecordsData[period][species].infrastructure_destroyed);
                    var threatToHumanLifeData = conflictLabels.map(period => conflictRecordsData[period][species].threat_to_human_life);

                    conflictDatasets.push({
                        label: species + ' - Crop Damage Cases',
                        data: cropDamageData,
                        backgroundColor: 'rgba(255, 99, 132, 0.6)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    });

                    conflictDatasets.push({
                        label: species + ' - Human Injured',
                        data: humanInjuredData,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    });

                    conflictDatasets.push({
                        label: species + ' - Human Death',
                        data: humanDeathData,
                        backgroundColor: 'rgba(255, 206, 86, 0.6)',
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 1
                    });

                    conflictDatasets.push({
                        label: species + ' - Livestock Killed/Injured',
                        data: livestockKilledInjuredData,
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    });

                    conflictDatasets.push({
                        label: species + ' - Infrastructure Destroyed',
                        data: infrastructureDestroyedData,
                        backgroundColor: 'rgba(153, 102, 255, 0.6)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    });

                    conflictDatasets.push({
                        label: species + ' - Threat to Human Life',
                        data: threatToHumanLifeData,
                        backgroundColor: 'rgba(255, 159, 64, 0.6)',
                        borderColor: 'rgba(255, 159, 64, 1)',
                        borderWidth: 1
                    });
                });

                new Chart(ctxConflict, {
                    type: 'bar',
                    data: {
                        labels: conflictLabels,
                        datasets: conflictDatasets
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                // Control Cases Chart
                var ctxControl = document.getElementById('controlCasesChart').getContext('2d');
                var controlCasesData = @json($controlCases);
                var controlLabels = Object.keys(controlCasesData);
                var controlDatasets = [];
                Object.keys(controlCasesData[controlLabels[0]]).forEach(function (species, index) {
                    var casesData = controlLabels.map(period => controlCasesData[period][species].cases);
                    var killedData = controlLabels.map(period => controlCasesData[period][species].killed);
                    var scaredData = controlLabels.map(period => controlCasesData[period][species].scared);
                    var relocatedData = controlLabels.map(period => controlCasesData[period][species].relocated);

                    controlDatasets.push({
                        label: species + ' - Cases',
                        data: casesData,
                        backgroundColor: 'rgba(255, 99, 132, 0.6)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    });

                    controlDatasets.push({
                        label: species + ' - Killed',
                        data: killedData,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    });

                    controlDatasets.push({
                        label: species + ' - Scared',
                        data: scaredData,
                        backgroundColor: 'rgba(255, 206, 86, 0.6)',
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 1
                    });

                    controlDatasets.push({
                        label: species + ' - Relocated',
                        data: relocatedData,
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    });
                });

                new Chart(ctxControl, {
                    type: 'bar',
                    data: {
                        labels: controlLabels,
                        datasets: controlDatasets
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            });
        </script>
    @endpush
@endsection
