<?php

namespace App\Crossword;

use Illuminate\Support\Facades\Http;

class Helper 
{
	public static function mb_strcasecmp($str1, $str2, $encoding = null) 
	{
	    if (null === $encoding) { $encoding = mb_internal_encoding(); }
	    return strcmp(mb_strtoupper($str1, $encoding), mb_strtoupper($str2, $encoding));
	}

	public static function strEqualsCaseInsensitive($str1, $str2, $encoding = "utf-8") 
	{
		return self::mb_strcasecmp($str1, $str2, $encoding) === 0;
	}

	public static function itertoolsProduct($arrays, $i = 0) {
	    if (!isset($arrays[$i])) {
	        return array();
	    }
	    if ($i == count($arrays) - 1) {
	        return $arrays[$i];
	    }

	    // get combinations from subsequent arrays
	    $tmp = self::itertoolsProduct($arrays, $i + 1);

	    $result = array();

	    // concat each array from tmp with each element from $arrays[$i]
	    foreach ($arrays[$i] as $v) {
	        foreach ($tmp as $t) {
	            $result[] = is_array($t) ? 
	                array_merge(array($v), $t) :
	                array($v, $t);
	        }
	    }

	    return $result;
	}

	private static function generateAllPossibleWords($cipher, $mask) {
		$cipher_associate = [];
		foreach ($cipher as $number) {
			$cipher_associate[$number["number"]] = $number["chars"];
		}

		$product_arrays = [];
        foreach (mb_str_split($mask) as $char) {
            if (is_numeric($char)) {
            	$product_arrays[] = $cipher_associate[$char];
            } else {
            	$product_arrays[] = [$char];
            }
        }

        $words = [];
        foreach (self::itertoolsProduct($product_arrays) as $product) {
        	$words[] = join("", $product);
        }

        return $words;
	}

	private static function getPossibleWords($generated_words) {
		$possible_words = [];

		foreach ($generated_words as $generated_word) {
			$response = Http::withOptions([
			    "verify" => false,
			])->get("https://poncy.ru/crossword/crossword-solve.jsn", ["mask" => $generated_word]);

			foreach ($response["words"] as $possible_word) {
				$possible_words[] = $possible_word;
			}
		}

		return $possible_words;
	}

	public static function getWords($cipher, $mask) {
		$generated_words = self::generateAllPossibleWords($cipher, $mask);

		return self::getPossibleWords($generated_words);
	}
}