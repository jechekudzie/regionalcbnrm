@extends('layouts.organisation')
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
                        <h4 class="mb-sm-0">{{$huntingActivity->organisation->name}} - Info
                            ({{str_pad($huntingDetail->id, 6, '0', STR_PAD_LEFT)}})</h4>

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

                                    <a class="btn btn-info add-btn"
                                       href="{{route('organisation.hunting-activities.species-details',[$organisation->slug,$huntingActivity->slug])}}"><i
                                            class="fa fa-arrow-left"></i> Back to hunting details species
                                    </a>
                                    <button class="btn btn-success add-btn" data-bs-toggle="modal"
                                            data-bs-target="#showModal"><i
                                            class="fa fa-plus"></i> Add Kill Info
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


                            <h2 style="margin: 10px;">{{$huntingDetail->species->name}}
                                - {{$huntingDetail->huntingActivity->huntingConcession->name}} Concession</h2>

                            <br/>

                            <table style="width: 100%;" id="buttons-datatables"
                                   class="display table table-bordered dataTable no-footer"
                                   aria-describedby="buttons-datatables_info">
                                <thead>
                                <tr>
                                    <th>Species Image</th>
                                    <th>Species</th>
                                    <th>Is Special?</th>
                                    <th>Client</th>
                                    <th>Shot</th>
                                    <th>Shot Outcome</th>
                                    <th>Location</th>
                                    <th>Latitude</th>
                                    <th>Longitude</th>
                                    <th>Pictures</th>
                                    <th>Action</th>
                                    <!-- Add more columns as needed -->
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($huntingDetail->huntingDetailOutComes as $huntingDetailOutCome)
                                    <tr>
                                        <td>
                                            <div class="avatar-md bg-light rounded p-1"><img
                                                    src="{{asset($huntingDetailOutCome->huntingDetail->species->avatar)}}"
                                                    alt="" class="img-fluid d-block"></div>
                                        </td>
                                        <td>{{ $huntingDetailOutCome->huntingDetail->species->name }}</td>
                                        <td>
                                            @if($huntingDetailOutCome->huntingDetail->species->is_special)
                                                <span class="badge bg-danger">Yes</span>
                                            @else
                                                <span class="badge bg-success">No</span>
                                            @endif
                                        </td>
                                        <td>{{ $huntingDetailOutCome->hunter->name}}</td>
                                        <td>{{ $huntingDetailOutCome->shot->name}}</td>
                                        <td>{{ $huntingDetailOutCome->huntingOutCome->name}}</td>
                                        <td>{{ $huntingDetailOutCome->location_of_shot}}</td>
                                        <td>{{ $huntingDetailOutCome->latitude}}</td>
                                        <td>{{ $huntingDetailOutCome->longitude}}</td>
                                        <td>
                                            <a href="#pictureModal" data-bs-toggle="modal"
                                               data-slug="{{ $huntingDetailOutCome->slug }}" class="open-pictures-modal btn btn-info btn-sm">
                                               <i class="fa fa-eye"> </i> View
                                            </a>
                                        </td>
                                        <td>

                                            <form action="{{ route('organisation.hunting-detail-outcome.destroy', [$organisation->slug, $huntingDetailOutCome->slug]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this?');">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash"></i> Delete
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

                    <!-- Modal -->


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
                                        <h4 class="card-title mb-0"> Hunting Outcome Details
                                            ({{$huntingDetail->species->name}})</h4>
                                    </div>
                                    <div class="card-body">

                                        <form id="huntingDetailsForm" method="POST"
                                              action="{{ route('organisation.hunting-detail-outcome.store',[$organisation->slug,$huntingDetail->slug]) }}"
                                              enctype="multipart/form-data">
                                            @csrf

                                            <!-- Hunting Detail ID (Hidden Field if needed) -->
                                            <input type="hidden" name="hunting_detail_id" value="">

                                            <div class="row">
                                                <!-- Hunter Dropdown -->
                                                <div class="form-group col-md-6 mb-2">
                                                    <label for="hunter_id">Client</label>
                                                    <select name="hunter_id" id="hunter_id" class="form-control">
                                                        <!-- Populate with Hunters -->
                                                        <option value="">Select Hunter</option>
                                                        @foreach($huntingActivity->hunters as $hunter)
                                                            <option value="{{$hunter->id}}">{{$hunter->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- Location of Shot -->
                                                <div class="form-group col-md-6 mb-2">
                                                    <label for="location_of_shot">Professional Hunter On-Hunt</label>
                                                    <input type="text" name="professional_hunter"
                                                           id="professional_hunter" class="form-control">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <!-- Shot Type Dropdown -->
                                                <div class="form-group col-md-6 mb-2">
                                                    <label for="shot_id">Shot Type</label>
                                                    <select name="shot_id" id="shot_id" class="form-control">
                                                        <!-- Populate with Shot Types -->
                                                        <option value="">Select Shot Type</option>
                                                        @foreach(\App\Models\Shot::all() as $shot)
                                                            <option value="{{$shot->id}}">{{$shot->name}}</option>
                                                        @endforeach

                                                    </select>
                                                </div>

                                                <!-- Location of Shot -->
                                                <div class="form-group col-md-6 mb-2">
                                                    <label for="location_of_shot">Location of Shot</label>
                                                    <input type="text" name="location_of_shot" id="location_of_shot"
                                                           class="form-control">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <!-- Number of Shots -->
                                                <div class="form-group col-md-6 mb-2">
                                                    <label for="number_of_shots">Number of Shots</label>
                                                    <input type="number" name="number_of_shots" id="number_of_shots"
                                                           class="form-control">
                                                </div>

                                                <!-- Hunting Outcome Dropdown -->
                                                <div class="form-group col-md-6 mb-2">
                                                    <label for="hunting_out_come_id">Hunting Outcome</label>
                                                    <select name="hunting_out_come_id" id="hunting_out_come_id"
                                                            class="form-control">
                                                        <!-- Populate with Hunting Outcomes -->
                                                        <option value="">Select Hunting Outcome</option>
                                                        @foreach(\App\Models\HuntingOutCome::all() as $huntingOutCome)
                                                            <option
                                                                value="{{$huntingOutCome->id}}">{{$huntingOutCome->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <!-- Number of Misses -->
                                                <div class="form-group col-md-6 mb-2">
                                                    <label for="number_of_misses">Number of Misses(optional)</label>
                                                    <input type="number" name="number_of_misses" id="number_of_misses"
                                                           class="form-control">
                                                </div>

                                                <!-- Pictures -->
                                                <div class="form-group col-md-6 mb-2">
                                                    <label for="pictures">Pictures</label>
                                                    <input type="file" name="pictures[]" id="pictures"
                                                           class="form-control" multiple>
                                                </div>


                                            </div>

                                            <div class="row">
                                                <!-- Latitude -->
                                                <div class="form-group col-md-6 mb-2">
                                                    <label for="latitude">Latitude</label>
                                                    <input type="text" name="latitude" id="latitude"
                                                           class="form-control">
                                                </div>

                                                <!-- Longitude -->
                                                <div class="form-group col-md-6 mb-2">
                                                    <label for="longitude">Longitude</label>
                                                    <input type="text" name="longitude" id="longitude"
                                                           class="form-control">
                                                </div>


                                            </div>

                                            <div id="address"></div>
                                            <div id="map" style="height: 300px; width: 100%;"></div>


                                            <!-- Submit Button, kept full width for better visibility -->
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <button type="submit" class="btn btn-primary">Submit Hunting Detail
                                                        Outcome
                                                    </button>
                                                </div>
                                            </div>
                                        </form>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="pictureModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content border-0">
                                <div class="modal-header bg-soft-info p-3">
                                    <h5 class="modal-title" id="exampleModalLabel">Hunting Outcome Pictures</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close" id="close-modal"></button>
                                </div>

                                <div class="modal-body" id="pictureModalBody">
                                    <!-- Pictures will be loaded here -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Picture Modal -->



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

            <script>
                // Define the base URL using Laravel's asset helper in Blade syntax
                var baseUrl = "{{ asset('') }}";

                document.addEventListener('DOMContentLoaded', function () {
                    $('.open-pictures-modal').on('click', function () {
                        var huntingDetailOutCome = $(this).data('slug'); // Get the slug from the clicked element

                        // Use the route that returns the pictures for the given slug
                        var url = "/api/hunting-outcomes/pictures/" + huntingDetailOutCome ;

                        // Fetch the pictures for the given slug
                        fetch(url)
                            .then(response => response.json())
                            .then(data => {
                                var pictures = data.pictures; // Access the pictures array from the response
                                $('#pictureModalBody').empty(); // Clear previous content

                                // Loop through the pictures and append them to the modal body
                                pictures.forEach(function (pictureUrl) {
                                    var fullUrl = baseUrl + pictureUrl; // Prepend the base URL to the picture URL
                                    var img = $('<img>')
                                        .attr('src', fullUrl)
                                        .css({
                                            'width': '250px',
                                            'height': '200px',
                                            'margin': '10px' // Adjust the margin value as needed
                                        })
                                        .addClass('img-fluid');
                                    $('#pictureModalBody').append(img);
                                });


                                // Show the modal
                                $('#pictureModal').modal('show');
                            })
                            .catch(error => console.error('Error fetching pictures:', error));
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
