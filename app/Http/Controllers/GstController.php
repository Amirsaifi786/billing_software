<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GstService;

class GstController extends Controller
{
    protected $gstService;

    public function __construct(GstService $gstService)
    {
        $this->gstService = $gstService;
    }

    public function fetch(Request $request)
{
    $request->validate([
        'gst_number' => 'required|string|max:15',
    ]);
    
    $gstDetails = $this->gstService->fetchGstDetails($request->gst_number);
   

    if (isset($gstDetails['error'])) {
        return view('invoice.gst_details', ['error' => $gstDetails['error']]);
    }

    return view('invoice.gst_details', compact('gstDetails'));
}

}

