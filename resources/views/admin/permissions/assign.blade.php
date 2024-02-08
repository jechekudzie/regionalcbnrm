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
                        <h4 class="mb-sm-0" id="page-title">Modules - {{$organisation->name}}  - Assign {{$role->name}} Permissions</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">CRM</a></li>
                                <li class="breadcrumb-item active">System Modules</li>
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

                                        <a href="{{route('admin.organisation-roles.index',$organisation->slug)}}"
                                           class="btn btn-info btn-sm add-btn">
                                            <i class="fa fa-arrow-left"></i> Back
                                        </a>
                                        <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#showModal"><i
                                                class="fa fa-plus"></i> {{$organisation->name}}  - Assign {{$role->name}} Permissions
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end col-->
                    <div class="col-xxl-12">
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

                                        <th class="sorting sorting_asc" {{--tabindex="0"--}}
                                        aria-controls="buttons-datatables" {{--rowspan="1" colspan="1"--}}
                                            aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending"
                                        >#
                                        </th>
                                        <th class="sorting sorting_asc" {{--tabindex="0"--}}
                                            aria-controls="buttons-datatables" {{--rowspan="1" colspan="1"--}}
                                            aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending"
                                            >Module
                                        </th>
                                        <th class="sorting" {{--tabindex="0"--}} aria-controls="buttons-datatables"
                                            {{--rowspan="1" colspan="1"--}}
                                            aria-label="Position: activate to sort column ascending"
                                           >View
                                        </th>

                                        <th class="sorting" {{--tabindex="0"--}} aria-controls="buttons-datatables"
                                            {{--rowspan="1" colspan="1"--}}
                                            aria-label="Position: activate to sort column ascending"
                                            >Create
                                        </th>

                                        <th class="sorting" {{--tabindex="0"--}} aria-controls="buttons-datatables"
                                            {{--rowspan="1" colspan="1"--}}
                                            aria-label="Salary: activate to sort column ascending"
                                            >Read
                                        </th>
                                        <th class="sorting" {{--tabindex="0"--}} aria-controls="buttons-datatables"
                                            {{--rowspan="1" colspan="1"--}}
                                            aria-label="Salary: activate to sort column ascending"
                                            >Update
                                        </th>
                                        <th class="sorting" {{--tabindex="0"--}} aria-controls="buttons-datatables"
                                            {{--rowspan="1" colspan="1"--}}
                                            aria-label="Salary: activate to sort column ascending"
                                            >Delete
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($modules as $module)
                                        @php
                                            $moduleName = strtolower(str_replace(' ', '-', $module->name));
                                        @endphp

                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $module->name }}</td>
                                            <!-- Display permission name and badge -->
                                            @foreach(['view', 'create', 'read', 'update', 'delete'] as $action)
                                                @php
                                                    $permissionName = "{$action}-{$moduleName}";
                                                    $hasPermission = $rolePermissions->contains(fn($perm) => Str::contains($perm->name, $permissionName));
                                                @endphp
                                                <td>
                                                    @if($hasPermission)
                                                        <span class="badge bg-success">Yes</span>  {{ $permissionName }}
                                                    @else
                                                        <span class="badge bg-danger">No</span>  {{ $permissionName }}
                                                    @endif
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <!--end table-->

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

                                                    <h4 class="card-title mb-0"> {{$organisation->name}}  - Assign {{$role->name}} Permissions</h4>
                                                </div>
                                                <div class="card-body">

                                                    <form action="{{route('admin.permissions.assign-permission-to-role',[$organisation->slug,$role->id])}}" method="POST">
                                                        @csrf
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                <tr>
                                                                    <th>Module</th>
                                                                    <th>View <span>&#10003;</span></th>
                                                                    <th>Create <span>&#10003;</span></th>
                                                                    <th>Read <span>&#10003;</span></th>
                                                                    <th>Update <span>&#10003;</span></th>
                                                                    <th>Delete <span>&#10003;</span></th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach ($modules as $module)
                                                                    @php
                                                                        $moduleName = strtolower(str_replace(' ', '-', $module->name));
                                                                        // Get an array of permission names for the current role
                                                                        $rolePermissions = $role->permissions->pluck('name')->toArray();
                                                                    @endphp
                                                                    <tr>
                                                                        <td>{{ $module->name }}</td>
                                                                        <!-- Checkboxes for permissions -->
                                                                        <td><input class="form-check-input" type="checkbox" name="permissions[]" value="view-{{ $moduleName }}" @if(in_array("view-{$moduleName}", $rolePermissions)) checked @endif></td>
                                                                        <td><input class="form-check-input" type="checkbox" name="permissions[]" value="create-{{ $moduleName }}" @if(in_array("create-{$moduleName}", $rolePermissions)) checked @endif></td>
                                                                        <td><input class="form-check-input" type="checkbox" name="permissions[]" value="read-{{ $moduleName }}" @if(in_array("read-{$moduleName}", $rolePermissions)) checked @endif></td>
                                                                        <td><input class="form-check-input" type="checkbox" name="permissions[]" value="update-{{ $moduleName }}" @if(in_array("update-{$moduleName}", $rolePermissions)) checked @endif></td>
                                                                        <td><input class="form-check-input" type="checkbox" name="permissions[]" value="delete-{{ $moduleName }}" @if(in_array("delete-{$moduleName}", $rolePermissions)) checked @endif></td>
                                                                    </tr>
                                                                @endforeach

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Save Permissions</button>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
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


            // Click event for the edit button
            $('.edit-button').on('click', function () {
                var name = $(this).data('name');
                var description = $(this).data('description');
                var slug = $(this).data('slug');

                // Set form action for update, method to PATCH, and button text to Update
                $('#edit-form').attr('action', '/admin/permissions/' + slug + '/update');
                $('input[name="_method"]').val('PATCH');
                submitButton.text('Update');
                // Populate the form for editing
                $('#name').val(name);
                $('#card-title').text('Edit - ' + name + ' System Modules');
                $('#page-title').text('Edit - ' + name + ' System Modules');
            });

            // Click event for adding a new item
            $('#new-button').on('click', function () {
                // Clear the form, set action for creation, method to POST, and button text to Add New
                $('#edit-form').attr('action', 'admin/conflict-types/store');
                $('input[name="_method"]').val('POST');
                submitButton.text('Add New');
                $('#name').val('');
                $('#card-title').text('Add System Modules');
                $('#page-title').text('Add New System Modules');
            });
        });


    </script>

@endpush
