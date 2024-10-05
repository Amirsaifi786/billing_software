<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\State;
use App\Models\Country;
use App\Models\Customer;
use App\Models\Product;
use App\Models\InvoiceProduct;
use Illuminate\Http\Request;
use DB;
use PDF;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
   

        $invoices = Invoice::all();
        $products=Product::all();
    
        return view('invoice.index',compact('invoices','products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        $customers=Customer::with('invoices')->get();
        $products=Product::all();
        $countries=DB::table('countries')->get();
        // dd($customers);
    return view('invoice.create',compact('customers','countries','products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {

    //     dd($request->all()); 

        // $lastInvoice = Invoice::orderBy('id', 'desc')->first();
    
        // if ($lastInvoice) {
        //     $lastNumber = intval(substr($lastInvoice->invoice_no, -3)); // Get the last 3 digits
        //     $newInvoiceNo = 'INV-' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        // } else {
        //    $newInvoiceNo = 'INV-001';
        // }

    //     $inv=new Invoice();
    //     $inv->invoice_no=$newInvoiceNo;
    //     $inv->customer_id=$request->customer_id;
    //     $inv->product_id=$request->product_id;        
    //     $inv->invoice_date=$request->invoice_date;
    //     $inv->price=$request->price;
    //     $inv->quantity=$request->quantity;
    //     $inv->discount_type=$request->discount_type;
    //     $inv->total_amount=$request->total_amount;
       
    //     $inv->save();
    //     return redirect()->route('invoiceIndex')->with('success','Invoice create successfully');


    // }
    public function Store(Request $request)
{

    // dd($request->all());
    $lastInvoice = Invoice::orderBy('id', 'desc')->first();
    
    if ($lastInvoice) {
        $lastNumber = intval(substr($lastInvoice->invoice_no, -3)); // Get the last 3 digits
        $newInvoiceNo = 'INV-' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
    } else {
       $newInvoiceNo = 'INV-001';
    }

    // Validate invoice data
    $validated = $request->validate([
        'customer_id' => 'required',
        'invoice_date' => 'required|date',
        // Add other invoice fields validation
    ]);

    // Create the invoice
    $invoice = new Invoice();
    $invoice->customer_id = $validated['customer_id'];
    $invoice->invoice_no = $newInvoiceNo;
    $invoice->invoice_date = $validated['invoice_date'];
    $invoice->save();

    // Handle products
    $products = json_decode($request->input('products'), true);
    
    foreach ($products as $product) {
        $invoiceProduct = new InvoiceProduct();
        $invoiceProduct->invoice_id = $invoice->id;
        // $invoiceProduct->id = $product['id'];
        $invoiceProduct->name = $product['name'];
        $invoiceProduct->price = $product['price'];
        $invoiceProduct->stock = $product['stock'];
        $invoiceProduct->tax = $product['tax'];
        $invoiceProduct->total = $product['total'];
        $invoiceProduct->save();
    }

    return redirect()->route('invoiceIndex')->with('success', 'Invoice saved successfully');
}
public function downloadInvoice($id)
{

    // Fetch invoice data from the database
    $invoice = InvoiceProduct::where('invoice_id' ,$id)->get(); // Assuming relation with products

    // Load view and pass the invoice data
    $pdf = PDF::loadView('invoice.pdf', compact('invoice'));

    // Download the generated PDF
    return $pdf->download('invoice_'.$invoice->id.'.pdf');
}


    public function show(Invoice $invoice)
    {
        //
    }

   
    public function edit(Request $request,$id)
    {


        $invoices=Invoice::find($id);
        $customers=Customer::with('invoices')->get();
        $states = State::where('country_id', 101)->get();
        $products = Product::all();


        return view('invoice.edit',compact('invoices','customers','states','products'));
    }

   
    public function update(Request $request,  $id)
    {
        
        // $lastInvoice = Invoice::orderBy('id', 'desc')->first();
    
        // if ($lastInvoice) {
        //     $lastNumber = intval(substr($lastInvoice->invoice_no, -3)); // Get the last 3 digits
        //     $newInvoiceNo = 'INV-' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        // } else {
        //    $newInvoiceNo = 'INV-001';
        // }

        $inv=Invoice::find($id);
        // $inv->invoice_no=$newInvoiceNo;
        $inv->customer_id=$request->customer_id;
        $inv->product_id=$request->product_id;        
        $inv->invoice_date=$request->invoice_date;
        $inv->price=$request->price;
        $inv->quantity=$request->quantity;
        $inv->discount_type=$request->discount_type;
        $inv->total_amount=$request->total_amount;
        $inv->save();
        return redirect()->back()->with('success','Invoice Updated Successfully');

    }

   
    public function destroy($id)
    {

        $invoice=Invoice::find($id);
        $invoice->delete();

        return redirect()->back()->with('success','Invoice Deleted Successfully');
        
    }
}
