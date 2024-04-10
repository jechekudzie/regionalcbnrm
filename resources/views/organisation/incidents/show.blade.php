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
                        <h4 class="mb-sm-0" id="page-title">{{$organisation->name}} Hunting Activity - {{ str_pad($incident->id, 6, '0', STR_PAD_LEFT) }} </h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">CRM</a></li>
                                <li class="breadcrumb-item active">{{$organisation->name}} Hunting Activity - </li>
                            </ol>
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

                                        <a href="{{route('organisation.incidents.index',$organisation->slug)}}"
                                           class="btn btn-primary add-btn"><i
                                                class="fa fa-arrow-left"></i> Back to HWC Incidents
                                        </a>
                                        <br/>
                                        <br/>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end col-->
                    <div class="col-xxl-12">
                        <div class="card">
                            <div class="card-body">
                                <!--start table-->
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
                                <div class="row">
                                    <div class="col-lg-12">

                                        <div class="col-xxl-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <!-- Nav tabs -->
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="card mt-n4 mx-n4">
                                                                <div class="bg-soft-warning">
                                                                    <div class="card-body pb-0 px-4">
                                                                        <div class="row mb-3">
                                                                            <div class="col-md">
                                                                                <div class="row align-items-center g-3">
                                                                                    <div class="col-md-auto">
                                                                                        <div class="avatar-md">
                                                                                            <div
                                                                                                class="avatar-title bg-white rounded-circle">
                                                                                                {{--<img src="assets/images/brands/slack.png" alt="" class="avatar-xs">--}}
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md">
                                                                                        <div>
                                                                                            <h4 class="fw-bold">HWC Incident #{{ str_pad($incident->id, 6, '0', STR_PAD_LEFT) }}</h4>
                                                                                            <div
                                                                                                class="hstack gap-3 flex-wrap">
                                                                                                <div class="vr"></div>
                                                                                                <div>Start Date : <span
                                                                                                        class="fw-medium">{{ $incident->date ? date('F m Y',strtotime($incident->date)) : 'N/A' }}</span>
                                                                                                </div>

                                                                                                <div class="vr"></div>
                                                                                                <div
                                                                                                    class="badge rounded-pill bg-info fs-12">
                                                                                                    New
                                                                                                </div>
                                                                                                <div
                                                                                                    class="badge rounded-pill bg-danger fs-12">
                                                                                                    High
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-auto">
                                                                                <div class="hstack gap-1 flex-wrap">
                                                                                    <button type="button"
                                                                                            class="btn py-0 fs-16 favourite-btn active">
                                                                                        <i class="ri-star-fill"></i>
                                                                                    </button>
                                                                                    <button type="button"
                                                                                            class="btn py-0 fs-16 text-body">
                                                                                        <i class="ri-share-line"></i>
                                                                                    </button>
                                                                                    <button type="button"
                                                                                            class="btn py-0 fs-16 text-body">
                                                                                        <i class="ri-flag-line"></i>
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <ul class="nav nav-tabs-custom border-bottom-0"
                                                                            role="tablist">
                                                                            <li class="nav-item">
                                                                                <a class="nav-link fw-semibold active"
                                                                                   data-bs-toggle="tab"
                                                                                   href="#project-overview" role="tab"
                                                                                   aria-selected="true">
                                                                                    Overview
                                                                                </a>
                                                                            </li>
                                                                            <li class="nav-item">
                                                                                <a class="nav-link fw-semibold"
                                                                                   data-bs-toggle="tab"
                                                                                   href="#project-documents" role="tab"
                                                                                   aria-selected="false">
                                                                                   Conflicts
                                                                                </a>
                                                                            </li>
                                                                            <li class="nav-item">
                                                                                <a class="nav-link fw-semibold"
                                                                                   data-bs-toggle="tab"
                                                                                   href="#project-activities" role="tab"
                                                                                   aria-selected="false">
                                                                                    Species
                                                                                </a>
                                                                            </li>
                                                                            <li class="nav-item">
                                                                                <a class="nav-link fw-semibold"
                                                                                   data-bs-toggle="tab"
                                                                                   href="#project-team" role="tab">
                                                                                    Incident Outcome
                                                                                </a>
                                                                            </li>

                                                                        </ul>
                                                                    </div>
                                                                    <!-- end card body -->
                                                                </div>
                                                            </div>
                                                            <!-- end card -->
                                                        </div>
                                                        <!-- end col -->
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="tab-content text-muted">
                                                                <div class="tab-pane fade active show"
                                                                     id="project-overview" role="tabpanel">
                                                                    <div class="row">
                                                                        <div class="col-xl-9 col-lg-8">
                                                                            <div class="card mb-3">
                                                                                <div class="card-body">
                                                                                    <div class="mb-4">
                                                                                        <a href="#" data-slug="{{$incident->slug}}"
                                                                                           data-title="{{$incident->title}}"
                                                                                           data-latitude="{{$incident->latitude}}"
                                                                                           data-longitude="{{$incident->longitude}}"
                                                                                           data-year="{{$incident->year}}" data-date="{{$incident->date}}"
                                                                                           data-time="{{$incident->time}}"
                                                                                           data-description="{{$incident->description}}"
                                                                                           data-location="{{$incident->location}}"
                                                                                           data-organisation_slug="{{$organisation->slug}}"
                                                                                           class="btn btn-success btn-sm"
                                                                                           data-bs-toggle="modal"
                                                                                           data-bs-target="#updateModal"
                                                                                        >  <i class="fa fa-pencil"></i> Edit
                                                                                        </a>


                                                                                    </div>
                                                                                    <div class="table-card">
                                                                                        <table class="table mb-0">
                                                                                            <tbody>
                                                                                            <tr>
                                                                                                <td class="fw-medium">
                                                                                                    Incident Title
                                                                                                </td>
                                                                                                <td>{{ $incident->title }}</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td class="fw-medium">
                                                                                                   Year
                                                                                                </td>
                                                                                                <td>{{ $incident->year }}</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td class="fw-medium">
                                                                                                     Date
                                                                                                </td>
                                                                                                <td>{{ $incident->date ? date('F m Y', strtotime($incident->date)) : 'N/A' }}</td>
                                                                                            </tr>
                                                                                            <!-- Add more rows as needed for other project details -->
                                                                                            </tbody>
                                                                                        </table>
                                                                                        <!--end table-->
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </div>

                                                                    </div>
                                                                    <!-- end row -->
                                                                </div>
                                                                <!-- end tab pane -->
                                                                <div class="tab-pane fade" id="project-documents"
                                                                     role="tabpanel">
                                                                    <div class="card">
                                                                        <div class="card-body">
                                                                            <div class="d-flex align-items-center mb-4">
                                                                                <a href="{{route('organisation.incident-conflict-types.index',[$organisation->slug,$incident->slug])}}"
                                                                                   class="btn btn-primary add-btn"><i
                                                                                        class="fa fa-plus"></i>
                                                                                    Conflicts </a>
                                                                            </div>
                                                                            <div class="card mb-3">
                                                                                <div class="card-body">
                                                                                    <div class="table-responsive">
                                                                                        <table style="width: 100%;" id="buttons-datatables"
                                                                                               class="display table table-bordered dataTable no-footer"
                                                                                               aria-describedby="buttons-datatables_info">
                                                                                            <thead>
                                                                                            <tr>
                                                                                                <th>Conflict Type</th>
                                                                                                <th>Actions</th>
                                                                                            </tr>
                                                                                            </thead>
                                                                                            <tbody>
                                                                                            @forelse ($incidentConflictTypes as $incidentConflictType)
                                                                                                <tr>
                                                                                                    <td>{{ $incidentConflictType->name }}</td>
                                                                                                    <td>
                                                                                                        <!-- Actions like Edit or Delete -->
                                                                                                        <form
                                                                                                            action="{{ route('organisation.incident-conflict-types.destroy', [$organisation->slug,$incident->slug,$incidentConflictType->id]) }}"
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
                                                                                                    <td colspan="4">No conflicts added yet.</td>
                                                                                                </tr>
                                                                                            @endforelse
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- end tab pane -->
                                                                <div class="tab-pane fade" id="project-activities"
                                                                     role="tabpanel">
                                                                    <div class="card">
                                                                        <div class="card-body">
                                                                            <div class="card col-md-3">
                                                                                <a href="{{route('organisation.incident-species.index',[$organisation->slug,$incident->slug])}}"
                                                                                   class="btn btn-primary add-btn"><i
                                                                                        class="fa fa-plus"></i>
                                                                                    Species </a>
                                                                                <br/>
                                                                            </div>
                                                                            <div class="card mb-3">

                                                                                <div class="card-body">
                                                                                    <div class="table-responsive">
                                                                                        <table style="width: 100%;" id="buttons-datatables"
                                                                                               class="display table table-bordered dataTable no-footer"
                                                                                               aria-describedby="buttons-datatables_info">
                                                                                            <thead>
                                                                                            <tr>
                                                                                                <th>Image</th>
                                                                                                <th>Species</th>
                                                                                                <th>Males</th>
                                                                                                <th>Females</th>
                                                                                                <th>Actions</th>
                                                                                            </tr>
                                                                                            </thead>
                                                                                            <tbody>
                                                                                            @forelse ($incidentSpecies as $incidentSpecie)
                                                                                                <tr>
                                                                                                    <td>
                                                                                                        <div class="avatar-md bg-light rounded p-1"><img
                                                                                                                src="{{asset($incidentSpecie->avatar)}}" alt=""
                                                                                                                class="img-fluid d-block"></div>
                                                                                                    </td>
                                                                                                    <td>{{ $incidentSpecie->name }}</td>
                                                                                                    <td>{{ $incidentSpecie->pivot->male_count }}</td>
                                                                                                    <td>{{ $incidentSpecie->pivot->female_count }}</td>
                                                                                                    <td>
                                                                                                        <!-- Actions like Edit or Delete -->
                                                                                                        <form
                                                                                                            action="{{ route('organisation.incident-species.destroy', [$organisation->slug,$incident->slug,$incidentSpecie->id]) }}"
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
                                                                                                    <td colspan="4">No species added yet.</td>
                                                                                                </tr>
                                                                                            @endforelse
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                        <!--end card-body-->
                                                                    </div>
                                                                    <!--end card-->
                                                                </div>
                                                                <!-- end tab pane -->
                                                                <div class="tab-pane fade" id="project-team"
                                                                     role="tabpanel">
                                                                    <div class="row">
                                                                        <div class="card col-md-3">
                                                                            <a href="{{route('organisation.incident-outcomes.index',[$organisation->slug,$incident->slug])}}"
                                                                               class="btn btn-primary add-btn"><i
                                                                                    class="fa fa-plus"></i>
                                                                                Incident Outcomes </a>
                                                                            <br/>
                                                                            <br/>
                                                                        </div>


                                                                    </div>
                                                                    <div class="row">
                                                                        <table style="width: 100%;" id="buttons-datatables"
                                                                               class="display table table-bordered dataTable no-footer"
                                                                               aria-describedby="buttons-datatables_info">
                                                                            <thead>
                                                                            <tr>
                                                                                <th>Incident</th>
                                                                                <th>Conflict Outcome</th>
                                                                                <th>Record Incident Information</th>
                                                                                <th>Actions</th>
                                                                            </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                            @forelse ($incidentOutcomes as $incidentOutcome)
                                                                                <tr>
                                                                                    <td>{{ $incidentOutcome->id }}</td>
                                                                                    <td>{{ $incidentOutcome->name }}</td>
                                                                                    <td>
                                                                                        <a href="{{route('organisation.incident-outcomes-dynamic-fields.index',[$organisation->slug,$incident->slug,$incidentOutcome->id])}}">Record data</a>
                                                                                    </td>
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


                                                                </div>
                                                                <!-- end tab pane -->
                                                                <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                                                     aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                                        <div class="modal-content border-0">
                                                                            <div class="modal-header bg-soft-info p-3">
                                                                                <h5 class="modal-title" id="exampleModalLabel"> Update an HWC incident</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                                        aria-label="Close" id="close-modal"></button>
                                                                            </div>

                                                                            <div class="card border">
                                                                                <div class="card-header">

                                                                                    <h4 class="card-title mb-0"> Update an HWC incident </h4>
                                                                                </div>
                                                                                <div class="card-body">

                                                                                    <form id="mainForm" method="POST">
                                                                                        @csrf <!-- CSRF token for Laravel form submission -->
                                                                                        @method('PATCH')
                                                                                        {{--<input type="hidden" name="_method" value="POST">--}}
                                                                                        <div class="row">
                                                                                            <!-- Title Field -->
                                                                                            <div class="col-md-4 mb-3">
                                                                                                <label for="title" class="form-label">Title</label>
                                                                                                <input type="text" class="form-control" id="title" name="title" required>
                                                                                            </div>


                                                                                            <!-- Latitude Field -->
                                                                                            <div class="col-md-4 mb-3">
                                                                                                <label for="latitude" class="form-label">Latitude</label>
                                                                                                <input type="text" class="form-control" id="latitude" name="latitude">
                                                                                            </div>

                                                                                            <!-- Longitude Field -->
                                                                                            <div class="col-md-4 mb-3">
                                                                                                <label for="longitude" class="form-label">Longitude</label>
                                                                                                <input type="text" class="form-control" id="longitude" name="longitude">
                                                                                            </div>

                                                                                        </div>

                                                                                        <div class="row">
                                                                                            <!-- Year -->
                                                                                            <div class="col-md-4 mb-3">
                                                                                                <label for="year" class="form-label">Year</label>
                                                                                                <select class="form-select" id="year" name="year">
                                                                                                    <option value="">Select Year</option>
                                                                                                    @for ($year = now()->year; $year >= 2015; $year--)
                                                                                                        <option value="{{ $year }}">{{ $year }}</option>
                                                                                                    @endfor
                                                                                                </select>
                                                                                            </div>

                                                                                            <!-- Date Field -->
                                                                                            <div class="col-md-4 mb-3">
                                                                                                <label for="date" class="form-label">Date</label>
                                                                                                <input type="date" class="form-control" id="date" name="date">
                                                                                            </div>

                                                                                            <!-- Time Field -->
                                                                                            <div class="col-md-4 mb-3">
                                                                                                <label for="time" class="form-label">Time</label>
                                                                                                <input type="time" class="form-control" id="time" name="time">
                                                                                            </div>

                                                                                            <!-- Location Field -->
                                                                                            <div class="col-md-12 mb-3">
                                                                                                <label for="time" class="form-label">Location</label>
                                                                                                <input type="text" class="form-control" id="location" name="location">
                                                                                            </div>

                                                                                            <!-- Description Field -->
                                                                                            <div class="col-md-12 mb-3">
                                                                                                <label for="description" class="form-label">Description</label>
                                                                                                <textarea class="form-control" id="description" name="description"
                                                                                                          rows="3"></textarea>
                                                                                            </div>
                                                                                        </div>

                                                                                        <!-- Submit Button -->
                                                                                        <div class="row">
                                                                                            <div class="col-12">
                                                                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </form>


                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                            </div>
                                                        </div>
                                                        <!-- end col -->
                                                    </div>
                                                </div><!-- end card-body -->
                                            </div><!-- end card -->
                                        </div>

                                    </div>
                                    <!-- end col -->

                                    {{-- Include other sections like project thumbnail, attached files, privacy settings, tags, and members as per your project requirements --}}

                                </div>

                                <!--end table-->

                            </div>
                        </div>
                    </div>
                    <!--end col-->

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

        function updateConcessionsDropdown() {
            const ruralDistrictCouncilId = document.getElementById('rdc_id').value;
            const concessionsDropdown = document.getElementById('hunting_concession_id');

            // Clear existing options
            concessionsDropdown.innerHTML = '<option value="">Select Hunting Concession</option>';

            // Fetch concessions based on selected RDC (you might need to adjust the URL structure)
            fetch(`/api/get-concessions-by-rdc/${ruralDistrictCouncilId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(concession => {
                        const option = new Option(concession.name, concession.id);
                        concessionsDropdown.add(option);
                    });
                })
                .catch(error => console.error('Error fetching concessions:', error));
        }


        // Assuming you have jQuery available
        $(document).ready(function () {
            $('#updateModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal

                // Extract info from data-* attributes
                var slug = button.data('slug');
                var title = button.data('title');
                var latitude = button.data('latitude');
                var longitude = button.data('longitude');
                var year = button.data('year');
                var date = button.data('date');
                var time = button.data('time');
                var location = button.data('location');
                var description = button.data('description');
                var organisationSlug = button.data('organisation_slug');

                // Assuming you have form fields with IDs corresponding to these data attributes
                // Update the modal's content with the data attributes
                var modal = $(this);
                modal.find('#title').val(title);
                modal.find('#latitude').val(latitude);
                modal.find('#longitude').val(longitude);
                modal.find('#year').val(year);
                modal.find('#date').val(date);
                modal.find('#time').val(time);
                modal.find('#location').val(location);
                modal.find('#description').val(description);

                // Update form action URL
                $('#mainForm').attr('action', '/' + organisationSlug + '/incidents/' + slug + '/update');

            });
        });

    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const latitudeInput = document.getElementById('latitude');
            const longitudeInput = document.getElementById('longitude');
            const addressDiv = document.getElementById('address');
            let map = null;
            let updateTimeout = null;

            longitudeInput.disabled = latitudeInput.value.trim() === '';

            // Function to update map and address
            function updateMapAndAddress(latitude, longitude) {
                // JavaScript call to your API backend
                fetch(`/api/get-location?lat=${latitude}&lon=${longitude}`)
                    .then(response => response.json())
                    .then(data => {
                        // Display address
                        addressDiv.textContent = data.address;

                        // Initialize or update map
                        if (!map) {
                            map = L.map('map').setView([data.lat, data.lon], 13);
                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                attribution: '© OpenStreetMap contributors'
                            }).addTo(map);
                        } else {
                            map.setView([data.lat, data.lon], 13);
                        }

                        L.marker([data.lat, data.lon]).addTo(map)
                            .bindPopup(data.address)
                            .openPopup();
                    });
            }

            // Enable longitude field when latitude is filled
            latitudeInput.addEventListener('input', function () {
                longitudeInput.disabled = latitudeInput.value.trim() === '';
            });

            // Update map and address on longitude input
            longitudeInput.addEventListener('input', function () {
                const latitude = latitudeInput.value.trim();
                const longitude = longitudeInput.value.trim();

                // Clear previous timeout to ensure this function runs after user has stopped typing
                clearTimeout(updateTimeout);

                // Set a timeout to update the map after the user has stopped typing for 1 second
                updateTimeout = setTimeout(() => {
                    if (latitude !== '' && longitude !== '') {
                        updateMapAndAddress(latitude, longitude);
                    }
                }, 1000); // Adjust timeout as needed
            });
        });

    </script>

@endpush
