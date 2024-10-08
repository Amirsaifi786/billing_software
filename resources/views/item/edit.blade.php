@extends('layouts.master')
@section('content')
<div class="content">
    <div class="page-header">
        <div class="page-title">
            <h4>Product Management</h4>
            <h6>Update Product</h6>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <form action="{{ route('itemUpdate',$items->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- item Details -->
                    <div class="row">
                        {{-- <div class="col-lg-3 col-sm-6 col-12"> --}}

                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="name">Product Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control  @error('name') @enderror " id="name" name="name" value="{{ old('name',$items->name) }}" required oninput="generateBarcode()">
                                    @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                                                        <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="Description">Description<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control  @error('description') @enderror " id="description" name="description" value="{{ old('description',$items->description) }}" required>
                                    @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="product_type">Item Type<span class="text-danger">*</span></label>
                                    <select name="product_type" class="form-control" id="product_type" required >
                                        <option disabled selected>Select Item Type</option>
                                        <option value="goods" {{ old('product_type', $items->product_type) == 'goods' ? 'selected' : '' }}>Goods</option>
                                        <option value="services" {{ old('product_type', $items->product_type) == 'services' ? 'selected' : '' }}>services</option>
                                    </select>
                                    @error('product_type')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="barcode">Barcode<span class="text-danger">*</span></label>
                                    <input type="text" name="barcode" class="form-control  @error('barcode') is-invalid @enderror " id="barcode" value="{{ old('barcode',$items->barcode) }}" required>
                                    @error('barcode')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <div >
                                    
                                    {!! DNS1D::getBarcodeHTML($items->barcode, 'C128') !!}</div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-sm-6 col-12">

                                <div class="form-group">
                                    <label for="price">Price<span class="text-danger">*</span></label>
                                    <input type="number" name="price" class="form-control @error('price') is-invalid @enderror " id="price" value="{{ old('price',$items->price) }}" required step="0.01">
                                    @error('price')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="stock">stock<span class="text-danger">*</span></label>
                                    <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror " id="stock" value="{{ old('stock',$items->stock) }}" required min="1">
                                    @error('stock')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">

                                <div class="form-group">
                                    <label for="total">Total<span class="text-danger">*</span></label>
                                    <input type="number" name="total" class="form-control @error('total') is-invalid @enderror" value="{{ old('total',$items->total) }}" id="total" readonly>
                                    @error('total')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <!-- Submit Button -->
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-submit me-2">Update</button>
                                <a href="{{ route('itemIndex') }}" class="btn btn-cancel">Cancel</a>
                            </div>
                        </div>
                </form>

            </div>
        </div>
    </div>

</div>
<script>
    document.getElementById('stock').addEventListener('input', calculateTotal);
    document.getElementById('price').addEventListener('input', calculateTotal);

    function calculateTotal() {
        const stock = document.getElementById('stock').value || 0;
        const price = document.getElementById('price').value || 0;
        document.getElementById('total').value = (stock * price).toFixed(2);
    }
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
