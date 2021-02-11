<?php
$db = new PDO('mysql:dbname=idea;host=localhost', 'root', '');
$json = $_POST;
$addSaveQuery = $db->prepare("
					INSERT saves (word, user_id)
					VALUES (:word, :user_id)
			");

$addSaveQuery->execute([
    "word" => $json["word"],
    "user_id" => 1

]);
$lastId = $db->lastInsertId();

foreach ($json["words"] as $word){
    echo print_r($word);
    $addWordQuery = $db->prepare("
                INSERT into words (word, top_val, left_val, save_id)
                VALUES (:word, :top_val, :left_val, :save_id)
        ");

    $addWordQuery->execute([
        "save_id" => $lastId,
        "word" => $word["word"],
        "left_val" => floatval($word["left"]),
        "top_val" => floatval($word["top"])
    ]);
    echo print_r($addWordQuery->errorCode());
}