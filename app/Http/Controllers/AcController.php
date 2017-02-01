<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class AcController extends Controller
{
    public function create (Request $request)
    {
    	// Create a client with a base URI
		$client = new Client(['base_uri' => 'https://api.indix.com/v2/']);
		// Send a request to https://foo.com/api/test
		$response = $client->request('GET', 'summary/products/', ['query' => [
	    	'countryCode' => 'US',
	    	'app_key' => 'Hw4loEa9Qg6OAHO3aHlzWVCAw6ZxtvEo',
	    	'q' => $request->get('q'),
    	]]);

    	return json_decode($response->getBody()->__toString(), true);
    }
}
