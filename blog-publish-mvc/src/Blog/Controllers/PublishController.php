<?php
namespace App\Blog\Controllers;

use App\Blog\Models\PostEntity;
use App\Blog\Models\Repositories\UserRepository;
use App\Blog\Models\Repositories\PostRepository;
use App\Blog\Models\UserEntity;

final class PublishController
{
    public function publish(): void
    {
        $userId = $this->getRequest("userId", 1, "post");
        $postId = $this->getRequest("postId", 1, "post");

        $postRepository = new PostRepository();
        $post = $postRepository->ofIdOrFail($postId);
        $post->publish();
        $postRepository->save($post);

        $userRepository = new UserRepository();
        $user = $userRepository->ofIdOrFail($userId);
        $this->notifyToUser($user);

        $this->render(["post"=>$post]);
    }

    private function notifyToUser(PostEntity $post, UserEntity $user): void
    {
        echo "sending email ...<br/>";
        mb_send_mail(
            $user->email(),
            "Your post with id {$post->id()} has been published",
            "Congrats!"
        );
    }

    private function render(array $vars=[]): void
    {
        foreach ($vars as $name=>$value)
            $$name = $value;
        include_once "Blog/Views/post-published.php";
        exit();
    }

    private function getRequest(string $key, $default=null, string $from="get")
    {
        if($from==="post") return $_POST[$key] ?? $default;
        return $_GET[$key] ?? $default;
    }
}