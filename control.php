<?php
session_start();
require_once 'database.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Pstyle.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
</head>

<body>
    <div class="container">

        <div class="change">
            <form class="row justify-content-center" method="POST">
                <div class="col-auto">
                    <input type="text" name="username" class="form-control" placeholder="Search...">
                </div>
                <div class="col-auto">
                    <input type="submit" name="" class="form-control" value="Search">
                </div>
                <div class="col-auto">
                    <a class="btn btn-primary" href="create.php" role="button">Add</a>
                </div>
            </form>
        </div>

        <table class="table table-success table-striped table-hover">
            <tr>
                <th colspan="5">Foydalanuvchilar jadvali</th>
            </tr>
            <tr>
                <th>ID</th>
                <th>Ism</th>
                <th>Telefon raqam</th>
                <th>O'zgartirish</th>
            </tr>
            <?php
            $query = "SELECT * FROM users";
            if (isset($_POST['username'])) {
                $username = $_POST['username'];
                $query .= " WHERE `name` LIKE '%{$username}%'";
            }
            $result = mysqli_query($connect, $query) or die("So'rov ishlamadi : " . mysqli_error($connect));
            while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                print "<tr>";
                print "<td>{$line['user_id']}</td>";
                print "<td>{$line['name']}</td>";
                print "<td>{$line['contact']}</td>";
                print "<td><a href=\"/edit.php?user_id={$line['user_id']}\"><img src='icons/editing.png'></a></td>";
                //print "<td><a href=\"/delete.php?user_id={$line['user_id']}\"><img src='icons/bin.png'></a></td>";
            }
            ?>
        </table>

    </div>

    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>