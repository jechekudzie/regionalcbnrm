<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
      data-sidebar-image="none">

<head>
    <meta charset="utf-8"/>
    <title>Regional CBNRM</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description"/>
    <meta content="Themesbrand" name="author"/>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('administration/assets/images/favicon.ico')}}">

    <!-- Sweet Alert css-->
    <link href="{{asset('administration/assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet"
          type="text/css"/>

    <!-- Layout config Js -->
    <script src="{{asset('administration/assets/js/layout.js')}}"></script>
    <!-- Bootstrap Css -->
    <link href="{{asset('administration/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- Icons Css -->
    <link href="{{asset('administration/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- App Css-->
    <link href="{{asset('administration/assets/css/app.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- custom Css-->
    <link href="{{asset('administration/assets/css/custom.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- Font Awsome Icons Css V4 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Gijgo config file -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css"/>
    <style>
        .gj-tree-bootstrap-4 ul.gj-list-bootstrap li.active {
            background-color: gray !important;
        }
        .nav, .nav-sm {
            list-style-type: none !important; /* Remove bullets */
            padding-left: 0; /* Remove indentation */
            margin-left: 0; /* Additional alignment, if necessary */
        }

        .menu-dropdown .nav, .menu-dropdown .nav-sm {
            list-style-type: none !important; /* Remove bullets */
            padding-left: 0; /* Remove indentation */
            margin-left: 0; /* Additional alignment, if necessary */
        }

    </style>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />

    @stack('head')


</head>

<body>

<!-- Begin page -->
<div id="layout-wrapper">

    <header id="page-topbar">
        <div class="layout-width">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box horizontal-logo">
                        <a href="{{url('/')}}" class="logo logo-dark">
                        </a>

                        <a href="{{url('/')}}" class="logo logo-light">
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger"
                            id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                    </button>
                </div>


                <div class="d-flex align-items-center">

                    <div class="dropdown topbar-head-dropdown ms-1 header-item">
                        <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                                id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                            <i class='bx bx-bell fs-22'></i>
                            <span
                                class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger">1<span
                                    class="visually-hidden">unread messages</span></span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                             aria-labelledby="page-header-notifications-dropdown">

                            <div class="dropdown-head bg-primary bg-pattern rounded-top">
                                <div class="p-3">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="m-0 fs-16 fw-semibold text-white"> Notifications </h6>
                                        </div>
                                    </div>
                                </div>

                                <div class="px-2 pt-2">
                                    <ul class="nav nav-tabs dropdown-tabs nav-tabs-custom" data-dropdown-tabs="true"
                                        id="notificationItemsTab" role="tablist">
                                        <li class="nav-item waves-effect waves-light">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#all-noti-tab"
                                               role="tab"
                                               aria-selected="true">
                                                All (1)
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                            </div>

                            <div class="tab-content" id="notificationItemsTabContent">
                                <div class="tab-pane fade show active py-2 ps-2" id="all-noti-tab" role="tabpanel">
                                    <div data-simplebar style="max-height: 300px;" class="pe-2">
                                        <div
                                            class="text-reset notification-item d-block dropdown-item position-relative">
                                            <div class="d-flex">
                                                <div class="flex-1">
                                                    <a href="#" class="stretched-link">
                                                        <h6 class="mt-0 mb-2 lh-base">
                                                            <span>Test notification</span>
                                                        </h6>
                                                    </a>
                                                    <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                        <span><i
                                                                class="mdi mdi-clock-outline"></i> Just 30 sec ago</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="my-3 text-center">
                                            <button type="button" class="btn btn-soft-success waves-effect waves-light">
                                                View
                                                All Notifications <i class="ri-arrow-right-line align-middle"></i>
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="dropdown ms-sm-3 header-item topbar-user">
                        <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <span class="text-start ms-xl-2">
                                <span
                                    class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">
                                    @if(auth()->check())
                                        {{auth()->user()->name}}
                                    @endif
                                </span>
                                <span
                                    class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">{{$organisation->name}} <br/>
                                    ({{$organisation->organisationType->name}})
                                </span>
                            </span>
                        </span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <a class="dropdown-item" href="#"><i
                                    class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span
                                    class="align-middle">Profile</span></a>

                            <a class="dropdown-item" href="#"><i
                                    class="mdi mdi-calendar-check-outline text-muted fs-16 align-middle me-1"></i> <span
                                    class="align-middle">Taskboard</span></a>

                            <div class="dropdown-divider"></div>

                            <a class="dropdown-item" href="#"><i
                                    class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i> <span
                                    class="align-middle">Settings</span></a>


                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a class="dropdown-item" href="{{route('logout')}}" onclick="event.preventDefault();
                                                this.closest('form').submit();"><i
                                        class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span
                                        class="align-middle" data-key="t-logout">Logout</span></a>
                            </form>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </header>
    <!-- ========== App Menu ========== -->
    <div class="app-menu navbar-menu">
        <!-- LOGO -->
        <div class="navbar-brand-box">
            <!-- Dark Logo-->
            <a href="{{url('/')}}" class="logo logo-dark">
                <span class="logo-sm">
                    <img src="{{asset('logo/logo.png')}}" alt="" height="50">
                </span>
                <span class="logo-lg">
                    <img src="{{asset('logo/logo.png')}}" alt="" height="60">
                </span>
            </a>
            <!-- Light Logo-->
            <a href="{{url('/')}}" class="logo logo-light">
                 <span class="logo-sm">
                     <img src="{{asset('logo/logo.png')}}" alt="" height="50">
                 </span>
                <span class="logo-lg">
                     <img src="{{asset('logo/logo.png')}}" alt="" height="60">
                 </span>
            </a>
            <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
                    id="vertical-hover">
                <i class="ri-record-circle-line"></i>
            </button>
        </div>
        <!-- LOGO -->

        <!-- SIDEBARD -->
        <div id="scrollbar">
            <div class="container-fluid">
                <div id="two-column-menu"></div>
                <ul class="navbar-nav" id="navbar-nav">
                    <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-pages">Organisation</span>
                    </li>

                    <li class="nav-item">
                        <a style="font-weight: bolder;" class="nav-link menu-link collapsed" href="#dash"
                           data-bs-toggle="collapse"
                           role="button" aria-expanded="false" aria-controls="dash">
                            <span data-key="t-dashboards">Dashboard</span>
                        </a>
                        <div class="collapse menu-dropdown" id="dash">
                            <ul class="nav nav-sm flex-column">

                                <li class="nav-item">
                                    <a href="{{route('main-dashboard',$organisation->slug)}}"
                                       class="nav-link {{ Request::routeIs('main-dashboard') ? 'active' : '' }}">
                                        Main Dashboard Trend
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('main-dashboard-2',$organisation->slug)}}"
                                       class="nav-link {{ Request::routeIs('main-dashboard-2') ? 'active' : '' }}">
                                        Main Dashboard Overview
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('income-records-dashboard',$organisation->slug)}}"
                                       class="nav-link {{ Request::routeIs('income-records-dashboard') ? 'active' : '' }}">
                                        Income Received Trend
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('income-records-dashboard-bar-chart',$organisation->slug)}}"
                                       class="nav-link {{ Request::routeIs('income-records-dashboard-bar-chart') ? 'active' : '' }}">
                                        Income Received Overview
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{route('report-dashboard',$organisation->slug)}}"
                                       class="nav-link {{ Request::routeIs('report-dashboard') ? 'active' : '' }}">
                                        Allocation & Utilisation Dashboard
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('hunting-dashboard-district',$organisation->slug)}}"
                                       class="nav-link {{ Request::routeIs('hunting-dashboard-district') ? 'active' : '' }}">
                                        Allocation & Utilisation Dashboard By District
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('hunting-dashboard-species',$organisation->slug)}}"
                                       class="nav-link {{ Request::routeIs('hunting-dashboard-species') ? 'active' : '' }}">
                                        Allocation & Utilisation Dashboard By Species
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('conflict-dashboard',$organisation->slug)}}"
                                       class="nav-link {{ Request::routeIs('conflict-dashboard') ? 'active' : '' }}">
                                        HWC Dashboard
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{route('conflict-dashboard-district',$organisation->slug)}}"
                                       class="nav-link {{ Request::routeIs('conflict-dashboard-district') ? 'active' : '' }}">
                                        HWC Dashboard By District
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('conflict-dashboard-species',$organisation->slug)}}"
                                       class="nav-link {{ Request::routeIs('conflict-dashboard-species') ? 'active' : '' }}">
                                        HWC Dashboard By Species
                                    </a>
                                </li>

                                <!-- Control cases -->
                                <li class="nav-item">
                                    <a href="{{route('control-cases-dashboard',$organisation->slug)}}"
                                       class="nav-link {{ Request::routeIs('control-cases-dashboard') ? 'active' : '' }}">
                                        PAC Dashboard
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{route('control-dashboard-district',$organisation->slug)}}"
                                       class="nav-link {{ Request::routeIs('control-dashboard-district') ? 'active' : '' }}">
                                        PAC Dashboard By District
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{route('control-dashboard-species',$organisation->slug)}}"
                                       class="nav-link {{ Request::routeIs('control-dashboard-species') ? 'active' : '' }}">
                                        PAC Dashboard By Species
                                    </a>
                                </li>


                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a style="font-weight: bolder;" class="nav-link menu-link collapsed" href="#species"
                           data-bs-toggle="collapse"
                           role="button" aria-expanded="false" aria-controls="species">
                            <span data-key="t-dashboards">Wildlife</span>
                        </a>
                        <div class="collapse menu-dropdown" id="species">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{route('organisation.species.index',$organisation->slug)}}"
                                       class="nav-link {{ Request::routeIs('organisation.species*') ? 'active' : '' }}">
                                        Species
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a style="font-weight: bolder;" class="nav-link menu-link collapsed" href="#populationEstimates"
                           data-bs-toggle="collapse"
                           role="button" aria-expanded="false" aria-controls="populationEstimates">
                            <span data-key="t-dashboards">Population Estimates</span>
                        </a>
                        <div class="collapse menu-dropdown" id="populationEstimates">
                            <ul class="nav nav-sm flex-column">

                                <li class="nav-item">
                                    <a href="{{route('organisation.population-estimates.species',$organisation->slug)}}"
                                       class="nav-link {{ Request::routeIs('organisation.population-estimates*') ? 'active' : '' }}">
                                        Manage Population Estimates
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a style="font-weight: bolder;" class="nav-link menu-link collapsed" href="#huntingConcessions"
                           data-bs-toggle="collapse"
                           role="button" aria-expanded="false" aria-controls="huntingConcessions">
                            <span data-key="t-dashboards">Hunting Concession</span>
                        </a>
                        <div class="collapse menu-dropdown" id="huntingConcessions">
                            <ul class="nav nav-sm flex-column">


                                <li class="nav-item">
                                    <a href="{{route('organisation.hunting-concessions.index',$organisation->slug)}}"
                                       class="nav-link {{ Request::routeIs('organisation.hunting-concessions.index*') ? 'active' : '' }}">
                                        Hunting Concessions
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a style="font-weight: bolder;" class="nav-link menu-link collapsed" href="#quotaSetings"
                           data-bs-toggle="collapse"
                           role="button" aria-expanded="false" aria-controls="quotaSetings">
                            <span data-key="t-dashboards">Quota Settings</span>
                        </a>
                        <div class="collapse menu-dropdown" id="quotaSetings">
                            <ul class="nav nav-sm flex-column">


                                <li class="nav-item">
                                    <a href="{{route('organisation.quota-settings.species',$organisation->slug)}}"
                                       class="nav-link {{ Request::routeIs('organisation.quota-settings.species*') ? 'active' : '' }}">
                                        Quota Allocation
                                    </a>
                                </li>


                            </ul>
                        </div>
                    </li>


                    <li class="nav-item">
                        <a style="font-weight: bolder;" class="nav-link menu-link collapsed" href="#huntingClients"
                           data-bs-toggle="collapse"
                           role="button" aria-expanded="false" aria-controls="huntingClients">
                            <span data-key="t-dashboards">Clients</span>
                        </a>
                        <div class="collapse menu-dropdown" id="huntingClients">
                            <ul class="nav nav-sm flex-column">

                                <li class="nav-item">
                                    <a href="{{route('organisation.hunters.index',$organisation->slug)}}"
                                       class="nav-link {{ Request::routeIs('organisation.hunters*') ? 'active' : '' }}">
                                        Manage Clients
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a style="font-weight: bolder;" class="nav-link menu-link collapsed" href="#hunting"
                           data-bs-toggle="collapse"
                           role="button" aria-expanded="false" aria-controls="hunting">
                            <span data-key="t-dashboards">Hunting Activities</span>
                        </a>
                        <div class="collapse menu-dropdown" id="hunting">
                            <ul class="nav nav-sm flex-column">

                                <li class="nav-item">
                                    <a href="{{route('organisation.hunting-activities.index',$organisation->slug)}}"
                                       class="nav-link {{ Request::routeIs('organisation.hunting-activities*') ? 'active' : '' }}">
                                        Manage Hunting Activities
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>


                    <li class="nav-item">
                        <a style="font-weight: bolder;" class="nav-link menu-link collapsed" href="#hwc"
                           data-bs-toggle="collapse"
                           role="button" aria-expanded="false" aria-controls="hwc">
                            <span data-key="t-dashboards">Human Wildlife Conflict </span>
                        </a>
                        <div class="collapse menu-dropdown" id="hwc">
                            <ul class="nav nav-sm flex-column">

                                <li class="nav-item">
                                    <a href="{{route('organisation.incidents.index',$organisation->slug)}}"
                                       class="nav-link {{ Request::routeIs('organisation.incidents.index*') ? 'active' : '' }}">
                                        Human Wildlife Conflict
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a style="font-weight: bolder;" class="nav-link menu-link collapsed" href="#pac"
                           data-bs-toggle="collapse"
                           role="button" aria-expanded="false" aria-controls="pac">
                            <span data-key="t-dashboards">Problem Animal Control </span>
                        </a>
                        <div class="collapse menu-dropdown" id="pac">
                            <ul class="nav nav-sm flex-column">

                                <li class="nav-item">
                                    <a href="{{route('organisation.problem-animal-control.index',$organisation->slug)}}"
                                       class="nav-link {{ Request::routeIs('organisation.problem-animal-control*') ? 'active' : '' }}">
                                        Manage Problem Animal Control
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a style="font-weight: bolder;" class="nav-link menu-link collapsed" href="#poaching"
                           data-bs-toggle="collapse"
                           role="button" aria-expanded="false" aria-controls="poaching">
                            <span data-key="t-dashboards">Poaching Incidents </span>
                        </a>
                        <div class="collapse menu-dropdown" id="poaching">
                            <ul class="nav nav-sm flex-column">

                                <li class="nav-item">
                                    <a href="{{route('organisation.poaching-incidents.index',$organisation->slug)}}"
                                       class="nav-link {{ Request::routeIs('organisation.poaching-incident*') ? 'active' : '' }}">
                                        Poaching Incidents
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a style="font-weight: bolder;" class="nav-link menu-link collapsed" href="#Projects"
                           data-bs-toggle="collapse"
                           role="button" aria-expanded="false" aria-controls="Projects">
                            <span data-key="t-dashboards">Projects </span>
                        </a>
                        <div class="collapse menu-dropdown" id="Projects">
                            <ul class="nav nav-sm flex-column">

                                <li class="nav-item">
                                    <a href="{{route('organisation.projects.index',$organisation->slug)}}"
                                       class="nav-link {{ Request::routeIs('organisation.projects.index') ? 'active' : '' }}">
                                        Community Projects
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a style="font-weight: bolder;" class="nav-link menu-link collapsed" href="#payable"
                           data-bs-toggle="collapse"
                           role="button" aria-expanded="false" aria-controls="payable">
                            <span data-key="t-dashboards">Payments </span>
                        </a>
                        <div class="collapse menu-dropdown" id="payable">
                            <ul class="nav nav-sm flex-column">

                                <li class="nav-item">
                                    <a href="{{route('organisation.transactions.index',$organisation->slug)}}"
                                       class="nav-link {{ Request::routeIs('organisation.transactions.index') ? 'active' : '' }}">
                                        Transactions Payments
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{route('organisation.payable-categories.index',$organisation->slug)}}"
                                       class="nav-link {{ Request::routeIs('organisation.payable-categories.index') ? 'active' : '' }}">
                                        Payable Items
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a style="font-weight: bolder;" class="nav-link menu-link collapsed" href="#reports"
                           data-bs-toggle="collapse"
                           role="button" aria-expanded="false" aria-controls="reports">
                            <span data-key="t-dashboards">Reports </span>
                        </a>
                        <div class="collapse menu-dropdown" id="reports">
                            <ul class="nav nav-sm flex-column">

                                <li class="nav-item">
                                    <a href="{{route('hunting_records.create',$organisation->slug)}}"
                                       class="nav-link {{ Request::routeIs('hunting_records.create') ? 'active' : '' }}">
                                        Quota Allocation & Utilisation
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{route('conflict_records.index',$organisation->slug)}}"
                                       class="nav-link {{ Request::routeIs('conflict_records.index') ? 'active' : '' }}">
                                     HWC Conflict Records
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{route('control_cases.index',$organisation->slug)}}"
                                       class="nav-link {{ Request::routeIs('control_cases.index') ? 'active' : '' }}">
                                    PAC Records
                                    </a>
                                </li>



                            </ul>
                        </div>
                    </li>

                    <!-- Main navigation structure -->
                    <li class="nav-item">
                        <a style="font-weight: bolder;" class="nav-link menu-link collapsed" href="#ChildOrganisations"
                           data-bs-toggle="collapse"
                           role="button" aria-expanded="false" aria-controls="ChildOrganisations">
                            <span data-key="t-dashboards">Sub District Organisations </span>
                        </a>
                        <div class="collapse menu-dropdown" id="ChildOrganisations">
                            <ul class="nav nav-sm flex-column no-bullet">
                                <!-- Include the recursive organisation types component -->
                                @if($organisation && $organisation->organisationType)
                                    <ul class="nav nav-sm flex-column no-bullet">
                                        @include('components.organisation-type-tree', [
                                            'organisationTypes' => $organisation->organisationType->children,
                                            'parentOrganisation' => $organisation
                                        ])
                                    </ul>
                                @endif

                            </ul>
                        </div>
                    </li>



                    <li class="nav-item">
                        <a style="margin: 10px;" class="btn btn-success btn-sm"
                           href="{{route('organisation.dashboard')}}">
                            <span data-key="t-dashboards">Return To Main Dashboard</span>
                        </a>

                    </li>
                    {{--<li class="nav-item">
                        <a style="margin: 10px;" class="btn btn-success btn-sm"
                           href="{{route('test.roles.index',$organisation->slug)}}">
                            <span data-key="t-dashboards">Test Permissions</span>
                        </a>

                    </li>--}}

                </ul>
            </div>
            <!-- Sidebar -->
        </div>
        <!-- SIDEBARD -->

        <div class="sidebar-background"></div>
    </div>
    <!-- Left Sidebar End -->
    <!-- Vertical Overlay-->
    <div class="vertical-overlay"></div>

    <div class="main-content">
        @yield('content')

        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <script>{{date('Y')}}</script>
                        © REGIONAL CBNRM.
                    </div>
                    <div class="col-sm-6">
                        <div class="text-sm-end d-none d-sm-block">
                            Design & Develop by Leading Digital
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!-- end main content-->
</div>
<!-- END layout-wrapper -->

<!--start back-to-top-->
<button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
    <i class="ri-arrow-up-line"></i>
</button>
<!--end back-to-top-->

<!-- JAVASCRIPT -->
<script src="{{asset('administration/assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('administration/assets/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{asset('administration/assets/libs/node-waves/waves.min.js')}}"></script>

<script src="{{asset('administration/assets/libs/feather-icons/feather.min.js')}}"></script>
<script src="{{asset('administration/assets/js/pages/plugins/lord-icon-2.1.0.js')}}"></script>
<script src="{{asset('administration/assets/js/plugins.js')}}"></script>

<!-- list.js min js -->
<script src="{{asset('administration/assets/libs/list.js/list.min.js')}}"></script>
<script src="{{asset('administration/assets/libs/list.pagination.js/list.pagination.min.js')}}"></script>

<!-- App js -->
<script src="{{asset('administration/assets/js/app.js')}}"></script>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script>
    $(document).ready(function () {
        // Iterate over each active nav-link
        $('.nav-link.active').each(function () {
            // Traverse up to find the parent 'menu-link'
            var parentMenuLink = $(this).closest('.collapse').prev('.menu-link');

            // Check if parentMenuLink is found
            if (parentMenuLink.length) {
                // Remove 'collapsed' class, set 'aria-expanded' to true, and add 'active' class
                parentMenuLink.removeClass('collapsed').addClass('active').attr('aria-expanded', 'true');

                // Expand the parent collapse menu
                $(this).closest('.collapse').addClass('show');
            }
        });
    });


    // Wait for the DOM to be fully loaded
    document.addEventListener('DOMContentLoaded', function () {
        // Set a timeout to hide the alerts after 10 seconds
        setTimeout(function () {
            var alertMessages = document.getElementsByClassName('alert-dismissible');
            for (var i = 0; i < alertMessages.length; i++) {
                alertMessages[i].style.display = 'none';
            }
        }, 5000); // 5000 milliseconds = 5 seconds
    });

    function toggleDropdown(dropdownId) {
        // Toggle the dropdown visibility
        var dropdown = document.getElementById(dropdownId);
        if (dropdown.classList.contains('show')) {
            dropdown.classList.remove('show');
        } else {
            dropdown.classList.add('show');
            // Optionally navigate to the link's href after a slight delay
            // setTimeout(() => {
            //     window.location.href = yourLinkHref;
            // }, 300);
        }
    }


</script>

@stack('scripts')

</body>

</html>
