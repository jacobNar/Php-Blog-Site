<?php 
include("authenticate.php");
include("connect.php");
$title = "Websites";
include("header.php"); 

if(isset($_POST['submit'])){
    $POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);
    
    $link = $POST['link'];
    $description = $POST['description'];
    
    $query = "INSERT INTO `Links` (`link`, `description`) VALUES ('$link', '$description');";
            
    if(mysqli_query($conn, $query)){
        echo "<h1>Link added</h1>";

    }else {
        echo "<h1>Failed to add the link</h1>";
    }
}

if(isset($_POST['delete-submit'])){
    $delete_id = $_POST['delete-id'];
    
    $sql = "DELETE FROM `Links` WHERE `id` = $delete_id";
    if(mysqli_query($conn, $sql)){
        echo "<h1>Link Deleted</h1>";

    }else {
        echo "<h1>Failed to delete the link</h1>";
        echo $sql;
    }
}
?>

<main>
    <h1>Related Links</h1>
    <?php 
    if ($admin == 1 ){
        echo "<form action='websites.php' method='post' style='width: 30%;'>";
        echo "<label for='link'>Link</label>";
        echo "<input type='input' class='form-control' name='link' required /><br>";
        
        echo "<label for='description'>Description</label>";
        echo "<textarea name='description' class='form-control'></textarea>";
        echo "<input type='submit' class='btn btn-primary' name='submit' value='Add Link'>";
        echo "</form >";
    }
    ?>
    <section>
    <ul style='width: 60%; margin: 0 auto;'>
    <?php
    $query = "SELECT * FROM `Links`";

        if($result = mysqli_query($conn, $query)){
            while($row = mysqli_fetch_assoc($result)){
                $link = $row['link'];
                $description = $row['description'];
                echo "<li><a href='$link'>$link</a> - $description";
                if($admin == 1){
                    echo "<form action='websites.php' method='post' style='max-width: 50px; display: inline-block; margin: 0 10px;'><input type='hidden' name='delete-id' value='{$row['id']}' /><input class='btn btn-primary' name='delete-submit' type='submit' value='Delete' /></form></li>";
                }else {
                    echo "</li>";
                }
                
            };            
        }else {
            echo "<h1>Failed to load links</h1>";
        }
    ?>
    </ul>
    </section>
</main>

<?php include("footer.php"); ?>