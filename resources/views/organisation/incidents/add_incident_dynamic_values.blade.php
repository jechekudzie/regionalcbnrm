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
                        <h4 class="mb-sm-0">{{$organisation->name}} ({{$incident->title}} - Conflict) </h4>

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
                                       href="{{route('organisation.incident-outcomes.index',[$organisation->slug,$incident->slug])}}"><i
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
                            <h2>{{$incident->title}} - {{$conflictOutCome->name}} </h2>
                                <br>

                                @php
                                    $maxRows = !empty($dynamicFieldsWithValues) ? max(array_map('count', $dynamicFieldsWithValues)) : 0; // Check if array is not empty before finding max
                                @endphp

                                @if($maxRows > 0) <!-- Only render the table if there are rows to display -->
                                <table class="table">
                                    <thead>
                                    <tr>
                                        @foreach($dynamicFieldsWithValues as $fieldName => $values)
                                            <th>{{ $fieldName }}</th> <!-- Dynamic field name as column header -->
                                        @endforeach
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @for($i = 0; $i < $maxRows; $i++)
                                        <tr>
                                            @foreach($dynamicFieldsWithValues as $values)
                                                <td>
                                                    @if(isset($values[$i]))
                                                        @if(is_array($values[$i])) <!-- Check if the value is an array, indicating multiple selections like checkboxes -->
                                                        {{ implode(', ', $values[$i]) }} <!-- Join array values with a comma -->
                                                        @else
                                                            {{ $values[$i] }} <!-- Display the single value -->
                                                            @endif
                                                            @else
                                                                &mdash; <!-- Display a dash (or any placeholder) for empty cells -->
                                                        @endif
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endfor
                                    </tbody>
                                </table>
                                @else
                                    <p>No dynamic field values available.</p> <!-- Display a message if there are no rows to display -->
                                @endif


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

                                                    <form action="{{route('organisation.incident-outcomes-dynamic-fields.store',[$organisation->slug,$incident->slug,$incidentOutCome])}}" method="POST">
                                                        @csrf
                                                        @foreach($conflictOutCome->dynamicFields as $field)
                                                            <div class="mb-3">
                                                                <label>{{ $field->label }}</label>
                                                                @if(in_array($field->field_type, ['text', 'number', 'email', 'date', 'time']))
                                                                    <input type="{{ $field->field_type }}" name="values[{{ $field->id }}]" class="form-control">
                                                                @elseif($field->field_type == 'select')
                                                                    <!-- Assuming you have predefined options for select fields -->
                                                                    <select name="values[{{ $field->id }}]" class="form-select">
                                                                        @foreach($field->options as $option) <!-- You need to define how options are related to fields -->
                                                                        <option value="{{ $option->option_value }}">{{ $option->option_label }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                @elseif($field->field_type == 'checkbox')
                                                                    <!-- Assuming checkboxes can have multiple options -->
                                                                    @foreach($field->options as $option)
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="checkbox" name="values[{{ $field->id }}][]" value="{{ $option->option_value }}">
                                                                            <label class="form-check-label">{{ $option->option_label }}</label>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        @endforeach

                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
