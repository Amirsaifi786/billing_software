@extends('layouts.master')
@section('content')
<div class="content">
    <div class="page-header">
        <div class="page-title">
            <h4>Product Management</h4>
            <h6>Add Product </h6>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <form action="{{ route('itemStore') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- item Details -->
                    <div class="row">
                        @csrf
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="name">Product Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required oninput="generateBarcode()">
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                          {{-- <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="product_code">Product Code<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="product_code" placeholder="PRD-001" name="product_code" value="{{ old('product_code') }}"  >
                                @error("product_code")
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div> --}}
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="description">Description<span class="text-danger">*</span></label>
                                <input type="text" name="description" class="form-control" id="description" required>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="type">Product Type<span class="text-danger">*</span></label>
                                <select name="type" class="form-control" id="type" required>
                                    <option disabled selected>Select Product Type</option>
                                    <option value="goods">Goods</option>
                                    <option value="services">Services</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="price">Price<span class="text-danger">*</span></label>
                                <input type="number" name="price" class="form-control" id="price" required step="0.01">
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="stock">Stock<span class="text-danger">*</span></label>
                                <input type="number" name="stock" class="form-control" id="stock" required min="1">
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="gst">GST Type<span class="text-danger">*</span></label>
                                <select name="gst" class="form-control" id="gst" required>
                                    <option disabled selected>Select GST</option>
                                    <option value="5">5%</option>
                                    <option value="8">8%</option>
                                    <option value="12">12%</option>
                                    <option value="18">18%</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="total">Total<span class="text-danger">*</span></label>
                                <input type="number" name="total" class="form-control" id="total" readonly>
                            </div>
                        </div>


                        {{-- <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="price">Price<span class="text-danger">*</span></label>
                                <input type="number" name="price" class="form-control" id="price" required step="0.01">
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="stock">Stock<span class="text-danger">*</span></label>
                                <input type="number" name="stock" class="form-control" id="stock" required min="1">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="type">Discount Type<span class="text-danger">*</span></label>
                                <select name="type" class="form-control" id="type" required>
                                    <option disabled selected>Select Gst</option>
                                    <option value="5">5%</option>
                                    <option value="8">8%</option>
                                    <option value="12">12%</option>
                                    <option value="18">18%</option>
                                </select>
                            </div>
                        </div>


                        <div class="col-lg-3 col-sm-6 col-12">

                            <div class="form-group">
                                <label for="total">Total<span class="text-danger">*</span></label>
                                <input type="number" name="total" class="form-control" id="total" readonly>
                            </div>
                        </div> --}}

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="barcode">Barcode<span class="text-danger">*</span></label>
                                <input type="text" name="barcode" class="form-control" id="barcode" readonly>
                            </div>
                        </div>



                    </div>


                    <!-- Submit Button -->
                    <div class="row">
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-submit me-2">Submit</button>
                            <a href="{{ route('itemIndex') }}" class="btn btn-cancel">Cancel</a>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>

</div>

<script>
    function calculateTotal() {
        const price = parseFloat(document.getElementById('price').value) || 0;
        const stock = parseInt(document.getElementById('stock').value) || 0;
        const gst = parseInt(document.getElementById('gst').value) || 0;

        if (price > 0 && stock > 0) {
            const subtotal = price * stock;
            const total = subtotal + (subtotal * (gst / 100));
            document.getElementById('total').value = total.toFixed(2); // Display total with two decimal points
        }
    }

    // Event listeners to trigger the calculation
    document.getElementById('price').addEventListener('input', calculateTotal);
    document.getElementById('stock').addEventListener('input', calculateTotal);
    document.getElementById('gst').addEventListener('change', calculateTotal);

    function generateBarcode() {
        // Get the value of the product name
        var productName = document.getElementById("name").value;

        // Generate a simple barcode by replacing spaces with dashes and converting to uppercase
        var barcode = productName.trim().toUpperCase().replace(/\s+/g, '-');

        // Set the barcode field's value
        document.getElementById("barcode").value = barcode;
    }

</script>
@endsection
