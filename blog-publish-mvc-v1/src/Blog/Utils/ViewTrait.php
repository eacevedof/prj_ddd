<?php
namespace App\Blog\Utils;

trait ViewTrait
{
    private array $vars = [];

    private function set(string $varName, $value): self
    {
        $this->vars[$varName] = $value;
        return $this;
    }

    private function render(string $path): void
    {
        foreach ($this->vars as $name=>$value) {
            $$name = $value;
        }

        include_once("Blog/views/$path.php");
        exit();
    }
}