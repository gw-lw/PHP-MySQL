<!DOCTYPE html>

<style>
    .error {color: #FF0000;}
</style>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script>
  //  $(document).ready(function(){
   //     $("#btn1").click(function(){
     //       window.location = 'client2.php';
      //  });

   // });
</script>


<?php
//error_reporting(E_ALL);

//ini_set('display_errors', 1);

// define variables and set to empty values
$user_nameErr = $emailErr = $exchangeErr = $websiteErr = $imageErr = $dateErr = "";
$username = $user_job = $email = $exchange = $comment = $website = $image = $date = "";
$checkname = $checkemail = $checkwebsite = $checkimage = $checkdate = $checkexchange = "";


//code to validate and upload data/ file

require_once 'dbconfig.php';
if(isset($_POST['btnsave']))
{
    $username = $_POST['user_name'];// user name
    //$userjob = $_POST['user_job'];// user job
    $website = $_POST['website'];
    $email = $_POST['email'];
    $date = $_POST['date'];
    $exchange = $_POST['exchange'];
    $comment = $_POST['comment'];


    $imgFile = $_FILES['user_image']['name'];
    $tmp_dir = $_FILES['user_image']['tmp_name'];
    $imgSize = $_FILES['user_image']['size'];


    if(empty($username)){
        $user_nameErr = "Name is required";
    } else {
        $username = test_input($_POST["user_name"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/",$username)) {
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
    if(empty($imgFile)){
        $errMSG = "Please Select Image File.";
        $imageErr = "Please upload a screenshot.";
    } else
    {
        $upload_dir = 'user_images/'; // upload directory

        $imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension

        // valid image extensions
        $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions

        // rename uploading image
        $userpic = rand(1000,1000000).".".$imgExt;

        // allow valid image file formats
        if(in_array($imgExt, $valid_extensions)){
            // Check file size '5MB'
            if($imgSize < 5000000)				{
                move_uploaded_file($tmp_dir,$upload_dir.$userpic);
            } else{
                $imageErr = "Sorry, your file is too large.Maximum 5 MB allowed";
                $errMSG = "Sorry, your file is too large.Maximum 5 MB allowed";
            }
        } else{
            $imageErr = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        }
    }
    if(empty($email)){
        $emailErr = "Email is required";
    }
    else {
        $email = test_input($_POST["email"]);
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "$email is not a valid email format, refer to this example: aaa@bbb(.com or .net or .org)";
        } else{
            $checkemail="1";
        }
    }
    if(empty($website)){
        $websiteErr = "Website is required";
    } else {
        $website = test_input($_POST["website"]);
        // check if URL address syntax is valid (this regular expression also allows dashes in the URL)
        if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$website)) {
            $websiteErr = "$website is not a valid URL, refer to this example: (http:// or ftp://)www.aaa(.com or .net or .org)";
        }
        else{
            $checkwebsite = "1";
        }
    }
    if(empty($date)){
        $dateErr = "Date is required";
    } else {
        $arr=explode("/",$date); // splitting the array
        $mm=$arr[0]; // first element of the array is month
        $dd=$arr[1]; // second element is date
        $yyyy=$arr[2]; // third element is year
        If(!checkdate($mm,$dd,$yyyy)){

            $dateErr = "Invalid date format, follow example mm/dd/yyyy.";
        }
        else if($yyyy<"2015"){
            $dateErr= "Only records after year 2015 is accepted";
                    }

        else {
            $today_start = strtotime('today');
            $today_end = strtotime('tomorrow');


            $date_timestamp = strtotime($date);

            if ($date_timestamp >= $today_end) {
                $dateErr = "Date should not later than today";
            }
            else {

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
    if(!isset($errMSG)&& $checkdate==1 && $checkexchange==1 && $checkemail==1 &&$checkname==1&&$checkwebsite==1)
    {
        $stmt = $DB_con->prepare('INSERT INTO tbl_users(userName,userPic,email, exchange, comment,date, website ) VALUES(:uname, :upic, :em, :ex, :cm, :dt, :wb)');
        $stmt->bindParam(':uname',$username);
        //$stmt->bindParam(':ujob',$userjob);
        $stmt->bindParam(':upic',$userpic);
        $stmt->bindParam(':em',$email);
        $stmt->bindParam(':ex',$exchange);
        $stmt->bindParam(':cm',$comment);
        $stmt->bindParam(':dt',$date);
        $stmt->bindParam(':wb',$website);

        if($stmt->execute())
        {
            $successMSG = "new record succesfully inserted ...";
            header("refresh:0;historylist.php"); // redirects image view page after 5 seconds.
        }
        else
        {
            $errMSG = "error while inserting....";
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



<?php


// old code
/*
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["user_name"])) {
        $nameErr = "Name is required";
    }
    else {
        $user_name = test_input($_POST["user_name"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/",$user_name)) {
            $user_nameErr = "Only letters and white space allowed";
        }
        else {
            $checkname = "1";
        }
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "$email is not a valid email format, refer to this example: aaa@bbb(.com or .net or .org";
        }
        else{
            $checkemail="1";
        }
    }

    if (empty($_POST["website"])) {
        $websiteErr = "Website is required";
    } else {
        $website = test_input($_POST["website"]);
        // check if URL address syntax is valid (this regular expression also allows dashes in the URL)
        if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$website)) {
            $websiteErr = "$website is not a valid URL, refer to this example: (http:// or ftp://)www.aaa(.com or .net or .org)";
        }
        else{
            $checkwebsite = "1";
        }
    }



    if (empty($_POST["comment"])) {
        $comment = "";
    } else {
        $comment = test_input($_POST["comment"]);
    }

    if (empty($_POST["exchange"])) {
        $exchangeErr = "Exchange is required";
    } else {
        $exchange = test_input($_POST["exchange"]);
        $checkexchange = "1";
    }
    if (empty($_POST["date"])) {
        $dateErr = "Date is required";
    } else {
        $date = test_input($_POST["date"]);
        $checkdate = "1";
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
*/
?>



<html>
<head lang="en">
   <meta charset="utf-8">
   <title>Input</title>
    <link rel="stylesheet" href="mobile.css" media="screen and (max-width:480px)" />
    <link rel="stylesheet" href="desktop.css" media="screen and (min-width:481px)" />


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

    <?php
    /*
    if(isset($errMSG)){
        ?>
        <div class="alert alert-danger">
            <span class="glyphicon glyphicon-info-sign"></span> <strong><?php echo $errMSG; ?></strong>
        </div>
        <?php
    }
    else if(isset($successMSG)){
        ?>
        <div class="alert alert-success">
            <strong><span class="glyphicon glyphicon-info-sign"></span> <?php echo $successMSG; ?></strong>
        </div>
        <?php
    }
    */
    ?>


    <form method="post" enctype="multipart/form-data" class="form-horizontal">
        <fieldset>
            <legend>Transaction Details</legend>



            <p>
                <label>Name: </label><br/>
                <input type="text" name="user_name" maxlength="40" class="required" value="<?php echo $username;?>"/>
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
                <input class="input-group" type="file" name="user_image" accept="image/*" />
                <span class="error">* <?php echo $imageErr;?></span><br/>
                <br/>
            </p>

            <p>
                <label>(Optional) Comments: </label><br/>
                <textarea placeholder="(Optional) Enter a comment." name="comment" rows="5" cols="45"><?php echo $comment;?></textarea>

            </p>



            <p>
                <button type="submit" name="btnsave" class="btn btn-default">
                        <span class="glyphicon glyphicon-save"></span> &nbsp; save
                    </button>
                <br/>

            </p>



        </fieldset>
    </form>




    <!--
    //old form



    <form enctype="multipart/form-data" name='mainForm' id='mainForm' method='post' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

        <fieldset>
            <legend>Transaction Details</legend>

            <p>
                <label>Name: </label><br/>
                <input type="text" name="user_name" maxlength="40" class="required" value="<?php echo $user_name;?>"/>
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
                <label>Screenshot: </label><br/>



                <input  type="file" name="user_image" accept="image/*"/>




                <span class="error">* <?php echo $imageErr;?></span>
                <br/>
            </p>

            <p>
                <label>Date of Transaction: </label><br/>
                <input type="date" name="date" class="required" value = "<?php echo $date;?>"/>
                <span class="error">* <?php echo $dateErr;?></span>
                <br/>
            </p>

            <p>
                <label>Transaction Exchange: </label><br/>
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
                <label>(Optional) Comments: </label><br/>
                <textarea placeholder="(Optional) Enter a comment." name="comment" rows="5" cols="45"><?php echo $comment;?></textarea>

            </p>

            <button type="submit" name="btnsave" class="btn btn-default">
                <span class="glyphicon glyphicon-save"></span> &nbsp; save
            </button>

            <input type="submit" name="submit" value="Submit"/><input type="reset" value="Reset" name="reset" />
        </fieldset>
    </form>
    -->



    <?php
    /*
    error_reporting(E_ALL);

    ini_set('display_errors', 1);

    echo "<h2>Your Input:</h2>";
    echo "username: ", $username;
    echo "<br>";
    echo "email: ", $email;
    echo "<br>";
    echo "website: ", $website;
    echo "<br>";
    echo "screenshot: ", $image;

    echo "<br>";
    echo "exchange: ", $exchange;
    echo "<br>";
    echo "date:", $date;
    echo "<br>";


    echo "comment: ", $comment;



    $servername = "localhost";
    $username = "root";
    $password = file_get_contents('./MySQL.txt', true);
    $dbname = "myDB";

    // Create connection


    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);

    }
    echo "Connected successfully";
    echo "<br>";

    // Create database
    $sql = "CREATE DATABASE  IF NOT EXISTS myDB";
    if ($conn->query($sql) === TRUE) {
        echo "Database created successfully";
        echo "<br>";
    } else {
        echo "Error creating database: " . $conn->error;
        echo "<br>";
    }

    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        echo "<br>";
    }





    $sql = "CREATE TABLE if not exists tbl_users (
ALTER TABLE tbl_users
add column website VARCHAR(30) NOT NULL,
add column email VARCHAR(50) NOT NULL,
add column exchange VARCHAR(30) NOT NULL,
add column date VARCHAR(30) NOT NULL,
add column comment VARCHAR(200));

)";


    if ($conn->query($sql) === TRUE) {
        echo "Table MyGuests created successfully";
        echo "<br>";
    } else {
        echo "Error creating table: " . $conn->error;
        echo "<br>";
    }
    //global $checkname;
    //global $checkwebsite;
    //global $checkemail;
    //echo $checkname;
    //echo $checkwebsite;
    //echo $checkemail;

    if ($checkname==1 and $checkemail==1 and $checkwebsite==1 and $checkdate == 1 and $checkimage == 1 and $checkexchange == 1)
    {


     $name = mysqli_real_escape_string($conn, $_REQUEST['name']);
     $website = mysqli_real_escape_string($conn, $_REQUEST['website']);
     $email = mysqli_real_escape_string($conn, $_REQUEST['email']);

       $sql = "INSERT INTO MyGuests1 (user_name, website, email) VALUES ('$user_name', '$website', '$email','$imagetmp', '$imagename')";



       if (mysqli_query($conn, $sql)) {
            echo "Records added successfully.";
            echo "<br>";
        } else {
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
            echo "<br>";
        }


        $sql = "SELECT * FROM MyGuests1";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            echo "<br>";
            echo "<br>";
            echo "Results in the table: ";
            echo "<br>";
            echo "Name | Website | Email";
            echo "<br>";


            // $sql = "DELETE FROM MyGuests1 WHERE name='dfas' ";

            //if ($conn->query($sql) === TRUE) {
            //echo "Record deleted successfully";
            //echo "<br>";
            //} else {
            //echo "Error deleting record: " . $conn->error;
            //echo "<br>";
            //}


            while ($row = $result->fetch_assoc()) {
                echo "name: " . $row["name"] . "|website: " . $row["website"] . "|email: " . $row["email"] . "<br>";
            }
        } else {
            echo "0 results";
            echo "<br>";
        }
    }

    else {
        echo "<br>";
        echo "Invalid input!";
    }

    $conn->close();
    */
    ?>





    <footer>
        <p><a href="homepage.html">Home</a> | <a href="#">Site Map</a> | <a href="contact.html">Contact</a></p>
        <p><em>Copyright &copy; 2017 Stock Transaction System</em></p>

    </footer>
</main>



</body>
</html>