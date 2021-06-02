<?php
$db = new PDO('mysql:dbname=idea;host=localhost', 'root', '');
$savesQuery = $db->prepare("
    SELECT * FROM saves
    WHERE id = :id
");
$savesQuery->execute([
    'id' => $_GET["id"]
]);

$currentSave = $savesQuery->fetch();


$inputQuery = $db->prepare("
    SELECT * FROM words
    WHERE save_id = :save_id
");
$inputQuery->execute([
    'save_id' => $_GET["id"]
]);

$inputs = $inputQuery->rowCount() ? $inputQuery->fetchAll(\PDO::FETCH_ASSOC) : [];
?>

<html>
<script>
    search = "<?php echo 'lang='.$_GET["lang"] ?>";
    id = "<?php echo $_GET["id"] ?>";
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="src/style/style.css">
<script src="src/script/libraries/carousel.js"></script>
<script src="src/script/script.js"></script>
<head>
    <title>Idea Searcher</title>
</head>
<body>
<?php include 'src/partials/saves.php'; ?>
<div id="content">
    <h1 id="word"><?php echo $currentSave["word"] ?></h1>
    <span class="material-icons md-4" id="next-word">skip_next</span>
    <div class="floating-action-button">
        <div>
            <span class="material-icons md-3" id="download">download</span>
        </div>
        <div>
            <label for="file" class="material-icons md-3" id="upload">upload</label>
            <input type="file" name="file" id="file">
        </div>
        <div>
            <span class="material-icons md-3" id="save">save</span>
        </div>
    </div>
    <?php foreach ($inputs as $input) { ?>
        <input type='text' data-new="false" placeholder='input' class='input-word' style='position: absolute; left: <?php echo $input["left_val"]."px" ?>; top: <?php echo $input["top_val"]."px" ?>' value="<?php echo $input["word"] ?>">
    <?php } ?>
</div>
</body>
</html>