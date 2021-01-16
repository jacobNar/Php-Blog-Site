<?php
include("connect.php");

function test_input($data){
	$data = trim($data); 
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
    return $data;
}

$conn = new mysqli($servername, $username, $pass, $db);

if ($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}

else{
    if (isset($_POST['submit'])){
        $postId = $_POST["postId"];
        $commentName = test_input($_POST["commentName"]);
        $comment = test_input($_POST["comment"]);
        $date = "0000-00-00";
        
        $sql = "INSERT INTO `Replies`(`Posted_by`, `Reply`, `Time_Posted`, `Post_Id`) VALUES ('".$commentName."', '".$comment."', ".$date.", ".$postId.")";
        if($conn->query($sql)){
            header("Location: stories.php");
        }else{echo '<h1>Failed to post.</h1>'; echo mysqli_error($conn); echo $sql;};
        $conn->close();
    }
}


?>