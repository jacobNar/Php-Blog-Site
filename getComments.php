<?php

/*
You need to make this so it responds to AJAX request and gives back comments.
*/
include("connect.php");

$conn = new mysqli($servername, $username, $pass, $db);

if ($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}
else{

$sql = "SELECT * FROM `Replies` WHERE Post_Id = ".$_GET["id"];

$result = $conn->query($sql);
$output = "";

if(true){
    while($row = mysqli_fetch_assoc($result)){
        $output .= "<div class='comments'>";
        $output .= "<h4>Posted By: ".$row['Posted_by']."</h4>";
        $output .= "<p>".$row["Reply"]."</p>";
        $output .= "</div>";
    }
}
}

echo $output;
$conn->close();