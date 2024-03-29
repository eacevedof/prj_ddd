<?php
namespace App\Blog\Models;

final class PostEntity
{
    private int $id;
    private int $status;
    private string $title;
    private string $content;

    public function __construct(int $id, string $title="", string $content="")
    {
        $this->id = $id;
        $this->status = 0;
        $this->title = $title;
        $this->content = $content;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function status(): int
    {
        return $this->status;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function content(): string
    {
        return $this->content;
    }

    public function publish(): self
    {
        $this->status = 1;
        pr("post status changed ...");
        return $this;
    }
}