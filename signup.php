<?php
include("connect.php");
$POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);

if(isset($POST['submit'])){
    $fname = $POST['fname'];
    $lname = $POST['lname'];
    $email = $POST['email'];
    $password = $POST['password'];
    $cpassword = $POST['cpassword'];

    if($password == $cpassword){
        $query = "INSERT INTO Users (`fname`, `lname`, `email`, `password`, `approved`) VALUES('$fname', '$lname', '$email', '$password', 0)";

        if(mysqli_query($conn, $query)){
            $success = true;
            
            $to = "jacobnarayan1998@gmail.com, jdnarayan56W@gmail.com";
            $subject = "New Sign Up";
            $message = "<p>Hello Admin(s). A new user: $fname $lname, has requested access to the site.</p>";
            $message .= "<p>Approve their access <a href='burindescendants.org/approve.php'>here</a>. </p>";
    
            $headers = "From: <SignupAlert@bracketswebdesign.com>\r\n";
            $headers .= "Content-type: text/html\r\n";
    
            mail($to, $subject, $message, $headers);
    
        }

    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Signup</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="utf-8">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="main.css">
<link href="https://fonts.googleapis.com/css?family=Prata|Source+Sans+Pro&display=swap" rel="stylesheet">
<link rel="stylesheet" href="stories.css">
<script src="forms.js"></script>
</head>
<body>
<div class="wrapper" id="wrapper">
    <nav>
            <a href="index.html">Home</a>
            <a href="familytree.html">Family Tree</a>
            <a href="biographies.html">Biographies</a>
            <a href="photos.html">Photos</a>
            <!--<a href="video.html">Videos</a>-->
            <a href="documents.html">Documentation</a>
            <a href="stories.php">Blog</a>
            </nav>
    <?php
        if($success){
            echo "<h1>Your are now signed up</h1><p>Log in <a href='login.php'>here</a></p>";
        }else{ ?>
        <form action="signup.php" method="post">
        <label for="fname">First Name</label>
        <input type="text" size="50" name="fname" required>
        <label for="lname">Last Name</label>
        <input type="text" size="50" name="lname" required>
        <label for="lname">Email</label>
        <input type="email" size="50" name="email" required>
        <label for="password">Password</label>
        <input type="password" size="30" name="password" required>
        <label for="cpassword">Confirm Password</label>
        <input type="password" size="30" name="cpassword" required>
        <input type='submit' name="submit">
        </form>
        
        <?php echo $query; } ?>
</body>
</html>
