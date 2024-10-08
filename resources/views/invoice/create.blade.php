@extends('layouts.master')
@section('content')
<style>
/* Add this CSS to your stylesheet */
.custom-swal {
    width: 300px !important;   /* Set the width */
    height: 350px !important;  /* Set the height */
}

.custom-swal .swal2-popup {
    border-radius: 10px;       /* Optional: round the corners */
    padding: 10px;             /* Optional: add some padding */
}

.custom-swal .swal2-title {
    font-size: 16px;           /* Optional: adjust title size */
}

.custom-swal .swal2-content {
    font-size: 14px;           /* Optional: adjust content size */
}

</style>
<div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCustomerModalLabel">Add New Customer</h5>
      <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
            <h4>Invoice Management</h4>
            <h6>Add/Update Invoice</h6>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('invoiceStore') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
 
             <div class="col-lg-4 col-sm-6 col-12 d-flex align-items-center">
    <div class="form-group flex-grow-1">
        <label for="customer_id">Customer Id</label>
        <select name="customer_id" class="form-select @error('customer_id') @enderror" required>
            <option disabled selected>Select Customer</option>
            @foreach($customers as $key => $customer)
            <option value="{{ $customer->id }}">{{ ucwords($customer->name) }}</option>
            @endforeach
        </select>
        @error('customer_id')
        <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    
  
        <button type="button" class="btn btn-primary btn-sm  " title="Add Customer" data-bs-toggle="modal" data-bs-target="#addCustomerModal">
            +
        </button>
    
</div>


                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="invoice_date">Invoice Date</label>
                            <input type="date" name="invoice_date" class="form-control" required>
                        </div>
                    </div>
                </div>

                <!-- Product Table -->
                <div class="row">
                    <table class="table table-bordered" id="productTable">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Tax</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Existing products will be populated here -->
                        </tbody>
                    </table>
                </div>

                <button type="button" class="btn btn-success" style='margin-top:10px;margin-bottom:25px;' id="addProductRow">+ Add Product</button>

                <div class="row">
                    <div class="col-lg-12">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ route('invoiceIndex') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    // Define the URL for the get-product route

    const getProductUrl = "{{ route('getProduct', ':id') }}"; 
    document.getElementById('addProductRow').addEventListener('click', function() {
        let tableBody = document.querySelector('#productTable tbody');
        let newRow = document.createElement('tr');

        newRow.innerHTML = `
        <td>
            <select class="form-control product-select" name="product_id[]" required>
                <option disabled selected>Select Product</option>
                @foreach($allProducts as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </td>
        <input type="hidden" class="form-control name-input" name="name[]"  >
        <input type="hidden" class="form-control discountprice-input" name="discountprice[]"  >
        <td><input type="number" class="form-control price-input" name="price[]" readonly ></td>
        <td><input type="number" class="form-control stock-input" name="stock[]" readonly min="1"></td>
        <td>
            <select class="form-control tax-input" name="tax[]" readonly required>
                <option value="">0%</option>
                <option value="5">5%</option>
                <option value="8">8%</option>
                <option value="12">12%</option>
                <option value="18">18%</option>
            </select>
        </td>
        <td><input type="number" class="form-control total-input" name="total[]" readonly></td>
        <td><button type="button" class="btn btn-danger btn-sm removeRow">x</button></td>
    `;
        tableBody.appendChild(newRow);

        // Add event listeners for the new row's inputs
        addEventListenersToRow(newRow);
    });

</script>

@endsection
