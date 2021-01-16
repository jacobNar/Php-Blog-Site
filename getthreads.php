<?php

include("connect.php");

if ($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}
else{

$sql = "SELECT * FROM `Threads`";

$result = $conn->query($sql);
$output = "<div id='output'>";

if(true){
    while($row = mysqli_fetch_assoc($result)){
     $output .= ("
     <div class='thread'>
     <div class='threadname'><h3>" . $row["Thread_Name"] . "</h3><h3>".$row["Posted_By"]."</h3></div>
     <p class='contents'>".$row["Message"]."</p>
     <div class='threadname'><h3>Comments</h3>");
     
     if($blog == 1){ $output .= "<button class='btn btn-secondary comment-btn' id='" . $row["Thread_Id"] . "'>Comment</button>"; }
     
      $output .= ("
      </div>
      <div id='comment-form" . $row["Thread_Id"] . "'></div>
     <div id='comments".$row["Thread_Id"]."'>
     <script>
       var xmlhttp = new XMLHttpRequest();
       xmlhttp.open('GET', 'getComments.php?id=".$row["Thread_Id"]."', true);
       xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
       xmlhttp.onreadystatechange = function() {
           if (this.readyState === 4 || this.status === 200){ 
               document.getElementById('comments".$row["Thread_Id"]."').innerHTML = this.responseText; // echo from php
           }       
       };
       xmlhttp.send();
     </script>
     </div>
     </div>");}
}else{ echo "<div>No result</div>";}

$output .= "</div>";

echo $output;
$conn->close();
}
?>