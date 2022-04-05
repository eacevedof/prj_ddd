<?php
/**
 * @var App\Blog\Models\PostEntity $post;
 */
if (isset($error)) dd($error, "Some error occurred:");
?>
<h1>Post status: <?=$post->status() ? "Published" : "Not published"?></h1>
<h2><?=$post->title()?></h2>
<p>
    <?=$post->content()?>
</p>