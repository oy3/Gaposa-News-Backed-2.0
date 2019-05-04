<?php
require 'conn.php';

	if (isset($_POST["token"])) {

		   $token=$_POST["token"];

		   $sql="INSERT INTO users(token) VALUES ('{$token}') ON DUPLICATE KEY UPDATE Token = '{$token}'";
		 	$query=$conn->query($sql);

				if($query){
			        echo "<script type='text/javascript'>alert('Added token successfully, please wait')</script>";
			    }
			     else {
			        echo "<script type='text/javascript'>alert('Could not add token in database')</script>";

			    }

	}else {
		$data = new stdClass();
		$data->token = "null";
		echo json_encode($data);
	}


 ?>
