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
                        <h4 class="mb-sm-0">{{$organisation->name}} {{$incident->title}} - Conflict </h4>

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
                                       href="{{route('organisation.incidents.index',[$organisation->slug])}}"><i
                                            class="fa fa-arrow-left"></i> Back To Incidents
                                    </a>
                                    <button class="btn btn-success add-btn" data-bs-toggle="modal"
                                            data-bs-target="#showModal"><i
                                            class="fa fa-plus"></i> Add Incident Outcomes
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
                <div class="col-xxl-9">
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
                            <h2>{{$incident->title}} - Outcomes</h2>
                            <table style="width: 100%;" id="buttons-datatables"
                                   class="display table table-bordered dataTable no-footer"
                                   aria-describedby="buttons-datatables_info">
                                <thead>
                                <tr>
                                    <th>Conflict Outcome</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($incidentOutcomes as $incidentOutcome)
                                    <tr>
                                        <td>{{ $incidentOutcome->name }}</td>
                                        <td>
                                            <!-- Actions like Edit or Delete -->
                                            <form
                                                action="{{ route('organisation.incident-outcomes.destroy', [$organisation->slug,$incident->slug,$incidentOutcome->id]) }}"
                                                method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Are you sure?')">Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">No outcomes added yet.</td>
                                    </tr>
                                @endforelse
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

                                        <h4 class="card-title mb-0"> {{$incident->title}} Conflict</h4>
                                    </div>
                                    <div class="card-body">

                                        <form action="{{ route('organisation.incident-outcomes.store',[$organisation->slug, $incident->slug])}}"
                                              method="POST">
                                            @csrf

                                            <!-- Hidden Input for Incident ID (if not included in the route) -->
                                            {{-- <input type="hidden" name="incident_id" value="{{ $incident->id }}"> --}}

                                            <!-- Conflict Selection Field -->
                                            <!-- Conflict Selection Field -->
                                            <div class="mb-3">
                                                <label class="form-label">Conflict Involved</label>
                                                <div class="row">
                                                    @foreach ($conflictOutcomes as $conflictOutcomes)
                                                        <div class="col-md-3 col-lg-3 mb-3">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                       value="{{ $conflictOutcomes->id }}"
                                                                       id="conflict_outcomes{{ $conflictOutcomes->id }}" name="conflict_outcomes[]">
                                                                <label class="form-check-label"
                                                                       for="conflict_outcomes{{ $conflictOutcomes->id }}">
                                                                    {{ $conflictOutcomes->name }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>


                                            <!-- Submit Button -->
                                            <button type="submit" class="btn btn-primary">Add Conflict to Incident
                                            </button>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel"
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

                                        <h4 class="card-title mb-0"> Update Hunter Vehicles</h4>
                                    </div>
                                    <div class="card-body">

                                        <form id="mainForm" method="post" action="">
                                            @method('PATCH')
                                            @csrf
                                            <!-- Hidden Hunting Activity ID -->

                                            <!-- Vehicle Type -->
                                            <div class="mb-3">
                                                <label for="vehicle_type" class="form-label">Vehicle Type</label>
                                                <input type="text" class="form-control" id="vehicle_type"
                                                       name="vehicle_type" placeholder="Enter vehicle type">
                                            </div>

                                            <!-- Registration Number -->
                                            <div class="mb-3">
                                                <label for="registration_number" class="form-label">Registration
                                                    Number</label>
                                                <input type="text" class="form-control" id="registration_number"
                                                       name="registration_number"
                                                       placeholder="Enter registration number">
                                            </div>

                                            <!-- Driver -->
                                            <div class="mb-3">
                                                <label for="driver" class="form-label">Driver</label>
                                                <input type="text" class="form-control" id="driver" name="driver"
                                                       placeholder="Enter driver's name">
                                            </div>

                                            <!-- Submit Button -->
                                            <button type="submit" class="btn btn-primary">Update Vehicle</button>
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
                $(document).ready(function () {
                    $('#updateModal').on('show.bs.modal', function (event) {
                        var button = $(event.relatedTarget); // Button that triggered the modal
                        var vehicle_type = button.data('vehicle_type'); // Extract info from data-* attributes
                        var registration_number = button.data('registration_number'); // Extract info from data-* attributes
                        var driver = button.data('driver');
                        var organisation = button.data('organisation_slug');
                        var HuntingActivityVehicle = button.data('slug');

                        //mainForm update action url

                        $('#mainForm').attr('action', '/' + organisation + '/hunting-activities/' + HuntingActivityVehicle + '/update-hunting-vehicles');

                        // Update the modal's content.
                        var modal = $(this);
                        modal.find('#vehicle_type').val(vehicle_type);
                        modal.find('#registration_number').val(registration_number);
                        modal.find('#driver').val(driver);

                    });
                });


            </script>

    @endpush
