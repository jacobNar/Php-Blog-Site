<?php
include("connect.php");

if(isset($_POST['submit'])){
    $POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);
    
    //token for unqiue id
    $selector = bin2hex(random_bytes(8));
    
    //token to verify user
    $token = random_bytes(32);
    
    $url = "https://www.bracketswebdesign.com/burinfamilysite/create-new-password.php?selector=$selector&validator=" . bin2hex($token);
    
    $expires = date("U") + 1800;
    
    $userEmail = $POST['email'];
    
    $sql = "DELETE FROM pwdReset WHERE `pwdResetEmail` = '$userEmail'";
    
    mysqli_query($conn, $sql);
    
    $hashedToken = bin2hex($token);
    
    $sql = "INSERT INTO pwdReset (`pwdResetEmail`, `pwdResetSelector`, `pwdResetToken`, `pwdResetExpires`) VALUES('$userEmail', '$selector', '$hashedToken', $expires);";
    
    mysqli_query($conn, $sql);
    
    // Email code
    $to = $userEmail;
    $subject = "Password Reset";
    $message = '<p>We have received a password reset request. The link to reset your password is below and will expire in 1 hour.</p>';
    $message .= "<p>Link:<br><a href='$url'>$url</a> </p>";
    
    $headers = "From: <donotreply@bracketswebdesign.com>\r\n";
    $headers .= "Content-type: text/html\r\n";
    
    mail($to, $subject, $message, $headers);
    
    header("Location: submitEmail.php?reset=success");
    
}else{
    header("Location: signin.php");
}

?>
