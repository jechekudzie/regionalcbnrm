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
                        <h4 class="mb-sm-0">{{ $organisation->name }} - Human Wildlife Conflicts</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                <li class="breadcrumb-item active">Human Wildlife Conflicts</li>
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

            <!-- Human Wildlife Conflicts Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addConflictModal">
                                <i class="fa fa-plus"></i> Add New Conflict
                            </button>
                        </div>
                        <div class="card-body">
                            <table id="conflicts-datatable" class="table table-bordered dt-responsive nowrap">
                                <thead>
                                <tr>
                                    <th>Incident #</th>
                                    <th>Title</th>
                                    <th>Year</th>
                                    <th>Date</th>
                                    <th>Species Involved</th>
                                    <th>Incident Types</th>
                                    <th>Incident Outcomes</th>
                                    <th>Problem Animal Control</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                {{-- Loop through conflicts here --}}
                                @foreach($incidents as $incident)
                                    <tr>
                                        <td> {{ sprintf('%04s', $incident->id) }} </td>
                                        <td> {{ $incident->title }} </td>
                                        <td> {{ $incident->year }} </td>
                                        <td> {{ $incident->date }} </td>
                                        <td>
                                            <a href="{{route('organisation.incident-species.index',[$organisation->slug,$incident->slug])}}">Species
                                                ({{ $incident->species->count() }})
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{route('organisation.incident-conflict-types.index',[$organisation->slug,$incident->slug])}}">Conflicts
                                                ({{ $incident->conflictTypes->count() }})</a>

                                        </td>
                                        <td>
                                            <a href="{{route('organisation.incident-outcomes.index',[$organisation->slug,$incident->slug])}}">Outcomes
                                                ({{ $incident->ConflictOutComes->count() }})</a>

                                        </td>

                                        <td>
                                            <a href="{{route('organisation.problem-animal-control.create',[$organisation->slug,$incident->slug])}}"
                                               class="btn btn-primary btn-sm"
                                            >
                                                Problem Animal Control
                                            </a>

                                        </td>

                                        <td>
                                            <a href="#" data-slug="{{$incident->slug}}"
                                               data-title="{{$incident->title}}"
                                               data-latitude="{{$incident->latitude}}"
                                               data-longitude="{{$incident->longitude}}"
                                               data-year="{{$incident->year}}" data-date="{{$incident->date}}"
                                               data-time="{{$incident->time}}"
                                               data-description="{{$incident->description}}"
                                               data-location="{{$incident->location}}"
                                               data-organisation_slug="{{$organisation->slug}}"
                                               class="btn btn-success btn-sm"
                                               data-bs-toggle="modal"
                                               data-bs-target="#updateModal"
                                            >  <i class="fa fa-pencil"></i> Edit
                                            </a>


                                            <a href="{{ route('organisation.incidents.show', [$organisation->slug, $incident->slug]) }}"
                                               class="btn btn-primary btn-sm">
                                                <i class="fa fa-eye"></i> view incident
                                            </a>
                                            <!-- Consider adding Edit/Delete buttons here -->
                                            <form
                                                action="{{ route('organisation.incidents.destroy', [$organisation->slug,$incident->slug]) }}"
                                                method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Are you sure?')"> <i class="fa fa-trash"></i> Delete
                                                </button>
                                            </form>
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
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content border-0">
                        <div class="modal-header bg-soft-info p-3">
                            <h5 class="modal-title" id="exampleModalLabel"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close" id="close-modal"></button>
                        </div>

                        <div class="card border">
                            <div class="card-header">

                                <h4 class="card-title mb-0"> Record an HWC incident </h4>
                            </div>
                            <div class="card-body">

                                <form action="{{ route('organisation.incidents.store', $organisation->slug) }}"
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
                                            <input type="text" class="form-control" id="latitude" name="latitude">
                                        </div>

                                        <!-- Longitude Field -->
                                        <div class="col-md-4 mb-3">
                                            <label for="longitude" class="form-label">Longitude</label>
                                            <input type="text" class="form-control" id="longitude" name="longitude">
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

                                        <div id="address"></div>
                                        <div id="map" style="height: 300px; width: 100%;"></div>

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


            <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content border-0">
                        <div class="modal-header bg-soft-info p-3">
                            <h5 class="modal-title" id="exampleModalLabel"> Update an HWC incident</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close" id="close-modal"></button>
                        </div>

                        <div class="card border">
                            <div class="card-header">

                                <h4 class="card-title mb-0"> Update an HWC incident </h4>
                            </div>
                            <div class="card-body">

                                <form id="mainForm" method="POST">
                                    @csrf <!-- CSRF token for Laravel form submission -->
                                    @method('PATCH')
                                    {{--<input type="hidden" name="_method" value="POST">--}}
                                    <div class="row">
                                        <!-- Title Field -->
                                        <div class="col-md-4 mb-3">
                                            <label for="title" class="form-label">Title</label>
                                            <input type="text" class="form-control" id="title" name="title" required>
                                        </div>


                                        <!-- Latitude Field -->
                                        <div class="col-md-4 mb-3">
                                            <label for="latitude" class="form-label">Latitude</label>
                                            <input type="text" class="form-control" id="latitude" name="latitude">
                                        </div>

                                        <!-- Longitude Field -->
                                        <div class="col-md-4 mb-3">
                                            <label for="longitude" class="form-label">Longitude</label>
                                            <input type="text" class="form-control" id="longitude" name="longitude">
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

    <!-- Your JavaScript code will be here -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const latitudeInput = document.getElementById('latitude');
            const longitudeInput = document.getElementById('longitude');
            const addressDiv = document.getElementById('address');
            let map = null;
            let updateTimeout = null;

            longitudeInput.disabled = latitudeInput.value.trim() === '';

            // Function to update map and address
            function updateMapAndAddress(latitude, longitude) {
                // JavaScript call to your API backend
                fetch(`/api/get-location?lat=${latitude}&lon=${longitude}`)
                    .then(response => response.json())
                    .then(data => {
                        // Display address
                        addressDiv.textContent = data.address;

                        // Initialize or update map
                        if (!map) {
                            map = L.map('map').setView([data.lat, data.lon], 13);
                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                attribution: '© OpenStreetMap contributors'
                            }).addTo(map);
                        } else {
                            map.setView([data.lat, data.lon], 13);
                        }

                        L.marker([data.lat, data.lon]).addTo(map)
                            .bindPopup(data.address)
                            .openPopup();
                    });
            }

            // Enable longitude field when latitude is filled
            latitudeInput.addEventListener('input', function () {
                longitudeInput.disabled = latitudeInput.value.trim() === '';
            });

            // Update map and address on longitude input
            longitudeInput.addEventListener('input', function () {
                const latitude = latitudeInput.value.trim();
                const longitude = longitudeInput.value.trim();

                // Clear previous timeout to ensure this function runs after user has stopped typing
                clearTimeout(updateTimeout);

                // Set a timeout to update the map after the user has stopped typing for 1 second
                updateTimeout = setTimeout(() => {
                    if (latitude !== '' && longitude !== '') {
                        updateMapAndAddress(latitude, longitude);
                    }
                }, 1000); // Adjust timeout as needed
            });
        });

    </script>

@endpush
