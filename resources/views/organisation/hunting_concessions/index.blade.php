@extends('layouts.organisation')
@push('head')

    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css"/>
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css"/>

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet"/>

@endpush
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Hunting Concessions</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">CRM</a></li>
                                <li class="breadcrumb-item active"></li>
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

                                    <button class="btn btn-success add-btn" data-bs-toggle="modal"
                                            data-bs-target="#showModal"><i
                                            class="fa fa-plus"></i> Add Hunting Concession
                                    </button>

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
                    <div class="card">
                        <div class="card-header">
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
                            <h2>{{ $organisation->name  }} - Hunting Concessions</h2>
                            <br/>
                            <table style="width: 100%;" id="buttons-datatables"
                                   class="display table table-bordered dataTable no-footer"
                                   aria-describedby="buttons-datatables_info">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Hectarage</th>
                                    <th>Wards covered</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($huntingConcessions as $huntingConcession)
                                    <tr>
                                        <td>{{ $huntingConcession->name }}</td>
                                        <td>{{ $huntingConcession->hectarage }}</td>
                                        <td>
                                            @if($huntingConcession->wards->count() > 0)
                                                @foreach($huntingConcession->wards as $ward)
                                                    {{ $ward->name }},
                                                @endforeach
                                            @else
                                                {{'No wards covered'}}
                                            @endif
                                        </td>
                                        <td>
                                            <!-- Edit Button -->
                                            <a href="{{ route('organisation.hunting-concessions.edit', [$organisation->slug,$huntingConcession->slug]) }}"
                                               class="btn btn-primary btn-sm">Edit</a>
                                            <!-- Delete Button -->
                                            <form
                                                action="{{ route('organisation.hunting-concessions.destroy', [$organisation->slug,$huntingConcession->slug]) }}"
                                                method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Are you sure?')">Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                        <!--end card-->
                    </div>

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

                                        <h4 class="card-title mb-0"> Hunting Concession</h4>
                                    </div>
                                    <div class="card-body">


                                        <form
                                            action="{{ route('organisation.hunting-concessions.store',$organisation->slug) }}"
                                            method="POST">
                                            @csrf
                                            <!-- Hunting Concession Name -->
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Concession Name</label>
                                                <input type="text" class="form-control" id="name" name="name" required>
                                            </div>

                                            <!-- Hectarage -->
                                            <div class="mb-3">
                                                <label for="hectarage" class="form-label">Hectarage</label>
                                                <input type="text" class="form-control" id="hectarage" name="hectarage">
                                            </div>


                                            <!-- Wards Covered -->
                                            <div class="mb-3">
                                                <label class="form-label">Covered Wards</label>
                                                <div class="row">
                                                    @if($organisation->firstGroupOfChildOrganisations())
                                                        @foreach($organisation->firstGroupOfChildOrganisations() as $ward)
                                                            <div class="col-md-4 col-lg-4">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                           value="{{ $ward->id }}"
                                                                           id="ward_{{ $ward->id }}"
                                                                           name="wards[]">
                                                                    <label class="form-check-label"
                                                                           for="ward_{{ $ward->id }}">
                                                                        {{ $ward->name }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif


                                                </div>
                                            </div>

                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </form>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

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
