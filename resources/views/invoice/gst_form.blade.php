@extends('layouts.master')
@section('content')
{{-- <div class="content">
    <div class="page-header">
        <div class="page-title">
            <h4>Customer Management</h4>
            <h6>Update Customer</h6>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <form action="{{ route('invoiceUpdate',$invoices->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- invoice Details -->
                    <div class="row">
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="invoice_type">Invoice Type</label>
                                <select class="form-control" id="invoice_type" required>
                                    <option value="" disabled selected>Select Type</option>
                                    <option value="GST">GST</option>
                                    <option value="Retail">Retail</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">

                            <div class="form-group">
                                <label for="customer_id">Customer Id</label>
                                <select name="customer_id" class="form-select" required>
                                    <option disabled selected>Select Customer</option>
                                    @foreach($customers as $key => $customer)

                                    <option value="{{ $customer->id }}">{{ $customer->customer_name }}</option>
                                    @endforeach
                                </select>
                                @error('customer_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>





                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="invoice_no">Invoice No<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="invoice_no" value="{{ old('invoice_no',$invoices->invoiceId) }}" required>
                                @error('invoice_no')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="invoice_date">Invoice Date</label>
                                <input type="date" class="form-control" name="invoice_date" value="{{ old('invoice_date',$invoices->invoice_date) }}">
                                @error('invoice_date')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="due_date">Due Date</label>
                                <input type="date" class="form-control" name="due_date" value="{{ old('due_date', $invoices->due_date) }}">
                                @error('due_date')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="bill_to">Bill To</label>
                                <div>
                                    <input type="radio" name="bill_to" value="Cash" required> Cash A/c
                                    <input type="radio" name="bill_to" value="Customer"> Customer A/c
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="state">Place of Supply</label>
                                <select name="state" id="state" class="form-select">
                                    <option disabled selected>Choose State</option>
                                    @foreach ($states as $state)
                                    <option value={{$state->id}} @if(old('state',$invoices->state)==$state->id) selected @endif>{{ $state->name }}</option>
                                    @endforeach
                                </select>
                                @error('state')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">

                            <div class="form-group">
                                <label for="gstin">Customer GSTIN</label>
                                <input type="text" class="form-control" id="gstin" required>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="sold_by">Sold By</label>
                                <select class="form-control" id="sold_by" required>
                                    <option value="" disabled selected>Select Salesperson</option>
                                    <option value="Person1">Person 1</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">

                            <div class="form-group">
                                <label for="payment_mode">Payment Mode</label>
                                <select class="form-control" id="payment_mode" required>
                                    <option value="" disabled selected>Select Payment Mode</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Card">Card</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="discount_rate">discount_rate<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="discount_rate" value="{{ old('discount_rate', $invoices->discount_rate) }}">
                                @error('discount_rate')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="discount_type">discount_type</label>
                                <select name="discount_type" class="form-select" required>
                                    <option disabled selected>Select Discount</option>

                                    <option value="5">5%</option>
                                    <option value="12">12%</option>
                                    <option value="18">18%</option>

                                </select>
                                @error('discount_type')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="total_amount">Total Amount <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="total_amount" value="{{ old('total_amount',$invoices->total_amount) }}" required>
                                @error('total_amount')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-submit me-2">Submit</button>
                            <a href="{{ route('invoiceIndex') }}" class="btn btn-cancel">Cancel</a>
                        </div>
                    </div>






                    <!-- Submit Button -->

                </form>

            </div>
        </div>
    </div>

</div> --}}


<div class="content">
    <div class="page-header">
        <div class="page-title">
            <h4>Invoice Management</h4>
            <h6>Update invoice</h6>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
             
    <form class="form-control" action="{{ route('fetch.gst') }}" method="POST">
        @csrf
          <div class="row">
        <label for="gst_number">GST Number:</label>
        <input type="text" name="gst_number" required>
        <button type="submit">Fetch GST Details</button>
        </div>
    </form>
</div>
</div>
</div>
</div>
@endsection