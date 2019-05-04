<?php
session_start();

// connect to database
//$db = mysqli_connect('localhost', 'root', 'root', 'gaposa');
require 'conn.php';


// variable declaration
$username = "";
$email = "";
$errors = array();

// call the register() function if register_btn is clicked
if (isset($_POST['register_btn'])) {
    register();
}

// call the addnews() function if btnsubmit is clicked
if (isset($_POST['btnsubmit'])) {
    addnews();
}

// call the login() function if register_btn is clicked
if (isset($_POST['login_btn'])) {
    login();
}

//// call updateNews() function if updateBtn is clicked
//if (isset($_POST['updateBtn'])) {
//    updatenews();
//}


if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user']);
    header("location: ../login.php");
}

// Add News
function addnews()
{
    global $conn, $errors;

//receive all input values from the form
    $title = e($_POST['title']);
    $content = e($_POST['content']);
    $pname = e($_POST['publisher']);
    $date = date("d/m/Y");


    if (empty($title)) {
        array_push($errors, "News title is required");
    }
    if (empty($content)) {
        array_push($errors, "News description is required");
    }
//    if (empty($imgName)) {
//        array_push($errors, "A picture is required is required");
//    }
    if (empty($pname)) {
        array_push($errors, "Publisher's name is required");
    }

    if (isset($_POST['confirmPicture']) == true) {

        $imgName = mysqli_real_escape_string($conn, trim($_FILES["picture"]["name"]));

        if (move_uploaded_file($_FILES["picture"]["tmp_name"], "newsimg/" . $imgName)) {

            if (count($errors) == 0) {
                $query = "INSERT INTO news (title, content, picture, publisher, dt) VALUES('$title', '$content', '$imgName', '$pname', '$date')";
                mysqli_query($conn, $query);
                $_SESSION['success'] = "Added news successfully!!";
            }
        } else {
            array_push($errors, "News image is required");
        }
    } else {
        $imgName = "no_image.jpg";
        if (count($errors) == 0) {
            $query = "INSERT INTO news (title, content, picture, publisher, dt) VALUES('$title', '$content', '$imgName', '$pname', '$date')";
            mysqli_query($conn, $query);
            $_SESSION['success'] = "Added news successfully!!";
        }
    }

}


//Update News
function updatenews()
{
    global $conn, $errors;

    $id = e($_POST['id']);
    $title = e($_POST['title']);
    $content = e($_POST['content']);
    $pname = e($_POST['publisher']);

    if (count($errors) == 0) {
        $query = "UPDATE news SET title = '{$title}', content = '{$content}', publisher = '{$pname}' WHERE id = " . $id;
        mysqli_query($conn, $query);

        $_SESSION['success'] = "Updated news successfully!!";
    } else {
        array_push($errors, "Error in updating news");
    }

}

// REGISTER USER
function register()
{
    global $conn, $errors;

    // receive all input values from the form
    $username = e($_POST['username']);
    $email = e($_POST['email']);
    $password_1 = e($_POST['password_1']);
    $password_2 = e($_POST['password_2']);

    // form validation: ensure that the form is correctly filled
    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password_1)) {
        array_push($errors, "Password is required");
    }
    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
    }

    // register user if there are no errors in the form
    if (count($errors) == 0) {
        $password = md5($password_1);//encrypt the password before saving in the database
        $user_type = e($_POST['user_type']);

        if (isset($_POST['user_type'])) {

            $query = "INSERT INTO login (username, password, user_type, email)
						  VALUES('$username', '$password', '$user_type', '$email')";
            mysqli_query($conn, $query);
            $_SESSION['success'] = "New user successfully created!!";
            header('location: home.php');
        } else {
            $query = "INSERT INTO login (username, password, user_type, email)
						  VALUES('$username', '$password', '$user_type', '$email')";
            mysqli_query($conn, $query);

            // get id of the created user
            $logged_in_user_id = mysqli_insert_id($conn);

            $_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
            $_SESSION['success'] = "You are now logged in";
            header('location: index.php');
        }

    }

}

// return user array from their id
function getUserById($id)
{
    global $conn;
    $query = "SELECT * FROM login WHERE id=" . $id;
    $result = mysqli_query($conn, $query);

    $user = mysqli_fetch_assoc($result);
    return $user;
}

// LOGIN USER
function login()
{
    global $conn, $username, $errors;

    // grap form values
    $username = e($_POST['username']);
    $password = e($_POST['password']);

    // make sure form is filled properly
    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    // attempt login if no errors on form
    if (count($errors) == 0) {
        $password = md5($password);

        $query = "SELECT * FROM login WHERE username='$username' AND password='$password' LIMIT 1";
        $results = mysqli_query($conn, $query);

        if (mysqli_num_rows($results) == 1) { // user found
            // check if user is admin or user
            $logged_in_user = mysqli_fetch_assoc($results);
            if ($logged_in_user['user_type'] == 'admin') {

                $_SESSION['user'] = $logged_in_user;
                $_SESSION['success'] = "You are now logged in";
                header('location: admin/home.php');
            } else {
                $_SESSION['user'] = $logged_in_user;
                $_SESSION['success'] = "You are now logged in";

                header('location: index.php');
            }
        } else {
            array_push($errors, "Wrong username/password combination");
        }
    }
}

function isLoggedIn()
{
    if (isset($_SESSION['user'])) {
        return true;
    } else {
        return false;
    }
}

function isAdmin()
{
    if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] == 'admin') {
        return true;
    } else {
        return false;
    }
}

// escape string
function e($val)
{
    global $conn;
    return mysqli_real_escape_string($conn, trim($val));
}

function display_error()
{
    global $errors;

    if (count($errors) > 0) {
        echo '<div class="error">';
        foreach ($errors as $error) {
            echo $error . '<br>';
        }
        echo '</div>';
    }
}

?>
