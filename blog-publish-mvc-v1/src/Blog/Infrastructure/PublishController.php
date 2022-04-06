<?php
namespace App\Blog\Infrastructure;

use App\Blog\Infrastructure\Repositories\UserRepository;
use App\Blog\Infrastructure\Repositories\PostRepository;
use App\Blog\Application\MonologService;
use App\Blog\Application\NotifyService;
use App\Blog\Application\PostPublishService;
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
                $postRepository = new PostRepository(),
                new NotifyService($userRepository = new UserRepository(), $postRepository),
                new MonologService($userRepository, $postRepository)
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