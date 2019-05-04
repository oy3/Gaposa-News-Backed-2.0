<?php
include('functions.php');

if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add news</title>
    <script src="js/func.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
</body>

<div class="tophead">
    <div class="dropdown">
        <button onclick="myFunction()" class="dropbtn"><i class="fa fa-bars"></i></button>
        <div id="myDropdown" class="dropdown-content">
            <a href="index.php">Home</a>
            <a href="add.php">Add News</a>
            <a href="editdelnews.php">Edit & Delete News</a>
        </div>
    </div>

    <b style="margin-left: 20px;"><a href="index.php">Backend</a></b>


    <!-- <img class="gpbannerlogo" src="images/logo.png"/> -->

    <!-- logged in user information -->
    <div class="profile_info">
        <img class="userimg" src="images/user_profile.png"/>
        <?php if (isset($_SESSION['user'])) : ?>
            <strong><?php echo $_SESSION['user']['username']; ?></strong>

            <small>
                <i style="color: #555;">(<?php echo ucfirst($_SESSION['user']['user_type']); ?>)</i>
                <br>
                <a href="index.php?logout='1'" style="color: red;">Logout</a>
            </small>
        <?php endif ?>
    </div>
</div>


<div class="addForm">

    <form method="post" action="" enctype="multipart/form-data">
        <?php echo display_error(); ?>
        <!-- notification message -->
        <?php if (isset($_SESSION['success'])) : ?>
            <div class="error success">
                <h3>
                    <?php
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                    ?>
                </h3>
            </div>
        <?php endif ?>
        <div class="input-group">
            <label>News title</label>
            <input type="text" name="title" value="" placeholder="Enter title">
        </div>

        <div class="input-group">
            <label>News content</label>
            <textarea type="text" name="content" placeholder="Enter content" rows="8" cols="50"></textarea>
        </div>

        <!--	<div class="input-group">-->
        <br>
        <label>News image</label><i style="font-size: 12px; color: #a94442"> *Uncheck if you're not adding news image.</i>
        <br><br>
        <input type="checkbox" name="confirmPicture" value="yes" checked/> Include picture<i style="font-size: 10px; color: #a94442"> *only png,jpeg,jpg</i>
        <br>
        <input id="profile-img" name="picture" type="file" allow-access="image/*"/>
        <img src="newsimg/no_image.jpg" id="profile-img-tag" width="200px" height="200px"/>

        <script type="text/javascript">
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#profile-img-tag').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#profile-img").change(function () {
                readURL(this);
            });
        </script>


        <!--	</div>-->

        <div class="input-group">
            <label>News publisher</label>
            <input name="publisher" type="text" value="" placeholder="Enter publisher's name"/>
        </div>

        <div class="input-group">
            <button class="normalbtn" type="submit" name="btnsubmit">Add</button>
        </div>
    </form>


</div>


</html>
