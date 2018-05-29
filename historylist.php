<?php

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

    header("Location: index.php");
}

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
    <table id="list">
        <caption>Transactions</caption>
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">UserName</th>
            <th scope="col">Website</th>
            <th scope="col">Email</th>
            <th scope="col">Exchange</th>
            <th scope="col">Date</th>
            <th scope="col">Comment</th>
            <th scope="col">UserPic</th>
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
        <tr onclick="window.location.href='details.php?detail_id=<?php echo $row['userID']; ?>'" title="Click to see more detail">

                    <th scope="row"><?php echo $userID ?></th>
                    <td><?php echo $userName ?></td>
                    <td><?php echo $website ?></td>
                    <td><?php echo $email ?></td>
                    <td><?php echo $exchange ?></td>
                    <td><?php echo $date ?></td>
                    <td><?php echo $comment ?></td>
                    <td><img src="user_images/<?php echo $row['userPic']; ?>" class="img-rounded" width="50px" height="50px" /></td>



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

<!--



        <tr onclick="window.location.href='details.html'" title="Click to see more detail">
            <th scope="row">1</th>
            <td>12/31/2017</td>
            <td>EEM</td>
            <td>99</td>
            <td>999</td>
            <td>New York Stock Exchange</td>
            <td>U.S. Dollar</td>
            <td>iShares MSCI Emerging Markets ETF</td>
        </tr>
        <tr onclick="window.location.href='details.html'" title="Click to see more detail">
            <th scope="row">2</th>
            <td>12/31/2017</td>
            <td>EEM</td>
            <td>99</td>
            <td>999</td>
            <td>New York Stock Exchange</td>
            <td>U.S. Dollar</td>
            <td>iShares MSCI Emerging Markets ETF</td>
        </tr>
        <tr onclick="window.location.href='details.html'" title="Click to see more detail">
            <th scope="row">3</th>
            <td>12/31/2017</td>
            <td>EEM</td>
            <td>99</td>
            <td>999</td>
            <td>New York Stock Exchange</td>
            <td>U.S. Dollar</td>
            <td>iShares MSCI Emerging Markets ETF</td>
        </tr>
        <tr onclick="window.location.href='details.html'" title="Click to see more detail">
            <th scope="row">4</th>
            <td>12/31/2017</td>
            <td>EEM</td>
            <td>99</td>
            <td>999</td>
            <td>New York Stock Exchange</td>
            <td>U.S. Dollar</td>
            <td>iShares MSCI Emerging Markets ETF</td>
        </tr>
        <tr onclick="window.location.href='details.html'" title="Click to see more detail">
            <th scope="row">5</th>
            <td>12/31/2017</td>
            <td>EEM</td>
            <td>99</td>
            <td>999</td>
            <td>New York Stock Exchange</td>
            <td>U.S. Dollar</td>
            <td>iShares MSCI Emerging Markets ETF</td>
        </tr>
        <tr onclick="window.location.href='details.html'" title="Click to see more detail">
            <th scope="row">6</th>
            <td>12/31/2017</td>
            <td>EEM</td>
            <td>99</td>
            <td>999</td>
            <td>New York Stock Exchange</td>
            <td>U.S. Dollar</td>
            <td>iShares MSCI Emerging Markets ETF</td>
        </tr>
        <tr onclick="window.location.href='details.html'" title="Click to see more detail">
            <th scope="row">7</th>
            <td>12/31/2017</td>
            <td>EEM</td>
            <td>99</td>
            <td>999</td>
            <td>New York Stock Exchange</td>
            <td>U.S. Dollar</td>
            <td>iShares MSCI Emerging Markets ETF</td>
        </tr>
        <tr onclick="window.location.href='details.html'" title="Click to see more detail">
            <th scope="row">8</th>
            <td>12/31/2017</td>
            <td>EEM</td>
            <td>99</td>
            <td>999</td>
            <td>New York Stock Exchange</td>
            <td>U.S. Dollar</td>
            <td>iShares MSCI Emerging Markets ETF</td>
        </tr>
        <tr onclick="window.location.href='details.html'" title="Click to see more detail">
            <th scope="row">9</th>
            <td>12/31/2017</td>
            <td>EEM</td>
            <td>99</td>
            <td>999</td>
            <td>New York Stock Exchange</td>
            <td>U.S. Dollar</td>
            <td>iShares MSCI Emerging Markets ETF</td>
        </tr>
        <tr onclick="window.location.href='details.html'" title="Click to see more detail">
            <th scope="row">10</th>
            <td>12/31/2017</td>
            <td>EEM</td>
            <td>99</td>
            <td>999</td>
            <td>New York Stock Exchange</td>
            <td>U.S. Dollar</td>
            <td>iShares MSCI Emerging Markets ETF</td>
        </tr>
        -->
        </tbody>

    </table>




    <footer>
        <p><a href="homepage.html">Home</a> | <a href="#">Site Map</a> | <a href="#">Contact</a></p>
        <p><em>Copyright &copy; 2017 Stock Transaction System</em></p>

    </footer>
</main>

</body>
</html>