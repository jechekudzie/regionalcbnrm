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
                        <h4 class="mb-sm-0">{{ $organisation->name }} - {{$selectedSpecies->name}} - Quota Requests</h4>

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

                                    <a class="btn btn-info add-btn"
                                       href="{{route('organisation.quota-settings.species',[$organisation->slug])}}"><i
                                            class="fa fa-arrow-left"></i> Back to species
                                    </a>
                                    <button class="btn btn-success add-btn" data-bs-toggle="modal"
                                            data-bs-target="#showModal"><i
                                            class="fa fa-plus"></i> Record Quota Settings
                                    </button>
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
                            <h2>{{ $organisation->name }} - Quota Settings for {{ $selectedSpecies->name }}</h2>
                            <br/>
                            <table style="width: 100%;" id="buttons-datatables"
                                   class="display table table-bordered dataTable no-footer"
                                   aria-describedby="buttons-datatables_info">
                                <thead>
                                <tr>
                                    <th>Hunting Concession</th>
                                    <th>Image</th>
                                    <th>Species</th>
                                    <th>Year</th>
                                    <th>Initial Quota</th>
                                    <th>RDC Quota</th>
                                    <th>Zimpark Station Quota</th>
                                    <th>National Park Quota</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($quotaRequests as $quota)
                                    <tr>
                                        <td>{{ $quota->huntingConcession->name }}</td>
                                        <td>
                                            <div class="avatar-md bg-light rounded p-1"><img src="{{asset($quota->species->avatar)}}" alt="" class="img-fluid d-block"></div>
                                        </td>
                                        <td>{{ $quota->species->name }}</td>
                                        <td>{{ $quota->year }}</td>
                                        <td>{{ $quota->initial_quota }}</td>
                                        <td>{{ $quota->rdc_quota }}</td>
                                        <td>{{ $quota->zimpark_station_quota }}</td>
                                        <td>{{ $quota->national_park_quota }}</td>
                                        <td>{{ $quota->status }}</td>
                                        <td>
                                            <!-- Edit Button -->
                                            <a href="{{ route('organisation.quota-settings.edit', [$organisation->slug, $quota->id]) }}"
                                               class="btn btn-sm btn-primary" title="Edit">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <!-- You can add a Delete button here if needed, similar to the Edit button with a form to submit the delete request -->
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>


                        </div>
                        <!--end card-->
                    </div>

                    <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content border-0">
                                <div class="modal-header bg-soft-info p-3">
                                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close" id="close-modal"></button>
                                </div>

                                <div class="card border">
                                    <div class="card-header">

                                        <h4 class="card-title mb-0">{{$selectedSpecies->name}} Quota Request</h4>
                                    </div>
                                    <div class="card-body">

                                        <form method="post"
                                              action="{{ route('organisation.quota-settings.store', $organisation->slug) }}">
                                            @csrf

                                            <!-- Hidden Fields -->
                                            <!-- Hidden Species ID -->
                                            <input type="hidden" name="species_id" value="{{ $selectedSpecies->id }}">

                                            <!-- Hidden Organisation ID -->
                                            <input type="hidden" name="organisation_id" value="{{ $organisation->id }}">

                                            <!-- Hunting Concession Dropdown -->
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label for="hunting_concession_id" class="form-label">Hunting
                                                        Concession</label>
                                                    <select class="form-control" id="hunting_concession_id"
                                                            name="hunting_concession_id" required>
                                                        <option value="">Select Hunting Concession</option>
                                                        @foreach($organisation->huntingConcessions as $concession)
                                                            <option
                                                                value="{{ $concession->id }}">{{ $concession->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- Year Selection -->
                                                <div class="col-md-4">
                                                    <label for="year" class="form-label">Year</label>
                                                    <select class="form-control" id="year" name="year" required>
                                                        <option value="">Select Year</option>
                                                        @for ($year = now()->year; $year >= 2015; $year--)
                                                            <option value="{{ $year }}">{{ $year }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Quota Fields -->
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label for="initial_quota" class="form-label">Initial Quota</label>
                                                    <input type="number" class="form-control" id="initial_quota"
                                                           name="initial_quota" placeholder="Enter initial quota"
                                                           min="0">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="rdc_quota" class="form-label">RDC Quota</label>
                                                    <input type="number" class="form-control" id="rdc_quota"
                                                           name="rdc_quota" placeholder="Enter RDC quota" min="0">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="campfire_quota" class="form-label">Campfire
                                                        Quota</label>
                                                    <input type="number" class="form-control" id="campfire_quota"
                                                           name="campfire_quota" placeholder="Enter campfire quota"
                                                           min="0">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label for="zimpark_station_quota" class="form-label">Zimpark
                                                        Station Quota</label>
                                                    <input type="number" class="form-control" id="zimpark_station_quota"
                                                           name="zimpark_station_quota"
                                                           placeholder="Enter Zimpark station quota" min="0">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="national_park_quota" class="form-label">National Park
                                                        Quota</label>
                                                    <input type="number" class="form-control" id="national_park_quota"
                                                           name="national_park_quota"
                                                           placeholder="Enter national park quota" min="0">
                                                </div>
                                            </div>

                                            <!-- Submit Button -->
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <button type="submit" class="btn btn-primary">Submit Quota Request
                                                    </button>
                                                </div>
                                            </div>
                                        </form>


                                    </div>
                                </div>
                            </div>
                        </div>
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
