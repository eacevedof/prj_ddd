<?php
function dd($var,$title=""){
    $sContent= var_export($var,1);
    if($title) echo "<b style=\"font-size: small; font-family: 'Roboto', 'sans-serif'\">$title</b>";
    echo "<pre style=\"background:greenyellow;border:1px solid;\">"
        .$sContent
        ."</pre>";
}

function pr($var="",$sTitle=NULL)
{
    if($sTitle)
        $sTitle=" $sTitle: ";

    if(!is_string($var))
        $var = var_export($var,TRUE);
    #F1E087
    $sTagPre = "<pre function=\"pr\" style=\"border:1px solid black;background:yellow; padding:0px; color:black; font-size:12px;\">\n";
    $sTagFinPre = "</pre>\n";
    echo $sTagPre.$sTitle.$var.$sTagFinPre;
}//function pr

$pathappds = dirname(__FILE__).DIRECTORY_SEPARATOR;
//dd($pathappds);
spl_autoload_register(function(string $nsclass) use ($pathappds) {
    //nsclass: App\\Blog\\Infrastructure\\PostController
    $nsclass = str_replace(["App\\","\\"],["","/"], $nsclass);
    $nsclass .= ".php";
    $pathclass = realpath($pathappds.$nsclass);
    if (is_file($pathclass)) include_once($pathclass);
});