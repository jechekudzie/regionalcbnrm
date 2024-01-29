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
                        <h4 class="mb-sm-0">{{$huntingActivity->organisation->name}}({{$huntingActivity->huntingLicense->license_number}}) - Add Off-take Species</h4>

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
                                       href="{{route('organisation.hunting-activities.index',[$organisation->slug])}}"><i
                                            class="fa fa-arrow-left"></i> Back to hunting activities
                                    </a>
                                    <button class="btn btn-success add-btn" data-bs-toggle="modal"
                                            data-bs-target="#showModal"><i
                                            class="fa fa-plus"></i> Add Species To be Hunted
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


                            <h2 style="margin: 10px;">Species off-take
                                - {{$huntingActivity->huntingConcession->name}} Concession</h2>
                            <br/>

                            <table style="width: 100%;" id="buttons-datatables"
                                   class="display table table-bordered dataTable no-footer"
                                   aria-describedby="buttons-datatables_info">
                                <thead>
                                <tr>
                                    <th>Quota</th>
                                    <th>Species Image</th>
                                    <th>Species</th>
                                    <th>Special Species</th>
                                    <th>Off-Take</th>
                                    <th>RBZ Trastool Number</th>
                                    <th>Trophy Size</th>
                                    <th>Trophy Quality</th>
                                    <th>Kill Location</th>
                                    <th>Action</th>
                                    <!-- Add more columns as needed -->
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($huntingActivity->huntingDetails as $detail)
                                    <tr>
                                        <td>{{ \App\Models\QuotaRequest::find($detail->quota_request_id)->year}} Quota</td>
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
                                        <td>{{ $detail->trophy_size }}</td>
                                        <td>{{ $detail->trophy_quality }}</td>
                                        <td>{{ $detail->location }}</td>
                                        <td>
                                            <a href="{{route('organisation.hunting-activities.edit-species-details',[$organisation->slug,$detail->id])}}"
                                               class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Update</a>
                                            <a href="{{route('organisation.hunting-activities.delete-species-details',[$organisation->slug,$detail->id])}}"
                                               class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</a>
                                        <!-- Add more data fields as needed -->
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>


                        </div>
                        <!--end card-->
                    </div>

                    <!-- Modal -->


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
                                        <h4 class="card-title mb-0"> Species Details</h4>
                                    </div>
                                    <div class="card-body">

                                        <form id="speciesForm" method="POST"
                                              action="{{route('organisation.hunting-activities.save-species-details',[$organisation->slug,$huntingActivity->slug])}}">
                                            @csrf
                                            <div class="row">
                                                <!-- Hunting Concession hidden field -->
                                                <input type="hidden" name="hunting_concession_id"
                                                       id="huntingConcessionId"
                                                       value="{{$huntingActivity->huntingConcession->id}}">

                                                <!-- Year -->
                                                <div class="col-md-6 mb-3">
                                                    <label for="year" class="form-label">Year</label>
                                                    <select class="form-select" id="year" name="year">
                                                        <option value="">Select Year</option>
                                                        @for ($year = now()->year; $year >= 2015; $year--)
                                                            <option value="{{ $year }}">{{ $year }}</option>
                                                        @endfor
                                                    </select>
                                                </div>

                                                <!-- Display Hunting Concession and Quota Request -->
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <p><strong>Hunting Concession:</strong> <span
                                                                id="huntingConcession"></span></p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p><strong>Quota Request:</strong> <span
                                                                id="quotaRequest"></span></p>
                                                    </div>
                                                </div>

                                                <!-- Species List -->
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                        <tr>
                                                            <th>Species Name</th>
                                                            <th>Initial Quota</th>
                                                            <th>RBZ Trastool Number</th>
                                                            <th>Offtake Number</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="speciesList">
                                                        <!-- Species rows will be added dynamically here -->
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <!-- Submit Button -->
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <button type="submit" class="btn btn-primary">Submit Quota
                                                            Request
                                                        </button>
                                                    </div>
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

                // Function to update species list based on selected year and hunting concession ID
                function updateSpeciesList(year, huntingConcessionId) {
                    // Send an AJAX request to fetch quota requests with species data
                    $.ajax({
                        url: '/api/fetch-quota-requests', // Route to fetch quota requests
                        method: 'GET',
                        data: {
                            year: year,
                            huntingConcessionId: huntingConcessionId
                        },
                        success: function (data) {
                            // Clear the species list
                            $('#speciesList').empty();

                            // Populate the species list with data
                            data.forEach(function (quotaRequest) {
                                var species = quotaRequest.species.name;
                                var initialQuota = quotaRequest.initial_quota;
                                var isSpecial = quotaRequest.species.is_special;

                                var row = `
                    <tr>
                        <td>${species}</td>
                        <td>${initialQuota}</td>
                        <td>
                            <input type="text" class="form-control" name="offtake[]" placeholder="Enter Offtake">
                            <input type="hidden" name="species_id[]" value="${quotaRequest.species.id}">
                            <input type="hidden" name="is_special[]" value="${isSpecial ? 1 : 0}">
                            <input type="hidden" name="quota_request_id[]" value="${quotaRequest.id}"
                        </td>
                        <td>
                        <td>

                          <input type="text" class="form-control" name="rbz_trastool_number[]" placeholder="Enter RBZ Trastool Number" ${isSpecial ? '' : 'disabled'}>
                        </td>
                    </tr>
                `;
                                $('#speciesList').append(row);
                            });
                        },
                        error: function () {
                            alert('Failed to fetch quota request data.');
                        }
                    });
                }


                // Event listener for year selection change
                $('#year').on('change', function () {
                    var selectedYear = $(this).val();
                    var huntingConcessionId = $('#huntingConcessionId').val();

                    if (selectedYear && huntingConcessionId) {
                        // Update species list based on selected year and hunting concession ID
                        updateSpeciesList(selectedYear, huntingConcessionId);
                    }
                });

                // Trigger the event when the page loads (if year and huntingConcessionId are preselected)
                $(document).ready(function () {
                    var preselectedYear = $('#year').val();
                    var preselectedHuntingConcessionId = $('#huntingConcessionId').val();

                    if (preselectedYear && preselectedHuntingConcessionId) {
                        updateSpeciesList(preselectedYear, preselectedHuntingConcessionId);
                    }
                });

                // Function to enable/disable rbz_trastool_number field based on isSpecial value
                function toggleRBZTrastoolNumber(isSpecial, rowIndex) {
                    var rbzTrastoolNumberInput = $(`input[name="rbz_trastool_number[${rowIndex}]"]`);

                    if (isSpecial) {
                        rbzTrastoolNumberInput.prop('disabled', false);
                        rbzTrastoolNumberInput.prop('required', true);
                    } else {
                        rbzTrastoolNumberInput.prop('disabled', true);
                        rbzTrastoolNumberInput.prop('required', false);
                        rbzTrastoolNumberInput.val(''); // Clear the value
                    }
                }

                // Event listener for is_special change
                $('input[name^="is_special"]').on('change', function () {
                    // Get the row index of the changed input
                    var rowIndex = $(this).data('row-index');
                    var isSpecial = $(this).prop('checked');

                    // Enable/disable rbz_trastool_number field for the corresponding row
                    toggleRBZTrastoolNumber(isSpecial, rowIndex);
                });


            </script>

    @endpush
