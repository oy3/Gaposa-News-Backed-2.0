<?php

include "conn.php";

$errors = array();
$id = $_POST['id'];

if ($id > 0) {

    $query = "SELECT * FROM news WHERE id = '" . $id . "'";

    // Check record exists
    $checkRecord = mysqli_query($conn, $query);

    $totalrows = mysqli_num_rows($checkRecord);

    if ($totalrows > 0) {
        // Delete record
        $query = "DELETE FROM news WHERE id = '" . $id . "'";
        mysqli_query($conn, $query);
        echo 1;
        exit;
    }

}

echo $id;
exit;