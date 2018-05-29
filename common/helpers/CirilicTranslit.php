<?php

namespace common\helpers;

class CirilicTranslit
{
    const STRICT_CHAR_PATTERN = '/[^a-z0-9_-]*/';


    /** @lang text */
    private static $converter = [
        'а' => 'a',   'б' => 'b',   'в' => 'v',
        'г' => 'g',   'д' => 'd',   'е' => 'e',
        'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
        'и' => 'i',   'й' => 'y',   'к' => 'k',
        'л' => 'l',   'м' => 'm',   'н' => 'n',
        'о' => 'o',   'п' => 'p',   'р' => 'r',
        'с' => 's',   'т' => 't',   'у' => 'u',
        'ф' => 'f',   'х' => 'h',   'ц' => 'c',
        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
        'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

        'А' => 'A',   'Б' => 'B',   'В' => 'V',
        'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
        'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
        'И' => 'I',   'Й' => 'Y',   'К' => 'K',
        'Л' => 'L',   'М' => 'M',   'Н' => 'N',
        'О' => 'O',   'П' => 'P',   'Р' => 'R',
        'С' => 'S',   'Т' => 'T',   'У' => 'U',
        'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
        'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
        'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
        'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
    ];




    /**
     * @return array
     */
    public static function getTransliteration()
    {
        return self::$converter;
    }

    /**
     * @param $str
     * @param null $maxLen
     * @return mixed|string
     *
     * Транслитерация кирилицы
     */
    public static function strictLowCaseTranslit($str, $maxLen = null){


        $rez = mb_strtolower($str, 'UTF-8');
        $rez = str_replace(array_keys(self::$converter), self::$converter, $rez);
        $rez = str_replace(' ', '-', $rez);
        $rez = preg_replace(self::STRICT_CHAR_PATTERN, '', $rez);

        if($maxLen !== null){
            $rez = substr($rez, 0, $maxLen);
        }

        return $rez;
    }
}