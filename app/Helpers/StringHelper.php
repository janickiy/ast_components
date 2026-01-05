<?php

namespace App\Helpers;

class StringHelper
{
    /**
     * @param mixed $data
     * @return array
     */
    public static function ObjectToArray(mixed $data): array
    {
        if (is_array($data) || is_object($data)) {
            $result = [];
            foreach ($data as $key => $value) {
                $result[$key] = self::ObjectToArray($value);
            }
            return $result;
        }
        return $data;
    }

    /**
     * @param mixed $el
     * @param bool $first
     * @return string
     */
    public static function tree(mixed $el, bool $first = true): string
    {
        if (is_object($el)) $el = (array)$el;

        if ($el) {

            if ($first) {
                $out = '<ul id="tree-checkbox" class="tree-checkbox treeview">';
            } else {
                $out = '<ul>';
            }

            foreach ($el as $k => $v) {
                if (is_object($v)) $v = (array)$v;

                if ($v) {

                    $out .= "<li><strong> " . $k . " :</strong> ";

                    if (is_array($v)) {
                        $out .= self::tree($v, false);
                    } else {
                        $out .= $v;
                    }

                    $out .= "</li>";
                }
            }

            $out .= "</ul>";

            return $out;
        }
    }

    /**
     * @param string $text
     * @param bool $toLower
     * @return string
     */
    public static function slug(string $text, bool $toLower = true): string
    {
        $text = trim($text);

        $tr = [
            "А" => "A",
            "Б" => "B",
            "В" => "V",
            "Г" => "G",
            "Д" => "D",
            "Е" => "E",
            "Ё" => "E",
            "Ж" => "J",
            "З" => "Z",
            "И" => "I",
            "Й" => "Y",
            "К" => "K",
            "Л" => "L",
            "М" => "M",
            "Н" => "N",
            "О" => "O",
            "П" => "P",
            "Р" => "R",
            "С" => "S",
            "Т" => "T",
            "У" => "U",
            "Ф" => "F",
            "Х" => "H",
            "Ц" => "TS",
            "Ч" => "CH",
            "Ш" => "SH",
            "Щ" => "SCH",
            "Ъ" => "",
            "Ы" => "YI",
            "Ь" => "",
            "Э" => "E",
            "Ю" => "YU",
            "Я" => "YA",
            "а" => "a",
            "б" => "b",
            "в" => "v",
            "г" => "g",
            "д" => "d",
            "е" => "e",
            "ё" => "e",
            "ж" => "j",
            "з" => "z",
            "и" => "i",
            "й" => "y",
            "к" => "k",
            "л" => "l",
            "м" => "m",
            "н" => "n",
            "о" => "o",
            "п" => "p",
            "р" => "r",
            "с" => "s",
            "т" => "t",
            "у" => "u",
            "ф" => "f",
            "х" => "h",
            "ц" => "ts",
            "ч" => "ch",
            "ш" => "sh",
            "щ" => "sch",
            "ъ" => "y",
            "ы" => "yi",
            "ь" => "",
            "э" => "e",
            "ю" => "yu",
            "я" => "ya",
            "«" => "",
            "»" => "",
            "№" => "",
            "Ӏ" => "",
            "’" => "",
            "ˮ" => "",
            "_" => "-",
            "'" => "",
            "`" => "",
            "^" => "",
            "\." => "",
            "," => "",
            ":" => "",
            ";" => "",
            "<" => "",
            ">" => "",
            "!" => "",
            "\(" => "",
            "\)" => ""
        ];

        foreach ($tr as $ru => $en) {
            $text = mb_eregi_replace($ru, $en, $text);
        }

        if ($toLower) {
            $text = mb_strtolower($text);
        }

        $text = str_replace(' ', '-', $text);

        return $text;
    }

    /**
     * @param string $str
     * @param int $chars
     * @return string
     */
    public static function shortText(string $str, int $chars = 500): string
    {
        $pos = strpos(substr($str, $chars), " ");
        $srttmpend = strlen($str) > $chars ? '...' : '';

        return substr($str, 0, $chars + $pos) . (isset($srttmpend) ? $srttmpend : '');
    }

    /**
     * @param int $size
     * @param int $maxDecimals
     * @param string $mbSuffix
     * @return string
     */
    public static function formatSizeInMb(int $size, int $maxDecimals = 3, string $mbSuffix = "MB")
    {
        $mbSize = round($size / 1024 / 1024, $maxDecimals);

        return preg_replace("/\\.?0+$/", "", $mbSize) . $mbSuffix;
    }

    /**
     * @return int|float
     */
    public static function detectMaxUploadFileSize(): int|float
    {
        /**
         * Converts shorthands like "2M" or "512K" to bytes
         *
         * @param int $size
         * @return int|float|bool
         */
        $normalize = function (int $size): int|float|bool {
            if (preg_match('/^(-?[\d\.]+)(|[KMG])$/i', $size, $match)) {
                $pos = array_search($match[2], ["", "K", "M", "G"]);
                $size = $match[1] * pow(1024, $pos);
            } else {
                return false;
            }
            return $size;
        };

        $limits = [];
        $limits[] = $normalize(ini_get('upload_max_filesize'));

        if (($max_post = $normalize(ini_get('post_max_size'))) !== 0) {
            $limits[] = $max_post;
        }

        if (($memory_limit = $normalize(ini_get('memory_limit'))) != -1) {
            $limits[] = $memory_limit;
        }

        return min($limits);
    }

    /**
     * @return string
     */
    public static function maxUploadFileSize()
    {
        $maxUploadFileSize = self::detectMaxUploadFileSize();

        if (!$maxUploadFileSize || $maxUploadFileSize == 0) {
            $maxUploadFileSize = 2097152;
        }

        return self::formatSizeInMb($maxUploadFileSize);
    }

    /**
     * @param string $path
     * @return mixed
     */
    public static function getMime(string $path): string
    {
        $path_info = getimagesize($path);

        return $path_info['mime'];
    }

    /**
     * @param string $string
     * @return array|string|string[]
     */
    public static function phone(string $string): string
    {
        return str_replace([' ', '(', ')', '-'], '', $string);
    }

    /**
     * @param string $phone
     * @return string
     */
    public static function getPhoneTag(string $phone): string
    {
        $phone = filter_var(str_replace(['-'], [], $phone), FILTER_SANITIZE_NUMBER_INT);
        return str_replace('+8', '7', $phone);
    }

    /**
     * @param string $string
     * @return string
     */
    public static function clearHtmlTags(string $string): string
    {
        $string = preg_replace("/&#?[a-z0-9]+;/i", "", $string);
        return strip_tags($string);
    }
}