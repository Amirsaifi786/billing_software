<!DOCTYPE html>
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
</html>
