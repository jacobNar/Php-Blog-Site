<?php 
include("header.php");
include("connect.php");

if(isset($_POST['submit'])){
    $POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);
    $fname = $POST['fname'];
    $lname = $POST['lname'];
    $password = $POST['password'];
    
    $query = "SELECT * FROM `Users` WHERE `fname` = '$fname'  AND `lname` = '$lname' AND `password` = '$password'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    if($row != ""){
        session_start();
        
        $_SESSION['fname'] = $row['fname'];
        $_SESSION['lname'] = $row['lname'];
        $_SESSION['admin'] = $row['admin'];
        $_SESSION['approved'] = $row['approved'];
        $_SESSION['blog'] = $row['blog'];
        $_SESSION['id'] = $row['id'];
        
        if(isset($_GET['redirect']) && $_GET['redirect'] != ""){
            $redirect = $_GET['redirect'];
            header("Location: $redirect");
        }else{
            header("Location: index.php");
        }
    }else{
        echo "<h1>Failed to Login</h1>";
    }
}

?>
<main>
    <?php
        if(isset($_GET['update']) && $_GET['update'] == 'success'){
            echo "<h3>Password Reset Successful";
        }
    ?>
<form action="login.php" method="post">
    <label for="fname">First Name</label>
    <input name="fname" type='text' size="50">
    <label for="lname">Last Name</label>
    <input name="lname" type='text' size="50">
    <label for="password">Password</label>
    <input name="password" type='password' size="30">
    <input type="submit" name="submit" value="Submit">
    <p style="text-align:center;">Reset password <a href="submitEmail.php">here</a></p>
</form>

</main>
<?php include("footer.php"); ?>
