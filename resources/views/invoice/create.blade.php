@extends('layouts.master')
@section('content')
<!-- Add Customer Modal -->
<!-- Add Product Button -->
<style>
    .modal-xl {
        max-width: 62%;
    }

</style>


<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel">Add Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="productForm">
                    <div class="table-responsive">
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
                                            <label for="tax">tax</label>
                                            <select name="tax[]" id="tax" class="form-select  @error('tax') @enderror " required>
                                                <option disabled>Select Discount</option>
                                                <option value="0" @if($product->tax== !null ) selected @endif>0%</option>
                                                <option value="5" @if($product->tax== !null )selected @endif>5%</option>
                                                <option value="10" @if($product->tax== !null )selected @endif> 10%</option>
                                                <option value="12" @if($product->tax== !null )selected @endif>12%</option>
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
                        <button type="button" class="btn btn-success" id="addProductRow">Add Product</button>

                    </div>
            
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveProduct">Save Product</button>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript to handle adding and removing rows -->




<div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCustomerModalLabel">Add New Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('invcustomerStore') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Customer Details -->
                    <div class="row">
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="name">Full Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="email">Email ID</label>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                                @error('email')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="mobile_no">Mobile No<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="mobile_no" value="{{ old('mobile_no') }}" required>
                                @error('mobile_no')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea class="form-control" name="address" rows="2" required>{{ old('address') }}</textarea>
                                @error('address')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="zip_code">Zip Code</label>
                                <input type="text" class="form-control" name="zip_code" value="{{ old('zip_code') }}">
                                @error('zip_code')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Choose Country</label>
                                <select name="country" id="country" class="select">
                                    <option selected disabled>Select country</option>
                                    @foreach ($countries as $country)
                                    <option value={{$country->id}} @if(old('country')==$country->id) selected @endif>{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="state">State</label>
                                <select name="state" id="state" class="form-select">
                                    <option disabled selected>Choose State</option>
                                    <!-- Dynamically populate state based on country -->
                                </select>
                                @error('state')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="city">City</label>
                                <select name="city" id="city" class="form-select">
                                    <option disabled selected>Choose City</option>
                                    <!-- Dynamically populate city based on state -->
                                </select>
                                @error('city')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Tax Information -->
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="tax_identification_no">GST NO</label>
                                <input type="text" class="form-control" placeholder="Enter GST NO " name="tax_identification_no" value="{{ old('tax_identification_no') }}">
                                @error('tax_identification_no')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="date_of_birth">Date of Birth</label>
                                <input type="date" class="form-control" name="date_of_birth" value="{{ old('date_of_birth') }}">
                                @error('date_of_birth')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="Remark">Remark<span class="text-danger">*</span></label>
                                <textarea class="form-control" name="remark" rows="3" required>{{ old('remark') }}</textarea>
                                @error('remark')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                    </div>


                    <!-- Submit Button -->
                    <div class="row">
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-submit me-2">Submit</button>
                            <a href="{{ route('customerIndex') }}" class="btn btn-cancel">Cancel</a>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<div class="content">
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
                                    Add Customer
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
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#productModal">
                                    Add Product
                                </button>

                                {{-- <label for="product_id">Product Id</label>
                                <select name="product_id" class="form-select  @error('product_id') @enderror" required>
                                    <option disabled selected>Select Product</option>
                                    @foreach($products as $key => $product)

                                    <option value="{{ $product->id }}">{{ ucwords($product->name )}}</option>
                                @endforeach
                                </select>
                                @error('product_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror --}}
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

                        {{-- <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="price">Product price</label>
                                <input type="number" id="price" class="form-control  @error('price') @enderror" name="price" value="{{ old('price') }}">
                        @error('price')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="form-group">
                    <label for="stock">stock</label>
                    <input type="number" class="form-control  @error('stock') @enderror " id="stock" name="stock" value="{{ old('stock') }}">
                    @error('stock')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="form-group">

                    <select name="discount_type" id="discount_type" class="form-select  @error('discount_type') @enderror " required>
                        <option disabled>Select Discount</option>
                        <option value="0" selected>0%</option>
                        <option value="5">5%</option>
                        <option value="10">10%</option>
                        <option value="12">12%</option>
                    </select>
                    @error('discount_type')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="form-group">
                    <label for="total_amount">Total Amount <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="total_amount" name="total_amount" value="{{ old('total_amount') }}" readonly>
                    @error('total_amount')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div> --}}
            {{-- <div class="col-lg-3 col-sm-6 col-12">
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
                                <label for="item_id">Item</label>
                                <select name="item_id" class="form-control" id="item_id" required>
                                    <option value="" disabled selected>Select Item</option>
                                    @foreach($variable as $key => $value)
                                    <option value="GST">GST</option>
                                    <option value="Retail">Retail</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="invoice_no">Invoice No<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="invoice_no" value="{{ old('invoice_no') }}" required>
            @error('invoice_no')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-lg-3 col-sm-6 col-12">
        <div class="form-group">
            <label for="due_date">Due Date</label>
            <input type="date" class="form-control" name="due_date" value="{{ old('due_date') }}">
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
                <option value={{$state->id}} @if(old('state')==$state->id) selected @endif>{{ $state->name }}</option>
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
                <!-- Add more options -->
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
            <input type="text" class="form-control" name="discount_rate">
            @error('discount_rate')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div> --}}



</div>






<!-- Submit Button -->
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

</div>
{{-- <script>
    document.getElementById('stock').addEventListener('input', calculateTotal);
    document.getElementById('price').addEventListener('input', calculateTotal);
    document.getElementById('discount_type').addEventListener('change', calculateTotal); // Add listener for discount

    function calculateTotal() {
        const stock = document.getElementById('stock').value || 0;
        const price = document.getElementById('price').value || 0;
        const discountType = document.getElementById('discount_type').value || 0;

        // Calculate total price before discount
        const totalPrice = (stock * price).toFixed(2);

        // Calculate discount amount
        const discountAmount = (totalPrice * (discountType / 100)).toFixed(2);

        // Calculate final total after applying discount
        const finalTotal = (totalPrice - discountAmount).toFixed(2);

        // Set the total amount input value
        document.getElementById('total_amount').value = finalTotal;
    }

</script> --}}
{{-- <script>
    document.getElementById('productForm').addEventListener('input', function() {
        let price = parseFloat(document.getElementById('price').value) || 0;
        let stock = parseInt(document.getElementById('stock').value) || 0;
        let taxRate = parseFloat(document.getElementById('tax').value) || 0;

        let subtotal = price * stock;
        let total = subtotal + (subtotal * (taxRate / 100));

        document.getElementById('total').value = total.toFixed(2); // Display the total amount
    });

    /* Handle saving the product using AJAX
    document.getElementById('saveProduct').addEventListener('click', function () {
        let formData = new FormData(document.getElementById('productForm'));

        // Use AJAX to submit the product
        fetch('/save-product', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Do something with the returned data (e.g., update the product list on the form)
                alert('Product added successfully!');
                // Hide the modal
                let modal = bootstrap.Modal.getInstance(document.getElementById('productModal'));
                modal.hide();
            } else {
                alert('Error adding product!');
            }
        });
    });*\


</script> --}}
@endsection
