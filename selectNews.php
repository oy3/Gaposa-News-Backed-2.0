<?php

include "conn.php";

$id = $_POST['id'];

if ($id > 0) {


    $query = "SELECT * FROM news WHERE id = '" . $id . "'";

    $checkRecord = mysqli_query($conn, $query);
    $totalrows = mysqli_num_rows($checkRecord);

    if ($totalrows > 0) {
        $_SESSION['success'] = "Selected news successfully!!";
        echo 'Selected news successfully!!';
    }

    exit();
} else {
    array_push($errors, "Error in selecting news");
    echo 'Error in selecting news';
}