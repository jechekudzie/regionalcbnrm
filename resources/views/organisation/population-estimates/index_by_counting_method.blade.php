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
                        <h4 class="mb-sm-0">Companies</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">CRM</a></li>
                                <li class="breadcrumb-item active">Companies</li>
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
                                    <button class="btn btn-info add-btn" data-bs-toggle="modal"
                                            data-bs-target="#showModal"><i
                                            class="ri-add-fill me-1 align-bottom"></i> Add Service
                                    </button>
                                </div>
                                <div class="flex-shrink-0">
                                    <div class="hstack text-nowrap gap-2">
                                        <button type="button" id="dropdownMenuLink1" data-bs-toggle="dropdown"
                                                aria-expanded="false" class="btn btn-soft-info"><i
                                                class="ri-more-2-fill"></i></button>
                                        {{-- <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink1">
                                             <li><a class="dropdown-item" href="#">All</a></li>
                                             <li><a class="dropdown-item" href="#">Last Week</a></li>
                                             <li><a class="dropdown-item" href="#">Last Month</a></li>
                                             <li><a class="dropdown-item" href="#">Last Year</a></li>
                                         </ul>--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end col-->
                <div class="col-xxl-12">
                    <div class="card" id="companyList">
                        <div class="card-header">
                            <h2>Population Estimates Grouped by Counting Methods</h2>
                            <table style="width: 100%;" id="buttons-datatables"
                                   class="display table table-bordered dataTable no-footer"
                                   aria-describedby="buttons-datatables_info">
                                <thead>
                                <tr>
                                    <th>Year</th>
                                    <th>Image</th>
                                    <th>Species</th>
                                    <th>Counting Method</th>
                                    @foreach ($maturities as $maturity)
                                        @foreach ($genders as $gender)
                                            <th>{{ $maturity->name }} - {{ $gender->name }}</th>
                                        @endforeach
                                    @endforeach
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($distinctYears as $year)
                                    @foreach ($species as $specie)
                                        @php
                                            $methodsUsed = $specie->populationEstimates->where('year', $year)->unique('counting_method_id');
                                        @endphp
                                        @foreach ($methodsUsed as $estimate)
                                            <tr>
                                                <td>{{ $year }}</td>
                                                <td>
                                                    <div class="avatar-md bg-light rounded p-1"><img src="{{asset($specie->avatar)}}" alt="" class="img-fluid d-block"></div>
                                                </td>
                                                <td>{{ $specie->name }}</td>
                                                <td>{{ $estimate->countingMethod->name }}</td>
                                                @foreach ($maturities as $maturity)
                                                    @foreach ($genders as $gender)
                                                        @php
                                                            $maturityGenderEstimate = $specie->populationEstimates
                                                                ->where('year', $year)
                                                                ->where('counting_method_id', $estimate->counting_method_id)
                                                                ->where('maturity_id', $maturity->id)
                                                                ->where('species_gender_id', $gender->id)
                                                                ->sum('estimate');
                                                        @endphp
                                                        <td class="text-center">{{ $maturityGenderEstimate ?: 'N/A' }}</td>
                                                    @endforeach
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    @endforeach
                                @endforeach
                                </tbody>
                            </table>
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
        $(document).ready(function () {
            // Define the submit button
            var submitButton = $('#submit-button'); // Replace with your actual button ID or class
            submitButton.text('Add New');
            //on load by default name field to be empty
            $('#name').val('');
            var organisation_id = $('#organisation_id').val();

            // Click event for the edit button
            $('.edit-button').on('click', function () {
                var name = $(this).data('name');
                var email = $(this).data('email');
                var slug = $(this).data('slug');
                var roleId = $(this).data('role-id');

                // Set form action for update, method to PATCH, and button text to Update
                $('#edit-form').attr('action', '/admin/organisation-users/' + slug + '/update');
                $('input[name="_method"]').val('PATCH');
                submitButton.text('Update');
                // Populate the form for editing
                $('#name').val(name);
                $('#email').val(email);

                // Set the dropdown value to the role ID and mark it as selected
                $('#role_id').val(roleId).trigger('change');

                $('#card-title').text('Edit - ' + name);
                $('#page-title').text('Edit - ' + name);
            });

            // Click event for adding a new item
            $('#new-button').on('click', function () {
                // Clear the form, set action for creation, method to POST, and button text to Add New
                $('input[name="_method"]').val('POST');
                submitButton.text('Add New');
                $('#name').val('');
                $('#card-title').text('Add Organisation user');
                $('#page-title').text('Add New Organisation user');
            });
        });


    </script>

@endpush
