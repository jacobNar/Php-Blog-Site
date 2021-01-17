<?php
session_start();
$sfname = $_SESSION['fname'];
$slname = $_SESSION['lname'];
$admin = $_SESSION['admin'];

if($admin != 1){
    header("Location: index.php");
}

if($sfname == "" || $slname == ""){
    header("Location: login.php?redirect=approve.php");
}
include("connect.php");
include("header.php");

if(isset($_POST['submit'])){
    $POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);
    $pid = $POST['id'];
    $email = $POST['email'];
    $approve = $POST['approve'];
    $blog = $POST['blog'];
    $admin = $POST['admin'];
    $sql = "UPDATE `Users` SET `approved` = $approve, `blog` = $blog, `admin` = $admin WHERE `id` = $pid";
    
    if(mysqli_query($conn, $sql)){
        echo "<h1>User has been updated!</h1>";
    
        $to = $email;
        $subject = "Your Account Permissions Have Been Updated";
        $message = "<p>Hello. Your account permissions at burindescendants.org have been updated. Your permissions are as follows:</p>";
        if($approve == 1){
            $message .= "<p>Site Access: Granted</p>";
        }else {
            $message .= "<p>Site Access: Denied</p>";
        }
        if($blog == 1){
            $message .= "<p>Blog Access: Granted</p>";
        }else {
            $message .= "<p>Blog Access: Denied</p>";
        }
        
        $headers = "From: <Account@bracketswebdesign.com>\r\n";
        $headers .= "Content-type: text/html\r\n";

        mail($to, $subject, $message, $headers);
        
    }else { 
        echo mysqli_error($conn);
        echo $sql;
    }
}

if(isset($_POST['family-tree-submit'])){
    $target_file = "familyTrees/familytree.html";
    //$target_file = $target_dir . $_FILES['family-tree']['name'];
    
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    
    if($imageFileType != "html") {
        echo $imageFileType;
        echo "<h1>Sorry, only '.html' files are allowed.</h1>";
        $uploadOk = 0;
    }else {
        if (file_exists($target_file) && $_FILES['family-tree']['tmp_name'] != "") {
            unlink($target_file);
        }
    }
    
    if ($uploadOk == 0) {
            //echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {
            
            if (move_uploaded_file($_FILES["family-tree"]["tmp_name"], $target_file)) {
                echo "<h1>Family tree successfully uploaded.</h1>";
            }else {
                echo "<h1>Failed to upload the family tree.</h1>";
            }
        }
    
}
?>
<main>
    <section>
        <h3>Upload new family tree</h3>
        <form action='approve.php' method='post' enctype="multipart/form-data" style="width:40%;">
            <div class="input-group">
                <div class="input-group-prepend">
                    <input type="submit" name="family-tree-submit" value='Upload' style="margin: 0;"/>
                </div>
                <div class="custom-file">
                    <label class="custom-file-label" for="family-tree">Choose file</label>
                    <input type="file" class="custom-file-input" name='family-tree'>
                    
                </div>
            </div>
        </form>

    </section>
    
    <section>
        <h1>Change permissions for all users</h1>
            <?php 
                $query = "SELECT * FROM `Users`";
                $result = mysqli_query($conn, $query);
                
                echo "<div id='blogposts'>";
                if($result){
                    while($row = mysqli_fetch_assoc($result)){
                        $fname = $row['fname'];
                        $lname = $row['lname'];
                        $admin = $row['admin'];
                        $approved = $row['approved'];
                        $blog = $row['blog'];
                        $email = $row['email'];
                        $name = $fname . $lname;
                        $id = $row['id'];
                        
                        echo "<div>";
                        echo "<form action='approve.php' method='post'>";
                        echo "<h4>$fname $lname</h4>";
                        echo "<input type='hidden' name='id' value='$id'>";
                        echo "<input type='hidden' name='email' value='$email'>";
                        echo "<label for='approve'>Site Access</label>";
                        echo "<p>Approve <input class='w3-radio' type='radio' name='approve' value='1' ";
                        if($approved == 1){ echo "checked";} 
                        echo " ></p>";
                        echo "<p>Deny <input class='w3-radio' type='radio' name='approve' value='0' ";
                        if($approved == 0){ echo "checked";} 
                        echo "></p>";
                        echo "<hr>";
                        echo "<label for='blog'>Blog Permission</label>";
                        echo "<p>Approve <input class='w3-radio' type='radio' name='blog' value='1' "; 
                        if($blog == 1){ echo "checked";} 
                        echo "></p>";
                        echo "<p>Deny <input class='w3-radio' type='radio' name='blog' value='0' ";
                         if($blog == 0){ echo "checked";} 
                        echo "></p>";
                        echo "<hr>";
                        echo "<label for='admin'>Admin Permission</label>";
                        echo "<p>Approve <input class='w3-radio' type='radio' name='admin' value='1' "; 
                        if($admin == 1){ echo "checked";} 
                        echo "></p>";
                        echo "<p>Deny <input class='w3-radio' type='radio' name='admin' value='0' ";
                         if($admin == 0){ echo "checked";} 
                        echo "></p>";
                        echo "<input type='submit' name='submit' value='Submit'>";
                        echo "</form>";
                        echo "</div>";
                    }
                }else {
                    echo mysqli_error($conn);
                    echo $query;
                }
                
            ?>
    </section>
</main>
<?php include("footer.php"); ?>