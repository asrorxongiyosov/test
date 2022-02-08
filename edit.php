<?php
require_once 'database.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    $id = $_GET['user_id'];
    $query = "SELECT * FROM users WHERE user_id = {$id}";
    $result = mysqli_query($connect, $query);
    $data = mysqli_fetch_assoc($result);

    ?>
    <form method="POST">
        <input type="text" name="name" value="<?= $data['name'] ?>">
        <input type="text" name="contact" value="<?= $data['contact'] ?>">
        <input type="text" name="password" value="<?= $data['password'] ?>">
        <input type="submit" value="Edit" name="addSubmit">
    </form>
    <?php
    if (isset($_POST['addSubmit'])) {
        $name = $_POST['name'];
        $password = $_POST['password'];
        $contact = $_POST['contact'];
        $name = mysqli_real_escape_string($connect, $name);
        $password = mysqli_real_escape_string($connect, $password);
        $contact = mysqli_real_escape_string($connect, $contact);
        $query = "UPDATE users SET `name`='{$name}' , `contact`='{$contact}' WHERE `user_id`={$data['user_id']}";

        $result = mysqli_query($connect, $query) or die("So'rov ishlamadi : " . mysqli_error($connect));

        mysqli_close($connect);

        header('Location: /control.php');
        exit;
    }
    ?>
</body>

</html>