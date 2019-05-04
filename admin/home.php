<?php
include('../functions.php');

if (!isAdmin()) {
    $_SESSION['msg'] = "You must log in first";
    header('location: ../login.php');
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin - Home</title>
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
            <a href="add.php">Add News</a>
            <a href="editdelnews.php">Edit & Delete News</a>
        </div>
    </div>


    <b style="margin-left: 20px;"><a href="home.php">Admin - Home Page</a></b>

    <!-- logged in user information -->
    <div class="profile_info">
        <img class="userimg"  src="../images/admin_profile.png">

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

<!-- notification message -->
<div>
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
</div>

<div>
    <?php
    // connect to database
    require '../conn.php';

    $query = "SELECT * FROM news ORDER BY id DESC";
    $results = mysqli_query($conn, $query);
    $numrows = mysqli_num_rows($results);
    if ($results) {
        ?>
        <div style="margin:10px;">Number of news: <?php echo $numrows; ?></div>

        <table>
            <tr>
                <th>News title</th>
                <th>News content</th>
                <th>Picture</th>
                <th>Publisher</th>
                <th>Date</th>
            </tr>

            <?php while ($row = mysqli_fetch_array($results)) { ?>
                <tr>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['content']; ?></td>
                    <td><img style='width: 100px;  height: 100px;' src="../newsimg/<?php echo $row['picture']; ?>"/></td>
                    <td><?php echo $row['publisher']; ?></td>
                    <td><?php echo $row['dt']; ?></td>
                </tr>

            <?php } ?>

        </table>
    <?php } ?>
</div>

</body>
</html>