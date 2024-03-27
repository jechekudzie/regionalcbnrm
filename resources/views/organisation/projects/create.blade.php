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

                                        <a href="{{route('organisation.projects.index',$organisation->slug)}}" class="btn btn-primary add-btn"><i
                                                class="fa fa-arrow-left"></i> Back to Projects
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
                                <div class="row">
                                    <div class="col-lg-12">
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
                                                            <input type="text" class="form-control" id="latitude-input" name="latitude" placeholder="Enter latitude">
                                                        </div>

                                                        <div class="col-md-4 mb-3">
                                                            <label class="form-label" for="longitude-input">Longitude</label>
                                                            <input type="text" class="form-control" id="longitude-input" name="longitude" placeholder="Enter longitude">
                                                        </div>
                                                    </div>

                                                    <div class="text-start mb-4">
                                                        <button type="submit" class="btn btn-success w-100">Create Project</button>
                                                    </div>
                                                </div>
                                                <!-- end card body -->
                                            </div>
                                            <!-- end card -->
                                        </form>

                                    </div>
                                    <!-- end col -->

                                    {{-- Include other sections like project thumbnail, attached files, privacy settings, tags, and members as per your project requirements --}}

                                </div>

                                <!--end table-->

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

        // Assuming you have jQuery available


    </script>

@endpush
