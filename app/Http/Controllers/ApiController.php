<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Http\Models\Crossword;
use App\Crossword\Helper;

class ApiController extends BaseController
{
	public function help(Request $request)
	{
		$request->validate([
			"cipher" => ["required", "cipher"],
			"mask" => ["required", "mask:cipher"],
		]);

		$generated_words = Helper::generateAllPossibleWords($request->cipher, $request->mask);

		$possible_words = [];
		foreach ($generated_words as $generated_word) {
			$response = Http::withOptions([
			    "verify" => false,
			])->get("https://poncy.ru/crossword/crossword-solve.jsn", ["mask" => $generated_word]);

			foreach ($response["words"] as $possible_word) {
				$possible_words[] = $possible_word;
			}
		}

		return new JsonResponse([
			"words" => $possible_words,
		]);
	}
}