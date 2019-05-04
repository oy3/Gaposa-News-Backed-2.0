<?php include('../functions.php') ?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin - Create user</title>
    <script src="../js/func.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>

<div class="tophead">

    <div class="dropdown">
        <button onclick="myFunction()" class="dropbtn"><i class="fa fa-bars"></i></button>
        <div id="myDropdown" class="dropdown-content">
            <a href="home.php">Home</a>
            <a href="../add.php">Add News</a>
            <a href="../editdelnews.php">Edit & Delete News</a>
        </div>
    </div>


    <b style="margin-left: 20px;"><a href="create_user.php">Admin - create user</a></b>

    <!-- logged in user information -->
    <div class="profile_info">
        <img class="userimg" src="../images/admin_profile.png">

        <div>
            <?php if (isset($_SESSION['user'])) : ?>
                <strong><?php echo $_SESSION['user']['username']; ?></strong>

                <small>
                    <i style="color: #555;">(<?php echo ucfirst($_SESSION['user']['user_type']); ?>)</i>
                    <br>
                    <a href="home.php?logout='1'" style="color: red;">logout</a>
                    &nbsp; <a href="create_user.php"> + add user</a>
                </small>

            <?php endif ?>
        </div>
    </div>

</div>

<div class="addForm">

<form method="post" action="create_user.php">

    <?php echo display_error(); ?>

    <div class="input-group">
        <label>Username</label>
        <input type="text" name="username" value="<?php echo $username; ?>">
    </div>
    <div class="input-group">
        <label>Email</label>
        <input type="email" name="email" value="<?php echo $email; ?>">
    </div>
    <div class="input-group">
        <label>User type</label>
        <select name="user_type" id="user_type">
            <option value=""></option>
            <option value="admin">Admin</option>
            <option value="user">User</option>
        </select>
    </div>
    <div class="input-group">
        <label>Password</label>
        <input type="password" name="password_1">
    </div>
    <div class="input-group">
        <label>Confirm password</label>
        <input type="password" name="password_2">
    </div>
    <div class="input-group">
        <button type="submit" class="normalbtn" name="register_btn"> + Create user</button>
    </div>
</form>

</div>
</body>
</html>