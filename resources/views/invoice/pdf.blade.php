<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tax Invoice</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #cbd5c7;
            color: #333;
             border-radius:10px;
        }

        .invoice-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 900px;
            margin: 0 auto;
           
        }

        .invoice-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .invoice-header h1 {
            color: #6A0DAD;
            margin: 5px 0;
            font-size: 24px;
        }

        .invoice-header p {
            font-size: 14px;
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: right;
        }

        th {
            background-color: #f9f9f9;
            text-align: left;
        }

        .text-left {
            text-align: left;
        }

        .no-border {
            border: none;
        }

        tfoot tr td {
            font-size: 16px;
            font-weight: bold;
            background-color: #f9f9f9;
        }

        .terms {
            margin-top: 20px;
            font-size: 14px;
        }

        .signature {
            text-align: right;
            margin-top: 40px;
        }

        .signature p {
            margin-bottom: 50px;
        }

        .total-row td {
            background-color: #fafafa;
        }

        @media only screen and (max-width: 768px) {
            body {
                padding: 10px;
            }

            .invoice-container {
                padding: 15px;
            }

            table,
            th,
            td {
                font-size: 14px;
            }

            th,
            td {
                padding: 8px;
            }

            .invoice-header h1 {
                font-size: 20px;
            }
        }

    </style>
</head>
<body>

    <div class="invoice-container">
        <div class="invoice-header">
            <h1>Tax Invoice</h1>
            <p>ssa tax<br>Phone no.: {{ $customer->first()->mobile_no }}</p>

        </div>

        <table>
            <tr>
                <td class="no-border text-left"><strong>Bill To:</strong> {{ ucwords($customer->first()->name) }} </td>
                <td class="no-border text-right">
                    <strong>Invoice Details</strong><br>
                    Invoice No.: {{ $invoices->invoice_no }}<br>
                    Date: {{ $invoices->invoice_date }}
                </td>
            </tr>
        </table>

        <table>
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Item name</th>
                    <th>Quantity</th>
                    <th>Price/ Unit</th>
                    <th>GST</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoiceProducts as $key=> $product)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td class="text-left">{{ ucwords($product->name) }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>{{ number_format($product->price, 2) }}</td>
                    <td>{{ number_format($product->stock * $product->price * ($product->tax / 100), 2) }} ({{ $product->tax }}%)</td>
                    <td>{{ number_format($product->total, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="5" style="text-align:right;">GST</td>
                    <td>{{ number_format($invoices->total_gst, 2) }}</td>
                </tr>
                <tr class="total-row">
                    <td colspan="5" style="text-align:right;">Subtotal</td>
                    <td>{{ number_format($invoices->total_amount, 2) }}</td>
                </tr>
            </tfoot>
        </table>

        <table>
            <tr>
                <?php
                function convertNumberToWords($number) {
                $words = [
                0 => 'zero', 1 => 'one', 2 => 'two', 3 => 'three',
                4 => 'four', 5 => 'five', 6 => 'six', 7 => 'seven',
                8 => 'eight', 9 => 'nine', 10 => 'ten', 11 => 'eleven',
                12 => 'twelve', 13 => 'thirteen', 14 => 'fourteen',
                15 => 'fifteen', 16 => 'sixteen', 17 => 'seventeen',
                18 => 'eighteen', 19 => 'nineteen', 20 => 'twenty',
                30 => 'thirty', 40 => 'forty', 50 => 'fifty',
                60 => 'sixty', 70 => 'seventy', 80 => 'eighty',
                90 => 'ninety'
                ];

                if ($number < 20) { return $words[$number]; } 
                
                elseif ($number < 100) { 
                    return $words[intval($number / 10) * 10] . ($number % 10 ? ' ' . $words[$number % 10] : '' ); } 
                elseif ($number < 1000) { 
                    return $words[intval($number / 100)] . ' hundred' . ($number % 100 ? ' and ' . convertNumberToWords($number % 100) : '' ); } 
                elseif ($number < 1000000) { 
                    return convertNumberToWords(intval($number / 1000)) . ' thousand' . ($number % 1000 ? ' ' . convertNumberToWords($number % 1000) : '' ); } else { return convertNumberToWords(intval($number / 1000000)) . ' million' . ($number % 1000000 ? ' ' . convertNumberToWords($number % 1000000) : '' ); } } $number=$invoices->total_amount;
                    $words = convertNumberToWords($number) . ' rupees';
                  ?>

                <td class="no-border text-left">
                    <strong>Invoice Amount In Words</strong><br>
                    <span style="color:blue">{{ ucwords($words) }}</span>
                </td>
            </tr>
        </table>



        <div class="signature">
            <p>For ssa tax</p>
            <p>________________________</p>
            <p>Authorized Signatory</p>
        </div>
    </div>

</body>
</html>
