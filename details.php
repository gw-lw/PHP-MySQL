<?php
require_once 'dbconfig.php';
if(isset($_GET['detail_id']) && !empty($_GET['detail_id'])) {
$id = $_GET['detail_id'];}
$stmt_edit = $DB_con->prepare('SELECT userName,userPic,email, exchange, comment,date, website FROM tbl_users WHERE userID =:uid');
$stmt_edit->execute(array(':uid' => $id));
$edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
extract($edit_row);

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

    <div id="container">


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




    </div>
    <figure class="detail">
        <img src="user_images/<?php echo $userPic; ?>"  />

    </figure>
    <table class="detail">
        <caption>Stocks Catalog</caption>


        <tbody>
        <tr>
            <th scope="row">System ID</th>
            <td><?php echo $id;?></td>
        </tr>
        <tr>
            <th scope="row">User Name</th>
            <td><?php echo $userName;?></td>
        </tr>
        <tr>
            <th scope="row">Email Address</th>
            <td><?php echo $email;?></td>
        </tr>
        <tr>
            <th scope="row">Website</th>
            <td><?php echo $website;?></td>
        </tr>
        <tr>
            <th scope="row">Transaction Exchange</th>
            <td><?php echo $exchange;?></td>
        </tr>
        <tr>
            <th scope="row">Transaction Date</th>
            <td><?php echo $date;?></td>
        </tr>
        <tr>
            <th scope="row">Comments</th>
            <td><?php echo $comment;?></td>
        </tr>

        </tbody>

    </table>
    <div class="return">
        <p><a href="homepage.html">Home</a>
            <a href="editlist.php">Edit Forms</a>
            <a href="historylist.php">View All</a>
        </p>


    </div>
    <div class="return">
        <p></p>
    </div>
    <footer>
        <p><a href="homepage.html">Home</a> | <a href="#">Site Map</a> | <a href="contact.html">Contact</a></p>
        <p><em>Copyright &copy; 2017 Stock Transaction System</em></p>

    </footer>
</main>

</body>
</html>