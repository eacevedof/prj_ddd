<?php
namespace App\Blog\Controllers;

final class PublishController
{
    public function publish(): void
    {

        $this->render(["post"=>$post]);
    }

    private function render(array $vars): void
    {
        foreach ($vars as $name=>$value)
            $$name = $value;
        include_once "../Views/post-published.php";
        exit();
    }
}