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
                        <h4 class="mb-sm-0">{{$huntingActivity->organisation->name}}
                             - add Clients -> Activity ({{str_pad($huntingActivity->id, 6, '0', STR_PAD_LEFT)}})</h4>

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
                                            class="fa fa-plus"></i> Add New Client
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

                            <div class="container">
                                <input type="text" id="hunterSearch" class="form-control mb-3"
                                       placeholder="Search by name or phone number">
                            </div>
                            <table id="searchTable" class="display table table-bordered dataTable no-footer"
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
                                <tbody id="huntersTableBody">
                                <!-- Hunters list will be rendered here -->
                                </tbody>
                            </table>


                            <h2 style="margin: 10px;">Current Clients</h2>
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

                                        <h4 class="card-title mb-0"> Client Details</h4>
                                    </div>
                                    <div class="card-body">

                                        <form method="post" action="{{ route('organisation.hunting-activities.save-new-hunter-client',[$organisation->slug,$huntingActivity->slug]) }}">
                                            @csrf
                                            <div class="row">
                                                <!-- Name -->
                                                <div class="col-md-6 mb-3">
                                                    <label for="name" class="form-label">Name</label>
                                                    <input type="text" class="form-control" id="name" name="name"
                                                           required>
                                                </div>

                                                <!-- Address -->
                                                <div class="col-md-6 mb-3">
                                                    <label for="address" class="form-label">Address</label>
                                                    <input type="text" class="form-control" id="address" name="address">
                                                </div>

                                                <!-- Email -->
                                                <div class="col-md-6 mb-3">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" class="form-control" id="email" name="email">
                                                </div>

                                                <!-- Mobile Number -->
                                                <div class="col-md-6 mb-3">
                                                    <label for="mobile_number" class="form-label">Mobile Number</label>
                                                    <input type="text" class="form-control" id="mobile_number"
                                                           name="mobile_number">
                                                </div>

                                                <!-- Country -->
                                                <div class="col-md-6 mb-3">
                                                    <label for="country_id" class="form-label">Country</label>
                                                    <select class="form-control" id="country_id" name="country_id">
                                                        <option value="">Select Country</option>
                                                        @foreach ($countries as $country)
                                                            <option
                                                                value="{{ $country->id }}">{{ $country->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Submit Button -->
                                            <button type="submit" class="btn btn-primary">Add Client</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="addHunterModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-md">
                            <div class="modal-content border-0">
                                <div class="modal-header bg-soft-info p-3">
                                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close" id="close-modal"></button>
                                </div>

                                <div class="card border">
                                    <div class="card-header">

                                        <h4 class="card-title mb-0"> Client Details</h4>
                                    </div>
                                    <div class="card-body">

                                        <form id="addHunterToActivityForm" method="post"
                                              action="{{route('organisation.hunting-activities.save-hunter-client',[$organisation->slug,$huntingActivity->slug])}}">
                                            @csrf

                                            <div class="modal-body">
                                                <h5 style="color: black;font-weight: bold;" id="hunterName"></h5>
                                                <input type="hidden" name="hunting_activity_id" value="{{ $huntingActivity->id }}">
                                                <input type="hidden" id="hunter_id" name="hunter_id">
                                                <div class="alert alert-success alert-dismissible fade show"
                                                     role="alert">
                                                    <strong>Message!</strong> Confirm you want to add this
                                                    client to the activity?
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                            aria-label="Close"></button>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">I confirm</button>
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

                $(document).ready(function () {
                    $('#searchTable').hide();

                    $('#hunterSearch').on('keyup', function () {
                        var value = $(this).val();

                        if (value.length === 0) {
                            // Clear the table if the search input is empty
                            $('#huntersTableBody').empty();
                        } else {
                            // Perform AJAX request to search for hunters
                            $.ajax({
                                url: '/api/hunters/search', // Update this URL to your search route
                                type: 'GET',
                                data: {'search': value},
                                success: function (data) {
                                    $('#searchTable').show();
                                    renderHuntersTable(data);

                                }
                            });
                        }
                    });

                    function renderHuntersTable(hunters) {
                        var tableBody = $('#huntersTableBody');
                        tableBody.empty();

                        hunters.forEach(function (hunter) {
                            tableBody.append(
                                `<tr>
                    <td>${hunter.name}</td>
                    <td>${hunter.address}</td>
                    <td>${hunter.email}</td>
                    <td>${hunter.mobile_number}</td>
                    <td>${hunter.country ? hunter.country.name : 'N/A'}</td>
                    <td>
                        <a href="#" data-bs-toggle="modal"
                           data-bs-target="#addHunterModal" data-name="${hunter.name}" data-id="${hunter.id}"
                           class="btn btn-primary btn-sm">
                            Add To Hunting Activity
                        </a>
                    </td>
                </tr>`
                            );
                        });
                    }
                });


                // Add Hunter to Activity Modal
                $(document).ready(function () {
                    $('#addHunterModal').on('show.bs.modal', function (event) {
                        var button = $(event.relatedTarget); // Button that triggered the modal
                        var hunterName = button.data('name'); // Extract info from data-* attributes
                        var hunterId = button.data('id');

                        // Update the modal's content.
                        var modal = $(this);
                        modal.find('.modal-body #hunterName').text('Add ' + hunterName);
                        modal.find('.modal-body #hunter_id').val(hunterId);
                    });
                });


            </script>

    @endpush
