<?php
/**
 * Created by PhpStorm.
 * User: jameshill
 * Date: 6/5/15
 * Time: 9:39 AM
 */
session_start();
require_once(dirname(__DIR__) . "/lib/csrfver.php");
echo generateInputTags();

?>