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
                        <h4 class="mb-sm-0">{{$mySelectedSpecies->name}}</h4>

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

                                    <a class="btn btn-info add-btn" href="{{route('organisation.population-estimates.species',[$organisation->slug])}}"><i
                                            class="fa fa-arrow-left"></i> Back to species
                                    </a>
                                    <button class="btn btn-success add-btn" data-bs-toggle="modal"
                                            data-bs-target="#showModal"><i
                                            class="fa fa-plus"></i>  Record Population Estimate
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
                            <h3> {{ $selectedSpecies->name }} Population Estimates Grouped by Counting Methods</h3>

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
                                    @php
                                        $methodsUsed = $selectedSpecies->populationEstimates->where('year', $year)->unique('counting_method_id');
                                    @endphp
                                    @foreach ($methodsUsed as $estimate)
                                        <tr>
                                            <td>{{ $year }}</td>
                                            <td>
                                                <div class="avatar-md bg-light rounded p-1"><img src="{{asset($selectedSpecies->avatar)}}" alt="" class="img-fluid d-block"></div>
                                            </td>
                                            <td>{{ $selectedSpecies->name }}</td>
                                            <td>{{ $estimate->countingMethod->name }}</td>
                                            @foreach ($maturities as $maturity)
                                                @foreach ($genders as $gender)
                                                    @php
                                                        $maturityGenderEstimate = $selectedSpecies->populationEstimates
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

                                        <h6 class="card-title mb-0">{{$mySelectedSpecies->name}} Population Estimate</h6>
                                    </div>
                                    <div class="card-body">
                                        <form method="post" action="{{ route('organisation.population-estimates.store',$organisation->slug) }}">
                                            @csrf
                                            <!-- Hidden Species ID -->
                                            <input type="hidden" name="species_id" value="{{ $mySelectedSpecies->id }}">

                                            <div class="row">
                                                <!-- Select Year -->
                                                <div class="col-md-4 mb-3">
                                                    <label for="year" class="form-label">Year</label>
                                                    <select class="form-control" id="year" name="year" required>
                                                        <option value="">Select Year</option>
                                                        @for ($year = now()->year; $year >= 2015; $year--)
                                                            <option value="{{ $year }}">{{ $year }}</option>
                                                        @endfor
                                                    </select>
                                                </div>

                                                <!-- Select Counting Method -->
                                                <div class="col-md-4 mb-3">
                                                    <label for="counting_method_id" class="form-label">Counting Method</label>
                                                    <select class="form-control" id="counting_method_id" name="counting_method_id" required>
                                                        <option value="">Select Counting Method</option>
                                                        @foreach ($countingMethods as $method)
                                                            <option value="{{ $method->id }}">{{ $method->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Input fields for each maturity and gender combination -->
                                            <div class="row">
                                                @foreach ($maturities as $maturity)
                                                    @foreach ($genders as $gender)
                                                        <div class="col-md-4 mb-3">
                                                            <label class="form-label">{{ $maturity->name }} - {{ $gender->name }} Estimate</label>
                                                            <input type="number" class="form-control" name="estimates[{{ $maturity->id }}][{{ $gender->id }}]" placeholder="Enter estimate">
                                                        </div>
                                                    @endforeach
                                                @endforeach
                                            </div>

                                            <!-- Submission Button -->
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <button type="submit" class="btn btn-primary">Submit Estimates</button>
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
