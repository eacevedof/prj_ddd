<?php
namespace App\Blog\Application\Commands;

final class PublishCommand implements ICommand
{
    private int $authorId;
    private int $postId;

    public function __construct(int $authorId, int $postId)
    {
        $this->authorId = $authorId;
        $this->postId = $postId;
    }

    public function authorId():int
    {
        return $this->authorId;
    }

    public function postId():int
    {
        return $this->postId;
    }
}