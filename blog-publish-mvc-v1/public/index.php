<?php
include_once "../src/autoload.php";

use App\Blog\Controllers\PublishController;

try {
    (new PublishController())->publish();
}
catch (Exception | Throwable $ex) {
    pr($ex->getMessage());
    pr("file: ".$ex->getFile()." (".$ex->getLine().")");
}