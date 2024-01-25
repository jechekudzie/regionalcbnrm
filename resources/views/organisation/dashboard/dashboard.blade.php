@extends('layouts.dashboard')

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
                                                child
                                                organisations @if($organisation && method_exists($organisation, 'getAllChildren'))
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
                                        <div class="d-grid gap-2">
                                            <a style="margin: 3px;" href="{{route('organisation.dashboard.index', $organisation->slug)}}"
                                               class="btn btn-primary  btn-sm  float-start">Enter organisation <i
                                                    class="ri-arrow-right-s-line align-middle ms-1 lh-1"></i>
                                            </a>

                                            <a style="margin: 3px;" href="javascript:void(0);"
                                               class="btn btn-primary btn-sm float-end"
                                               data-slug="{{$organisation->slug}}" data-name="{{$organisation->name}}"
                                               data-id="{{$organisation->id}}"
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
                <div class="col-xxl-3 col-xl-6">
                    <div class="card">
                        <div class="card-header card-primary align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1"><i class="fa fa-sitemap"></i> Child Organisations</h4>

                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="">
                                <div class="list-group list-group-fill-success">
                                    <a href="#" class="list-group-item list-group-item-action active"><i
                                            class="ri-download-2-fill align-middle me-2"></i>Category Download</a>
                                    <a href="#" class="list-group-item list-group-item-action"><i
                                            class="ri-shield-check-line align-middle me-2"></i>Security Access</a>
                                    <a href="#" class="list-group-item list-group-item-action"><i
                                            class="ri-database-2-line align-middle me-2"></i>Storage folder</a>
                                    <a href="#" class="list-group-item list-group-item-action"><i
                                            class="ri-notification-3-line align-middle me-2"></i>Push Notification</a>
                                    <a href="#" class="list-group-item list-group-item-action disabled" tabindex="-1"><i
                                            class="ri-moon-fill align-middle me-2"></i>Dark Mode</a>
                                </div>
                            </div>

                        </div><!-- end card-body -->
                    </div><!-- end card -->
                </div>
                <!--end col-->
            </div>
            <!--end row-->

        </div>
        <!-- container-fluid -->
    </div>
@stop
