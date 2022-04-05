<?php
namespace App\Blog\Utils;

trait RequestTrait
{
    private function getGet($key, $default=null)
    {
        return $_GET[$key] ?? $default;
    }

    private function getPost($key, $default=null)
    {
        return $_POST[$key] ?? $default;
    }

    private function getSession($key, $default=null)
    {
        return $_SESSION[$key] ?? $default;
    }
}