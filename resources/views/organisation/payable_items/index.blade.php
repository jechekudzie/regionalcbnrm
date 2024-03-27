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
                        <h4 class="mb-sm-0" id="page-title">{{$category->name}} - Payable Items</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">CRM</a></li>
                                <li class="breadcrumb-item active">{{$category->name}} Payable Items</li>
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

                                        <a href="{{route('organisation.payable-categories.index',$organisation->slug)}}" class="btn btn-info btn-sm add-btn">
                                            <i class="fa fa-arrow-left"></i> Back
                                        </a>
                                        <button id="new-button" class="btn btn-success btn-sm add-btn">
                                            <i class="fa fa-plus"></i> Add new
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end col-->
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
                    <div class="col-xxl-9">
                        <div class="card">
                            <div class="card-body">
                                <!--start table-->
                                <table style="width: 100%;" id="buttons-datatables"
                                       class="display table table-bordered dataTable no-footer"
                                       aria-describedby="buttons-datatables_info">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Payable Item</th>
                                        <th>Price</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($organisation->organisationPayableItems as $organisationPayableItem)
                                        @if($organisationPayableItem->payableItem->category_id == $category->id)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $organisationPayableItem->payableItem->name ?? 'N/A' }}</td>
                                                <td>
                                                    @if($organisationPayableItem->price)
                                                        {{ $organisationPayableItem->price }}
                                                    @else
                                                        @foreach($organisationPayableItem->species as $species)
                                                            {{ $species->pivot->price }} ({{ $species->name }})
                                                            @if(!$loop->last)
                                                                ,
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="javascript:void(0);"
                                                       class="edit-button btn btn-sm btn-primary"
                                                       data-category-name="{{ $category->name }}"
                                                       data-category-slug="{{ $category->slug }}"
                                                       data-id="{{ $organisationPayableItem->id }}"
                                                       data-slug="{{ $organisationPayableItem->slug }}"
                                                       data-amount="{{ $organisationPayableItem->price }}"
                                                       data-description="{{ $organisationPayableItem->description }}"
                                                       title="Edit"> <i class="fa fa-pencil"></i>
                                                    </a>
                                                    <form action="" method="POST"
                                                          onsubmit="return confirm('Are you sure?');"
                                                          style="display: inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                                title="Delete">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                                <!--end table-->
                            </div>
                        </div>
                    </div>
                    <!--end col-->
                    <div class="col-xxl-3">
                        <div class="card border card-border-light">
                            <div class="card-header">
                                <h6 id="card-title" class="card-title mb-0">Add {{$category->name}} - Payable Items</h6>
                            </div>
                            <div class="card-body">
                                <form id="edit-form"
                                      action="{{route('organisation.payable-items.store',[$organisation->slug,$category->slug])}}"
                                      method="post" enctype="multipart/form-data">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="payable_item_id" class="form-label">Payable Item</label>
                                        <select name="payable_item_id" class="form-control" id="payable_item_id">
                                            <option value="">Choose Payable Item</option>
                                            @foreach($payableItems as $payableItem)
                                                <option value="{{ $payableItem->id }}">{{ $payableItem->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="amount" class="form-label">Price</label>
                                        <input type="number" step="0.01" value="0.00" name="price" class="form-control"
                                               id="amount" placeholder="Enter price">
                                    </div>


                                    <!-- Species Checkbox -->
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="forSpeciesCheckbox">
                                            <label class="form-check-label" for="forSpeciesCheckbox">For Species (Optional)</label>
                                        </div>
                                    </div>
                                    <!-- Profession Dropdown, initially hidden -->
                                    <div class="mb-3" id="speciesDropdown" style="display: none;">
                                        <label for="species_id" class="form-label">Species</label>
                                        <select name="species_id" class="form-control" id="species_id">
                                            <option value="">Select Species</option>
                                            @foreach(\App\Models\Species::all() as $species)
                                                <option value="{{ $species->id }}">{{ $species->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>



                                    <div class="text-end">
                                        <button type="submit" id="submit-button" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>

                                <script>
                                    // JavaScript to toggle the display of the profession dropdown

                                </script>

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

        // Assuming you have jQuery available
        $(document).ready(function () {
            // Define the submit button
            var submitButton = $('#submit-button'); // Replace with your actual button ID or class
            submitButton.text('Add New');
            //on load by default name field to be empty
            $('#name').val('');

            $('#forSpeciesCheckbox').change(function () {
                if ($(this).is(':checked')) {
                    $('#speciesDropdown').show();
                } else {
                    $('#speciesDropdown').hide();
                    $('#species_id').val(''); // Reset the profession selection
                }
            });

            // Click event for the edit button
            $('.edit-button').on('click', function () {
                var categoryName = $(this).data('category-name');
                var categorySlug = $(this).data('category-slug');
                var name = $(this).data('name');
                var amount = $(this).data('amount');
                var slug = $(this).data('slug');
                var currencyId = $(this).data('currency');
                var description = $(this).data('description');

                // Set form action
                $('#edit-form').attr('action', '/fees-categories/' + categorySlug + '/items/' + slug + '/update');

                // Change form method to PATCH for update operation
                $('input[name="_method"]').val('PATCH');

                // Update submit button text to 'Update'
                $('#submit-button').text('Update');

                // Populate the form fields for editing
                $('#name').val(name);
                $('#amount').val(amount);
                $('#currency_id').val(currencyId);
                $('#description').val(description);

                // Update the card and page titles
                $('#card-title').text('Edit - ' + name);
                $('#page-title').text('Edit - ' + name);
            });

        });


    </script>

@endpush
