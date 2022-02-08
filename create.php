<?php
session_start();

/*
if (isset($_SESSION['user_id'])) {
    header('Location: /menu.php');
}
*/

if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin') {
    header('Location: /control.php');
} elseif (isset($_SESSION['user_id']) && $_SESSION['role'] === "user") {
    header('Location: /menu.php');
}

require_once 'database.php';

if (isset($_POST['signup'])) {
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $password = $_POST['password'];

    $name = mysqli_real_escape_string($connect, $name);
    $contact = mysqli_real_escape_string($connect, $contact);
    $password = mysqli_real_escape_string($connect, $password);

    $query = "INSERT INTO users (name, contact, password) VALUES('{$name}', '{$contact}', '{$password}')";

    $result = mysqli_query($connect, $query) or die("So'rov ishlamadi : " . mysqli_error($connect));

    $query = "SELECT * FROM users WHERE name='{$name}' AND password='{$password}'";

    $result = mysqli_query($connect, $query);
    if (mysqli_num_rows($result) > 0) {
        $result = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $result['user_id'];
        $_SESSION['name'] = $result['name'];
        $_SESSION['role'] = $result['role'];
        $_SESSION['photo'] = $result['photo'];

        header('refresh:1;url=/menu.php');
    } else {
        $error = 1;
    }

    mysqli_close($connect);

    header('Location: /menu.php');
    exit;
} elseif (isset($_POST['signin'])) {
    $name = $_POST['name'];
    $password = $_POST['password'];
    $name = mysqli_real_escape_string($connect, $name);
    $password = mysqli_real_escape_string($connect, $password);

    $query = "SELECT * FROM users WHERE name='{$name}' AND password='{$password}'";

    $result = mysqli_query($connect, $query);
    if (mysqli_num_rows($result) > 0) {
        $result = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $result['user_id'];
        $_SESSION['name'] = $result['name'];
        $_SESSION['role'] = $result['role'];
        $_SESSION['photo'] = $result['photo'];

        if ($result['role'] == 'admin') {
            header('refresh:1;url=/control.php');
        } else {
            header('refresh:1;url=/menu.php');
        }
    } else {
        $error = 1;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="createStyle.css">
</head>

<body>
    <div class="container">
        <div class="blueBg">
            <div class="box signin">
                <h2>Already have an account ?</h2>
                <button class="signinBtn">Sign in</button>
            </div>

            <div class="box signup">
                <h2>Don't have an account ?</h2>
                <button class="signupBtn">Sign up</button>
            </div>
        </div>
        <div class="formBx">
            <div class="form signinForm">
                <form method="POST">
                    <h3>Sign In</h3>
                    <input type="text" name="name" placeholder="Username">
                    <input type="password" name="password" placeholder="Password">
                    <input type="submit" value="Login" name="signin">
                    <a href="#" class="forgot">Forgot password</a>
                </form>
            </div>

            <div class="form signupForm">
                <form method="POST">
                    <h3>Sign Up</h3>
                    <input type="text" name="name" placeholder="Username">
                    <input type="text" name="contact" placeholder="Contact">
                    <input type="password" name="password" placeholder="Password">
                    <input type="submit" value="Register" name="signup">
                </form>
            </div>
        </div>
    </div>

    <script src="createScript.js"></script>
</body>

</html>