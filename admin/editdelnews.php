<?php
include('../functions.php');

if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first";
    header('location: ../login.php');
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin - Edit & Delete News</title>
    <script src="../js/func.js"></script>
    <script src="../js/modal.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
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
                <th>Action</th>
            </tr>
            <?php while ($row = mysqli_fetch_array($results)) { ?>
                <tr>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['content']; ?></td>
                    <td><img style='width: 100px;  height: 100px;' src="../newsimg/<?php echo $row['picture']; ?>"/></td>
                    <td><?php echo $row['publisher']; ?></td>
                    <td><?php echo $row['dt']; ?></td>

                    <td>
                        <!--                        <button id="edit" class="edit" type="button"-->
                        <!--                                onclick="document.getElementById('id01').style.display='block'">-->
                        <!--                            <input type="hidden" name="getID" value="-->
                        <?php //echo $row['id']; ?><!--"/>-->
                        <!--                            edit-->
                        <!--                        </button>-->

                        <button id="edit" class="edit" type="button" onclick="selectNewsById(<?= $row['id']; ?> )">
                            edit
                        </button>


                        <button id="delete" class="delete" type="button" onclick="deleteNews(<?= $row['id']; ?> )">
                            delete
                        </button>

                    </td>
                </tr>

            <?php } ?>


        </table>
    <?php } ?>


    <div id="id01" class="modal">

        <form class="modal-content animate" action="../functions.php">

            <div class="modalcontainer">
                    <span onclick="document.getElementById('id01').style.display='none'" class="close"
                          title="Close Modal">&times;</span></div>

            <div class="modalcontainer">

                <input type="text" name="id" value="<?php echo $row['id']; ?>" placeholder="ID">
                <label for="title">News title</label>
                <input type="text" name="title" value="<?php echo $row['title']; ?>" placeholder="Enter news title"
                       required>

                <label for="content">News content</label>
                <textarea type="text" name="content" value="<?php echo $row['content']; ?>"
                          placeholder="Enter news content" rows="8" cols="50"></textarea>

                <label for="picture">News image</label>
                <input name="picture" type="file" allow-access="image/*"/>

                <label for="publisher">News publisher</label>
                <input name="publisher" type="text" value="<?php echo $row['publisher']; ?>"
                       placeholder="Enter publisher's name"/>

                <button id="update" class="editbtn" type="button" onclick="updateNews(<?= $row['id']; ?>)">Update
                </button>
            </div>

            <div class="modalcontainer" style="background-color:#f1f1f1">
                <button type="button" onclick="document.getElementById('id01').style.display='none'"
                        class="cancelbtn">Cancel
                </button>
            </div>

        </form>
    </div>


</div>

<script>
    function selectNewsById(id) {
        $.ajax({
            method: 'POST',
            url: 'http://localhost:8888/gaposanews/selectNews.php',
            data: {
                id
            },
            success(res) {
                console.log(res, ' Selected news. ');
            },
            error(err) {
                console.log(err, ' Error ');
            }

        })

    }
</script>


<script>
    function updateNews(id) {
        $.ajax({
            method: 'POST',
            url: 'http://localhost:8888/gaposanews/edit.php',
            data: {
                id
            },
            success(res) {
                console.log(res, ' Updated. ');
            },
            error(err) {
                console.log(err, ' Error ');
            }

        })

    }
</script>


<script>

    function deleteNews(id) {
        $.ajax({
            method: 'POST',
            url: 'http://localhost:8888/gaposanews/remove.php',
            data: {
                id
            },
            success(res) {
                window.location.reload();
            },
            error(err) {
                console.log(err, ' Error ');
            }
        })
    }
</script>

</body>
</html>
