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
                        <h4 class="mb-sm-0" id="page-title">Organisation Payable Items</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">CRM</a></li>
                                <li class="breadcrumb-item active">Organisation Payable Items</li>
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

                                        <a href="{{route('organisation.transactions.index',$organisation->slug)}}" class="btn btn-primary add-btn">
                                            <i class="fa fa-arrow-left"></i> Back
                                        </a>
                                        <button class="btn btn-success add-btn" data-bs-toggle="modal"
                                                data-bs-target="#showModal"><i
                                                class="fa fa-plus"></i> Record Payment
                                        </button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end col-->
                    <div class="col-xxl-12">
                        <div class="card">
                            <div class="card-body">
                                <!--start table-->
                                @if($errors->any())
                                    @foreach($errors->all() as $error)
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong> Errors! </strong> {{ $error }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    @endforeach
                                @endif

                            @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Message!</strong> {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                    </div>
                                @endif
                                <table style="width: 100%;" id="buttons-datatables"
                                       class="display table table-bordered dataTable no-footer"
                                       aria-describedby="buttons-datatables_info">
                                    <thead>

                                    <tr>
                                        <th>ID</th>
                                        <th>Transaction ID</th>
                                        <th>Payable Item</th>
                                        <th>Currency</th>
                                        <th>Billable Price</th>
                                        <th>Amount Paid</th>
                                        <th>Balance</th>
                                        <th>Status</th>
                                        <th>Reference</th>
                                        <th>Species</th>

                                        <th>Date</th>
                                        <th>Notes</th>
                                        <th>Action</th>
                                    </tr>

                                    </thead>
                                    <tbody>
                                    @foreach($transactionPayables as $transactionPayable)
                                        <tr class="even">
                                            <td class="sorting_1">{{$loop->iteration}}</td>
                                            <td>{{$transactionPayable->transaction_id}}</td>
                                            <td>{{$transactionPayable->organisationPayableItem->payableItem->name}}</td>
                                            <td>{{$transaction->currency}}</td>
                                            <td>
                                                @if($transactionPayable->organisationPayableItem->price)
                                                    {{ $transactionPayable->price }}
                                                @else
                                                    @foreach($transactionPayable->organisationPayableItem->species as $transactionPayableSpecies)
                                                        {{ $transactionPayableSpecies->pivot->price }} ({{ $transactionPayableSpecies->name }})
                                                        @if(!$loop->last)
                                                            ,
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </td>

                                            <td>{{$transactionPayable->amount}}</td>
                                            <td>{{$transactionPayable->balance}}</td>
                                            <td>{{$transactionPayable->status}}</td>
                                            <td>{{$transactionPayable->reference_number}}</td>
                                            <td>
                                                @if($transactionPayable->organisationPayableItem->species->isNotEmpty())
                                                    @foreach($transactionPayable->organisationPayableItem->species as $transactionPayableSpecies)
                                                        {{ $transactionPayableSpecies->name }}
                                                        @if(!$loop->last)
                                                            ,
                                                        @endif
                                                    @endforeach
                                                @else
                                                    N/A
                                                @endif
                                            </td>

                                            <td>{{$transactionPayable->transaction_date}}</td>
                                            <td>{{$transactionPayable->notes}}</td>
                                            <td>
                                                <a href="{{ route('organisation.transaction-payables.index', [$organisation->slug, $transactionPayable->id]) }}">
                                                  Clear Payment
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <!--end table-->

                                <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                     aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content border-0">
                                            <div class="modal-header bg-soft-info p-3">
                                                <h5 class="modal-title" id="exampleModalLabel"> Record Payment</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close" id="close-modal"></button>
                                            </div>

                                            <div class="card border">
                                                <div class="card-header">

                                                    <h4 class="card-title mb-0"> Choose a  payable</h4>
                                                </div>
                                                <div class="card-body">


                                                    <form style="margin: 20px;" action="{{ route('organisation.transaction-payables.store',[$organisation->slug,$transaction->id]) }}" method="POST">
                                                        @csrf

                                                        <!-- Organisation Payable Item Selection -->
                                                        <div class="form-group">
                                                            <label for="organisation_payable_item_id">Payable Item</label>
                                                            {{-- Ensure this is wrapped within a <form> element and that $organisationPayableItems is defined and passed to the view --}}
                                                            <select name="organisation_payable_item_id" id="organisation_payable_item_id" class="form-control mb-2" required>
                                                                <option value="">Select Payable Item</option>
                                                                @foreach($organisationPayableItems as $item)
                                                                    <option value="{{ $item->id }}"
                                                                            data-price="{{ $item->price ?? $item->species->first()->pivot->price ?? '0' }}"
                                                                            data-has-species="{{ $item->species->isNotEmpty() ? 'true' : 'false' }}"
                                                                            data-species-id="{{ $item->species->first()->id ?? '' }}">
                                                                        {{ $item->payableItem->name }}
                                                                        @if($item->price)
                                                                            (General Price: {{ $item->price }})
                                                                        @elseif($item->species->first())
                                                                            (Species: {{ $item->species->first()->name }} Price: {{ $item->species->first()->pivot->price }})
                                                                        @else
                                                                            (No Price Set)
                                                                        @endif
                                                                    </option>
                                                                @endforeach
                                                            </select>

                                                        </div>

                                                        <!-- Species Selection (Optional) -->
                                                        <div class="form-group">
                                                            <label for="species_id">Species (Optional)</label>
                                                            <select name="species_id" id="species_id" class="form-control mb-2">
                                                                <option value="">None</option>
                                                                @foreach($species as $specie)
                                                                    <option value="{{ $specie->id }}">{{ $specie->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <!-- Price Field -->
                                                        <div class="form-group">
                                                            <label for="price">Price Per Item</label>
                                                            <input type="number" step="0.01" name="price" id="price" class="form-control mb-2" required readonly>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="amount">Amount Paid</label>
                                                            <input type="number" step="0.01" name="amount" id="amount" class="form-control mb-2" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="payment_method">Payment Method</label>
                                                            <select name="payment_method" id="payment_method" class="form-control mb-2" required>
                                                                <option value="">Select Payment Method</option>
                                                                <option value="cash">Cash</option>
                                                                <option value="bank_transfer">Bank Transfer</option>
                                                                <option value="mobile_money">Mobile Money</option>

                                                            </select>
                                                        </div>
                                                        <!-- Notes, spanning full width below the two columns -->
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-control mb-3">
                                                                    <label for="notes">Notes</label>
                                                                    <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Submit Button -->
                                                        <div class="form-group">
                                                            <button type="submit" class="btn btn-primary">Add Payable Item</button>
                                                        </div>
                                                    </form>



                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end col-->

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

        document.addEventListener('DOMContentLoaded', function() {
            const payableItemSelect = document.getElementById('organisation_payable_item_id');
            const speciesSelect = document.getElementById('species_id');
            const priceInput = document.getElementById('price');

            payableItemSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const price = selectedOption.getAttribute('data-price') || '0';
                const hasSpecies = selectedOption.getAttribute('data-has-species') === 'true';
                const speciesId = selectedOption.getAttribute('data-species-id') || '';

                // Update the price input
                priceInput.value = price;

                // Remove any previous 'readonly' workaround
                speciesSelect.style.backgroundColor = ""; // Reset background color
                speciesSelect.onmousedown = function() { return true; }; // Allow opening the dropdown

                if (hasSpecies) {
                    // Pre-select the species if a specific species id is provided
                    if (speciesId) {
                        speciesSelect.value = speciesId;

                        // Apply a 'readonly' workaround to make the species dropdown appear read-only
                        speciesSelect.style.backgroundColor = "#e9ecef"; // Make it look disabled or read-only
                        speciesSelect.onmousedown = function() { return false; }; // Prevent opening the dropdown
                    }
                } else {
                    speciesSelect.value = ''; // Reset species selection if no associated species
                }
            });
        });

    </script>



@endpush
