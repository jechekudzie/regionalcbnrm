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
                        <h4 class="mb-sm-0">Regional CBNRM - DASHBOARD</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                <li class="breadcrumb-item active">DASHBOARD</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row project-wrapper">
                <div class="col-xxl-12">
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm flex-shrink-0">
                                                    <span class="avatar-title bg-soft-primary text-primary rounded-2 fs-2">
                                                        <i data-feather="briefcase" class="text-primary"></i>
                                                    </span>
                                        </div>
                                        <div class="flex-grow-1 overflow-hidden ms-3">
                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-3">Active HWC Cases</p>
                                            <div class="d-flex align-items-center mb-3">
                                                <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value" data-target="2">0</span></h4>
                                            </div>
                                            <p class="text-muted text-truncate mb-0">This month</p>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div>
                        </div><!-- end col -->
                        <div class="col-xl-6">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm flex-shrink-0">
                                                    <span class="avatar-title bg-soft-primary text-primary rounded-2 fs-2">
                                                        <i data-feather="briefcase" class="text-primary"></i>
                                                    </span>
                                        </div>
                                        <div class="flex-grow-1 overflow-hidden ms-3">
                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-3">Active PAC Cases</p>
                                            <div class="d-flex align-items-center mb-3">
                                                <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value" data-target="5">0</span></h4>
                                            </div>
                                            <p class="text-muted text-truncate mb-0">This month</p>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div>
                        </div><!-- end col -->
                    </div><!-- end row -->

                    <div class="row">
                        <div class="col-xl-8 col-lg-8">
                            <div class="card">
                                <div class="card-header border-0 align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Hunting Overview</h4>
                                </div><!-- end card header -->

                                <div class="card-header p-0 border-0 bg-soft-light">
                                </div><!-- end card header -->
                                <div class="card-body p-0 pb-2">
                                    <div>
                                        <div id="projects-overview-chart" data-colors='["--vz-primary", "--vz-warning", "--vz-success"]' dir="ltr" class="apex-charts"></div>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end col -->
                        <div class="col-xl-4 col-lg4">
                            <div class="card card-height-100">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Community Projects</h4>
                                    <div class="flex-shrink-0">
                                        <div class="dropdown card-header-dropdown">
                                            <a class="dropdown-btn text-muted" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                All Time <i class="mdi mdi-chevron-down ms-1"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="#">All Time</a>
                                                <a class="dropdown-item" href="#">Last 7 Days</a>
                                                <a class="dropdown-item" href="#">Last 30 Days</a>
                                                <a class="dropdown-item" href="#">Last 90 Days</a>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- end card header -->

                                <div class="card-body">
                                    <div id="prjects-status" data-colors='["--vz-success", "--vz-primary", "--vz-warning", "--vz-danger"]' class="apex-charts" dir="ltr"></div>
                                    <div class="mt-3">
                                        <div class="d-flex justify-content-center align-items-center mb-4">
                                            <h2 class="me-3 ff-secondary mb-0">258</h2>
                                            <div>
                                                <p class="text-muted mb-0">Total Projects</p>
                                                <p class="text-success fw-medium mb-0">
                                                    <span class="badge badge-soft-success p-1 rounded-circle"><i class="ri-arrow-right-up-line"></i></span> +3 New
                                                </p>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between border-bottom border-bottom-dashed py-2">
                                            <p class="fw-medium mb-0"><i class="ri-checkbox-blank-circle-fill text-success align-middle me-2"></i> Completed</p>
                                            <div>
                                                <span class="text-muted pe-5">3 Projects</span>

                                            </div>
                                        </div><!-- end -->
                                        <div class="d-flex justify-content-between border-bottom border-bottom-dashed py-2">
                                            <p class="fw-medium mb-0"><i class="ri-checkbox-blank-circle-fill text-primary align-middle me-2"></i> In Progress</p>
                                            <div>
                                                <span class="text-muted pe-5">4 Projects</span>

                                            </div>
                                        </div><!-- end -->
                                        <div class="d-flex justify-content-between border-bottom border-bottom-dashed py-2">
                                            <p class="fw-medium mb-0"><i class="ri-checkbox-blank-circle-fill text-warning align-middle me-2"></i> Yet to Start</p>
                                            <div>
                                                <span class="text-muted pe-5">1 Projects</span>

                                            </div>
                                        </div><!-- end -->
                                        <div class="d-flex justify-content-between py-2">
                                            <p class="fw-medium mb-0"><i class="ri-checkbox-blank-circle-fill text-danger align-middle me-2"></i> Cancelled</p>
                                            <div>
                                                <span class="text-muted pe-5">2 Projects</span>

                                            </div>
                                        </div><!-- end -->
                                    </div>
                                </div><!-- end cardbody -->
                            </div><!-- end card -->
                        </div><!-- end col -->
                    </div><!-- end row -->

                    <div class="row">
                        <div class="col-xl-8">
                            <div class="card card-height-100">
                                <div class="card-header d-flex align-items-center">
                                    <h4 class="card-title flex-grow-1 mb-0">Poaching Activities</h4>
                                    <div class="flex-shrink-0">
                                        <a href="javascript:void(0);" class="btn btn-soft-info btn-sm">Export Report</a>
                                    </div>
                                </div><!-- end cardheader -->
                                <div class="card-body">
                                    <div class="table-responsive table-card">
                                        <table class="table table-hover">
                                            <thead class="thead-light">
                                            <tr>
                                                <th scope="col">Species Name</th>
                                                <th scope="col">Total Poached</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>Elephant</td>
                                                <td>3</td>
                                            </tr>
                                            <tr>
                                                <td>Lion</td>
                                                <td>5</td>
                                            </tr>
                                            <tr>
                                                <td>Leopard</td>
                                                <td>2</td>
                                            </tr>
                                            <tr>
                                                <td>Buffalo</td>
                                                <td>7</td>
                                            </tr>
                                            <tr>
                                                <td>Crocodile</td>
                                                <td>1</td>
                                            </tr>
                                            <tr>
                                                <td>Hippo</td>
                                                <td>4</td>
                                            </tr>
                                            <tr>
                                                <td>Hyena - Spotted</td>
                                                <td>6</td>
                                            </tr>
                                            <tr>
                                                <td>Hyena - Brown</td>
                                                <td>8</td>
                                            </tr>
                                            <tr>
                                                <td>Wild Dogs</td>
                                                <td>9</td>
                                            </tr>
                                            <tr>
                                                <td>Jackal</td>
                                                <td>10</td>
                                            </tr>
                                            <tr>
                                                <td>Snakes</td>
                                                <td>2</td>
                                            </tr>
                                            <tr>
                                                <td>Python</td>
                                                <td>6</td>
                                            </tr>
                                            <tr>
                                                <td>Wild Pigs</td>
                                                <td>4</td>
                                            </tr>
                                            <tr>
                                                <td>Antelopes</td>
                                                <td>7</td>
                                            </tr>
                                            <tr>
                                                <td>Quelea Birds</td>
                                                <td>5</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>


                                    <div class="align-items-center mt-xl-3 mt-4 justify-content-between d-flex">
                                        <div class="flex-shrink-0">
                                            <div class="text-muted">Showing <span class="fw-semibold">5</span> of <span class="fw-semibold">25</span> Results </div>
                                        </div>
                                        <ul class="pagination pagination-separated pagination-sm mb-0">
                                            <li class="page-item disabled">
                                                <a href="#" class="page-link">←</a>
                                            </li>
                                            <li class="page-item">
                                                <a href="#" class="page-link">1</a>
                                            </li>
                                            <li class="page-item active">
                                                <a href="#" class="page-link">2</a>
                                            </li>
                                            <li class="page-item">
                                                <a href="#" class="page-link">3</a>
                                            </li>
                                            <li class="page-item">
                                                <a href="#" class="page-link">→</a>
                                            </li>
                                        </ul>
                                    </div>

                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end col -->
                    </div><!-- end row -->
                </div><!-- end col -->

            </div><!-- end row -->




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

    <!-- apexcharts -->
    <script src="{{asset('administration/assets/libs/apexcharts/apexcharts.min.js')}}"></script>

    <!-- projects js -->
    <script src="{{asset('administration/assets/js/pages/dashboard-projects.init.js')}}"></script>

    <!-- App js -->

    <script>
        <!-- datatable js -->
        document.addEventListener("DOMContentLoaded", function () {
            $('#buttons-datatables').DataTable({
                dom: 'Bfrtip',
                buttons: ['copy', 'csv', 'excel', 'print', 'pdf']
            });
        });

        // Assuming you have jQuery available
        $(document).ready(function() {
            // Define the submit button
            var submitButton = $('#submit-button'); // Replace with your actual button ID or class
            submitButton.text('Add New');
            //on load by default name field to be empty
            $('#name').val('');


            // Click event for the edit button
            $('.edit-button').on('click', function() {
                var name = $(this).data('name');
                var description = $(this).data('description');
                var slug = $(this).data('slug');

                // Set form action for update, method to PATCH, and button text to Update
                $('#edit-form').attr('action', '/admin/counting-methods/' + slug + '/update');
                $('input[name="_method"]').val('PATCH');
                submitButton.text('Update');
                // Populate the form for editing
                $('#name').val(name);
                $('#card-title').text('Edit - ' + name + ' Counting Methods');
                $('#page-title').text('Edit - ' + name + ' Counting Methods');
            });

            // Click event for adding a new item
            $('#new-button').on('click', function() {
                // Clear the form, set action for creation, method to POST, and button text to Add New
                $('#edit-form').attr('action', 'admin/counting-methods/store');
                $('input[name="_method"]').val('POST');
                submitButton.text('Add New');
                $('#name').val('');
                $('#card-title').text('Add Counting Methods');
                $('#page-title').text('Add New Counting Methods');
            });
        });



    </script>

@endpush
