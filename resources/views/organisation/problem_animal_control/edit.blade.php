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
                        <h4 class="mb-sm-0">{{ $organisation->name }} - Problem Animal Control ({{$incident->title}}
                            )</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                <li class="breadcrumb-item active">Problem Animal Control</li>
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

            <!-- Problem Animal Control Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{route('organisation.problem-animal-control.create',[$organisation->slug,$incident->slug])}}" class="btn btn-primary" >
                                <i class="fa fa-arrow-left"></i> Back to PAC Incident
                            </a>

                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addConflictModal">
                                <i class="fa fa-plus"></i> Add PAC Incident
                            </button>
                        </div>
                        <div class="card-body">
                            {{-- Assuming you have a route like "organisation.problem-animal-control.edit-species" that takes a species ID --}}
                            <form action="{{ route('organisation.problem-animal-control.update-species-detail', [$organisation->slug, $detail->id]) }}" method="POST">
                                @csrf
                                @method('PATCH') {{-- Use PUT method for update operations --}}

                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h6>Edit Details for Species #{{ $detail->species_id }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <input type="hidden" name="detail_id" value="{{ $detail->id }}">

                                        <div class="mb-3">
                                            <label class="form-label">Control Measures</label>
                                            <div class="row">
                                                @foreach (\App\Models\ControlMeasure::all() as $measure)
                                                    <div class="col-md-4">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="control_measures[]" value="{{ $measure->id }}" id="control_measure_{{ $measure->id }}" {{ $detail->controlMeasures->contains('id', $measure->id) ? 'checked' : '' }}>

                                                            <label class="form-check-label" for="control_measure_{{ $measure->id }}">
                                                                {{ $measure->name }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="male_count" class="form-label">Male Count</label>
                                                    <input type="number" class="form-control" id="male_count" name="male_count" placeholder="Male Count" value="{{ $detail->controlMeasures->first()->pivot->male_count }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="female_count" class="form-label">Female Count</label>
                                                    <input type="number" class="form-control" id="female_count" name="female_count" placeholder="Female Count" value="{{ $detail->controlMeasures->first()->pivot->female_count }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="location" class="form-label">Location</label>
                                                    <input type="text" class="form-control" id="location" name="location" placeholder="Location" value="{{ $detail->controlMeasures->first()->pivot->location }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="latitude" class="form-label">Latitude</label>
                                                    <input type="number" class="form-control" step="any" id="latitude" name="latitude" placeholder="Latitude" value="{{ $detail->controlMeasures->first()->pivot->latitude }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="longitude" class="form-label">Longitude</label>
                                                    <input type="number" class="form-control" step="any" id="longitude" name="longitude" placeholder="Longitude" value="{{ $detail->controlMeasures->first()->pivot->longitude }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="remarks" class="form-label">Remarks</label>
                                            <textarea class="form-control" id="remarks" name="remarks" rows="3" placeholder="Remarks">{{ $detail->controlMeasures->first()->pivot->remarks }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>

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

        $(document).ready(function () {
            $('#updateModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal

                // Extract info from data-* attributes
                var slug = button.data('slug');
                var title = button.data('title');
                var latitude = button.data('latitude');
                var longitude = button.data('longitude');
                var year = button.data('year');
                var date = button.data('date');
                var time = button.data('time');
                var location = button.data('location');
                var description = button.data('description');
                var organisationSlug = button.data('organisation_slug');

                // Assuming you have form fields with IDs corresponding to these data attributes
                // Update the modal's content with the data attributes
                var modal = $(this);
                modal.find('#title').val(title);
                modal.find('#latitude').val(latitude);
                modal.find('#longitude').val(longitude);
                modal.find('#year').val(year);
                modal.find('#date').val(date);
                modal.find('#time').val(time);
                modal.find('#location').val(location);
                modal.find('#description').val(description);

                // Update form action URL
                $('#mainForm').attr('action', '/' + organisationSlug + '/incidents/' + slug + '/update');

            });
        });

    </script>
@endpush
