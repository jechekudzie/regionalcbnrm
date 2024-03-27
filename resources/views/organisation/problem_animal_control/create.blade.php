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

                            <a href="{{route('organisation.incidents.index',[$organisation->slug])}}" class="btn btn-primary" >
                                <i class="fa fa-arrow-left"></i> Back to Human Wild Conflict Incidents
                            </a>
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addConflictModal">
                                <i class="fa fa-plus"></i> Add PAC Incident
                            </button>
                        </div>
                        <div class="card-body">
                            <table id="conflicts-datatable" class="table table-bordered dt-responsive nowrap">
                                <thead>
                                <tr>
                                    <th>HWC Ref#</th>
                                    <th>PAC Ref#</th>
                                    <th>Species</th>
                                    <th>Control Measures</th>
                                    <th>Male Count</th>
                                    <th>Female Count</th>
                                    <th>Location</th>
                                    <th>Date</th>
                                    <th>Remarks</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                {{-- Loop through conflicts here --}}
                                @foreach ($pacDetails as $detail)
                                    <tr>
                                        <td>{{ sprintf('%04s',$detail->problemAnimalControl->incident->id) }}</td>
                                        <td>{{ sprintf('%04s',$detail->id)}}</td>
                                        <td>{{ $detail->species->name }}</td>
                                        <td>
                                            @foreach ($detail->controlMeasures as $measure)
                                                {{ $measure->name }}@if(!$loop->last), @endif
                                            @endforeach
                                        </td>
                                        <!-- Display only the first male_count -->
                                        <td>{{ $detail->controlMeasures->first()->pivot->male_count ?? 'N/A' }}</td>
                                        <!-- Display only the first female_count -->
                                        <td>{{ $detail->controlMeasures->first()->pivot->female_count ?? 'N/A' }}</td>
                                        <!-- Display only the first location -->
                                        <td>{{ $detail->controlMeasures->first()->pivot->location ?? 'N/A' }}</td>
                                        <td>{{ $detail->created_at->format('Y-m-d H:i') }}</td>
                                        <td>{{ $detail->controlMeasures->first()->pivot->remarks ?? 'N/A' }}</td>
                                        <td>
                                            {{-- edit route --}}
                                            <a href="{{route('organisation.problem-animal-control.edit',[$organisation->slug,$detail->id])}}" class="btn btn-primary btn-sm"
                                            >
                                                <i class="fa fa-edit"></i> Edit
                                            </a>

                                        </td>
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
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <div class="modal-content border-0">
                        <div class="modal-header bg-soft-info p-3">
                            <h5 class="modal-title" id="exampleModalLabel"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close" id="close-modal"></button>
                        </div>

                        <div class="card border">
                            <div class="card-header">

                                <h4 class="card-title mb-0"> Record PAC Incident </h4>
                            </div>
                            <div class="card-body">

                                <form
                                    action="{{ route('organisation.problem-animal-control.store', [$organisation->slug, $incident->slug]) }}"
                                    method="POST">
                                    @csrf

                                    @foreach ($incident->species as $specie)
                                        <div class="card mb-3">
                                            <div class="card-header">
                                                <h6>{{ $specie->name }} (Males: {{ $specie->pivot->male_count }},
                                                    Females: {{ $specie->pivot->female_count }})</h6>
                                            </div>
                                            <div class="card-body">
                                                <input type="hidden" name="species[{{ $specie->id }}][species_id]"
                                                       value="{{ $specie->id }}">

                                                <!-- Assuming this is within the loop of species -->
                                                <!-- Assuming this is within the loop of species -->
                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label">Control Measures
                                                        for {{ $specie->name }}</label>
                                                    <div class="row">
                                                        @foreach (\App\Models\ControlMeasure::all() as $index => $measure)
                                                            <!-- Create a new column for every control measure, distributing them across 3 columns -->
                                                            <div class="col-md-4">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                           name="control_measures[{{ $specie->id }}][]"
                                                                           value="{{ $measure->id }}"
                                                                           id="control_measure_{{ $measure->id }}_{{ $specie->id }}">
                                                                    <label class="form-check-label"
                                                                           for="control_measure_{{ $measure->id }}_{{ $specie->id }}">
                                                                        {{ $measure->name }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <!-- Add a line break after every 3 items to ensure 3 columns layout -->
                                                            @if(($index + 1) % 3 == 0)
                                                                <div class="w-100"></div>
                                                                <!-- This creates a line break after every 3 control measures -->
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="mb-3">
                                                            <label for="male_count_{{ $specie->id }}"
                                                                   class="form-label">Male Count</label>
                                                            <input type="number" class="form-control"
                                                                   id="male_count_{{ $specie->id }}"
                                                                   name="species[{{ $specie->id }}][male_count]"
                                                                   placeholder="Male Count">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-3">
                                                            <label for="female_count_{{ $specie->id }}"
                                                                   class="form-label">Female Count</label>
                                                            <input type="number" class="form-control"
                                                                   id="female_count_{{ $specie->id }}"
                                                                   name="species[{{ $specie->id }}][female_count]"
                                                                   placeholder="Female Count">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-3">
                                                            <label for="location_{{ $specie->id }}" class="form-label">Location</label>
                                                            <input type="text" class="form-control"
                                                                   id="location_{{ $specie->id }}"
                                                                   name="species[{{ $specie->id }}][location]"
                                                                   placeholder="Location">
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="latitude_{{ $specie->id }}" class="form-label">Latitude</label>
                                                            <input type="number" class="form-control" step="any"
                                                                   id="latitude_{{ $specie->id }}"
                                                                   name="species[{{ $specie->id }}][latitude]"
                                                                   placeholder="Latitude">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="longitude_{{ $specie->id }}" class="form-label">Longitude</label>
                                                            <input type="number" class="form-control" step="any"
                                                                   id="longitude_{{ $specie->id }}"
                                                                   name="species[{{ $specie->id }}][longitude]"
                                                                   placeholder="Longitude">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="remarks_{{ $specie->id }}"
                                                           class="form-label">Remarks</label>
                                                    <textarea class="form-control" id="remarks_{{ $specie->id }}"
                                                              name="species[{{ $specie->id }}][remarks]" rows="3"
                                                              placeholder="Remarks"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    <button type="submit" class="btn btn-primary">Submit</button>
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
