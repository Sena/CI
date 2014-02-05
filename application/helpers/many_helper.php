<?php
/*
 * Method to change date pattern
 * @param String the $date to change the pattern
 * @param String the $newPattern to the new date
 */
if ( ! function_exists('convertDate')) {
    function convertDate($date, $newPattern = NULL) {
        $oldPattern = '#(\d{2})[/-](\d{2})[/-](\d{4})#';
        preg_match($oldPattern, $date, $matches);
        $date = $matches[3] . '-' . $matches[2] . '-' . $matches[1];
        if($newPattern !== NULL) {
            $date = date($newPattern, strtotime($date));            
        }
        return $date;
    }
}
/*
 * Method to checks if mb_string is installed and use it, or switch to normal strtolower
 * @param String the $data to change to lower
 * @param String the $charset
 */
if ( ! function_exists('str2lower')) {
    function str2lower($data, $charset = 'UTF-8') {
        return function_exists('mb_strtolower') ? mb_strtolower($data, $charset) : strtolower($data);
    }
}/*
 * Method to checks if mb_string is installed and use it, or switch to normal strtoupper
 * @param String the $data to change to upper
 * @param String the $charset
 */
if ( ! function_exists('str2upper')) {
    function str2upper($data, $charset = 'UTF-8') {
        return function_exists('mb_strtoupper') ? mb_strtoupper($data, $charset) : strtoupper($data);
    }
}