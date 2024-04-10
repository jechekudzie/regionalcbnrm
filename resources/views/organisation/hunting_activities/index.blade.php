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
                            <h2>{{$organisation->name}} - Hunting Activities</h2>
                            <br/>
                            <table style="width: 100%;" id="buttons-datatables"
                                   class="display table table-bordered dataTable no-footer"
                                   aria-describedby="buttons-datatables_info">
                                <thead>
                                <tr>
                                    <th>Activity ID</th>
                                    <th>Year</th>
                                    <th>Hunting Concession</th>
                                    <th>Safari Operator</th>
                                    <th>Safari License</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Hunting Clients</th>
                                    <th>Hunting Vehicles</th>
                                    <th>Species Details</th>
                                    <th>Payment Reference</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($huntingActivities as $activity)
                                    <tr>
                                        <td>{{ str_pad($activity->id, 6, '0', STR_PAD_LEFT) }}</td>
                                        <td>{{ $year = date('Y', strtotime($activity->start_date))}}</td>
                                        <td>{{ $activity->huntingConcession->name }}</td>
                                        <td>{{ $activity->organisation->name }}</td>
                                        <td>{{$activity->hunting_license}}</td>
                                        <td>{{ $activity->start_date }}</td>
                                        <td>{{ $activity->end_date }}</td>
                                        <td>
                                            <a href="{{ route('organisation.hunting-activities.add-hunter-client', [$organisation->slug, $activity->slug]) }}">
                                                 Clients ({{ $activity->hunters->count() ?? '0' }})
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('organisation.hunting-activities.add-hunting-vehicles', [$organisation->slug, $activity->slug]) }}">
                                                Vehicles ({{ $activity->huntingVehicles->count() ?? '0' }})
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('organisation.hunting-activities.species-details', [$organisation->slug, $activity->slug]) }}">
                                                Species Details ({{ $activity->huntingDetails->count() ?? '0' }})
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{route('organisation.transaction-payables.index',[$organisation->slug,$activity->transaction->id])}}"
                                               target="_blank">
                                                {{ $activity->transaction_reference }}
                                            </a>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-sm edit-hunting-activity"
                                                    data-bs-toggle="modal" data-bs-target="#showModal"
                                                    data-rdc_id="{{ $activity->huntingConcession->rdc_id }}"
                                                    data-hunting_concession_id="{{ $activity->hunting_concession_id }}"
                                                    data-hunting_license="{{ $activity->hunting_license }}"
                                                    data-transaction_reference="{{ $activity->transaction_reference }}"
                                                    data-start_date="{{ $activity->start_date }}"
                                                    data-end_date="{{ $activity->end_date }}"
                                                    data-action="{{ route('organisation.hunting-activities.update',[$organisation->slug, $activity->slug]) }}">
                                                <i class="fa fa-pencil"></i>
                                            </button>

                                            <a href="{{ route('organisation.hunting-activities.show', [$organisation->slug, $activity->slug]) }}"
                                               class="btn btn-primary btn-sm">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <!-- Consider adding Edit/Delete buttons here -->
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
