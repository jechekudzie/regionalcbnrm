@extends('layouts.organisation')

@push('head')
    <!-- DataTable CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css"/>
@endpush

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- Page Title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Control Cases</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                <li class="breadcrumb-item active">Control Cases</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Page Title -->

            @if(session()->has('errors'))
                @if($errors->any())
                    @foreach($errors->all() as $error)
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> {{ $error }}
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

            <div class="card-header">
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <div class="flex-grow-1">
                        <a class="btn btn-info add-btn" href="{{ route('control_cases.index',$organisation->slug) }}">
                            <i class="fa fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>

                <div class="modal-body">
                    <form action="{{ route('control_cases.store',$organisation->slug) }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <label for="organisation" class="col-md-3 col-form-label">Organisation</label>
                            <div class="col-md-9">
                                <select name="organisation_id" id="organisation" class="form-select">
                                    <option value="">Select Organisation</option>
                                    @foreach($organisations as $organisation)
                                        <option value="{{ $organisation->id }}">{{ $organisation->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="period" class="col-md-3 col-form-label">Period</label>
                            <div class="col-md-9">
                                <select name="period" id="period" class="form-select">
                                    @foreach($years as $year)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <h4>Species Data</h4>
                        <table class="table table-bordered">
                            <tbody>
                            @foreach($species as $specie)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                   value="{{ $specie->id }}" id="specie{{ $specie->id }}"
                                                   name="records[{{ $specie->id }}][species_id]">
                                            <label class="form-check-label"
                                                   for="specie{{ $specie->id }}">{{ $specie->name }}</label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group mb-2">
                                            <span class="input-group-text">Cases</span>
                                            <input type="number" class="form-control"
                                                   name="records[{{ $specie->id }}][cases]" placeholder="0"
                                                   min="0">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group mb-2">
                                            <span class="input-group-text">Killed</span>
                                            <input type="number" class="form-control"
                                                   name="records[{{ $specie->id }}][killed]" placeholder="0"
                                                   min="0">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group mb-2">
                                            <span class="input-group-text">Scared</span>
                                            <input type="number" class="form-control"
                                                   name="records[{{ $specie->id }}][scared]" placeholder="0"
                                                   min="0">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group mb-2">
                                            <span class="input-group-text">Relocated</span>
                                            <input type="number" class="form-control"
                                                   name="records[{{ $specie->id }}][relocated]" placeholder="0"
                                                   min="0">
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Container-Fluid -->
    </div>
@endsection

@push('scripts')
    <!-- DataTable JS -->
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
        $(document).ready(function () {
            $('#controlCasesTable').DataTable({
                dom: 'Bfrtip',
                buttons: ['copy', 'csv', 'excel', 'print', 'pdf']
            });
        });
    </script>
@endpush
