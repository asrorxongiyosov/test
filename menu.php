<?php
session_start();
require_once 'database.php';

if (!isset($_SESSION['savat'])) {
    $_SESSION['savat'] = array();
}

if (isset($_POST['food_id']) && isset($_POST['add'])) {
    $food_id = $_POST['food_id'];
    $price = $_POST['price'];
    $amount = $_POST['amount'];
    $fname = $_POST['name'];

    $item = array();
    array_push($item, $food_id);
    array_push($item, $price);
    array_push($item, $amount);
    array_push($item, $fname);

    array_push($_SESSION['savat'], $item);
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Pstyle.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
</head>

<body>

    <div class="container">
        <!-- Navbar start-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Express 24</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Categories</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contacts</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">About</a>
                        </li>
                    </ul>
                    <form class="d-flex">
                        <input class="form-control me-2 btn-outline-warning" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-warning" type="submit">Search</button>
                    </form>
                </div>
            </div>

            <?php if (isset($_SESSION['user_id'])) : ?>
                <a class="nav-link btn btn-outline-warning text-success" aria-current="page" href="#"><?= $_SESSION['name'] ?><br></a>
                <a class="nav-link mr-2" href=""><img class="user" src="<?= $_SESSION['photo']; ?>" alt=""></a>
            <?php else : ?>
                <a href="/create.php" class="btn mx-2 btn-warning btn">Kirish</a>
            <?php endif ?>

        </nav>
        <!-- Navbar end-->

        <ul class="list-group">
            <li class="list-group-item"><a href="/exit.php" class="btn btn-warning btn">Chiqish</a></li>
            <li class="list-group-item">
                <!-- Order list menu -->
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-warning position-relative" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <img class="img-fluid" src="/icons/shopping-cart.png" alt="">
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        <?php
                        $number = 0;
                        for ($i = 0; $i < count($_SESSION['savat']); $i++) {
                            $number = $number + $_SESSION['savat'][$i][2];
                        }
                        echo $number;
                        ?>
                        <span class="visually-hidden">unread messages</span>
                    </span>
                </button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Savatcha</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <table class="table">
                                    <tr>
                                        <th>Mahsulot nomi</th>
                                        <th>Mahsulot narxi</th>
                                        <th>Buyurtma soni</th>
                                    </tr>
                                    <?php
                                    for ($i = 0; $i < count($_SESSION['savat']); $i++) {
                                    ?>
                                        <tr>
                                            <td><?= $_SESSION['savat'][$i][3] ?></td>
                                            <td><?= $_SESSION['savat'][$i][1] ?></td>
                                            <td><?= $_SESSION['savat'][$i][2] ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                    <tr>
                                        <th>Umumiy summa:</th>
                                        <th colspan="2">
                                            <?php
                                            $sum = 0;
                                            for ($i = 0; $i < count($_SESSION['savat']); $i++) {
                                                $sum = $sum + ($_SESSION['savat'][$i][1] * $_SESSION['savat'][$i][2]);
                                            }
                                            echo $sum . " so'm";
                                            ?>
                                        </th>
                                    </tr>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Yopish</button>
                                <button type="button" class="btn btn-warning">Tasdiqlash</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal end -->

            </li>
        </ul>

        <div class="container">

            <div class="row">

                <?php
                $query = "SELECT food.food_id, food.name, food.type, food.price, food.photo, restourant.name as rname FROM food INNER JOIN restourant USING(restourant_id)";
                $result = mysqli_query($connect, $query) or die("So'rov ishlamadi : " . mysqli_error($connect));

                while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                ?>
                    <div class="card col-4 my-2">
                        <img src="<?= $line['photo'] ?>" class="card-img mt-1 img-fluid">
                        <div class="card-body">
                            <div class="row">
                                <h5 class="card-title col-4"><?= $line['name'] ?></h5>
                                <p class="card-text col-4"><small class="text-muted"><?= $line['rname'] ?></small></p>
                                <h5 class="card-title col-4"><?= $line['price'] ?> so'm</h5>
                            </div>
                            <form method="POST">
                                <div class="row">
                                    <div class=" col-9">
                                        <input name="amount" type="number" class="form-control">
                                        <input name="food_id" type="hidden" value="<?= $line['food_id'] ?>">
                                        <input name="price" type="hidden" value="<?= $line['price'] ?>">
                                        <input name="name" type="hidden" value="<?= $line['name'] ?>">
                                    </div>
                                    <button type="submit" class="btn btn-warning col-3" name="add">Qo'shish</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- PHP cod oxiri -->
                <?php
                }
                ?>

                <div class="card col-4 my-2">
                    <img src="..." class="card-img-top mt-2" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a wider card with supporting text below as a natural
                            lead-in to
                            additional content. This content is a little bit longer.</p>
                        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                    </div>
                </div>
                <div class="card col-4 my-2">
                    <img src="..." class="card-img-top mt-2" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a wider card with supporting text below as a natural
                            lead-in to
                            additional content. This content is a little bit longer.</p>
                        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                    </div>
                </div>
                <div class="card col-4 my-2">
                    <img src="..." class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a wider card with supporting text below as a natural
                            lead-in to
                            additional content. This content is a little bit longer.</p>
                        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                    </div>
                </div>
                <div class="card col-4 my-2">
                    <img src="..." class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a wider card with supporting text below as a natural
                            lead-in to
                            additional content. This content is a little bit longer.</p>
                        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                    </div>
                </div>
                <div class="card col-4 my-2">
                    <img src="..." class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a wider card with supporting text below as a natural
                            lead-in to
                            additional content. This content is a little bit longer.</p>
                        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                    </div>
                </div>
                <div class="card col-4 my-2">
                    <img src="..." class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a wider card with supporting text below as a natural
                            lead-in to
                            additional content. This content is a little bit longer.</p>
                        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                    </div>
                </div>
                <div class="card col-4 my-2">
                    <img src="..." class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a wider card with supporting text below as a natural
                            lead-in to
                            additional content. This content is a little bit longer.</p>
                        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                    </div>
                </div>
                <div class="card col-4 my-2">
                    <img src="..." class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a wider card with supporting text below as a natural
                            lead-in to
                            additional content. This content is a little bit longer.</p>
                        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                    </div>
                </div>
                <div class="card col-4 my-2">
                    <img src="..." class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a wider card with supporting text below as a natural
                            lead-in to
                            additional content. This content is a little bit longer.</p>
                        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                    </div>
                </div>
                <div class="card col-4 my-2">
                    <img src="..." class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a wider card with supporting text below as a natural
                            lead-in to
                            additional content. This content is a little bit longer.</p>
                        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                    </div>
                </div>


            </div>

        </div>

    </div>

    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>