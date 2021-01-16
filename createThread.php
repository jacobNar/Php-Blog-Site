
    <?php

function test_input($data){
	$data = trim($data); 
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
  return $data;
}

include("connect.php");

if ($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}

else{
    if (isset($_POST['submit'])){
        $newThreadName = test_input($_POST["newThreadName"]);
        $newPostedBy = test_input($_POST["newPostedBy"]);
        $postContents = test_input($_POST["postContents"]);
        $date = "0000-00-00";
        
        $sql = "INSERT INTO `Threads`(`Thread_Name`, `Posted_By`, `Message`, `Time_Posted`) VALUES ('".$newThreadName."', '".$newPostedBy."', '".$postContents."', ".$date.")";

        if($conn->query($sql)){
            header("Location: stories.php");
        }else{echo '<h1>'.$conn->error.'</h1>';};
        $conn->close();
    }
}


?>
    </main>


</div>

</body>
</html>

