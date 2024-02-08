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
                                    <a href="{{route('organisation.dashboard')}}" class="btn btn-info add-btn">
                                        <i class="fa fa-arrow-left"></i>
                                        Return to dashboard
                                    </a>
                                    @can('view-generic')
                                        <a style="margin: 3px;" href="{{route('organisation.dashboard.rural-district-councils')}}"
                                           class="btn btn-danger"
                                        >View RDC Organisations
                                            <i class="ri-arrow-right-s-line align-middle ms-1 lh-1"></i>
                                        </a>
                                    @endcan
                                    @if(auth()->user()->hasRole('super-admin'))
                                        <a style="margin: 3px;" href="{{route('admin.organisations.manage')}}"
                                           class="btn btn-success" target="_blank"
                                        >Super Admin Dashboard
                                            <i class="ri-arrow-right-s-line align-middle ms-1 lh-1"></i>
                                        </a>
                                    @endif
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
                    <div class="row">
                        @foreach($organisations as $organisation)
                            <div class="col-lg-4 col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-center fs-15 fw-semibold mb-8">{{$organisation->name}}</h5>
                                        <p class="text-center fs-12 fw-semibold mb-8">({{$organisation->parentOrganisation->name}})</p>
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
                                        <div class="d-grid gap-2">
                                            <a style="margin: 3px;"
                                               href="{{route('organisation.dashboard.index', $organisation->slug)}}"
                                               class="btn btn-success btn-sm  float-start">Enter Your Organisation <i
                                                    class="ri-arrow-right-s-line align-middle ms-1 lh-1"></i>
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

            </div>
            <!--end row-->

        </div>
        <!-- container-fluid -->
    </div>
@stop
