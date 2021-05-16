<?php
/**
 * Created by PhpStorm.
 * User: NeoN
 * Date: 29.11.2018
 * Time: 17:35
 */


if (!function_exists('parseMultiLanguageString')) {
    function parseMultiLanguageString($string, $languageKey = null, $tilda = false)
    {
        if (empty($languageKey)) {
            $languageKey = app()->getLocale();
        }
        if (!is_array($string)) {
            $string = json_decode($string, true);
        }

        return isset($string[$languageKey]) ? $string[$languageKey] : ($tilda ? '~' : null);
    }
}