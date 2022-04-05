<?php
date_default_timezone_set("UTC");
session_start();
ob_start();
include_once "../src/autoload.php";

use App\Blog\Controllers\PublishController;

try {
    (new PublishController())->publish();
}
catch (Exception | Throwable $ex) {
    pr($ex->getMessage());
    pr("file: ".$ex->getFile()." (".$ex->getLine().")");
}
ob_end_flush();