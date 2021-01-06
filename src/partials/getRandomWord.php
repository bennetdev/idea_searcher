<?php
    $lang = $_GET["lang"];
    if($lang == "de"){
        $words = explode("\n", file_get_contents("../files/words_german.txt"));
    }
    else{
        $words = explode("\n", file_get_contents("../files/words.txt"));
    }

    echo $words[array_rand($words)];