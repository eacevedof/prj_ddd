<?php
include_once "../src/autoload.php";

use App\Blog\Controllers\PublishController;
var_dump(get_included_files());
(new PublishController())->publish();
