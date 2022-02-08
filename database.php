<?php

$connect = mysqli_connect("127.0.0.1", "root", "", "express", 33333)
    or die("Serverga bog'lanmadi : " . mysqli_error($connect));
