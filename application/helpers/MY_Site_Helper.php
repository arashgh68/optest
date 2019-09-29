<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Mohammad
 * Date: 12/29/2018
 * Time: 4:10 PM
 */
//this function generates the text related to the question level for display in website
if ( ! function_exists('question_level_indicator')) {
    function question_level_indicator($level)
    {
        if ($level > 8)
            return 'بسیار دشوار';
        else if ($level > 6)
            return 'دشوار';
        else if ($level > 4)
            return 'میانه';
        else if ($level > 2)
            return 'آسان';
        else
            return 'بسیار آسان';
    }
}
?>