
<?php
require_once 'init.php';

session_start();


if ( !isset($_POST['username'], $_POST['password']) ) {
    exit('Please fill both the username and password fields!');
}
else{
    $userQuery = $db->prepare("
		SELECT * FROM users
		WHERE name = :name
	");
    $userQuery->execute([
        'name' => trim($_POST['username'])
    ]);
    $user = $userQuery->fetch();
    if(!empty($user)){
        if(password_verify($_POST['password'], $user['password'])){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['name'];
            header("Location: index.php");
        }
        else{

        }
    }
    else{
        header("Location: index.php");
    }
}