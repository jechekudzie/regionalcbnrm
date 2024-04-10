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
                        <h4 class="mb-sm-0" id="page-title">{{$organisation->name}} Hunting Activity - {{ str_pad($huntingActivity->id, 6, '0', STR_PAD_LEFT) }} </h4>
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

                                        <a href="{{route('organisation.hunting-activities.index',$organisation->slug)}}"
                                           class="btn btn-primary add-btn"><i
                                                class="fa fa-arrow-left"></i> Back to Hunting Activity
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
                                                                                            <h4 class="fw-bold">Activity #{{ str_pad($huntingActivity->id, 6, '0', STR_PAD_LEFT) }}</h4>
                                                                                            <div
                                                                                                class="hstack gap-3 flex-wrap">
                                                                                                <div class="vr"></div>
                                                                                                <div>Start Date : <span
                                                                                                        class="fw-medium">{{ $huntingActivity->start_date ? date('F m Y',strtotime($huntingActivity->start_date)) : 'N/A' }}</span>
                                                                                                </div>
                                                                                                <div class="vr"></div>
                                                                                                <div>Completion Date :
                                                                                                    <span
                                                                                                        class="fw-medium">{{ $huntingActivity->start_date ? date('F m Y',strtotime($huntingActivity->end_date)) : 'N/A' }}</span>
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
                                                                                   Hunting Clients
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
                                                                                    Hunting Vehicles
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
                                                                                        <button class="btn btn-primary btn-sm edit-hunting-activity"
                                                                                                data-bs-toggle="modal" data-bs-target="#showModal"
                                                                                                data-rdc_id="{{ $huntingActivity->huntingConcession->rdc_id }}"
                                                                                                data-hunting_concession_id="{{ $huntingActivity->hunting_concession_id }}"
                                                                                                data-hunting_license="{{ $huntingActivity->hunting_license }}"
                                                                                                data-transaction_reference="{{ $huntingActivity->transaction_reference }}"
                                                                                                data-start_date="{{ $huntingActivity->start_date }}"
                                                                                                data-end_date="{{ $huntingActivity->end_date }}"
                                                                                                data-action="{{ route('organisation.hunting-activities.update',[$organisation->slug, $huntingActivity->slug]) }}">
                                                                                            <i class="fa fa-pencil"></i> Edit Hunting Activity {{ str_pad($huntingActivity->id, 6, '0', STR_PAD_LEFT)}}
                                                                                        </button>
                                                                                    </div>
                                                                                    <div class="table-card">
                                                                                        <table class="table mb-0">
                                                                                            <tbody>
                                                                                            <tr>
                                                                                                <td class="fw-medium">
                                                                                                    Hunting Concession
                                                                                                </td>
                                                                                                <td>{{ $huntingActivity->huntingConcession->name }}</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td class="fw-medium">
                                                                                                    Safari Operator
                                                                                                </td>
                                                                                                <td>{{ $huntingActivity->organisation->name }}</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td class="fw-medium">
                                                                                                    Start Date
                                                                                                </td>
                                                                                                <td>{{ $huntingActivity->start_date ? date('F m Y', strtotime($huntingActivity->start_date)) : 'N/A' }}</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td class="fw-medium">
                                                                                                    End Date
                                                                                                </td>
                                                                                                <td>{{ $huntingActivity->end_date ? date('F m Y', strtotime($huntingActivity->end_date)) : 'N/A' }}</td>
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
                                                                                <a href="{{route('organisation.hunting-activities.add-hunter-client', [$organisation->slug, $huntingActivity->slug]) }}"
                                                                                   class="btn btn-primary add-btn"><i
                                                                                        class="fa fa-plus"></i>
                                                                                   Hunting Clients </a>
                                                                            </div>
                                                                            <div class="card mb-3">
                                                                                <div class="card-body">
                                                                                    <div class="table-responsive">
                                                                                        <table style="width: 100%;" id="buttons-datatables"
                                                                                               class="display table table-bordered dataTable no-footer"
                                                                                               aria-describedby="buttons-datatables_info">
                                                                                            <thead>
                                                                                            <tr>
                                                                                                <th>Name</th>
                                                                                                <th>Address</th>
                                                                                                <th>Email</th>
                                                                                                <th>Mobile Number</th>
                                                                                                <th>Country</th>
                                                                                                <th>Actions</th>
                                                                                            </tr>
                                                                                            </thead>
                                                                                            <tbody>
                                                                                            @foreach ($huntingActivity->hunters as $hunter)
                                                                                                <tr>
                                                                                                    <td>{{ $hunter->name }}</td>
                                                                                                    <td>{{ $hunter->address }}</td>
                                                                                                    <td>{{ $hunter->email }}</td>
                                                                                                    <td>{{ $hunter->mobile_number }}</td>
                                                                                                    <td>{{ $hunter->country->name ?? 'N/A' }}</td>
                                                                                                    <td>
                                                                                                        <!-- Add Button -->


                                                                                                        <!-- Delete Button -->
                                                                                                    </td>
                                                                                                </tr>
                                                                                            @endforeach
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
                                                                                <a href="{{ route('organisation.hunting-activities.species-details', [$organisation->slug, $huntingActivity->slug]) }}"
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
                                                                                                <th>Quota</th>
                                                                                                <th>Species Image</th>
                                                                                                <th>Species</th>
                                                                                                <th>Is Special?</th>
                                                                                                <th>Off-Take</th>
                                                                                                <th>RBZ Trastool Number</th>
                                                                                                <th>Action</th>
                                                                                                <!-- Add more columns as needed -->
                                                                                            </tr>
                                                                                            </thead>
                                                                                            <tbody>
                                                                                            @foreach ($huntingActivity->huntingDetails as $detail)
                                                                                                <tr>
                                                                                                    <td>{{ \App\Models\QuotaRequest::find($detail->quota_request_id)->year}}</td>
                                                                                                    <td>
                                                                                                        <div class="avatar-md bg-light rounded p-1"><img src="{{asset($detail->species->avatar)}}" alt="" class="img-fluid d-block"></div>
                                                                                                    </td>
                                                                                                    <td>{{ $detail->species->name }}</td>
                                                                                                    <td>
                                                                                                        @if($detail->species->is_special)
                                                                                                            <span class="badge bg-danger">Yes</span>
                                                                                                        @else
                                                                                                            <span class="badge bg-success">No</span>
                                                                                                        @endif
                                                                                                    </td>
                                                                                                    <td>{{ $detail->offtake}}</td>
                                                                                                    <td>{{ $detail->rbz_trastool_number}}</td>
                                                                                                    <td>
                                                                                                        <a href="{{route('organisation.hunting-detail-outcome.index',[$organisation->slug,$detail->slug])}}"
                                                                                                           class="btn btn-info btn-sm"><i class="fa fa-info"></i> Info</a>
                                                                                                        <a href="{{route('organisation.hunting-activities.delete-species-details',[$organisation->slug,$detail->id])}}"
                                                                                                           class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</a>
                                                                                                        <!-- Add more data fields as needed -->
                                                                                                </tr>
                                                                                            @endforeach
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
                                                                            <a href="{{ route('organisation.hunting-activities.add-hunting-vehicles', [$organisation->slug, $huntingActivity->slug]) }}"
                                                                               class="btn btn-primary add-btn"><i
                                                                                    class="fa fa-plus"></i>
                                                                                Hunting Vehicles </a>
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
                                                                                <th>Vehicle Type</th>
                                                                                <th>Registration Number</th>
                                                                                <th>Driver</th>
                                                                                <th>Actions</th>
                                                                            </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                            @forelse ($huntingActivity->huntingVehicles as $vehicle)
                                                                                <tr>
                                                                                    <td>{{ $vehicle->vehicle_type }}</td>
                                                                                    <td>{{ $vehicle->registration_number }}</td>
                                                                                    <td>{{ $vehicle->driver }}</td>
                                                                                    <td>
                                                                                        <!-- Actions like Edit or Delete -->
                                                                                        <a href="#" data-slug="{{$vehicle->slug}}" data-vehicle_type="{{$vehicle->vehicle_type}}"
                                                                                           data-registration_number="{{$vehicle->registration_number}}" data-driver="{{$vehicle->driver}}"
                                                                                           data-organisation_slug="{{$organisation->slug}}"
                                                                                           class="btn btn-primary btn-sm"
                                                                                           data-bs-toggle="modal"
                                                                                           data-bs-target="#updateModal"
                                                                                        > Edit
                                                                                        </a>

                                                                                        <form
                                                                                            action="{{ route('organisation.hunting-activities.delete-hunting-vehicles', [$organisation->slug,$vehicle->slug]) }}"
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
                                                                                    <td colspan="4">No vehicles added yet.</td>
                                                                                </tr>
                                                                            @endforelse
                                                                            </tbody>
                                                                        </table>
                                                                    </div>


                                                                </div>
                                                                <!-- end tab pane -->
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

                                                                                    <h4 class="card-title mb-0"> Hunter Activities</h4>
                                                                                </div>
                                                                                <div class="card-body">

                                                                                    <form method="post" id="huntingActivityForm" action="{{ route('organisation.hunting-activities.store', $organisation->slug) }}">
                                                                                        <input type="hidden" name="_method" value="POST">
                                                                                        @csrf
                                                                                        <!-- Hidden Organisation ID (Safari Operator) -->
                                                                                        <input type="hidden" name="organisation_id" value="{{ $organisation->id }}">

                                                                                        <div class="row">
                                                                                            <!-- RDC Dropdown -->
                                                                                            <div class="col-md-6 mb-3">
                                                                                                <label for="rdc_id" class="form-label">RDC</label>
                                                                                                <select class="form-control" id="rdc_id" name="rdc_id" required
                                                                                                        onchange="updateConcessionsDropdown()">
                                                                                                    <option value="">Select RDC</option>
                                                                                                    @foreach ($ruralDistrictCouncils as $rdc)
                                                                                                        <option value="{{ $rdc->id }}">{{ $rdc->name }}</option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>

                                                                                            <!-- Hunting Concession Dropdown -->
                                                                                            <div class="col-md-6 mb-3">
                                                                                                <label for="hunting_concession_id" class="form-label">Hunting
                                                                                                    Concession</label>
                                                                                                <select class="form-control" id="hunting_concession_id"
                                                                                                        name="hunting_concession_id" required>
                                                                                                    <option value="">Select Hunting Concession</option>
                                                                                                    {{-- Options will be dynamically populated based on RDC selection --}}
                                                                                                </select>
                                                                                            </div>

                                                                                            <!-- Hunting License Dropdown -->
                                                                                            <div class="col-md-6 mb-3">
                                                                                                <label for="hunting_license" class="form-label">PH Hunting
                                                                                                    License</label>
                                                                                                <input type="text" class="form-control" id="hunting_license"
                                                                                                       name="hunting_license" placeholder="Enter PH License">
                                                                                            </div>

                                                                                            <div class="col-md-6 mb-3">
                                                                                                <label for="transaction_reference" class="form-label">Payment Reference</label>
                                                                                                <input type="text" class="form-control" id="transaction_reference"
                                                                                                       name="transaction_reference" placeholder="Enter Payment Reference Number">
                                                                                            </div>

                                                                                            <!-- Start Date -->
                                                                                            <div class="col-md-3 mb-3">
                                                                                                <label for="start_date" class="form-label">Start Date</label>
                                                                                                <input type="date" class="form-control" id="start_date"
                                                                                                       name="start_date">
                                                                                            </div>

                                                                                            <!-- End Date -->
                                                                                            <div class="col-md-3 mb-3">
                                                                                                <label for="end_date" class="form-label">End Date</label>
                                                                                                <input type="date" class="form-control" id="end_date"
                                                                                                       name="end_date">
                                                                                            </div>
                                                                                        </div>

                                                                                        <!-- Submit Button -->
                                                                                        <button type="submit" class="btn btn-primary">Add Hunting Activity</button>
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
        $(document).ready(function() {
            $('.edit-hunting-activity').on('click', function() {
                // Extract data attributes from the button
                var rdcId = $(this).data('rdc_id');
                var concessionId = $(this).data('hunting_concession_id');
                var license = $(this).data('hunting_license');
                var transactionRef = $(this).data('transaction_reference');
                var startDate = $(this).data('start_date');
                var endDate = $(this).data('end_date');
                var actionUrl = $(this).data('action');

                // Prefill the form in the modal
                $('#showModal').find('#rdc_id').val(rdcId);
                $('#showModal').find('#hunting_concession_id').val(concessionId);
                $('#showModal').find('#hunting_license').val(license);
                $('#showModal').find('#transaction_reference').val(transactionRef);
                $('#showModal').find('#start_date').val(startDate);
                $('#showModal').find('#end_date').val(endDate);

                // Update form action
                $('#huntingActivityForm').attr('action', actionUrl);

                //update method to patch
                $('#huntingActivityForm').find('input[name="_method"]').val('PATCH');
            });
        });

    </script>

@endpush
