<?php

namespace App\Http\Controllers\Api;

use ApaiIO\ApaiIO;
use ApaiIO\Configuration\GenericConfiguration;
use ApaiIO\Operations\Lookup;
use ApaiIO\Request\GuzzleRequest;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class AmazonProductController extends Controller
{

	private $amazonApi;

	public function __construct()
	{

		$this->amazonApi = $this->init();
	}

	public function infos(Request $request, $productId)
	{

		$lookup = new Lookup();
		$lookup->setItemId($productId);
		$lookup->setResponseGroup(array('Medium')); // More detailed information

		$response = $this->amazonApi->runOperation($lookup);

		$json = $this->xmlToJson($response);

		return response()->json(['data' => $json['Items']['Item']], 200);
		// $title = $json['Items'];
		// dd($title);

	}

	/**
	 * Initialize amazonApi
	 * @return [type] [description]
	 */
	private function init()
	{

		$conf = new GenericConfiguration();
		$client = new Client();
		$request = new GuzzleRequest($client);
		$conf
			->setCountry('fr')
			->setAccessKey(env('AMAZON_ACCESS_KEY'))
			->setSecretKey(env('AMAZON_SECRET_KEY'))
			->setAssociateTag(env('AMAZON_ASSOCIATE_TAG'))
			->setRequest($request);

		return new ApaiIO($conf);
	}

	private function xmlToJson($operation)
	{
		$xml = simplexml_load_string($operation);
		$json = json_encode($xml);
		return json_decode($json, TRUE);
	}
}
