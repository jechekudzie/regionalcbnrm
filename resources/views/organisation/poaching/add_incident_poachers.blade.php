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
                        <h4 class="mb-sm-0">{{$organisation->name}} {{$poachingIncident->title}} - Poachers </h4>

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
                                       href="{{route('organisation.poaching-incidents.index',[$organisation->slug])}}"><i
                                            class="fa fa-arrow-left"></i> Back To Incidents
                                    </a>
                                    <button class="btn btn-success add-btn" data-bs-toggle="modal"
                                            data-bs-target="#showModal"><i
                                            class="fa fa-plus"></i> Add Poacher
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

                            <h2>{{$poachingIncident->title}} - Poachers </h2>
                                <table style="width: 100%;" id="buttons-datatables"
                                       class="display table table-bordered dataTable no-footer"
                                       aria-describedby="buttons-datatables_info">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Full Name</th>
                                        <th scope="col">Age</th>
                                        <th scope="col">Identification</th>
                                        <th scope="col">Gender</th>
                                        <th scope="col">Offence</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Reason</th>
                                        <th scope="col">Docket</th>
                                        <th scope="col">Country</th>
                                        <th scope="col">Province</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($poachingIncident->poachers as $poacher)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $poacher->full_name }}</td>
                                            <td>{{ $poacher->age }}</td>
                                            <td>{{ $poacher->identification }}</td>
                                            <td>{{ $poacher->gender->name ?? 'N/A' }}</td>
                                            <td>{{ $poacher->offenceType->name ?? 'N/A' }}</td>
                                            <td>{{ $poacher->poacherType->name ?? 'N/A' }}</td>
                                            <td>{{ $poacher->poachingReason->name ?? 'N/A' }}</td>
                                            <td>{{ $poacher->docket_number ?? 'N/A' }}</td>
                                            <td>{{ $poacher->country->name ?? 'N/A' }}</td>
                                            <td>{{ $poacher->province->name ?? 'N/A' }}</td>
                                            <td>
                                                <!-- Example Action Buttons -->
                                                <a href="{{ route('organisation.poaching-incident-poacher.index', [$organisation->slug,$poachingIncident->slug]) }}" class="btn btn-sm btn-primary">Edit</a>
                                                <form action="{{ route('organisation.poaching-incident-poacher.destroy', [$organisation->slug,$poacher->slug]) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7">No poachers found.</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>

                        </div>
                        <!--end card-->
                    </div>

                    <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-xl">
                            <div class="modal-content border-0">
                                <div class="modal-header bg-soft-info p-3">
                                    <h5 class="modal-title" id="exampleModalLabel">{{$poachingIncident->title}} - Poached Species</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                                </div>
                                <div class="card border">
                                    <div class="card-body">

                                        <form method="post" action="{{route('organisation.poaching-incident-poacher.store',[$organisation->slug,$poachingIncident->slug])}}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="container">
                                                <div class="row">

                                                    <!-- Column 1: Incident and Poacher Details -->
                                                    <div class="col-md-6">
                                                        <h3>Incident & Poacher Details</h3>
                                                        <div class="mb-3">
                                                            <label for="fullName" class="form-label">Full Name</label>
                                                            <input type="text" class="form-control" name="full_name" id="full_name" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="age" class="form-label">Age</label>
                                                            <input type="number" class="form-control" name="age" id="age">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="genderId" class="form-label">Gender</label>
                                                            <select class="form-select" id="gender_id" name="gender_id">
                                                                <option value="">Select Gender</option>
                                                                @foreach(\App\Models\Gender::all() as $gender)
                                                                    <option value="{{ $gender->id }}">{{ $gender->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="poacherTypeId" class="form-label">Poacher Type</label>
                                                            <select class="form-select" name="poacher_type_id" id="poacher_type_id">
                                                                <option value="">Select Poacher Type</option>
                                                                @foreach(\App\Models\PoacherType::all() as $poacherType)
                                                                    <option value="{{ $poacherType->id }}">{{ $poacherType->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="offenceTypeId" class="form-label">Offence Type</label>
                                                            <select class="form-select" name="offence_type_id" id="offence_type_id">
                                                                <option value="">Select Offence Type</option>
                                                                @foreach(\App\Models\OffenceType::all() as $offenceType)
                                                                    <option value="{{ $offenceType->id }}">{{ $offenceType->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="poachingReasonId" class="form-label">Poaching Reason</label>
                                                            <select class="form-select" name="poaching_reason_id" id="poaching_reason_id">
                                                                <option value="">Select Poaching Reason</option>
                                                                @foreach(\App\Models\PoachingReason::all() as $poachingReason)
                                                                    <option value="{{ $poachingReason->id }}">{{ $poachingReason->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <!-- Column 2: Identification and Origin -->
                                                    <div class="col-md-6">
                                                        <h3>Identification & Origin</h3>
                                                        <div class="mb-3">
                                                            <label for="identificationTypeId" class="form-label">Identification Type</label>
                                                            <select class="form-select" name="identification_type_id" id="identification_type_id">
                                                                <option value="">Select Identification Type</option>
                                                                @foreach(\App\Models\IdentificationType::all() as $identificationType)
                                                                    <option value="{{ $identificationType->id }}">{{ $identificationType->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="identification" class="form-label">Identification Number</label>
                                                            <input type="text" class="form-control" name="identification" id="identification">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="provinceId" class="form-label">Country of Origin</label>
                                                            <select class="form-select" name="country_id" id="country_id">
                                                                <option value="">Select Country of Origin</option>
                                                                <!-- Dynamically populate options here -->
                                                                @foreach(\App\Models\Country::all() as $country)
                                                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="provinceId" class="form-label">Province</label>
                                                            <select class="form-select" name="province_id" id="province_id">
                                                                <option value="">Select Province</option>
                                                                <!-- Dynamically populate options here -->
                                                                @foreach(\App\Models\Province::all() as $province)
                                                                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="docketNumber" class="form-label">Docket Number</label>
                                                            <input type="text" class="form-control" name="docket_number" id="docket_number">
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Submit Button -->
                                                <div class="mb-3 text-center">
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
