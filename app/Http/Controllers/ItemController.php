<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Product;
use Milon\Barcode\DNS1D;
use Illuminate\Http\Request;

class ItemController extends Controller
{

    public function index()
    {
        $items=Product::all();
       return view('item.index',compact('items'));
    }


    public function create()
    {

        return view('item.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{

   
    // Generate the barcode PNG
    $barcode = $request->input('barcode');
    $barcodeImage = DNS1D::getBarcodePNGPath($barcode, 'C128');
    \Storage::put('public/images/' . $barcode . '.png', file_get_contents($barcodeImage));

    Product::create([
        'name' => $request->name,
        'product_type' => $request->type,
        'barcode' => $barcode,
        'stock' => $request->stock,
        'description' => $request->description,
        'price' => $request->price,
        'gst' => $request->gst,
        'total' => $request->total,
        'barcode_image_path' => 'storage/barcodes/' . $barcode . '.png'
    ]);

    return redirect()->back()->with('success', 'Invoice item added successfully.');
}

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $items=Product::find($id);
        return view('item.edit',compact('items'));
        

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Find the item by ID
        $item = Product::find($id);
    
        // Validate the request data
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'description' => 'required|string|max:255',
        //     'type' => 'required|in:goods,services',
        //     'barcode' => 'required|string|max:255|unique:items,barcode,' . $id,
        //     'stock' => 'required|integer|min:1',
        //     'price' => 'required|numeric|min:0',
        //     // 'gst' => 'required',
        // ]);
    
        // Generate barcode PNG using instance of DNS1D
        $barcode = $request->input('barcode');
        $barcodeGenerator = new DNS1D(); // Create an instance of DNS1D
        $barcodeImage = $barcodeGenerator->getBarcodePNG($barcode, 'C128'); // Generate barcode PNG
    
        // Save barcode as an image to the storage
        \Storage::put('public/barcodes/' . $barcode . '.png', $barcodeImage);
    
        // Update item fields and calculate total
        $item->update([
            'name' => $request->name,
            'product_type' => $request->type,
            'barcode' => $barcode,
            'description' => $request->description,
            'stock' => $request->stock,
            'price' => $request->price,
            'total' => $request->stock * $request->price,
            'barcode_image_path' => 'storage/barcodes/' . $barcode . '.png', // Save path to DB
        ]);
    
        return redirect()->back()->with('success', 'Item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $item=Product::find($id);
        $item->delete();
        return redirect()->back()->with('success', 'Item deleted  successfully ');
    }
}
