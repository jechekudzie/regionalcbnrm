@extends('layouts.organisation')

@push('head')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endpush

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- Page Title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ $organisation->name }} - Poaching Incidents</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                <li class="breadcrumb-item active">Poaching Incidents</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alerts for Messages -->
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

            <!-- Poaching Incidents Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addConflictModal">
                                <i class="fa fa-plus"></i> Add New Poaching Incident
                            </button>
                        </div>
                        <div class="card-body">
                            <table id="conflicts-datatable" class="table table-bordered dt-responsive nowrap">
                                <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Year</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Species Involved</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                {{-- Loop through conflicts here --}}
                                @foreach($poachingIncidents as $poachingIncident)
                                    <tr>
                                        <td> {{ $poachingIncident->title }} </td>
                                        <td> {{ $poachingIncident->year }} </td>
                                        <td> {{ $poachingIncident->date }} </td>
                                        <td> {{ $poachingIncident->time }} </td>
                                        <td>
                                            <a href="{{route('organisation.poaching-incident-species.index',[$organisation->slug,$poachingIncident->slug])}}">Species
                                                ({{ $poachingIncident->species->count() }})
                                            </a>
                                        </td>
                                        <td> Action</td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add Conflict Modal -->
            <div class="modal fade" id="addConflictModal" tabindex="-1" aria-labelledby="exampleModalLabel"
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

                                <h4 class="card-title mb-0"> Record Poaching incident </h4>
                            </div>
                            <div class="card-body">

                                <form action="{{ route('organisation.poaching-incidents.store', $organisation->slug) }}"
                                      method="POST">
                                    @csrf <!-- CSRF token for Laravel form submission -->

                                    <div class="row">
                                        <!-- Title Field -->
                                        <div class="col-md-4 mb-3">
                                            <label for="title" class="form-label">Title</label>
                                            <input type="text" class="form-control" id="title" name="title" required>
                                        </div>


                                        <!-- Latitude Field -->
                                        <div class="col-md-4 mb-3">
                                            <label for="latitude" class="form-label">Latitude</label>
                                            <input type="number" step="any" class="form-control" id="latitude" name="latitude">
                                        </div>

                                        <!-- Longitude Field -->
                                        <div class="col-md-4 mb-3">
                                            <label for="longitude" class="form-label">Longitude</label>
                                            <input type="number" step="any" class="form-control" id="longitude" name="longitude">
                                        </div>

                                    </div>

                                    <div class="row">
                                        <!-- Year -->
                                        <div class="col-md-4 mb-3">
                                            <label for="year" class="form-label">Year</label>
                                            <select class="form-select" id="year" name="year">
                                                <option value="">Select Year</option>
                                                @for ($year = now()->year; $year >= 2015; $year--)
                                                    <option value="{{ $year }}">{{ $year }}</option>
                                                @endfor
                                            </select>
                                        </div>

                                        <!-- Date Field -->
                                        <div class="col-md-4 mb-3">
                                            <label for="date" class="form-label">Date</label>
                                            <input type="date" class="form-control" id="date" name="date">
                                        </div>

                                        <!-- Time Field -->
                                        <div class="col-md-4 mb-3">
                                            <label for="time" class="form-label">Time</label>
                                            <input type="time" class="form-control" id="time" name="time">
                                        </div>

                                        <!-- Location Field -->
                                        <div class="col-md-12 mb-3">
                                            <label for="time" class="form-label">Location</label>
                                            <input type="text" class="form-control" id="location" name="location">
                                        </div>

                                        <!-- Description Field -->
                                        <div class="col-md-12 mb-3">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea class="form-control" id="description" name="description"
                                                      rows="3"></textarea>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="row">
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection

@push('scripts')
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#conflicts-datatable').DataTable({
                dom: 'Bfrtip',
                buttons: ['copy', 'csv', 'excel', 'print', 'pdf']
            });
        });
    </script>
@endpush
