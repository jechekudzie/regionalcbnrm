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
                        <h4 class="mb-sm-0">{{$organisation->name}} - Hunting Activities</h4>

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

                                    <button class="btn btn-success add-btn" data-bs-toggle="modal"
                                            data-bs-target="#showModal"><i
                                            class="fa fa-plus"></i> Add Hunting Activity
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
                            <h2>{{$organisation->namae}} Hunting Activities</h2>
                                <table style="width: 100%;" id="buttons-datatables"
                                       class="display table table-bordered dataTable no-footer"
                                       aria-describedby="buttons-datatables_info">
                                    <thead>
                                    <tr>
                                        <th>Safari Operator</th>
                                        <th>Safari License</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Hunting Clients</th>
                                        <th>Hunting Vehicles</th>
                                        <th>Species Details</th>
                                        <th>Action</th>
                                        <!-- Add other columns as necessary -->
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($huntingActivities as $activity)
                                        <tr>
                                            <td>{{ $activity->organisation->name }}</td>
                                            <td>{{ $activity->huntingLicense->license_number }}</td>
                                            <td>{{ $activity->start_date }}</td>
                                            <td>{{ $activity->end_date }}</td>
                                            <td> <a href="{{route('organisation.hunting-activities.add-hunter-client',[$organisation->slug,$activity->slug])}}">Hunting Clients ({{ $activity->hunters()->count() }})</a> </td>
                                            <td>
                                                <a href="{{route('organisation.hunting-activities.add-hunting-vehicles',[$organisation->slug,$activity->slug])}}">
                                                    Hunting Vehicles ({{ $activity->vehicles()->count() }})
                                                </a>
                                            </td>
                                            <td>
                                                <a>
                                                    Species Details ({{ $activity->huntingDetails->count() }})
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{route('organisation.hunting-activities.show',[$organisation->slug,$activity->slug])}}">
                                                    <i class="fa fa-eye"></i> View Activity
                                                </a>
                                            </td>
                                            <!-- Add other data fields as necessary -->
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

                                        <h4 class="card-title mb-0"> Hunter Activities</h4>
                                    </div>
                                    <div class="card-body">

                                        <form method="post" action="{{ route('organisation.hunting-activities.store', $organisation->slug) }}">
                                            @csrf
                                            <!-- Hidden Organisation ID -->
                                            <input type="hidden" name="organisation_id" value="{{ $organisation->id }}">

                                            <div class="row">
                                                <!-- Hunting License Dropdown -->
                                                <div class="col-md-6 mb-3">
                                                    <label for="hunting_license_id" class="form-label">Safari Hunting License</label>
                                                    <select class="form-control" id="hunting_license_id" name="hunting_license_id" required>
                                                        <option value="">Select Hunting License</option>
                                                        @foreach ($huntingLicenses as $license)
                                                            <option value="{{ $license->id }}">{{ $license->license_number }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- Start Date -->
                                                <div class="col-md-3 mb-3">
                                                    <label for="start_date" class="form-label">Start Date</label>
                                                    <input type="date" class="form-control" id="start_date" name="start_date">
                                                </div>

                                                <!-- End Date -->
                                                <div class="col-md-3 mb-3">
                                                    <label for="end_date" class="form-label">End Date</label>
                                                    <input type="date" class="form-control" id="end_date" name="end_date">
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
