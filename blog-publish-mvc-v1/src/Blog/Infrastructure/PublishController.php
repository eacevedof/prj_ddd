<?php
namespace App\Blog\Infrastructure;

use App\Blog\Application\Commands\PublishCommand;
use App\Blog\Application\KafkaService;
use App\Blog\Application\PostPublishingCommandHandler;
use App\Blog\Infrastructure\EventSourcing\DomainEventPublisher;
use App\Blog\Infrastructure\Repositories\UserRepository;
use App\Blog\Infrastructure\Repositories\PostRepository;
use App\Blog\Application\MonologService;
use App\Blog\Application\NotifyService;
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
            DomainEventPublisher::instance()->subscribe(new KafkaService());
            $post = (new PostPublishingCommandHandler(
                $postRepository = new PostRepository(),
                new NotifyService($userRepository = new UserRepository(), $postRepository),
                new MonologService($userRepository, $postRepository)
            ))->execute(new PublishCommand($userId, $postId));

            $this->set("post", $post);
        }
        catch (Exception $e) {
            $this->set("error", $e->getMessage());
        }
        pr("rendering saved post ...");
        $this->render("post-published");
    }
}