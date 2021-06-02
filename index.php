<?php
    session_start();
    if(!isset($_SESSION['user_id'])){
        header("Location: login.php");
    }
    if(isset($_GET["lang"])){
        $lang = $_GET["lang"];
    }
    else{
        $lang = "en";
    }
?>

<html>
    <script>
        search = "<?php echo 'lang='.$lang ?>";
        id = null;
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
        <h1 id="word"></h1>
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
    </div>
</body>
</html>
<script>
    get_random_word().then((response) => $("#word").html(response));
</script>