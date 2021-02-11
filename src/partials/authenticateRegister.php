
<?php
require_once 'init.php';

if(isset($_POST['submit'])) {
    $error = false;
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    if(strlen($password) == 0) {
        echo 'Select a password';
        $error = true;
    }
    if($password != $password2) {
        echo 'Passwords are not equal';
        $error = true;
    }
    if(strpos($password, " ") == true || strpos($username, " ") == true) {
        echo 'There is whitespace in your username or password';
        $error = true;
    }
    if(!$error) {
        $statement = $db->prepare("SELECT * FROM users WHERE name = :name");
        $result = $statement->execute([
            "name" => $username
        ]);
        $user = $statement->fetch();

        if($user !== false) {
            echo 'The Username is already taken';
            $error = true;
        }
    }

    if(!$error) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $statement = $db->prepare("
		        	INSERT INTO users (name, password) 
		        	VALUES (:name, :password)
	        ");
        $result = $statement->execute([
            'name' => $username,
            'password' => $password_hash,
        ]);

        if($result) {
            echo 'Success. <a href="login.php">Login</a>';
        } else {
            echo 'Beim Abspeichern ist leider ein Fehler aufgetreten<br>';
        }
    }
}
?>