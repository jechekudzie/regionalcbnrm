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

                                        <a href="{{route('organisation.projects.index',$organisation->slug)}}"
                                           class="btn btn-primary add-btn"><i
                                                class="fa fa-arrow-left"></i> Back to Projects
                                        </a>
                                        <br/>
                                        <br/>


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

                                        <div class="col-xxl-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <!-- Nav tabs -->
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="card mt-n4 mx-n4">
                                                                <div class="bg-soft-warning">
                                                                    <div class="card-body pb-0 px-4">
                                                                        <div class="row mb-3">
                                                                            <div class="col-md">
                                                                                <div class="row align-items-center g-3">
                                                                                    <div class="col-md-auto">
                                                                                        <div class="avatar-md">
                                                                                            <div
                                                                                                class="avatar-title bg-white rounded-circle">
                                                                                                {{--<img src="assets/images/brands/slack.png" alt="" class="avatar-xs">--}}
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md">
                                                                                        <div>
                                                                                            <h4 class="fw-bold">{{$project->name}}</h4>
                                                                                            <div
                                                                                                class="hstack gap-3 flex-wrap">
                                                                                                <div class="vr"></div>
                                                                                                <div>Start Date : <span
                                                                                                        class="fw-medium">{{ $project->project_start_date ? date('F m Y',strtotime($project->project_start_date)) : 'N/A' }}</span>
                                                                                                </div>
                                                                                                <div class="vr"></div>
                                                                                                <div>Completion Date :
                                                                                                    <span
                                                                                                        class="fw-medium">{{ $project->project_start_date ? date('F m Y',strtotime($project->project_end_date)) : 'N/A' }}</span>
                                                                                                </div>
                                                                                                <div class="vr"></div>
                                                                                                <div
                                                                                                    class="badge rounded-pill bg-info fs-12">
                                                                                                    New
                                                                                                </div>
                                                                                                <div
                                                                                                    class="badge rounded-pill bg-danger fs-12">
                                                                                                    High
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-auto">
                                                                                <div class="hstack gap-1 flex-wrap">
                                                                                    <button type="button"
                                                                                            class="btn py-0 fs-16 favourite-btn active">
                                                                                        <i class="ri-star-fill"></i>
                                                                                    </button>
                                                                                    <button type="button"
                                                                                            class="btn py-0 fs-16 text-body">
                                                                                        <i class="ri-share-line"></i>
                                                                                    </button>
                                                                                    <button type="button"
                                                                                            class="btn py-0 fs-16 text-body">
                                                                                        <i class="ri-flag-line"></i>
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <ul class="nav nav-tabs-custom border-bottom-0"
                                                                            role="tablist">
                                                                            <li class="nav-item">
                                                                                <a class="nav-link fw-semibold active"
                                                                                   data-bs-toggle="tab"
                                                                                   href="#project-overview" role="tab"
                                                                                   aria-selected="true">
                                                                                    Overview
                                                                                </a>
                                                                            </li>
                                                                            <li class="nav-item">
                                                                                <a class="nav-link fw-semibold"
                                                                                   data-bs-toggle="tab"
                                                                                   href="#project-documents" role="tab"
                                                                                   aria-selected="false">
                                                                                    Stages & Timelines
                                                                                </a>
                                                                            </li>
                                                                            <li class="nav-item">
                                                                                <a class="nav-link fw-semibold"
                                                                                   data-bs-toggle="tab"
                                                                                   href="#project-activities" role="tab"
                                                                                   aria-selected="false">
                                                                                    Budget & Expenses
                                                                                </a>
                                                                            </li>
                                                                            <li class="nav-item">
                                                                                <a class="nav-link fw-semibold"
                                                                                   data-bs-toggle="tab"
                                                                                   href="#project-team" role="tab">
                                                                                    Stakeholders
                                                                                </a>
                                                                            </li>
                                                                            <li class="nav-item">
                                                                                <a class="nav-link fw-semibold"
                                                                                   data-bs-toggle="tab"
                                                                                   href="#beneficiary" role="tab">
                                                                                    Project Beneficiaries
                                                                                </a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                    <!-- end card body -->
                                                                </div>
                                                            </div>
                                                            <!-- end card -->
                                                        </div>
                                                        <!-- end col -->
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="tab-content text-muted">
                                                                <div class="tab-pane fade active show"
                                                                     id="project-overview" role="tabpanel">
                                                                    <div class="row">
                                                                        <div class="col-xl-9 col-lg-8">
                                                                            <div class="card mb-3">
                                                                                <div class="card-body">
                                                                                    <div class="mb-4">
                                                                                        <a href="{{route('organisation.projects.index',$organisation->slug)}}"
                                                                                           class="btn btn-primary add-btn"><i
                                                                                                class="fa fa-pencil"></i>
                                                                                            Edit Project </a>
                                                                                    </div>
                                                                                    <div class="table-card">
                                                                                        <table class="table mb-0">
                                                                                            <tbody>
                                                                                            <tr>
                                                                                                <td class="fw-medium">
                                                                                                    Project Name
                                                                                                </td>
                                                                                                <td>{{ $project->name }}</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td class="fw-medium">
                                                                                                    Category
                                                                                                </td>
                                                                                                <td>{{ $project->category->name }}</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td class="fw-medium">
                                                                                                    Status
                                                                                                </td>
                                                                                                <td style="font-size: 20px;">
                                                                                                    <span class="badge">
                                                                                                    @if($project->status == 'completed')
                                                                                                            <span
                                                                                                                class="badge bg-success">Completed</span>
                                                                                                        @elseif($project->status->name == 'Completed')
                                                                                                            <span
                                                                                                                class="badge bg-warning">In Progress</span>
                                                                                                        @elseif($project->status->name == 'Active')
                                                                                                            <span
                                                                                                                class="badge bg-danger">Not Started</span>
                                                                                                        @elseif($project->status->name == 'Planning')
                                                                                                            <span
                                                                                                                class="badge bg-info">Planning</span>
                                                                                                        @else
                                                                                                            <span
                                                                                                                class="badge bg-secondary">On Hold</span>

                                                                                                        @endif
                                                                                                    </span>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td class="fw-medium">
                                                                                                    Start Date
                                                                                                </td>
                                                                                                <td>{{ $project->project_start_date ? date('F m Y', strtotime($project->project_start_date)) : 'N/A' }}</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td class="fw-medium">
                                                                                                    End Date
                                                                                                </td>
                                                                                                <td>{{ $project->project_end_date ? date('F m Y', strtotime($project->project_end_date)) : 'N/A' }}</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td class="fw-medium">
                                                                                                    Location
                                                                                                </td>
                                                                                                <td>
                                                                                                    Latitude: {{ $project->latitude ?? 'N/A' }}
                                                                                                    ,
                                                                                                    Longitude: {{ $project->longitude ?? 'N/A' }}</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td class="fw-medium">
                                                                                                    Funding
                                                                                                </td>
                                                                                                <td>{{ $project->project_funds }}</td>
                                                                                            </tr>
                                                                                            <!-- Add more rows as needed for other project details -->
                                                                                            </tbody>
                                                                                        </table>
                                                                                        <!--end table-->
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </div>

                                                                    </div>
                                                                    <!-- end row -->
                                                                </div>
                                                                <!-- end tab pane -->
                                                                <div class="tab-pane fade" id="project-documents"
                                                                     role="tabpanel">
                                                                    <div class="card">
                                                                        <div class="card-body">
                                                                            <div class="d-flex align-items-center mb-4">
                                                                                <a href="{{route('organisation.project-timelines.create',[$organisation->slug,$project->slug])}}"
                                                                                   class="btn btn-primary add-btn"><i
                                                                                        class="fa fa-plus"></i>
                                                                                    Add Project Activities </a>
                                                                            </div>
                                                                            <div class="card mb-3">
                                                                                <div class="card-body">
                                                                                    <div class="table-responsive">
                                                                                        <table
                                                                                            class="table table-bordered mb-0">
                                                                                            <thead>
                                                                                            <tr>
                                                                                                <th scope="col">Stage
                                                                                                </th>
                                                                                                <th scope="col">
                                                                                                    Description
                                                                                                </th>
                                                                                                <th scope="col">Start
                                                                                                    Date
                                                                                                </th>
                                                                                                <th scope="col">End
                                                                                                    Date
                                                                                                </th>
                                                                                                <th scope="col">Status
                                                                                                </th>
                                                                                            </tr>
                                                                                            </thead>
                                                                                            <tbody>
                                                                                            @foreach ($project->timelines as $timeline)
                                                                                                <tr>
                                                                                                    <td>{{ $timeline->stage }}</td>
                                                                                                    <td>{{ $timeline->description }}</td>
                                                                                                    <td>{{ $timeline->start_date ? date('Y-m-d',strtotime($timeline->start_date)) : 'N/A' }}</td>
                                                                                                    <td>{{ $timeline->end_date ? date('Y-m-d',strtotime($timeline->start_date)) : 'N/A' }}</td>
                                                                                                    <td>
                                <span
                                    class="badge bg-{{ $timeline->projectStatus->name == 'Completed' ? 'success' : ($timeline->projectStatus->name == 'Active' ? 'primary' : 'secondary') }}">
                                    {{ ucfirst($timeline->projectStatus->name) }}
                                </span>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            @endforeach
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- end tab pane -->
                                                                <div class="tab-pane fade" id="project-activities"
                                                                     role="tabpanel">
                                                                    <div class="card">
                                                                        <div class="card-body">
                                                                            <div class="card col-md-3">
                                                                            <a href="{{route('organisation.project-budgets.create',[$organisation->slug,$project->slug])}}"
                                                                               class="btn btn-primary add-btn"><i
                                                                                    class="fa fa-plus"></i>
                                                                                Add Budget Items </a>
                                                                            <br/>
                                                                            </div>
                                                                            <div class="card mb-3">

                                                                                <div class="card-body">
                                                                                    <div class="table-responsive">
                                                                                        <table
                                                                                            class="table table-bordered mb-0">
                                                                                            <thead>
                                                                                            <tr>
                                                                                                <th scope="col">Item
                                                                                                    Name
                                                                                                </th>
                                                                                                <th scope="col">
                                                                                                    Description
                                                                                                </th>
                                                                                                <th scope="col">Cost
                                                                                                </th>
                                                                                                <th scope="col">
                                                                                                    Quantity
                                                                                                </th>
                                                                                                <th scope="col">Total
                                                                                                    Cost
                                                                                                </th>
                                                                                                <th scope="col">Status
                                                                                                </th>
                                                                                            </tr>
                                                                                            </thead>
                                                                                            <tbody>
                                                                                            @foreach ($project->budgets as $item)
                                                                                                <tr>
                                                                                                    <td>{{ $item->item_name }}</td>
                                                                                                    <td>{{ $item->item_description }}</td>
                                                                                                    <td>
                                                                                                        ${{ number_format($item->item_cost, 2) }}</td>
                                                                                                    <td>{{ $item->item_quantity }}</td>
                                                                                                    <td>
                                                                                                        ${{ number_format($item->item_total_cost, 2) }}</td>
                                                                                                    <td>
                                                                                                    <span
                                                                                                        class="badge bg-{{ $item->item_status == 'approved' ? 'success' : 'secondary' }}">
                                                                                                        {{ ucfirst($item->item_status) }}
                                                                                                    </span>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            @endforeach
                                                                                            <!-- Total row -->
                                                                                            <tr class="fw-bold">
                                                                                                <td colspan="4"
                                                                                                    class="text-end">
                                                                                                    Total:
                                                                                                </td>
                                                                                                <td colspan="2">
                                                                                                    ${{ number_format($project->budgets->sum('item_total_cost'), 2) }}</td>
                                                                                            </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                        <!--end card-body-->
                                                                    </div>
                                                                    <!--end card-->
                                                                </div>
                                                                <!-- end tab pane -->
                                                                <div class="tab-pane fade" id="project-team"
                                                                     role="tabpanel">
                                                                    <div class="row">
                                                                        <div class="card col-md-3">
                                                                            <a href="{{route('organisation.project-stakeholders.create',[$organisation->slug,$project->slug])}}"
                                                                               class="btn btn-primary add-btn"><i
                                                                                    class="fa fa-plus"></i>
                                                                                Add Stakeholders </a>
                                                                            <br/>
                                                                            <br/>
                                                                        </div>


                                                                    </div>
                                                                    <div class="row">
                                                                        @foreach($project->stakeholders as $stakeholder)
                                                                            <div class="col-md-6 col-lg-4">
                                                                                <div style="color: black;" class="card">
                                                                                    <div style="background-color: lightgrey" class="card-body">
                                                                                        <h5 class="card-title">{{ $stakeholder->stakeholder_name }}</h5>
                                                                                        <h6 class="card-subtitle mb-2 text-black">ROLE: {{ $stakeholder->role }}</h6>
                                                                                        <p class="card-text">
                                                                                            <strong>Email:</strong> {{ $stakeholder->stakeholder_email }}<br>
                                                                                            <strong>Phone:</strong> {{ $stakeholder->stakeholder_phone }}<br>
                                                                                            <strong>Interest:</strong> {{ $stakeholder->interest }}<br>
                                                                                            <strong>Status:</strong> <span class="badge bg-{{ $stakeholder->status == 'active' ? 'success' : 'secondary' }}">{{ ucfirst($stakeholder->status) }}</span>
                                                                                        </p>
                                                                                        <a href="#" class="card-link">View Details</a>
                                                                                        <a href="#" class="card-link">Edit</a>
                                                                                        <a href="#" class="card-link text-danger">Remove</a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>


                                                                </div>
                                                                <!-- end tab pane -->

                                                                <!-- end tab pane -->
                                                                <div class="tab-pane fade" id="beneficiary"
                                                                     role="tabpanel">
                                                                    <div class="row">
                                                                        <div class="card col-md-3">
                                                                            <a href="{{route('organisation.project-beneficiaries.create',[$organisation->slug,$project->slug])}}"
                                                                               class="btn btn-primary add-btn"><i
                                                                                    class="fa fa-plus"></i>
                                                                                Add Beneficiaries </a>
                                                                            <br/>
                                                                            <br/>
                                                                        </div>


                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="row">
                                                                            @foreach($project->beneficiaries as $beneficiary)
                                                                                <div class="col-md-6 col-lg-4">
                                                                                    <div class="card">
                                                                                        <div class="card-body">
                                                                                            <h5 class="card-title">{{ $beneficiary->beneficiary_name }}</h5>
                                                                                            <p style="color: black;" class="card-text">
                                                                                                <strong style="color: black;">Number of Beneficiaries:</strong> {{ $beneficiary->beneficiary_number }}
                                                                                            </p>
                                                                                            <a href="#" class="card-link">View Details</a>
                                                                                            <a href="#" class="card-link">Edit</a>
                                                                                            <a href="#" class="card-link text-danger">Remove</a>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>

                                                                    </div>


                                                                </div>
                                                                <!-- end tab pane -->
                                                            </div>
                                                        </div>
                                                        <!-- end col -->
                                                    </div>
                                                </div><!-- end card-body -->
                                            </div><!-- end card -->
                                        </div>

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
