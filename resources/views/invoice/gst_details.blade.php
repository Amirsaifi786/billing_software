 @extends('layouts.master')
@section('content')
   <h1>GST Details</h1>
    @if(isset($error))
        <p style="color: red;">{{ $error }}</p>
    @elseif($gstDetails)
        <p><strong>GST Number:</strong> {{ $gstDetails['gst_number'] ?? 'N/A' }}</p>
        <p><strong>Name:</strong> {{ $gstDetails['name'] ?? 'N/A' }}</p>
        <p><strong>Status:</strong> {{ $gstDetails['status'] ?? 'N/A' }}</p>
        <!-- Add more fields as necessary based on the response -->
    @else
        <p>No details found for the provided GST number.</p>
    @endif
    <a href="{{ route('gst.form') }}">Search Again</a>
    @endsection