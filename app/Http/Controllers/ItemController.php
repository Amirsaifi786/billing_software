<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Product;
// use Milon\Barcode\DNS1D;
use Milon\Barcode\Facades\DNS1DFacade as DNS1D;
use Illuminate\Http\Request;
use Str;
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



private function generateUniqueBarcode()
{
    do {
        $barcode = strtoupper(Str::random(8)); // Generate a random 8-character unique barcode
    } while (Product::where('barcode', $barcode)->exists());

    return $barcode;
}

    public function store(Request $request)
{
    $barcode = $this->generateUniqueBarcode();

    $barcodeImage = DNS1D::getBarcodePNG($barcode, 'C128');
    $imagePath = 'public/images/' . $barcode . '.png';
    \Storage::put($imagePath, $barcodeImage);
    // Generate the barcode PNG
    // $barcode = $request->input('barcode');
    // $barcodeImage = DNS1D::getBarcodePNGPath($barcode, 'C128');
    // \Storage::put('public/images/' . $barcode . '.png', file_get_contents($barcodeImage));
    // 'product_code' => $request->product_code,
    $product=new Product;
    $product->name = $request->name;
    $product->product_type = $request->type;
    $product->barcode = $barcode;
    $product->stock = $request->stock;
    $product->description = $request->description;
    $product->price = $request->price;
    $product->gst = $request->gst;
    $product->total = $request->total;
    // $product->barcode_image_path = 'storage/barcodes/' . $barcode . '.png';
    $product->save();

    return redirect()->route('itemIndex')->with('success', 'Item Create successfully.');

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
    public function deleteAll(Request $request)
{
    $selectedIds = $request->input('checkbox', []);

    if (count($selectedIds) > 0) {
        // Perform deletion logic here
        Product::whereIn('id', $selectedIds)->delete();

        return redirect()->back()->with('success', 'Selected Product deleted successfully.');
    }

    return redirect()->back()->with('error', 'No Product were selected.');
}


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
        // dd($request->all());
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
        // $barcode = $request->input('barcode');
        // $barcodeGenerator = new DNS1D(); // Create an instance of DNS1D
        // $barcodeImage = $barcodeGenerator->getBarcodePNG($barcode, 'C128'); // Generate barcode PNG
        // \Storage::put('public/barcodes/' . $barcode . '.png', $barcodeImage);
        
            
        $item->name = $request->name ??  $item->name;
        $item->product_type =$request->product_type ?? $item->product_type;
        // $item->barcode = $barcode??$item->barcode;
        $item->description = $request->description??$item->description;
        $item->stock = $request->stock ?? $item->stock;
        $item->price = $request->price??$item->price;
        $item->total = $request->stock * $request->price ?? $item->total;
        $item->save();
            // 'barcode_image_path' => 'storage/barcodes/' . $barcode . '.png', // Save path to DB
        // ]);
    
        // return redirect()->back()->with('success', 'Item updated successfully.');
        return redirect()->route('itemIndex')->with('success', 'Item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $item=Product::find($id);
        $item->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Product deleted  successfully',
        ]);
        
    }
}
