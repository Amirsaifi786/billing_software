<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class GstService
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function fetchGstDetails($gstNumber)
    {
        $url = 'https://www.gstsearch.in/process.php';

        try {
            $response = $this->client->request('GET', $url, [
                'query' => [
                    'gstin' => $gstNumber, // Make sure this is the correct parameter
                ]
            ]);

            // Check if the response is successful
            if ($response->getStatusCode() === 200) {
                $body = (string) $response->getBody();

                // Attempt to decode JSON if the response is in JSON format
                $data = json_decode($body, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    return $data; // Return decoded JSON
                } else {
                    // If not JSON, process the HTML response
                    return $this->parseHtmlResponse($body);
                }
            }
        } catch (RequestException $e) {
            // Log the error for debugging
            \Log::error('GstService fetchGstDetails error: ' . $e->getMessage());
            return [
                'error' => 'Unable to fetch GST details. Please try again later.'
            ];
        }

        return null; // Return null if request fails
    }

    private function parseHtmlResponse($html)
    {
        // Create a new DOMDocument instance
        $dom = new \DOMDocument();

        // Suppress warnings related to malformed HTML
        @$dom->loadHTML($html);

        // Initialize an array to hold GST details
        $details = [];

        // Here you should identify the elements containing the GST information.
        // For example, if the name is inside a <div class="name">...</div>
        // Note: Modify the selectors based on the actual HTML structure you encounter.
        
        // Example of extracting elements - adjust based on actual HTML
        $nameElements = $dom->getElementsByTagName('div');
        foreach ($nameElements as $element) {
            dd($element);
            if ($element->getAttribute('class') === 'name') {
                $details['name'] = $element->textContent;
            }
            // Add more conditions for other fields like GST number, status, etc.
        }

        // Return the parsed details or a message if nothing is found
        return $details ?: ['error' => 'No details found.'];
    }
}
