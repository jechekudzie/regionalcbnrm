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

                                        <button class="btn btn-success add-btn" data-bs-toggle="modal"
                                                data-bs-target="#showModal"><i
                                                class="fa fa-plus"></i> Record New Transaction
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
                                <table style="width: 100%;" id="buttons-datatables"
                                       class="display table table-bordered dataTable no-footer"
                                       aria-describedby="buttons-datatables_info">
                                    <thead>

                                    <tr>
                                        <th>ID</th>
                                        <th>Type</th>
                                        <th>Customer/Donor</th>
                                        <th>Status</th>
                                        <th>Reference</th>
                                        <th>Amount Invoiced</th>
                                        <th>Amount Paid</th>
                                        <th>Balance</th>
                                        <th>Date</th>
                                        <th>Notes</th>
                                        <th>Action</th>
                                    </tr>

                                    </thead>
                                    <tbody>
                                    @foreach($transactions as $transaction)
                                        <tr class="even">
                                            <td class="sorting_1">{{$loop->iteration}}</td>
                                            <td>{{$transaction->transaction_type}}</td>
                                            <td>{{$transaction->customer_or_donor}}</td>
                                            <td>{{$transaction->status}}</td>
                                            <td>{{$transaction->reference_number}}</td>
                                            <td>
                                                @if($transaction->transactionPayables)
                                                    {{$transaction->transactionPayables->sum('price')}}
                                                @else
                                                    0.00
                                                @endif

                                            </td>
                                            <td>
                                                @if($transaction->transactionPayables)
                                                    {{$transaction->transactionPayables->sum('amount')}}
                                                @else
                                                    0.00
                                                @endif

                                            </td>

                                            <td>
                                                @if($transaction->transactionPayables)
                                                    {{$transaction->transactionPayables->sum('balance')}}
                                                @else
                                                    0.00
                                                @endif

                                            </td>
                                            <td>{{$transaction->transaction_date}}</td>
                                            <td>{{$transaction->notes}}</td>
                                            <td>
                                                <a href="{{ route('organisation.transaction-payables.index', [$organisation->slug, $transaction->id]) }}">
                                                    Record Payable Item
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
                                                <h5 class="modal-title" id="exampleModalLabel"></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close" id="close-modal"></button>
                                            </div>

                                            <div class="card border">
                                                <div class="card-header">

                                                    <h4 class="card-title mb-0"> Record Payment</h4>
                                                </div>
                                                <div class="card-body">


                                                    <form action="{{route('organisation.transactions.store',$organisation->slug)}}" method="POST">
                                                        @csrf

                                                        <div class="row">
                                                            <!-- Left Column -->
                                                            <div class="col-md-6">
                                                                <!-- Transaction Type -->
                                                                <div class="form-control mb-3">
                                                                    <label for="transactionType">Transaction Type</label>
                                                                    <select class="form-control" id="transactionType" name="transaction_type">
                                                                        <option value="income">Income</option>
                                                                        <option value="expense">Expense</option>
                                                                    </select>
                                                                </div>

                                                                <!-- Customer/Donor -->
                                                                <div class="form-control mb-3">
                                                                    <label for="customerOrDonor">Customer/Donor</label>
                                                                    <input type="text" class="form-control" id="customerOrDonor" name="customer_or_donor">
                                                                </div>


                                                                <!-- Transaction Date -->
                                                                <div class="form-control mb-3">
                                                                    <label for="transactionDate">Transaction Date</label>
                                                                    <input type="date" class="form-control" id="transactionDate" name="transaction_date">
                                                                </div>

                                                            </div>

                                                            <!-- Right Column -->
                                                            <div class="col-md-6">
                                                                <!-- Reference Number -->
                                                                <div class="form-control mb-3">
                                                                    <label for="referenceNumber">Reference Number</label>
                                                                    <input type="text" class="form-control" id="referenceNumber" name="reference_number">
                                                                </div>

                                                                <!-- Status -->
                                                                <div class="form-control mb-3">
                                                                    <label for="status">Status</label>
                                                                    <select class="form-control" name="status">
                                                                        <option value="pending">Pending</option>
                                                                        <option value="completed">Completed</option>
                                                                        <option value="cancelled">Cancelled</option>
                                                                    </select>
                                                                </div>


                                                            </div>
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


    </script>

@endpush
