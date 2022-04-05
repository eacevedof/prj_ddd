<?php
namespace App\Blog\Controllers;

use App\Blog\Models\Repositories\UserRepository;
use App\Blog\Models\Repositories\PostRepository;

final class PublishController
{
    public function publish(): void
    {
        $userId = $this->getRequest("userId", 1, "post");
        $postId = $this->getRequest("postId", 1, "post");
        $postRepository = new PostRepository();
        $userRepository = new UserRepository();



        $this->render(["post"=>$post]);
    }

    private function render(array $vars): void
    {
        foreach ($vars as $name=>$value)
            $$name = $value;
        include_once "../Views/post-published.php";
        exit();
    }

    private function getRequest(string $key, $default=null, string $from="get")
    {
        if($from==="post") return $_POST[$key] ?? $default;
        return $_GET[$key] ?? $default;
    }
}