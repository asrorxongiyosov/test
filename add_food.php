<?php
require_once 'database.php';

if (isset($_POST['submit'])) {
    $uploaddir = '/food/photos/';
    $uploadfile = __DIR__ . $uploaddir . basename($_FILES['foodPhoto']['name']);
    if (move_uploaded_file(
        $_FILES['foodPhoto']['tmp_name'],
        $uploadfile
    )) {
        echo "Fayl yuklandi.\n";
    } else {
        echo "Fayl yuklanmadi!\n";
    }
    echo '<pre>FILE MASSIV: ';
    print_r($_FILES);
}



if (isset($_POST['submit'])) {

    $query1 = "SELECT MAX(food_id) FROM food";
    $result1 = mysqli_query($connect, $query1);
    $result1 = mysqli_fetch_assoc($result1);
    $result1['MAX(food_id)'];
    echo $result1['MAX(food_id)'];
    $name = $_POST['name'];
    $type = $_POST['type'];
    $price = $_POST['price'];
    $photo = $uploaddir . basename($_FILES['foodPhoto']['name']);

    $name = mysqli_real_escape_string($connect, $name);
    $type = mysqli_real_escape_string($connect, $type);
    $price = mysqli_real_escape_string($connect, $price);
    $photo = mysqli_real_escape_string($connect, $photo);

    $query = "INSERT INTO food(name,type,price,photo,restourant_id)VALUES('{$name}','{$type}',{$price},'{$photo}',{$result1['MAX(food_id)']})";
    $result = mysqli_query($connect, $query) or die("So'rov ishlamadi : " . mysqli_error($connect));
    /*
    $query2 = "INSERT INTO restourant()";
    $result = mysqli_query($connect, $query2) or die("So'rov ishlamadi : " . mysqli_error($connect));*/
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
</head>

<body>

    <div class="container d-flex align-items-center justify-content-center" style="height: 100vh;">

        <form class="row needs-validation novalidate" enctype="multipart/form-data" method="POST">
            <h1><span class="badge bg-success d-flex justify-content-center">Food</span></h1>
            <div class="col-6">
                <label for="inputAddress" class="form-label badge bg-success">Enter food name</label>
                <input style="outline-color: #198754;" name="name" type="text" class="form-control" id="inputAddress" placeholder="Food name" required>
            </div>

            <div class="col-6">
                <label for="inputNumber" class="form-label badge bg-success">Enter food price</label>
                <input name="price" type="number" class="form-control" id="inputNumber" placeholder="Price" required>
            </div>

            <div class="col-6">
                <label class="form-label badge bg-success" for="autoSizingSelect">Choose restourant name</label>
                <select class="form-select" id="autoSizingSelect" name="rname" required>
                    <option selected>Choose restourant name...</option>
                    <option value="1">Evos</option>
                    <option value="2">Feed up</option>
                    <option value="3">Oq-tepa lavash</option>
                    <option value="4">Max Way</option>
                </select>
            </div>

            <div class="col-6">
                <label class="form-label badge bg-success" for="autoSizingSelect">Choose food type</label>
                <select class="form-select" id="autoSizingSelect" onchange="document.getElementById('text_type').value=this.options[this.selectedIndex].text" required>
                    <option selected>Choose food type...</option>
                    <option value="1">Fast food</option>
                    <option value="2">Milliy taom</option>
                    <option value="3">Ichimlik</option>
                </select>
                <input name="type" type="hidden" id="text_type" value="">
            </div>

            <div class="col-12">
                <label class="form-label badge bg-success" for="photo">Choose food photo</label>
                <input type="file" class="form-control" id="photo" aria-label="file example" name="foodPhoto" required placeholder="Choose photo...">
            </div>

            <div class="col-4 mt-2">
                <button class="btn btn-success" type="submit" name="submit">Add to database</button>
            </div>
        </form>

    </div>

    <script src="/js/jquery.js"></script>
    <script src="/bootstrap/js/bootstrap.min.js"></script>
    <script src="/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>