@extends('layouts.organisation')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Welcome {{$user->name}}</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">CRM</a></li>
                                <li class="breadcrumb-item active">Welcome</li>
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
                                            class="ri-add-fill me-1 align-bottom"></i> Return to dashboard
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
                <div class="col-xxl-9">
                    <div class="row">
                        @foreach($organisations as $organisation)
                            <div class="col-lg-4 col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-center fs-15 fw-semibold mb-8">{{$organisation->name}}</h5>
                                        <div class="d-flex flex-wrap justify-content-evenly">
                                            <p class="text-muted text-start">
                                                <i class="fa fa-user text-success fs-18 align-left me-2"></i>
                                                @if($user->roles())
                                                    {{$user->roles()->wherePivot('organisation_id', $organisation->id)->first()->name ?? 'Default Name'}}
                                                @endif
                                            </p>

                                            <p class="text-muted text-end">
                                                <i class="fa fa-sitemap text-primary fs-18 align-right me-2"></i>
                                                child organisations @if($organisation && method_exists($organisation, 'getAllChildren'))
                                                    ( {{ count($organisation->getAllChildren()) }})
                                                @else
                                                    child organisations (0)
                                                @endif

                                            </p>
                                        </div>
                                    </div>
                                    <div class="progress animated-progress rounded-bottom rounded-0"
                                         style="height: 6px;">
                                        <div class="progress-bar bg-success rounded-0" role="progressbar"
                                             style="width: 30%" aria-valuenow="30" aria-valuemin="0"
                                             aria-valuemax="100"></div>

                                        <div class="progress-bar rounded-0" role="progressbar" style="width: 20%"
                                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <!-- card footer -->
                                    <div class="card-footer">
                                        <!-- Buttons Grid -->
                                        <div class="d-grid gap-2" >
                                            <a style="margin: 3px;" href="javascript:void(0);"
                                               class="btn btn-primary  btn-sm  float-start">Enter organisation <i
                                                    class="ri-arrow-right-s-line align-middle ms-1 lh-1"></i>
                                            </a>

                                            <a style="margin: 3px;" href="javascript:void(0);" class="btn btn-primary btn-sm float-end"
                                            data-slug="{{$organisation->slug}}" data-name="{{$organisation->name}}" data-id="{{$organisation->id}}"
                                            >View Child Organisations
                                                <i class="ri-arrow-right-s-line align-middle ms-1 lh-1"></i>
                                            </a>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        @endforeach
                        <!-- end col -->
                    </div>
                    <!--end card-->
                </div>
                <!--end col-->
                <div class="col-xxl-3">
                    <div class="card" id="company-view-detail">
                        <div class="card-body text-center">
                            <div class="position-relative d-inline-block">
                                <div class="avatar-md">
                                    <div class="avatar-title bg-light rounded-circle">
                                        <img src="administration/assets/images/brands/mail_chimp.png" alt=""
                                             class="avatar-sm rounded-circle object-cover">
                                    </div>
                                </div>
                            </div>
                            <h5 class="mt-3 mb-1">Syntyce Solution</h5>
                            <p class="text-muted">Michael Morris</p>

                            <ul class="list-inline mb-0">
                                <li class="list-inline-item avatar-xs">
                                    <a href="javascript:void(0);"
                                       class="avatar-title bg-soft-success text-success fs-15 rounded">
                                        <i class="ri-global-line"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item avatar-xs">
                                    <a href="javascript:void(0);"
                                       class="avatar-title bg-soft-danger text-danger fs-15 rounded">
                                        <i class="ri-mail-line"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item avatar-xs">
                                    <a href="javascript:void(0);"
                                       class="avatar-title bg-soft-warning text-warning fs-15 rounded">
                                        <i class="ri-question-answer-line"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <h6 class="text-muted text-uppercase fw-semibold mb-3">Information</h6>
                            <p class="text-muted mb-4">A company incurs fixed and variable costs such as the
                                purchase of raw materials, salaries and overhead, as explained by AccountingTools,
                                Inc. Business owners have the discretion to determine the actions.</p>
                            <div class="table-responsive table-card">
                                <table class="table table-borderless mb-0">
                                    <tbody>
                                    <tr>
                                        <td class="fw-medium" scope="row">Industry Type</td>
                                        <td>Chemical Industries</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium" scope="row">Location</td>
                                        <td>Damascus, Syria</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium" scope="row">Employee</td>
                                        <td>10-50</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium" scope="row">Rating</td>
                                        <td>4.0 <i class="ri-star-fill text-warning align-bottom"></i></td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium" scope="row">Website</td>
                                        <td>
                                            <a href="javascript:void(0);"
                                               class="link-primary text-decoration-underline">www.syntycesolution.com</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium" scope="row">Contact Email</td>
                                        <td>info@syntycesolution.com</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium" scope="row">Since</td>
                                        <td>1995</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--end card-->
                </div>
                <!--end col-->
            </div>
            <!--end row-->

        </div>
        <!-- container-fluid -->
    </div>
@stop
