<!DOCTYPE html>
<style>
    .error {color: #FF0000;}
</style>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<?php
//error_reporting(E_ALL);

//ini_set('display_errors', 1);

// define variables and set to empty values
$user_nameErr = $emailErr = $exchangeErr = $websiteErr = $imageErr = $dateErr = "";
$userName = $user_job = $email = $exchange = $comment = $website = $image = $date = "";
$checkname = $checkemail = $checkwebsite = $checkimage = $checkdate = $checkexchange = "";


//code to validate and upload data/ file

require_once 'dbconfig.php';
if(isset($_GET['edit_id']) && !empty($_GET['edit_id'])) {
    $id = $_GET['edit_id'];
    $stmt_edit = $DB_con->prepare('SELECT userName,userPic,email, exchange, comment,date, website FROM tbl_users WHERE userID =:uid');
    $stmt_edit->execute(array(':uid' => $id));
    $edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
    extract($edit_row);
}
else
    {
        header("Location: editlist.php");
    }



if(isset($_POST['btn_save_updates'])) {


    $userName = $_POST['user_name'];// user name
    //$userjob = $_POST['user_job'];// user job
    $website = $_POST['website'];
    $email = $_POST['email'];
    $date = $_POST['date'];
    $exchange = $_POST['exchange'];
    $comment = $_POST['comment'];


    $imgFile = $_FILES['user_image']['name'];
    $tmp_dir = $_FILES['user_image']['tmp_name'];
    $imgSize = $_FILES['user_image']['size'];


    if (empty($userName)) {
        $user_nameErr = "Name is required";
    } else {
        $userName = test_input($_POST["user_name"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/", $userName)) {
            $user_nameErr = "Only letters and white space allowed";
        } else {
            $checkname = "1";
        }
    }
    /*
        if(empty($userjob)){
            $errMSG = "Please Enter Your Job Work.";
        }
    */
    if (empty($imgFile)) {
        $errMSG = "Please Select Image File.";
        $imageErr = "Please upload a screenshot.";
    } else {
        $upload_dir = 'user_images/'; // upload directory

        $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION)); // get image extension

        // valid image extensions
        $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions

        // rename uploading image
        $userpic = rand(1000, 1000000) . "." . $imgExt;

        // allow valid image file formats
        if (in_array($imgExt, $valid_extensions)) {
            // Check file size '5MB'
            if ($imgSize < 5000000) {
                move_uploaded_file($tmp_dir, $upload_dir . $userpic);
            } else {
                $imageErr = "Sorry, your file is too large.Maximum 5 MB allowed";
                $errMSG = "Sorry, your file is too large.Maximum 5 MB allowed";
            }
        } else {
            $imageErr = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        }
    }
    if (empty($email)) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "$email is not a valid email format, refer to this example: aaa@bbb(.com or .net or .org)";
        } else {
            $checkemail = "1";
        }
    }
    if (empty($website)) {
        $websiteErr = "Website is required";
    } else {
        $website = test_input($_POST["website"]);
        // check if URL address syntax is valid (this regular expression also allows dashes in the URL)
        if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $website)) {
            $websiteErr = "$website is not a valid URL, refer to this example: (http:// or ftp://)www.aaa(.com or .net or .org)";
        } else {
            $checkwebsite = "1";
        }
    }
    if (empty($date)) {
        $dateErr = "Date is required";
    } else {
        $arr = explode("/", $date); // splitting the array
        $mm = $arr[0]; // first element of the array is month
        $dd = $arr[1]; // second element is date
        $yyyy = $arr[2]; // third element is year
        If (!checkdate($mm, $dd, $yyyy)) {

            $dateErr = "Invalid date format, follow example mm/dd/yyyy.";
        } else if ($yyyy < "2015") {
            $dateErr = "Only records after year 2015 is accepted";
        } else {
            $today_start = strtotime('today');
            $today_end = strtotime('tomorrow');


            $date_timestamp = strtotime($date);

            if ($date_timestamp >= $today_end) {
                $dateErr = "Date should not later than today";
            } else {

                $checkdate = "1";
            }
        }


        /*$date = test_input($_POST["date"]);
        $checkdate = "1";
        */
    }
    if (empty($exchange)) {
        $exchangeErr = "Exchange is required";
    } else {
        $exchange = test_input($_POST["exchange"]);
        $checkexchange = "1";
    }
    if (empty($_POST["comment"])) {
        $comment = "";
    } else {
        $comment = test_input($_POST["comment"]);
    }


    // if no error occured, continue ....
    if (!isset($errMSG) && $checkdate == 1 && $checkexchange == 1 && $checkemail == 1 && $checkname == 1 && $checkwebsite == 1) {

        $stmt = $DB_con->prepare('UPDATE tbl_users 
									     SET userName=:uname, 
									         email=:em,
									         exchange=:ex,
									         comment=:cm,
									         date=:dt,
									         website=:wb,
										     userPic=:upic 
								       WHERE userID=:uid');
       /*
       $stmt->bindParam(':uname',$username);
        $stmt->bindParam(':ujob',$userjob);
        $stmt->bindParam(':upic',$userpic);
        $stmt->bindParam(':uid',$id);
       */





       // $stmt = $DB_con->prepare('INSERT INTO tbl_users(userName,userPic,email, exchange, comment,date, website ) VALUES(:uname, :upic, :em, :ex, :cm, :dt, :wb)');
        $stmt->bindParam(':uname', $userName);
        //$stmt->bindParam(':ujob',$userjob);
        $stmt->bindParam(':upic', $userpic);
        $stmt->bindParam(':em', $email);
        $stmt->bindParam(':ex', $exchange);
        $stmt->bindParam(':cm', $comment);
        $stmt->bindParam(':dt', $date);
        $stmt->bindParam(':wb', $website);
        $stmt->bindParam(':uid',$id);


        if($stmt->execute()){
            ?>
            <script>
                alert('Successfully Updated ...');
                window.location.href='editlist.php';
            </script>
            <?php
        }
        else{
            $errMSG = "Sorry Data Could Not Updated !";
        }

    }
}
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
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
    <!--
    <figure class="detail">
        <img src="images/charts.gif" alt="Stock Detail" title="Stock Detail"/>
    </figure>
    <table class="detail">
    -->
        <?php
        if(isset($errMSG)){
            ?>
            <div class="alert alert-danger">
                <span class="glyphicon glyphicon-info-sign"></span> &nbsp; <?php echo $errMSG; ?>
            </div>
            <?php
        }
        ?>

        <form method="post" enctype="multipart/form-data" class="form-horizontal">
            <fieldset>
                <legend>Update a Form</legend>



                <p>
                    <label>Name: </label><br/>
                    <input type="text" name="user_name" maxlength="40" class="required" value="<?php echo $userName;?>"/>
                    <span class="error">* <?php echo $user_nameErr;?></span>
                    <br/>
                </p>

                <p>
                    <label>E-mail: </label><br/>
                    <input type="text" name="email" class="required" value="<?php echo $email;?>"/>
                    <span class="error">* <?php echo $emailErr;?></span>
                    <br/>
                </p>
                <p>
                    <label>Website: </label><br/>
                    <input type="text" name="website" class="required"  value="<?php echo $website;?>"/>
                    <span class="error">* <?php echo $websiteErr;?></span>
                    <br/>
                </p>
                <p>
                    <label>Date of Transaction: </label><br/>
                    <input type="text" name="date" class="required" value = "<?php echo $date;?>"/>
                    <span class="error">* <?php echo $dateErr;?></span>
                    <br/>
                </p>
                <!--
            <p>
                <label class="control-label">Profession(Job)</label>
                <input class="form-control" type="text" name="user_job" placeholder="Your Profession" value="<?php echo $user_job; ?>" />
                <br/>
            </p>
            -->

                <p>
                    <label>Transaction Exchange: </label>
                    <span class="error">* <?php echo $exchangeErr;?></span><br/>

                    <input type="radio" name="exchange" <?php if (isset($exchange) && $exchange=="NYSE") echo "checked";?> value = "NYSE">NYSE Stock Exchange
                    <br/>
                    <input type="radio" name="exchange" <?php if (isset($exchange) && $exchange=="Nasdaq") echo "checked";?> value = "Nasdaq">Nasdaq Stock Market
                    <br/>
                    <input type="radio" name="exchange" <?php if (isset($exchange) && $exchange=="ECNs") echo "checked";?> value = "ECNs">Electronic Communication Networks
                    <br/>
                    <input type="radio" name="exchange" <?php if (isset($exchange) && $exchange=="OTC") echo "checked";?> value = "OTC">Over the Counter
                    <br/>
                </p>

                <p>
                    <label class="control-label">Screenshot: </label>
                    <img src="user_images/<?php echo $userPic; ?>" height="150" width="150" />
                    <input class="input-group" type="file" name="user_image" accept="image/*" />
                    <span class="error">* <?php echo $imageErr;?></span><br/>
                    <br/>
                </p>

                <p>
                    <label>(Optional) Comments: </label><br/>
                    <textarea placeholder="(Optional) Enter a comment." name="comment" rows="5" cols="45"><?php echo $comment;?></textarea>

                </p>



                <p>
                    <button type="submit" name="btn_save_updates" class="btn btn-default">
                        <span class="glyphicon glyphicon-save"></span> Update
                    </button>
                    <br/>

                </p>



            </fieldset>
        </form>



    <footer>
        <p><a href="homepage.html">Home</a> | <a href="#">Site Map</a> | <a href="contact.html">Contact</a></p>
        <p><em>Copyright &copy; 2017 Stock Transaction System</em></p>

    </footer>
</main>

</body>
</html>