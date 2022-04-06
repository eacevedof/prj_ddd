<?php
namespace App\Blog\Controllers;

use App\Blog\Models\Repositories\PostRepository;
use App\Blog\Models\Repositories\UserRepository;
use App\Blog\Services\PostPublishService;
use App\Blog\Utils\RequestTrait;
use App\Blog\Utils\ViewTrait;
use \Exception;

final class PublishController
{
    use RequestTrait;
    use ViewTrait;

    public function publish(): void
    {
        $userId = $this->getRequestSession("userId", 1);
        $postId = $this->getRequestPost("postId", 1);

        try {
            $post = (new PostPublishService(
                new UserRepository(),
                new PostRepository()
            ))->execute($userId, $postId);

            $this->set("post", $post);
        }
        catch (Exception $e) {
            $this->set("error", $e->getMessage());
        }
        pr("rendering saved post ...");
        $this->render("post-published");
    }
}