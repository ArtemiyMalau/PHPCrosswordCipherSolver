<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Crossword\Helper;

class ApiController extends BaseController
{
	public function help(Request $request)
	{
		$request->validate([
			"cipher" => ["required", "cipher"],
			"mask" => ["required", "mask:cipher"],
		]);

		$words = Helper::getWords($request->cipher, $request->mask);

		return new JsonResponse([
			"words" => $words,
		]);
	}
}