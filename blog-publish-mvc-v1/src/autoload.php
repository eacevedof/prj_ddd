<?php
function dd($var, string $title=""): void
{
    $content= var_export($var,1);
    if($title) echo "<b style=\"font-size: small; font-family: 'Roboto', 'sans-serif'\">$title</b>";
    echo "<pre style=\"background:greenyellow;border:1px solid;\">"
        .$content
        ."</pre>";
}

function pr($var="", string $title=""): void
{
    if($title) $title=" $title: ";

    $content = $var;
    if(!is_string($var)) $content = var_export($var,true);
    if($title) echo "<b style=\"font-size: small; font-family: 'Roboto', 'sans-serif'\">$title</b>";
    echo "<pre style=\"background:yellow;border:1px solid;\">"
        .$content
        ."</pre>";
}

$pathappds = dirname(__FILE__);
set_include_path(get_include_path().":".$pathappds);
spl_autoload_register(function(string $nsclass) use ($pathappds) {
    $nsclass = str_replace(["App\\","\\"],["","/"], $nsclass);
    $nsclass .= ".php";
    include_once $nsclass;
});
