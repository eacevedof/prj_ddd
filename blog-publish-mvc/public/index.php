<?php
include_once "../src/autoload.php";

use App\Blog\Controllers\PublishController;
(new PublishController())->publish();