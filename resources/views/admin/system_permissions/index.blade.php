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
                        <h4 class="mb-sm-0">Practitioners</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">CRM</a></li>
                                <li class="breadcrumb-item active">Practitioners</li>
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

                                        <a href="" class="btn btn-info add-btn">
                                            <i class="fa fa-arrow-left"></i> Back
                                        </a>

                                        <a href="" class="btn btn-info add-btn">
                                            <i class="fa fa-plus"></i> Add Direct
                                        </a>

                                        <button class="btn btn-info add-btn" data-bs-toggle="modal"
                                                data-bs-target="#showModal">
                                            <i class="fa fa-plus"></i> Add Modal
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end col-->
                    <div class="col-xxl-9">
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
                                            style="width: 224.4px;">Name
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="buttons-datatables"
                                            rowspan="1" colspan="1"
                                            aria-label="Position: activate to sort column ascending"
                                            style="width: 336.4px;">Position
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="buttons-datatables"
                                            rowspan="1" colspan="1"
                                            aria-label="Office: activate to sort column ascending"
                                            style="width: 164.4px;">Office
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="buttons-datatables"
                                            rowspan="1" colspan="1"
                                            aria-label="Age: activate to sort column ascending"
                                            style="width: 83.4px;">Age
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="buttons-datatables"
                                            rowspan="1" colspan="1"
                                            aria-label="Start date: activate to sort column ascending"
                                            style="width: 156.4px;">Start date
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="buttons-datatables"
                                            rowspan="1" colspan="1"
                                            aria-label="Salary: activate to sort column ascending"
                                            style="width: 112.4px;">Salary
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="even">
                                        <td class="sorting_1">Brielle Williamson</td>
                                        <td>Integration Specialist</td>
                                        <td>New York</td>
                                        <td>61</td>
                                        <td>2012/12/02</td>
                                        <td>$372,000</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <!--end table-->
                            </div>

                            <!--start modal-->
                            <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                 aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content border-0">
                                        <div class="modal-header bg-soft-info p-3">
                                            <h5 class="modal-title" id="exampleModalLabel"></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close" id="close-modal"></button>
                                        </div>
                                        <form action="">
                                            <div class="modal-body">
                                                <input type="hidden" id="id-field"/>
                                                <div class="row g-3">
                                                    <div class="col-lg-12">
                                                        <div class="text-center">
                                                            <div class="position-relative d-inline-block">
                                                                <div class="position-absolute bottom-0 end-0">
                                                                    <label for="company-logo-input" class="mb-0"
                                                                           data-bs-toggle="tooltip"
                                                                           data-bs-placement="right"
                                                                           title="Select Image">
                                                                        <div class="avatar-xs cursor-pointer">
                                                                            <div
                                                                                class="avatar-title bg-light border rounded-circle text-muted">
                                                                                <i class="ri-image-fill"></i>
                                                                            </div>
                                                                        </div>
                                                                    </label>
                                                                    <input class="form-control d-none" value=""
                                                                           id="company-logo-input" type="file"
                                                                           accept="image/png, image/gif, image/jpeg">
                                                                </div>
                                                                <div class="avatar-lg p-1">
                                                                    <div
                                                                        class="avatar-title bg-light rounded-circle">
                                                                        <img
                                                                            src="administration/assets/images/users/multi-user.jpg"
                                                                            id="companylogo-img"
                                                                            class="avatar-md rounded-circle object-cover"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <h5 class="fs-13 mt-3">Company Logo</h5>
                                                        </div>
                                                        <div>
                                                            <label for="companyname-field"
                                                                   class="form-label">Name</label>
                                                            <input type="text" id="companyname-field"
                                                                   class="form-control"
                                                                   placeholder="Enter company name" required/>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div>
                                                            <label for="owner-field" class="form-label">Owner
                                                                Name</label>
                                                            <input type="text" id="owner-field" class="form-control"
                                                                   placeholder="Enter owner name" required/>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div>
                                                            <label for="industry_type-field" class="form-label">Industry
                                                                Type</label>
                                                            <select class="form-select" id="industry_type-field">
                                                                <option value="">Select industry type</option>
                                                                <option value="Computer Industry">Computer
                                                                    Industry
                                                                </option>
                                                                <option value="Chemical Industries">Chemical
                                                                    Industries
                                                                </option>
                                                                <option value="Health Services">Health Services
                                                                </option>
                                                                <option value="Telecommunications Services">
                                                                    Telecommunications Services
                                                                </option>
                                                                <option value="Textiles: Clothing, Footwear">
                                                                    Textiles: Clothing, Footwear
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div>
                                                            <label for="star_value-field"
                                                                   class="form-label">Rating</label>
                                                            <input type="text" id="star_value-field"
                                                                   class="form-control" placeholder="Enter rating"
                                                                   required/>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div>
                                                            <label for="location-field"
                                                                   class="form-label">Location</label>
                                                            <input type="text" id="location-field"
                                                                   class="form-control" placeholder="Enter location"
                                                                   required/>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div>
                                                            <label for="employee-field"
                                                                   class="form-label">Employee</label>
                                                            <input type="text" id="employee-field"
                                                                   class="form-control" placeholder="Enter employee"
                                                                   required/>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div>
                                                            <label for="website-field"
                                                                   class="form-label">Website</label>
                                                            <input type="text" id="website-field"
                                                                   class="form-control" placeholder="Enter website"
                                                                   required/>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div>
                                                            <label for="contact_email-field" class="form-label">Contact
                                                                Email</label>
                                                            <input type="text" id="contact_email-field"
                                                                   class="form-control"
                                                                   placeholder="Enter contact email" required/>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div>
                                                            <label for="since-field"
                                                                   class="form-label">Since</label>
                                                            <input type="text" id="since-field" class="form-control"
                                                                   placeholder="Enter since" required/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="hstack gap-2 justify-content-end">
                                                    <button type="button" class="btn btn-light"
                                                            data-bs-dismiss="modal">Close
                                                    </button>
                                                    <button type="submit" class="btn btn-success" id="add-btn">Add
                                                        Company
                                                    </button>
                                                    <button type="button" class="btn btn-success" id="edit-btn">
                                                        Update
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!--end add modal-->
                        </div>
                    </div>
                    <!--end col-->
                    <div class="col-xxl-3">
                        <div class="card border card-border-light">
                            <div class="card-header">
                                <h6 class="card-title mb-0">Heading</h6>
                            </div>
                            <div class="card-body">

                                <form action="">
                                    <div class="mb-3">
                                        <label for="employeeName" class="form-label">Employee Name</label>
                                        <input type="text" class="form-control" id="employeeName" placeholder="Enter emploree name">
                                    </div>

                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary">Add Leave</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!--end col-->
                    <!--end card-->
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

    </script>

@endpush
