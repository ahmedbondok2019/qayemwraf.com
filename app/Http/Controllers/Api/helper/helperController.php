<?php

namespace App\Http\Controllers\Api\helper;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

class helperController extends Controller
{
    public static function make_slug($string, $separator = '-')
    {
        /* شغال انجليزى فقط */
        //        // replace non letter or digits by -
        //        $string = preg_replace('~[^\pL\d]+~u', '-', $string);
        //
        //        // transliterate
        //        $string = iconv('utf-8', 'us-ascii//TRANSLIT', $string);
        //
        //        // remove unwanted characters
        //        $string = preg_replace('~[^-\w]+~', '', $string);
        //
        //        // trim
        //        $string = trim($string, '-');
        //
        //        // remove duplicate -
        //        $string = preg_replace('~-+~', '-', $string);
        //
        //        // lowercase
        //        $string = strtolower($string);
        //
        //        if (empty($string)) {
        //            return 'n-a';
        //        }

        //        /* قبل التحديث الاخير للارافل كان يعمل */
        //        $string = trim($string);
        //        $string = mb_strtolower($string, 'UTF-8');
        //
        //        // Make alphanumeric (removes all other characters)
        //        // this makes the string safe especially when used as a part of a URL
        //        // this keeps latin characters and Persian characters as well
        //        $string = preg_replace("/[^a-z0-9_\s-۰۱۲۳۴۵۶۷۸۹ىءاآأؤئبپتثجچحخدذرزژسشصضطظعغفقکكگگلمنوهیية]/u", '', $string);
        //
        //        // Remove multiple dashes or whitespaces or underscores
        //        $string = preg_replace("/[\s-_]+/", ' ', $string);
        //
        //        // Convert whitespaces and underscore to the given separator
        //        $string = preg_replace("/[\s_]/", $separator, $string);
        //
        //        return $string;

        $_transliteration = [
            '/ä|æ|ǽ/' => 'ae',
            '/ö|œ/' => 'oe',
            '/ü/' => 'ue',
            '/Ä/' => 'Ae',
            '/Ü/' => 'Ue',
            '/Ö/' => 'Oe',
            '/À|Á|Â|Ã|Å|Ǻ|Ā|Ă|Ą|Ǎ/' => 'A',
            '/à|á|â|ã|å|ǻ|ā|ă|ą|ǎ|ª/' => 'a',
            '/Ç|Ć|Ĉ|Ċ|Č/' => 'C',
            '/ç|ć|ĉ|ċ|č/' => 'c',
            '/Ð|Ď|Đ/' => 'D',
            '/ð|ď|đ/' => 'd',
            '/È|É|Ê|Ë|Ē|Ĕ|Ė|Ę|Ě/' => 'E',
            '/è|é|ê|ë|ē|ĕ|ė|ę|ě/' => 'e',
            '/Ĝ|Ğ|Ġ|Ģ/' => 'G',
            '/ĝ|ğ|ġ|ģ/' => 'g',
            '/Ĥ|Ħ/' => 'H',
            '/ĥ|ħ/' => 'h',
            '/Ì|Í|Î|Ï|Ĩ|Ī|Ĭ|Ǐ|Į|İ/' => 'I',
            '/ì|í|î|ï|ĩ|ī|ĭ|ǐ|į|ı/' => 'i',
            '/Ĵ/' => 'J',
            '/ĵ/' => 'j',
            '/Ķ/' => 'K',
            '/ķ/' => 'k',
            '/Ĺ|Ļ|Ľ|Ŀ|Ł/' => 'L',
            '/ĺ|ļ|ľ|ŀ|ł/' => 'l',
            '/Ñ|Ń|Ņ|Ň/' => 'N',
            '/ñ|ń|ņ|ň|ŉ/' => 'n',
            '/Ò|Ó|Ô|Õ|Ō|Ŏ|Ǒ|Ő|Ơ|Ø|Ǿ/' => 'O',
            '/ò|ó|ô|õ|ō|ŏ|ǒ|ő|ơ|ø|ǿ|º/' => 'o',
            '/Ŕ|Ŗ|Ř/' => 'R',
            '/ŕ|ŗ|ř/' => 'r',
            '/Ś|Ŝ|Ş|Ș|Š/' => 'S',
            '/ś|ŝ|ş|ș|š|ſ/' => 's',
            '/Ţ|Ț|Ť|Ŧ/' => 'T',
            '/ţ|ț|ť|ŧ/' => 't',
            '/Ù|Ú|Û|Ũ|Ū|Ŭ|Ů|Ű|Ų|Ư|Ǔ|Ǖ|Ǘ|Ǚ|Ǜ/' => 'U',
            '/ù|ú|û|ũ|ū|ŭ|ů|ű|ų|ư|ǔ|ǖ|ǘ|ǚ|ǜ/' => 'u',
            '/Ý|Ÿ|Ŷ/' => 'Y',
            '/ý|ÿ|ŷ/' => 'y',
            '/Ŵ/' => 'W',
            '/ŵ/' => 'w',
            '/Ź|Ż|Ž/' => 'Z',
            '/ź|ż|ž/' => 'z',
            '/Æ|Ǽ/' => 'AE',
            '/ß/' => 'ss',
            '/Ĳ/' => 'IJ',
            '/ĳ/' => 'ij',
            '/Œ/' => 'OE',
            '/ƒ/' => 'f',
        ];
        $quotedReplacement = preg_quote($separator, '/');
        $merge = [
            '/[^\s\p{Zs}\p{Ll}\p{Lm}\p{Lo}\p{Lt}\p{Lu}\p{Nd}]/mu' => ' ',
            '/[\s\p{Zs}]+/mu' => $separator,
            sprintf('/^[%s]+|[%s]+$/', $quotedReplacement, $quotedReplacement) => '',
        ];
        $map = $_transliteration + $merge;
        unset($_transliteration);

        return mb_strtolower(preg_replace(array_keys($map), array_values($map), $string));
    }

    public static function upload_images($path, $destination, $image, $width, $height)
    {
        if (! File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        $flag = true;
        $try = 1;
        while ($flag && $try < 2) {
            try {
                // open and resize an image file
                $img = Image::make($image)->resize($width, $height);
                // save file as jpg with medium quality
                $img->save($destination, 60);
                $flag = false;
            } catch (\Exception $e) {
                // not throwing  error when exception occurs
            }
            $try++;
        }
    }

    public static function getDistance($latitude1, $longitude1, $latitude2, $longitude2)
    {
        $earth_radius = 6371;

        $dLat = deg2rad($latitude2 - $latitude1);
        $dLon = deg2rad($longitude2 - $longitude1);

        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * asin(sqrt($a));
        $d = $earth_radius * $c;

        return $d;
    }
}
