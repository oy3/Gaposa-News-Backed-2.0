<?php

include "conn.php";

$id = $_POST['id'];
$title = $_POST['title'];
$content = $_POST['content'];
$pname = $_POST['publisher'];

if (isset($_POST['edit_row'])) {


    $query = "UPDATE news SET title = '{$title}', content = '{$content}', publisher = '{$pname}' WHERE id = " . $id;
    mysqli_query($conn, $query);

    $_SESSION['success'] = "Updated news successfully!!";
    exit();
} else {
    array_push($errors, "Error in updating news");
}