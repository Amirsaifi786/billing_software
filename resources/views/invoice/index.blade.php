@extends('layouts.master')
@section('content')
{{-- @if ($message = Session::get('message'))
<div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ $message }}</strong>
</div>
@endif --}}
@if(session('success'))
    <div id="successMessage" class="alert alert-success">
        {{ session('success') }}
    </div>

    <script>
        // Hide the success message after 2 seconds (2000 milliseconds)
        setTimeout(function() {
            var successMessage = document.getElementById('successMessage');
            if (successMessage) {
                successMessage.style.display = 'none';
            }
        }, 2000); // 2 seconds
    </script>
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
                        <li>
                        <form id="delete-form" action="{{ route('invoicedeleteAll') }}" method="POST">
                                @csrf
                                <button class="btn btn-primary"  type="submit" title="Delete Selected">Delete All
                                    {{-- <img src="{{ asset('assets/img/icons/delete.svg') }}" alt="Delete"> --}}
                                </button>
                            </form>
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
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoices as $key => $invoice)


                        <tr>
                            <td>
                                   <label class="checkboxs">
                                    <input type="checkbox" name="checkbox[]" value="{{ $invoice->id }}">
                                    <span class="checkmarks"></span>
                                </label>
                            </td>

                            <td>{{ $key+1  }}</td>
                            <td>{{ $invoice->customer_id }}</td>
                            <td>{{ $invoice->invoice_no }}</td>
                            <td>{{ $invoice->invoice_date }}</td>
                            <td>{{ $invoice->total_amount }}</td>
                      



                            <td>
                             
                                {{-- @can('invoice edit') --}}
                                <a class="me-3" title="View PDF {{ $invoice->invoice_no }} " href="{{ route('invoice.download', $invoice->id) }}">
                                    <img src="{{ asset('assets/img/icons/pdf.svg')}}" alt="img">
                                </a>

                                {{-- <a class="me-3" href="{{ route('invoiceEdit',$invoice->id) }}">
                                    <img src="{{ asset('assets/img/icons/edit.svg')}}" alt="img">
                                </a> --}}
                                {{-- @endcan 
                                @can('invoice delete') --}}
                                {{-- <a class="confirm-text delete_invoice" data-id="{{ $invoice->id }}">
                                    <img src="{{ asset('assets/img/icons/delete.svg')}}" alt="img">
                                </a> --}}
                             
                                 <a class="confirm-text delete_invoice" data-id="{{ $invoice->id }}">
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectAllCheckbox = document.getElementById('select-all');
        const checkboxes = document.querySelectorAll('input[name="checkbox[]"]');
        const form = document.getElementById('delete-form');

        // Toggle select all checkboxes
        selectAllCheckbox.addEventListener('change', function () {
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = selectAllCheckbox.checked;
            });
        });

        // Handle form submission
        form.addEventListener('submit', function (event) {
            const selectedCheckboxes = Array.from(checkboxes)
                .filter(checkbox => checkbox.checked)
                .map(checkbox => checkbox.value); // Get checked values

            if (selectedCheckboxes.length === 0) {
                event.preventDefault(); // Prevent form submission if no checkbox is selected
           
                Swal.fire({
                    icon: 'warning',
                    title: 'No Selection',
                    text: 'Please select at least one Invoice to delete.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#3085d6'
                });            } else {
                // Attach selected checkbox values as hidden inputs to form
                selectedCheckboxes.forEach(function (value) {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'checkbox[]';
                    hiddenInput.value = value;
                    form.appendChild(hiddenInput);
                });
            }
        });
    });
</script>
@endsection
