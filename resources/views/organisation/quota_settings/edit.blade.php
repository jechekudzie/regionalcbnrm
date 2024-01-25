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
                        <h4 class="mb-sm-0">Update Quota Requests - {{$selectedSpecies->name}}</h4>

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
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center flex-wrap gap-2">
                                <div class="flex-grow-1">

                                    <a class="btn btn-info add-btn" href="{{route('organisation.quota-settings.index',[$organisation->slug,$selectedSpecies->slug])}}"><i
                                            class="fa fa-arrow-left"></i> Back to {{$selectedSpecies->name}} Quota Settings
                                    </a>

                                </div>
                                <div class="flex-shrink-0">
                                    <div class="hstack text-nowrap gap-2">
                                        <button type="button" id="dropdownMenuLink1" data-bs-toggle="dropdown"
                                                aria-expanded="false" class="btn btn-soft-info"><i
                                                class="ri-more-2-fill"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end col-->
                <div class="col-xxl-12">
                    <div class="card">
                        <div class="card-header">
                            @if(session()->has('errors'))
                                @if($errors->any())

                                    @foreach($errors->all() as $error)
                                        <!-- Success Alert -->
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong> Errors! </strong> {{ $error }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                        </div>
                                    @endforeach

                                @endif
                            @endif
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Message!</strong> {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                </div>
                            @endif
                            <h2>Update Quota Settings for {{ $selectedSpecies->name }}</h2>
                                <form method="post" action="{{ route('organisation.quota-settings.update', [$organisation->slug, $quotaRequest->slug]) }}">
                                    @csrf
                                    @method('PATCH') <!-- HTTP PUT method for updating -->

                                    <!-- Hidden Species ID -->
                                    <input type="hidden" name="species_id" value="{{ $selectedSpecies->id }}">

                                    <!-- Hidden Organisation ID -->
                                    <input type="hidden" name="organisation_id" value="{{ $organisation->id }}">

                                    <div class="row">
                                        <!-- Select Year -->
                                        <div class="col-md-4 mb-3">
                                            <label for="year" class="form-label">Year</label>
                                            <select class="form-control" id="year" name="year" required>
                                                <option value="">Select Year</option>
                                                @for ($year = now()->year; $year >= 2015; $year--)
                                                    <option value="{{ $year }}" {{ $year == $quotaRequest->year ? 'selected' : '' }}>{{ $year }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <!-- Initial Quota -->
                                        <div class="col-md-4 mb-3">
                                            <label for="initial_quota" class="form-label">Initial Quota</label>
                                            <input type="number" class="form-control" id="initial_quota" name="initial_quota" placeholder="Enter initial quota" value="{{ $quotaRequest->initial_quota }}">
                                        </div>

                                        <!-- RDC Quota -->
                                        <div class="col-md-4 mb-3">
                                            <label for="rdc_quota" class="form-label">RDC Quota</label>
                                            <input type="number" class="form-control" id="rdc_quota" name="rdc_quota" placeholder="Enter RDC quota" value="{{ $quotaRequest->rdc_quota }}">
                                        </div>

                                        <!-- Campfire Quota -->
                                        <div class="col-md-4 mb-3">
                                            <label for="campfire_quota" class="form-label">Campfire Quota</label>
                                            <input type="number" class="form-control" id="campfire_quota" name="campfire_quota" placeholder="Enter campfire quota" value="{{ $quotaRequest->campfire_quota }}">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <!-- Zimpark Station Quota -->
                                        <div class="col-md-4 mb-3">
                                            <label for="zimpark_station_quota" class="form-label">Zimpark Station Quota</label>
                                            <input type="number" class="form-control" id="zimpark_station_quota" name="zimpark_station_quota" placeholder="Enter Zimpark station quota" value="{{ $quotaRequest->zimpark_station_quota }}">
                                        </div>

                                        <!-- National Park Quota -->
                                        <div class="col-md-4 mb-3">
                                            <label for="national_park_quota" class="form-label">National Park Quota</label>
                                            <input type="number" class="form-control" id="national_park_quota" name="national_park_quota" placeholder="Enter national park quota" value="{{ $quotaRequest->national_park_quota }}">
                                        </div>
                                    </div>

                                    <!-- Submission Button -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary">Update Quota Request</button>
                                        </div>
                                    </div>
                                </form>

                        </div>
                        <!--end card-->
                    </div>



                </div>
                <!--end row-->

            </div>
            <!-- container-fluid -->
        </div>
        @stop

        @push('scripts')
            <!--datatable js-->
            <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
            <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

            <script>
                <!-- datatable js -->
                document.addEventListener("DOMContentLoaded", function () {
                    $('#buttons-datatables').DataTable({
                        dom: 'Bfrtip',
                        buttons: ['copy', 'csv', 'excel', 'print', 'pdf']
                    });
                });

                // Assuming you have jQuery available



            </script>

    @endpush
