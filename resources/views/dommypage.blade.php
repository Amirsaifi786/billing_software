{{-- <div class="content">
    <div class="page-header">
        <div class="page-title">
            <h4>invoice Management</h4>
            <h6>Add/Update invoice</h6>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <form action="{{ route('invoiceStore') }}" method="POST" enctype="multipart/form-data">
@csrf
<input type="hidden" name="products" id="productsInput">
<div class="row">
    <div class="col-lg-3 col-sm-6 col-12">
        <div class="form-group">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCustomerModal">
                + Customer
            </button>
            <label for="customer_id">Customer Id</label>
            <select name="customer_id" class="form-select  @error('customer_id') @enderror " required>
                <option disabled selected>Select Customer</option>
                @foreach($customers as $key => $customer)
                <option value="{{ $customer->id }}">{{ ucwords($customer->name) }}</option>
                @endforeach
            </select>
            @error('customer_id')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

    </div>


    <div class="col-lg-3 col-sm-6 col-12">
        <div class="form-group">
            <label for="invoice_date">Invoice Date</label>
            <input type="date" class="form-control  @error('invoice_date') @enderror " name="invoice_date" value="{{ old('invoice_date') }}">
            @error('invoice_date')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>


    <div class="row">
        <table class="table table-bordered table-striped" id="productTable">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>stock</th>
                    <th>Tax</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $key => $product)
                <tr>
                    <td>
                        <div class="form-group mb-2">
                            <input type="text" class="form-control" name="name[]" value="{{ $product->name }}" />
                        </div>
                    </td>
                    <td>
                        <div class="form-group mb-2">
                            <input type="number" class="form-control" name="price[]" value="{{ $product->price }}" />
                        </div>
                    </td>
                    <td>
                        <div class="form-group mb-2">
                            <input type="number" class="form-control" name="stock[]" value="{{ $product->stock }}" />
                        </div>
                    </td>
                    <td>

                        <div class="form-group mb-2">
                            <select name="tax[]" id="tax" class="form-control  @error('tax') @enderror " required>
                                <option disabled>Select Discount</option>
                                <option value="0" @if($product->gst == 0) selected @endif>0%</option>
                                <option value="5" @if($product->gst == 5) selected @endif>5%</option>
                                <option value="8" @if($product->gst == 8) selected @endif>8%</option>
                                <option value="12" @if($product->gst == 12) selected @endif>12%</option>
                                <option value="18" @if($product->gst == 18) selected @endif>18%</option>
                            </select>
                            @error('tax')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </td>
                    <td>
                        <div class="form-group mb-2">
                            <input type="number" class="form-control" name="total[]" value="{{ $product->total }}" />

                        </div>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm removeRow">x</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>


    </div>

</div>






<button type="button" class="btn btn-success" id="addProductRow"> + Product</button>

<div class="row">
    <div class="col-lg-12">
        <button type="submit" class="btn btn-submit me-2">Submit</button>
        <a href="{{ route('invoiceIndex') }}" class="btn btn-cancel">Cancel</a>
    </div>
</div>
</form>

</div>
</div>
</div>

</div> --}}{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        /* Add your CSS styles to make it look like the invoice in the image */
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid black; padding: 8px; }
        th { background-color: #f2f2f2; }
        .heading { text-align: center; margin-bottom: 20px; }
        .total-row { font-weight: bold; }
    </style>
</head>
<body>
    <div class="heading">
        <h1>Tax Invoice</h1>
        {{-- <h4>{{ $invoice->company_name }}</h4> --}}
        <p>Phone: {{ $customer->first()->mobile_no }}</p>
    </div>

    <div>


<strong>Bill To:</strong> {{  ucwords($customer->first()->name) }} <br>
<strong>Invoices No:</strong> {{ $invoices->invoice_no }} <br>

        {{-- <strong>Bill To:</strong> {{ $inv->customer_id }} <br>
        {{-- @dd($invoice) --}}

    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Item Name</th>
                <th>HSN/SAC</th>
                <th>Quantity</th>
                <th>Price/Unit</th>
                <th>GST</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
          
            @foreach ($invoiceProducts as $key=> $product)
                <tr>
          
                    <td>{{ $key+1 }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->hsn_sac }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>{{ number_format($product->price, 2) }}</td>
                    <td>{{ number_format($product->tax, 2) }}</td>
                    <td>{{ number_format($product->total, 2) }}</td>
                </tr>
            @endforeach 
        </tbody>
        <tfoot>
           
            <tr class="total-row">
                <td colspan="6" style="text-align:right;">Subtotal</td>
                <td>{{ number_format($invoices->total_amount, 2) }}</td>
            </tr>
            <tr class="total-row">
                <td colspan="6" style="text-align:right;">GST</td>
                <td>{{ number_format($invoices->total_gst, 2) }}</td>
            </tr>
            {{-- <tr class="total-row">
                <td colspan="6" style="text-align:right;">Total</td>
                <td>{{ number_format($invoice->total_amount_with_gst, 2) }}</td>
            </tr> --}}
        </tfoot>
    </table>

    <p>Thank you for your business!</p>
</body>
</html> --}}