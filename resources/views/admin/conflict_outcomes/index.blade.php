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
                        <h4 class="mb-sm-0" id="page-title">Conflict Outcomes</h4>
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
                                        <a href="{{route('admin.species-gender.index')}}"
                                           class="btn btn-info add-btn">
                                            <i class="fa fa-refresh"></i> Refresh
                                        </a>
                                        <button id="new-button" class="btn btn-success add-btn">
                                            <i class="fa fa-plus"></i> Add new outcome
                                        </button>
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
                                            style="width: 336.4px;">Outcome
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="buttons-datatables"
                                            rowspan="1" colspan="1"
                                            aria-label="Position: activate to sort column ascending"
                                            style="width: 336.4px;">Type
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="buttons-datatables"
                                            rowspan="1" colspan="1"
                                            aria-label="Position: activate to sort column ascending"
                                            style="width: 336.4px;">Custom Data Fields
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="buttons-datatables"
                                            rowspan="1" colspan="1"
                                            aria-label="Salary: activate to sort column ascending"
                                            style="width: 112.4px;">Actions
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($conflictOutcomes as $conflictOutcome)
                                        <tr class="even">
                                            <td class="sorting_1">{{$loop->iteration}}</td>
                                            <td>{{$conflictOutcome->name}}</td>
                                            <td>{{$conflictOutcome->conflictType->name}}</td>
                                            <td>
                                                <a href="{{route('admin.dynamic-fields.index',$conflictOutcome->slug)}}">
                                                    Data Fields ({{$conflictOutcome->dynamicFields->count()}})
                                                </a>
                                            </td>
                                            <td>
                                                <!-- Edit Button -->
                                                <a href="javascript:void(0);" class="edit-button btn btn-sm btn-primary"
                                                   data-name="{{ $conflictOutcome->name }}" data-slug="{{ $conflictOutcome->slug }}" title="Edit">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                <!-- Delete Button -->
                                                <form action="{{ route('admin.conflict-outcomes.destroy',$conflictOutcome->slug)}}"
                                                    method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
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
                                <h6 id="card-title" class="card-title mb-0">Add Conflict Outcomes</h6>
                            </div>
                            <div class="card-body">
                                <form id="edit-form" action="{{route('admin.conflict-outcomes.store')}}" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="_method" value="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Conflict Outcomes</label>
                                        <input type="text" name="name" class="form-control" id="name" placeholder="Enter outcome"/>
                                    </div>
                                    <!-- Conflict Types Dropdown -->
                                    <div class="mb-3">
                                        <label for="conflict_type_id" class="form-label">Conflict Type</label>
                                            <select name="conflict_type_id" id="conflict_type_id" class="form-control">
                                                <option value="">Select Conflict Type</option>
                                                @foreach ($conflictTypes as $type)
                                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                @endforeach
                                            </select>
                                    </div>
                                    <div class="text-end">
                                        <button id="submit-button" type="submit" class="btn btn-primary">Add New</button>
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
            $('#name').val('');


            // Click event for the edit button
            $('.edit-button').on('click', function () {
                var name = $(this).data('name');
                var conflictOutCome = $(this).data('slug');

                // Set form action for update, method to PATCH, and button text to Update
                $('#edit-form').attr('action', '/admin/conflict-outcomes/' + conflictOutCome + '/update');
                $('input[name="_method"]').val('PATCH');
                submitButton.text('Update');
                // Populate the form for editing
                $('#name').val(name);
                $('#card-title').text('Edit - ' + name + ' Conflict Outcomes');
                $('#page-title').text('Edit - ' + name + ' Conflict Outcomes');
            });

            // Click event for adding a new item
            $('#new-button').on('click', function () {
                // Clear the form, set action for creation, method to POST, and button text to Add New
                $('#edit-form').attr('action', 'admin/conflict-outcomes/store');
                $('input[name="_method"]').val('POST');
                submitButton.text('Add New');
                $('#name').val('');
                $('#card-title').text('Add Conflict Outcomes');
                $('#page-title').text('Add New Conflict Outcomes');
            });
        });


    </script>

@endpush
