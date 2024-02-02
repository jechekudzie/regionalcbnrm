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
                        <h4 class="mb-sm-0">{{$organisation->name}} - {{$quotaRequest->species->name}} Ward Quota
                            Distribution</h4>

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
                                       href="{{route('organisation.quota-settings.index',[$organisation->slug,$quotaRequest->species->slug])}}"><i
                                            class="fa fa-arrow-left"></i> Back to quota settings
                                    </a>
                                    <button class="btn btn-success add-btn" data-bs-toggle="modal"
                                            data-bs-target="#showModal"><i
                                            class="fa fa-plus"></i> Distribute Quota
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

                            <div class="align-content-start">
                                <h2>{{$organisation->name}} - {{$quotaRequest->species->name}} Ward Quota
                                    Distribution
                                </h2>
                            </div>
                            <div class="align-content-end">
                                <img width="200" src="{{asset($quotaRequest->species->avatar)}}" alt=""
                                     class="img-fluid d-block"><br/>
                            </div>

                            <br/>
                            <table style="width: 100%;" id="buttons-datatables"
                                   class="display table table-bordered dataTable no-footer"
                                   aria-describedby="buttons-datatables_info">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Ward</th>
                                    <th>Year</th>
                                    <th>Hunting Quota</th>
                                    <th>PAC Quota</th>
                                    <th>Rational Quota</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($quotaRequest->wardQuotaDistributions as $wardQuotaDistribution)
                                    <tr>

                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $wardQuotaDistribution->ward->name }}</td>
                                        <td>{{ $wardQuotaDistribution->quotaRequest->year }}</td>
                                        <td>{{ $wardQuotaDistribution->hunting_quota }}</td>
                                        <td>{{ $wardQuotaDistribution->pac_quota }}</td>
                                        <td>{{ $wardQuotaDistribution->rational_quota }}</td>
                                        <td>
                                            <!-- Edit Button -->
                                            <a href="#" class="edit-ward-link" data-bs-toggle="modal" data-bs-target="#updateWardModal"
                                               data-ward-name="{{$wardQuotaDistribution->ward->name}}"
                                               data-ward-id="{{$wardQuotaDistribution->ward_id}}"
                                               data-hunting-quota="{{$wardQuotaDistribution->hunting_quota}}"
                                               data-pac-quota="{{$wardQuotaDistribution->pac_quota}}"
                                               data-rational-quota="{{$wardQuotaDistribution->rational_quota}}"
                                               data-action-url="{{ route('organisation.ward-quota-distribution.update', [$organisation->slug,$quotaRequest->slug,$wardQuotaDistribution->slug]) }}">Edit</a>


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

                                        <h4 class="card-title mb-0">{{$organisation->name}}
                                            - {{$quotaRequest->species->name}} Ward Quota Distribution</h4>
                                    </div>
                                    <div class="card-body">

                                        <form method="post" action="{{ route('organisation.ward-quota-distribution.store', [$organisation->slug, $quotaRequest->slug]) }}">
                                            @csrf

                                            <!-- Hidden Fields -->
                                            <!-- Hidden Organisation ID -->
                                            <input type="hidden" name="organisation_id" value="{{ $organisation->id }}">

                                            @foreach($organisation->childOrganisations as $ward)
                                                <div class="ward-section mb-4">
                                                    <h5>{{ $ward->name }} Quotas</h5>
                                                    <input type="hidden" name="wards[{{ $ward->id }}][ward_id]" value="{{ $ward->id }}">

                                                    <!-- Quota Fields for each Ward -->
                                                    <div class="row mb-3">
                                                        <div class="col-md-4">
                                                            <label for="wards_{{ $ward->id }}_hunting_quota" class="form-label">Hunting Quota</label>
                                                            <input type="number" class="form-control" id="wards_{{ $ward->id }}_hunting_quota"
                                                                   name="wards[{{ $ward->id }}][hunting_quota]" placeholder="Enter hunting quota"
                                                                   min="0">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="wards_{{ $ward->id }}_pac_quota" class="form-label">PAC Quota</label>
                                                            <input type="number" class="form-control" id="wards_{{ $ward->id }}_pac_quota"
                                                                   name="wards[{{ $ward->id }}][pac_quota]" placeholder="Enter PAC quota" min="0">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="wards_{{ $ward->id }}_rational_quota" class="form-label">Rational Quota</label>
                                                            <input type="number" class="form-control" id="wards_{{ $ward->id }}_rational_quota"
                                                                   name="wards[{{ $ward->id }}][rational_quota]" placeholder="Enter rational quota"
                                                                   min="0">
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                            <!-- Submit Button -->
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <button type="submit" class="btn btn-primary">Submit Quota Distribution</button>
                                                </div>
                                            </div>
                                        </form>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="updateWardModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content border-0">
                                <div class="modal-header bg-soft-info p-3">
                                    <h5 class="modal-title" id="wardName"></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close" id="close-modal"></button>
                                </div>

                                <div class="card border">
                                    <div class="card-header">

                                        <h5 class="modal-title" id="updateWardModalLabel">Update Ward Quota</h5>
                                    </div>
                                    <div class="card-body">

                                        <form id="updateWardForm" method="post">
                                            @csrf
                                            @method('PATCH') <!-- Method Spoofing for PUT request -->
                                            <div class="modal-body">
                                                <!-- Hidden Ward ID -->
                                                <input type="hidden" name="ward_id" id="wardIdField">

                                                <!-- Hunting Quota Field -->
                                                <div class="mb-3">
                                                    <label for="updateHuntingQuota" class="form-label">Hunting Quota</label>
                                                    <input type="number" class="form-control" id="updateHuntingQuota" name="hunting_quota" min="0">
                                                </div>

                                                <!-- PAC Quota Field -->
                                                <div class="mb-3">
                                                    <label for="updatePacQuota" class="form-label">PAC Quota</label>
                                                    <input type="number" class="form-control" id="updatePacQuota" name="pac_quota" min="0">
                                                </div>

                                                <!-- Rational Quota Field -->
                                                <div class="mb-3">
                                                    <label for="updateRationalQuota" class="form-label">Rational Quota</label>
                                                    <input type="number" class="form-control" id="updateRationalQuota" name="rational_quota" min="0">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Update Quota</button>
                                            </div>
                                        </form>
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
                    $('.edit-ward-link').on('click', function() {
                        var wardId = $(this).data('ward-id');
                        var wardName = $(this).data('ward-name');
                        var huntingQuota = $(this).data('hunting-quota');
                        var pacQuota = $(this).data('pac-quota');
                        var rationalQuota = $(this).data('rational-quota');
                        var actionUrl = $(this).data('action-url');

                        // Set form action
                        $('#updateWardForm').attr('action', actionUrl);

                        // Populate form fields
                        $('#wardName').text(wardName);
                        $('#wardIdField').val(wardId);
                        $('#updateHuntingQuota').val(huntingQuota);
                        $('#updatePacQuota').val(pacQuota);
                        $('#updateRationalQuota').val(rationalQuota);
                    });
                });
            </script>

    @endpush
