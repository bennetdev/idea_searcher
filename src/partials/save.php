<?php
session_start();
$db = new PDO('mysql:dbname=idea;host=localhost', 'root', '');
$json = $_POST;
$get_save_id = $db->prepare("
					SELECT id from saves
                    WHERE user_id = :user_id AND id = :id
			");

$get_save_id->execute([
    "id" => $json["current_id"],
    "user_id" => $_SESSION["user_id"]
]);
$save = $get_save_id->rowCount() ? $get_save_id->fetchAll(\PDO::FETCH_ASSOC)[0] : [];

if(empty($save)){
    $addSaveQuery = $db->prepare("
					INSERT saves (word, user_id)
					VALUES (:word, :user_id)
			");

    $addSaveQuery->execute([
        "word" => $json["word"],
        "user_id" => 1
    ]);
    $lastId = $db->lastInsertId();
}
else{
    $lastId = $json["current_id"];
}



foreach ($json["words"] as $word){
    if($word["new"] == "true"){
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
    }
}