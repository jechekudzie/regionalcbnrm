@extends('layouts.admin')

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
                        <h4 class="mb-sm-0" id="page-title">{{$conflictOutCome->name}} - Dynamic fields</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">CRM</a></li>
                                <li class="breadcrumb-item active">Conflict Outcomes</li>
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
                                        <a href="{{route('admin.conflict-outcomes.index')}}"
                                           class="btn btn-info  add-btn">
                                            <i class="fa fa-arrow-left"></i> Back Outcomes
                                        </a>

                                        <a href="{{route('admin.dynamic-fields.index',$conflictOutCome->slug)}}"
                                           class="btn btn-success add-btn">
                                            <i class="fa fa-refresh"></i> Add New
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end col-->
                    <div class="col-xxl-9">
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
                        <div class="card">
                            <div class="card-body">
                                <!--start table-->
                                <table style="width: 100%;" id="buttons-datatables"
                                       class="display table table-bordered dataTable no-footer"
                                       aria-describedby="buttons-datatables_info">
                                    <thead>
                                    <tr>
                                        <th class="sorting sorting_asc" tabindex="0"
                                            aria-controls="buttons-datatables" rowspan="1" colspan="1"
                                            aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending"
                                            style="width: 224.4px;">#
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="buttons-datatables"
                                            rowspan="1" colspan="1"
                                            aria-label="Position: activate to sort column ascending"
                                            style="width: 336.4px;">field name
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="buttons-datatables"
                                            rowspan="1" colspan="1"
                                            aria-label="Position: activate to sort column ascending"
                                            style="width: 336.4px;">field type
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="buttons-datatables"
                                            rowspan="1" colspan="1"
                                            aria-label="Position: activate to sort column ascending"
                                            style="width: 336.4px;">field label
                                        </th>

                                        <th class="sorting" tabindex="0" aria-controls="buttons-datatables"
                                            rowspan="1" colspan="1"
                                            aria-label="Position: activate to sort column ascending"
                                            style="width: 336.4px;">field options
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="buttons-datatables"
                                            rowspan="1" colspan="1"
                                            aria-label="Salary: activate to sort column ascending"
                                            style="width: 112.4px;">Actions
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($fields as $field)
                                        <tr class="even">
                                            <td class="sorting_1">{{$loop->iteration}}</td>
                                            <td>{{$field->field_name}}</td>
                                            <td>{{$field->field_type}}</td>
                                            <td>{{$field->label}}</td>
                                            <td>
                                                <a href="javascript:void(0);"
                                                   class="options-button btn btn-sm btn-primary" data-bs-toggle="modal"
                                                   data-bs-target="#optionsModal"
                                                   data-name="{{ $field->field_name }}"
                                                   data-type="{{ $field->field_type }}" data-label="{{ $field->label }}"
                                                   data-outcome_name="{{ $conflictOutCome->name }}"
                                                   data-outcome_slug="{{ $conflictOutCome->slug }}"
                                                   data-slug="{{ $field->slug }}" title="Add">
                                                    <i class="fa fa-plus"></i> add options
                                                </a>
                                            </td>
                                            <td>
                                                <!-- Edit Button -->
                                                <a href="javascript:void(0);" class="edit-button btn btn-sm btn-primary"
                                                   data-field_name="{{ $field->field_name }}"
                                                   data-field_type="{{ $field->field_type }}"
                                                   data-label="{{ $field->label }}"
                                                   data-outcome_slug="{{ $conflictOutCome->slug }}"
                                                   data-outcome_name="{{ $conflictOutCome->name }}"
                                                   data-slug="{{ $field->slug }}" title="Edit">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                <!-- Delete Button -->
                                                <form
                                                    action="{{ route('admin.conflict-outcomes.destroy',$field->slug)}}"
                                                    method="POST" onsubmit="return confirm('Are you sure?');"
                                                    style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <div class="modal fade" id="optionsModal" tabindex="-1"
                                         aria-labelledby="exampleModalLabel"
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

                                                        <h4 class="card-title mb-0"> Dynamic Field Options</h4>
                                                    </div>
                                                    <div class="card-body">

                                                        <form action="" id="optionsForm" method="POST">
                                                            @csrf

                                                            <!-- Option Value -->
                                                            <div class="mb-3">
                                                                <label for="optionValue" class="form-label">Option
                                                                    Value</label>
                                                                <input type="text" class="form-control" id="optionValue"
                                                                       name="option_value" required>
                                                            </div>

                                                            <!-- Option Label -->
                                                            <div class="mb-3">
                                                                <label for="optionLabel" class="form-label">Option
                                                                    Label</label>
                                                                <input type="text" class="form-control" id="optionLabel"
                                                                       name="option_label" required>
                                                            </div>

                                                            <!-- Submit Button -->
                                                            <button type="submit" class="btn btn-primary">Add Option
                                                            </button>
                                                        </form>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </tbody>
                                </table>
                                <!--end table-->
                            </div>
                        </div>
                    </div>

                    <!--end col-->
                    <div class="col-xxl-3">
                        <div class="card border card-border-light">
                            <div class="card-header">
                                <h6 id="card-title" class="card-title mb-0">Add {{$conflictOutCome->name }} Dynamic
                                    Fields</h6>
                            </div>
                            <div class="card-body">
                                <form id="edit-form"
                                      action="{{route('admin.dynamic-fields.store',$conflictOutCome->slug)}}"
                                      method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="_method" value="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Field name</label>
                                        <input type="text" name="field_name" class="form-control" id="field_name"
                                               placeholder="Enter field name"/>

                                    </div>
                                    <div class="mb-3">
                                        <label for="label" class="form-label">Field Label</label>
                                        <input type="text" name="label" class="form-control" id="label"
                                               placeholder="Enter field label"/>

                                    </div>
                                    <div class="mb-3">
                                        <label for="field_type" class="form-label">Field Type</label>
                                        <select class="form-select" id="field_type" name="field_type">
                                            <option value="">Select Field Type</option>
                                            <option value="text">Text</option>
                                            <option value="number">Number</option>
                                            <option value="tel">Telephone</option>
                                            <option value="email">Email</option>
                                            <option value="date">Date</option>
                                            <option value="time">Time</option>
                                            <option value="textarea">Text Area</option>
                                            <option value="select">Select Dropdown</option>
                                            <!-- Added option for select dropdown -->
                                            <option value="checkbox">Checkbox</option><!-- Added option for checkbox -->
                                            <!-- Add more field types as needed -->
                                        </select>
                                    </div>
                                    <div class="text-end">
                                        <button id="submit-button" type="submit" class="btn btn-primary">Add New Field
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
            <!--end row-->
        </div>
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
            $('#field_name').val('');
            $('#field_type').val('');
            $('#label').val('');


            // Click event for the edit button
            $('.edit-button').on('click', function () {
                var field_name = $(this).data('field_name');
                var field_type = $(this).data('field_type');
                var label = $(this).data('label');
                var outcome_name = $(this).data('outcome_name');
                var conflictOutCome = $(this).data('outcome_slug');
                var dynamicField = $(this).data('slug');

                // Set form action for update, method to PATCH, and button text to Update
                $('#edit-form').attr('action', '/admin/conflict-outcomes/' + conflictOutCome + '/dynamic-fields/' + dynamicField + '/update');

                $('input[name="_method"]').val('PATCH');


                submitButton.text('Update');
                // Populate the form for editing
                $('#field_name').val(field_name);
                $('#field_type').val(field_type);
                $('#label').val(label);

                $('#card-title').text('Edit - ' + outcome_name + ' Dynamic Field');

            });

        });


        $(document).ready(function () {
            $('.options-button').click(function () {
                // Extract data attributes from the link
                var name = $(this).data('name');
                var type = $(this).data('type');
                var field_type = $(this).data('field_type');
                var outcome_name = $(this).data('outcome_name');
                var conflictOutCome = $(this).data('outcome_slug');
                var dynamicField = $(this).data('slug');


                $('#optionsForm').attr('action', '/admin/conflict-outcomes/' + conflictOutCome + '/dynamic-fields/' + dynamicField + '/options/store');
                // Populate the modal fields
                $('#optionsModal .card-title').text(outcome_name + name + ' Options');
                // Populate other fields in the modal as needed

                // Show the modal
                $('#optionsModal').modal('show');
            });
        });


    </script>

@endpush
