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
                            <input type="hidden" name="total_discount" id="total_discount">

 
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
                  
                              <div class="total-order">
    <ul>
                <li>  
                    <div class="col-lg-4">
                        <label>Discount ₹</label>
                        <input class="form-control" name="discountR" type="number" min="0" id="discountR">
                    </div>
                    <div class="col-lg-4" style="padding-left:30px;">
                        <label>Discount %</label>
                        <input class="form-control" name="discountP" type="number" max="100" min="0" id="discountP">
                    </div>
                    <div class="col-lg-4" style="padding-left:30px;">
                        <label>Discount Amount</label>
                        <input class="form-control" readonly name="discountA" type="number" id="discountA">
                    </div>
                </li>
        {{-- <li>
            <h4>Discount</h4>
            <h5 id="displayDiscount">$ 0.00</h5>
        </li> --}}
        <li class="total">
            <h4>Grand Total</h4>
            <h5 id="displayGrandTotal">$ 0.00</h5>
        </li>
    </ul>
</div>

                                
                            </div>
                        </div>
                      
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
    <td><input type="number" class="form-control price-input" name="price[]" readonly></td>
    <td><input type="number" class="form-control stock-input" name="stock[]" readonly min="1"></td>
    <td>
        <select class="form-control tax-input" name="tax[]" required>
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
    addEventListenersToRow(newRow);
});

function addEventListenersToRow(row) {
    const productSelect = row.querySelector('.product-select');
    productSelect.addEventListener('change', function() {
        const productId = this.value;

        // Check for existing product in other rows
        const allProductSelects = document.querySelectorAll('.product-select');
        let productExists = false;

        allProductSelects.forEach(select => {
            if (select !== productSelect && select.value === productId) {
                productExists = true; // Set flag if product is found
            }
        });

        if (productExists) {
            // Show SweetAlert if product already exists
            Swal.fire({
                icon: 'warning',
                title: 'Product Already Exists',
                text: 'This product is already selected in another row.',
                confirmButtonText: 'OK'
            });
            productSelect.value = ''; // Reset the selection
        } else {
            // If product does not exist, fetch its details
            fetchProductDetails(productId, row);
        }
    });

    const removeRowBtn = row.querySelector('.removeRow');
    removeRowBtn.addEventListener('click', function() {
        row.remove();
        calculateGrandTotal(); // Recalculate total when a row is removed
    });

    // Event listeners for price, stock, and tax input changes
    row.querySelector('.price-input').addEventListener('input', function() {
        updateTotal(row);
    });

    row.querySelector('.stock-input').addEventListener('input', function() {
        updateTotal(row);
    });

    row.querySelector('.tax-input').addEventListener('change', function() {
        updateTotal(row);
    });
}


function fetchProductDetails(productId, row) {
    const url = getProductUrl.replace(':id', productId);


    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(product => {
            // Assign price and stock to inputs
            row.querySelector('.price-input').removeAttribute('readonly');
            row.querySelector('.price-input').value = product.price;

            row.querySelector('.stock-input').removeAttribute('readonly');
            row.querySelector('.stock-input').value = product.stock;

            row.querySelector('.name-input').value = product.name;

            if (product.gst) {
                row.querySelector('.tax-input').value = product.gst;
            }

            updateTotal(row); // Update total after fetching product details

            // Recalculate the grand total after fetching product details
            calculateGrandTotal();
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
}

// Function to update the total based on price, stock, and tax
function updateTotal(row) {
    const price = parseFloat(row.querySelector('.price-input').value) || 0;
    const stock = parseInt(row.querySelector('.stock-input').value) || 0;
    const taxRate = parseFloat(row.querySelector('.tax-input').value) || 0;

    const subtotal = price * stock; // Calculate subtotal
    const discount = subtotal * (taxRate / 100); // Calculate discount
    const total = subtotal + discount; // Calculate total

    row.querySelector('.total-input').value = total.toFixed(2); // Set total in the input
    row.querySelector('.discountprice-input').value = discount.toFixed(2); // Set discount in the input

    // Recalculate grand total
    calculateGrandTotal();
}

// Calculate discount based on Discount ₹ or Discount %
function calculateDiscount(subtotal) {
    let discountR = parseFloat(document.getElementById('discountR').value) || 0;
    let discountP = parseFloat(document.getElementById('discountP').value) || 0;

    let discountA = 0;
    if (discountR > 0) {
        discountA = discountR; 
        document.getElementById('discountP').value = ''; 
    } else if (discountP > 0) {
        discountA = (subtotal * discountP) / 100; 
        document.getElementById('discountR').value = ''; 
    }

    document.getElementById('discountA').value = discountA.toFixed(2);
    return discountA;
}

// Calculate the grand total
function calculateGrandTotal() {
    let totalRows = document.querySelectorAll('.total-input');
    let grandTotal = 0;
    
    totalRows.forEach(function(row) {
        grandTotal += parseFloat(row.value) || 0;
    });

    let discountA = calculateDiscount(grandTotal); // Pass the subtotal for discount calculation
    grandTotal -= discountA; 

    document.getElementById('displayGrandTotal').textContent = `$ ${grandTotal.toFixed(2)}`;
    document.getElementById('total_discount').value=grandTotal;
}

// Event listeners for discount changes
document.getElementById('discountR').addEventListener('input', function() {
    calculateGrandTotal(); // Recalculate grand total when discountR changes
});

document.getElementById('discountP').addEventListener('input', function() {
    calculateGrandTotal(); // Recalculate grand total when discountP changes
});


/*&

   */

</script>

@endsection
