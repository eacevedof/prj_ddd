<?php

namespace App\Blog\Infrastructure;

final class Kafka
{
    public function produce($content, string $title=""): void
    {
        if(!is_string($content)) $content = var_export($content, 1);
        $path = dirname(__FILE__).DIRECTORY_SEPARATOR."kafka.log";
        $final = [];
        if($title) $final["title"] = $title;
        $final["content"] = $content;
        file_put_contents($path, json_encode($final), FILE_APPEND);
    }
}