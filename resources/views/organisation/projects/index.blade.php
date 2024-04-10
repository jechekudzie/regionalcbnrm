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
                        <h4 class="mb-sm-0" id="page-title">{{$organisation->name}} Projects</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">CRM</a></li>
                                <li class="breadcrumb-item active">{{$organisation->name}} Projects</li>
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

                                        <a href="{{route('organisation.projects.create',$organisation->slug)}}" class="btn btn-success add-btn"><i
                                                    class="fa fa-plus"></i> Add New Project
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end col-->
                    <div class="col-xxl-12">
                        <div class="card">
                            <div class="card-body">
                                <!--start table-->
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
                                <table style="width: 100%;" id="buttons-datatables"
                                       class="display table table-bordered dataTable no-footer"
                                       aria-describedby="buttons-datatables_info">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Goals</th>
                                        <th>Funds</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($projects as $project)
                                        <tr>
                                            <td>{{ $project->id }}</td>
                                            <td>{{ $project->name }}</td>
                                            <td>{{ $project->category->name ?? 'N/A' }}</td>
                                            <td>{{ $project->status->name ?? 'N/A' }}</td>
                                            <td>{{ $project->project_start_date }}</td>
                                            <td>{{ $project->project_end_date }}</td>
                                            <td>{{ $project->project_goals }}</td>
                                            <td>{{ $project->project_funds }}</td>
                                            <td>
                                                <a href="{{ route('organisation.projects.show',[$organisation->slug,$project->slug]) }}"
                                                   class="btn btn-primary btn-sm">View</a>

                                                <button type="button" class="btn btn-success btn-sm edit-project" data-bs-toggle="modal" data-bs-target="#projectModal"
                                                        data-name="{{ $project->name }}"
                                                        data-category_id="{{ $project->project_category_id }}"
                                                        data-status_id="{{ $project->project_status_id }}"
                                                        data-funds="{{ $project->project_funds }}"
                                                        data-description="{{ $project->project_description }}"
                                                        data-goals="{{ $project->project_goals }}"
                                                        data-start_date="{{ $project->project_start_date }}"
                                                        data-end_date="{{ $project->project_end_date }}"
                                                        data-latitude="{{ $project->latitude }}"
                                                        data-longitude="{{ $project->longitude }}"
                                                        data-action="{{ route('organisation.projects.update', [$organisation->slug, $project->slug]) }}">
                                                    Edit Project
                                                </button>


                                                <form action="{{ route('organisation.projects.destroy',[$organisation->slug,$project->slug])}}"
                                                      method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <!--end table-->

                                <div class="modal fade" id="projectModal" tabindex="-1" aria-labelledby="projectModalLabel" aria-hidden="true">
                                    <!-- Modal dialog and content -->
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <!-- Modal header -->
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="projectModalLabel">Edit Project</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <!-- Modal body with form -->
                                            <div class="modal-body">
                                                <!-- Form here -->
                                                <form action="{{ route('organisation.projects.store', $organisation->slug) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf

                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="mb-3">
                                                                <label class="form-label" for="project-name-input">Project Name</label>
                                                                <input type="text" class="form-control" id="project-name-input" name="name" placeholder="Enter project name" required>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-4 mb-3">
                                                                    <label for="project-category-id" class="form-label">Project Category</label>
                                                                    <select class="form-select" id="project-category-id" name="project_category_id" required>
                                                                        {{-- Loop through project categories --}}
                                                                        @foreach ($projectCategories as $category)
                                                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="col-md-4 mb-3">
                                                                    <label for="project-status-id" class="form-label">Project Status</label>
                                                                    <select class="form-select" id="project-status-id" name="project_status_id" required>
                                                                        {{-- Loop through project statuses --}}
                                                                        @foreach ($projectStatuses as $status)
                                                                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="col-md-4 mb-3">
                                                                    <label class="form-label" for="project-funds-input">Project Funds (estimated total budget)</label>
                                                                    <input type="number" step="any" class="form-control" id="project-funds-input" name="project_funds" placeholder="Enter project funds, this is budget">
                                                                </div>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label" for="project-description-input">Project Description</label>
                                                                <textarea class="form-control" id="project-description-input" name="project_description" rows="4" placeholder="Enter project description"></textarea>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label class="form-label" for="project-goals-input">Project Goals</label>
                                                                <textarea class="form-control" id="project-goals-input" name="project_goals" rows="2" placeholder="Enter project goals"></textarea>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-4 mb-3">
                                                                    <label class="form-label" for="project-start-date-input">Project Start Date</label>
                                                                    <input type="date" class="form-control" id="project-start-date-input" name="project_start_date">
                                                                </div>

                                                                <div class="col-md-4 mb-3">
                                                                    <label class="form-label" for="project-end-date-input">Project End Date</label>
                                                                    <input type="date" class="form-control" id="project-end-date-input" name="project_end_date">
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-4 mb-3">
                                                                    <label class="form-label" for="latitude-input">Latitude</label>
                                                                    <input type="text" class="form-control" id="latitude" name="latitude" placeholder="Enter latitude">
                                                                </div>

                                                                <div class="col-md-4 mb-3">
                                                                    <label class="form-label" for="longitude-input">Longitude</label>
                                                                    <input type="text" class="form-control" id="longitude" name="longitude" placeholder="Enter longitude">
                                                                </div>
                                                            </div>

                                                            <div id="address"></div>
                                                            <div id="map" style="height: 300px; width: 100%;"></div>
                                                            <br/>

                                                            <div class="text-start mb-4">
                                                                <button type="submit" class="btn btn-success w-100">Create Project</button>
                                                            </div>
                                                        </div>
                                                        <!-- end card body -->
                                                    </div>
                                                    <!-- end card -->
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                    <!--end col-->

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

        $(document).ready(function() {
            $('.edit-project').click(function() {
                var modal = $('#projectModal');

                // Prefill the form fields
                modal.find('#project-name-input').val($(this).data('name'));
                modal.find('#project-category-id').val($(this).data('category_id'));
                modal.find('#project-status-id').val($(this).data('status_id'));
                modal.find('#project-funds-input').val($(this).data('funds'));
                modal.find('#project-description-input').val($(this).data('description'));
                modal.find('#project-goals-input').val($(this).data('goals'));
                modal.find('#project-start-date-input').val($(this).data('start_date'));
                modal.find('#project-end-date-input').val($(this).data('end_date'));
                modal.find('#latitude').val($(this).data('latitude'));
                modal.find('#longitude').val($(this).data('longitude'));

                // Update the form's action URL
                modal.find('form').attr('action', $(this).data('action'));

                //update method to patch
                modal.find('form').append('<input type="hidden" name="_method" value="PATCH">');

                //change submit button text to Update Poaching Incident
                modal.find('button[type="submit"]').text('Update Project Details');
            });
        });



    </script>

@endpush
