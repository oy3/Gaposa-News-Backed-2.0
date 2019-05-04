<?php
// connect to database
$db = mysqli_connect('localhost', 'root', 'root', 'gaposa');
//delete
if(isset($_POST['btndelete'])) {

  $news_id = mysqli_real_escape_string($db, trim($_POST["getID"]));

  $sql = "DELETE FROM newstbl WHERE id = '".$news_id."' " ;
  $result = $db->query($sql);
  if ($result) {

  	header("refresh:0; url= home.php");

    echo "<script type='text/javascript'>alert('Record deleted successfully')</script>";
    } else {
    echo "Error deleting record: " ;
    }
}//end of delete
?>

global $conn, $errors;

$newsId = mysqli_real_escape_string($conn, trim($_POST["getID"]));

// $id  =  e($_POST['getID']);

if (count($errors) == 0) {

$query = "DELETE FROM news WHERE id = 9 ";
mysqli_query($conn, $query);

echo "<script type='text/javascript'>alert('Record deleted successfully')</script>";
$_SESSION['success'] = "Deleted news successfully";
} else {
array_push($errors, "Error in deleting news");
}





