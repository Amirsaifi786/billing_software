@extends('layouts.master')
@section('content')
@if ($message = Session::get('message'))
<div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ $message }}</strong>
</div>
@endif
<style>
    .small-avatar {
        width: 50px;
        height: 50px;
        object-fit: cover;
        /* Ensures the image fits the dimensions without distortion */
    }

</style>
<div class="content">

    <div class="page-header">
        <div class="page-title">
            <h4>Invoice List</h4>
            <h6>invoice</h6>
        </div>
        {{-- @can('invoice add') --}}

        <div class="page-btn">
            <a href="{{ route('invoiceCreate') }}" class="btn btn-added"><img src="{{ asset('assets/img/icons/plus.svg')}}" alt="img" class="me-1">Add New invoice</a>
        </div>
        {{-- @endcan --}}
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-top">
                <div class="search-set">
                    <div class="search-path">
                        <a class="btn btn-filter" id="filter_search">
                            <img src="{{ asset('assets/img/icons/filter.svg')}}" alt="img">
                            <span><img src="{{ asset('assets/img/icons/closes.svg')}}" alt="img"></span>
                        </a>
                    </div>
                    <div class="search-input">
                        <a class="btn btn-searchset"><img src="{{ asset('assets/img/icons/search-white.svg')}}" alt="img"></a>
                    </div>
                </div>
                <div class="wordset">
                    <ul>
                        <li>
                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"><img src="{{ asset('assets/img/icons/pdf.svg')}}" alt="img"></a>
                        </li>
                        <li>
                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel"><img src="{{ asset('assets/img/icons/excel.svg')}}" alt="img"></a>
                        </li>
                        <li>
                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="print"><img src="{{ asset('assets/img/icons/printer.svg')}}" alt="img"></a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card mb-0" id="filter_inputs">
                <div class="card-body pb-0">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12">
                          
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table  datanew">
                    <thead>
                        <tr>
                            <th>
                                <label class="checkboxs">
                                    <input type="checkbox" id="select-all">
                                    <span class="checkmarks"></span>
                                </label>
                            </th>
                            <th>Id</th>
                            <th>Customer Id</th>
                            <th>Invoice No </th>
                            <th>Invoice Date </th>
                            <th>Invoice total </th>

                            {{-- <th>Product Id</th>
                {{-- <th>Price</th>
                <th>Quantity </th>
                <th>Discount Type</th>
                <th>Total Amount</th> --}}
                            {{--

                            <th>Zip_code</th>
                            <th>Tax_identification_no</th>
                            <th>Account_type</th>
                            <th>Opening_balance</th>
                            <th>Document_no</th>
                            <th>Credit_allowed</th>
                            <th>Remark</th>
                            <th>Avatar</th> --}}
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoices as $key => $invoice)


                        <tr>
                            <td>
                                <label class="checkboxs">
                                    <input type="checkbox">
                                    <span class="checkmarks"></span>
                                </label>
                            </td>

                            <td>{{ $key+1  }}</td>
                            <td>{{ $invoice->customer_id }}</td>
                            <td>{{ $invoice->invoice_no }}</td>
                            <td>{{ $invoice->invoice_date }}</td>
                            <td>{{ $invoice->total_amount }}</td>
                            {{-- <td>{{ $invoice->product_id }}</td>

                            <td>{{ $invoice->price }}</td>
                            <td>{{ $invoice->quantity }}</td>
                            <td>{{ $invoice->discount_type }}%</td>
                            <td>{{ $invoice->total_amount }}</td> --}}
                            {{-- <td>{{ $invoice->due_date }}</td> --}}


                            <td>
                                {{-- <a class="me-3" href="{{ route('invoiceUpdate',$invoice->id) }}">
                                <img src="{{ asset('assets/img/icons/eye.svg')}}" alt="img">
                                </a> --}}
                                {{-- @can('invoice edit') --}}
                                <a class="me-3" title="View PDF {{ $invoice->invoice_no }} " href="{{ route('invoice.download', $invoice->id) }}">
                                    <img src="{{ asset('assets/img/icons/pdf.svg')}}" alt="img"></a>

                                {{-- <a class="me-3" href="{{ route('invoiceEdit',$invoice->id) }}">
                                    <img src="{{ asset('assets/img/icons/edit.svg')}}" alt="img">
                                </a> --}}
                                {{-- @endcan 
                                @can('invoice delete') --}}
                                <a class="confirm-text" href="{{ route('invoiceDestroy',$invoice->id) }}">
                                    <img src="{{ asset('assets/img/icons/delete.svg')}}" alt="img">
                                </a>
                                {{-- @endcan --}}

                            </td>
                        </tr>
                        @endforeach



                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
