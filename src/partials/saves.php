<?php
if(!isset($_SESSION)){
    session_start();
}

$db = new PDO('mysql:dbname=idea;host=localhost', 'root', '');
$savesQuery = $db->prepare("
    SELECT * FROM saves
    WHERE user_id = :user_id
");
$savesQuery->execute([
    'user_id' => $_SESSION["user_id"]
]);

$saves = $savesQuery->rowCount() ? $savesQuery->fetchAll(\PDO::FETCH_ASSOC) : [];
?>


<div id="saves-box">
    <div id="saves">
        <?php foreach ($saves as $save) { ?>
            <div class="save shadow" id="<?php echo $save['id']; ?>">
                <h2><?php echo $save["word"]; ?></h2>
            </div>
        <?php } ?>
        <div id="add-save" class="save shadow">
            <span class="material-icons md-3">add</span>
        </div>
    </div>
</div>
<div class="save-move" id="save-left">
    <span class="material-icons md-3">chevron_left</span>
</div>
<div class="save-move" id="save-right">
    <span class="material-icons md-3">chevron_right</span>
</div>
<div id="hide-saves-box">
    <span class="material-icons md-3" id="hide-saves">keyboard_arrow_up</span>
</div>