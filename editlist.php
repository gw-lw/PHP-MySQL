<!DOCTYPE html>

<style>
    .error {color: #FF0000;}
</style>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>


<?php
//error_reporting(E_ALL);

//ini_set('display_errors', 1);
$idArr="";
$msg = "No Records were Selected";
require_once 'dbconfig.php';

$dbHost = 'localhost';  //database host name
$dbUser = 'root';       //database username
$dbPass = 'vsEb5TrcHlfd';         //database password
$dbName = 'myDB'; //database name
$conn = mysqli_connect($dbHost,$dbUser,$dbPass,$dbName);
session_start();
if(!isset($_POST['bulk_delete_submit'])){
    $msg="Select Records to Delete";
}
else
    if ($_POST['checked_id'==""]) {
?>
        <script >
        alert('No Record is Selected ...');
        window . location . href = 'editlist.php';
        </script >
        <?php
}
else
if(isset($_POST['bulk_delete_submit'])&&$_POST['checked_id']!=""){

    $idArr = $_POST['checked_id'];

    foreach($idArr as $id){
        mysqli_query($conn,"DELETE FROM tbl_users WHERE userID=$id");

    }
    ?>
<script>
    alert('Successfully Deleted ...');
    window.location.href='editlist.php';
</script>

<?php

    //$msg = "Users have been deleted successfully.";
   // header("Location:historylist.php");
}







 require_once 'dbconfig.php';
if(isset($_GET['delete_id']))
{

    // select image from db to delete
    $stmt_select = $DB_con->prepare('SELECT userPic FROM tbl_users WHERE userID =:uid');
    $stmt_select->execute(array(':uid'=>$_GET['delete_id']));
    $imgRow=$stmt_select->fetch(PDO::FETCH_ASSOC);
    unlink("user_images/".$imgRow['userPic']);

    // it will delete an actual record from db
    $stmt_delete = $DB_con->prepare('DELETE FROM tbl_users WHERE userID =:uid');
    $stmt_delete->bindParam(':uid',$_GET['delete_id']);
    $stmt_delete->execute();
    ?>
    <script>
        alert('Successfully Deleted ...');
        window.location.href='editlist.php';
    </script>
<?php


    header("Location: editlist.php");
}

/*
if(isset($_POST['btnsave']))

{
    header("refresh:0;historylist.php");
    header("Location:update.php");

    $dbHost = 'localhost';  //database host name
    $dbUser = 'root';       //database username
    $dbPass = 'vsEb5TrcHlfd';         //database password
    $dbName = 'myDB'; //database name
    $conn = mysqli_connect($dbHost,$dbUser,$dbPass,$dbName);
    if(!$conn){
        die("Database connection failed: " . mysqli_connect_error());
    }

session_start();


    header("Location:update.php");
    $idArr = $_POST['checked_id'];
    foreach($idArr as $id){
        mysqli_query($conn,"DELETE FROM tbl_users WHERE userID=".$id);
    }
    $_SESSION['success_msg'] = 'Users have been deleted successfully.';
    header("Location:update.php");


}
*/



?>







<!DOCTYPE html>
<html>
<head lang="en">
   <meta charset="utf-8">
   <title>Stocks Catalog</title>
    <link rel="stylesheet" href="mobile.css" media="screen and (max-width:480px)" />
    <link rel="stylesheet" href="desktop.css" media="screen and (min-width:481px)" />
    <script type="text/javascript" language="javascript" src="inputform.js"></script>
   <style>

   </style>
</head>
<body>
<main>
    <header>
        <h1 id="pagetitle">Stock Transaction System</h1>
        <div>
            <nav id="top">
                <ul>
                    <li><a href="homepage.html">Home</a></li>
                    <li><a href="inputform.php">New Form</a></li>
                    <li><a href="historylist.php">View All</a></li>
                    <li><a href="editlist.php">Edit Forms</a></li>
                    <li><a href="#">Online Banking</a></li>
                    <li><a href="#">Accounts</a></li>
                    <li><a href="#">About Us</a></li>
                </ul>
            </nav>
        </div>

    </header>

    <div>


        <nav>
            <select>
                <option href="homepage.html">Home</option>
                <option>New Record</option>
                <option>History</option>
                <option>Online Trading</option>
                <option>Online Banking</option>
                <option>Accounts</option>
                <option>About Us</option>
            </select>
        </nav>





    </div>
    <div>
        <form  name="bulk_action_form" method="POST" enctype="multipart/form-data" class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
    <table id="list">
        <caption>Transactions</caption>
        <thead>
        <tr>
            <th scope="col">Select</th>
            <th scope="col">ID</th>
            <th scope="col">UserName</th>
            <th scope="col">Website</th>
            <th scope="col">Email</th>
            <th scope="col">Exchange</th>
            <th scope="col">Date</th>
            <th scope="col">Comment</th>
            <th scope="col">UserPic</th>
            <th scope="col">Update </th>
        </tr>
        </thead>

        <tbody>


        <?php

        $stmt = $DB_con->prepare('SELECT userID, userName, email, website, exchange, date, comment, userPic FROM tbl_users ORDER BY userID DESC');
        $stmt->execute();

        if($stmt->rowCount() > 0)
        {
            while($row=$stmt->fetch(PDO::FETCH_ASSOC))
            {
                extract($row);
                ?>

        <tr>
                    <th>

                        <input type="checkbox" name="checked_id[]" id= "checked_id[]" class="checkbox" value="<?php echo $row['userID']; ?>"/>
                    </th>
                   <th scope="row"><?php echo $userID ?></th>

                    <td><?php echo $userName ?></td>
                    <td><?php echo $website ?></td>
                    <td><?php echo $email ?></td>
                    <td><?php echo $exchange ?></td>
                    <td><?php echo $date ?></td>
                    <td><?php echo $comment ?></td>
                    <td><img src="user_images/<?php echo $row['userPic']; ?>" class="img-rounded" width="50px" height="50px" /></td>
                    <td><a class="btn"  href="update.php?edit_id=<?php echo $row['userID']; ?>" title="click for edit" onclick="return confirm('Sure to edit ?')"><span class="glyphicon glyphicon-edit"></span> Edit</a>
                        <a class="btn" href="?delete_id=<?php echo $row['userID']; ?>" title="click for delete" onclick="return confirm('Sure to delete ?')"><span class="glyphicon glyphicon-remove-circle"></span> Delete</a>


                    </td>




                    <!--
                    <p class="page-header"><?php echo $userName."&nbsp;/&nbsp;".$userProfession; ?></p>
                    <img src="user_images/<?php echo $row['userPic']; ?>" class="img-rounded" width="250px" height="250px" />
                    <p class="page-header">

				<span>
				<a class="btn btn-info" href="editform.php?edit_id=<?php echo $row['userID']; ?>" title="click for edit" onclick="return confirm('sure to edit ?')"><span class="glyphicon glyphicon-edit"></span> Edit</a>
				<a class="btn btn-danger" href="?delete_id=<?php echo $row['userID']; ?>" title="click for delete" onclick="return confirm('sure to delete ?')"><span class="glyphicon glyphicon-remove-circle"></span> Delete</a>
				</span>
                    </p>
                    -->
                </tr>

                <?php
            }
        }
        else
        {
            ?>
            <div class="col-xs-12">
                <div class="alert alert-warning">
                    <span class="glyphicon glyphicon-info-sign"></span> &nbsp; No Data Found ...
                </div>
            </div>
            <?php
        }



        ?>
                    <aside>
                        <div class="box">
                            <h3>Cart</h3>
                            <p>You have no stocks in your cart</p>
                        </div>
                        <div class="box">
                            <h3>Messages</h3>
                            <p>You have three message in your inbox</p>
                        </div>



                    </aside>


        </tbody>

    </table>
            <button type="submit" onclick="return confirm('Sure to delete ?')" class="btn btn-danger" name="bulk_delete_submit" value="Delete">Delete Multiple</button>
            <span class="error">* <?php echo $msg;?></span><br/>
        </form>


        </div>

    <footer>
        <p><a href="homepage.html">Home</a> | <a href="#">Site Map</a> | <a href="#">Contact</a></p>
        <p><em>Copyright &copy; 2017 Stock Transaction System</em></p>

    </footer>






</main>


</body>
</html>