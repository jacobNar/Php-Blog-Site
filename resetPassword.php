<?php
include('connect.php');
if(isset($_POST['submit'])){
    $POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);
    
    $selector = $POST['selector'];
    $validator = $POST['validator'];
    $pwd = $POST['pwd'];
    $cpwd = $POST['cpwd'];
    
    if(empty($pwd) || empty($cpwd)){
        header("Location: create-new-password.php?newpad=empty");
        exit();
    }elseif($pwd != $cpwd){
        header("Location: create-new-password.php?newpad=notsame");
        exit();
    }
    
    $currentDate = date('U');
    
    $sql = "SELECT * FROM pwdReset WHERE pwdResetSelector = '$selector' AND pwdResetExpires >= $currentDate";
    
    $result = mysqli_query($conn, $sql);
    $rows = mysqli_fetch_assoc($result);
    
    $tokenBin = $validator;
    
    if($tokenBin != $rows['pwdResetToken']){
        echo "You need to resubmit your recent request.";
    }else{
        $tokenEmail = $rows['pwdResetEmail'];
        
        $sql = "SELECT * FROM `Users` WHERE `email` = '$tokenEmail'";
        $result = mysqli_query($conn, $sql);
        $rows = mysqli_fetch_assoc($result);
        
        $sql = "UPDATE `Users` SET `password` = '$pwd' WHERE `email` = '$tokenEmail';";
        if(mysqli_query($conn, $sql)){
            header("Location: login.php?update=success");
        }else{
            echo $sql;
        }
    }
    
}else{
    header("Location: login.php");
}
?>
