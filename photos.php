<?php
include("authenticate.php");
include("connect.php");
$title = "Photos";
include("header.php");
ini_set("display_errors", 1);
if(isset($_POST['submit'])){
    $POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);
    $src = $_FILES["image"]["name"];
    $description = $POST['description'];
    $date = $POST['year'] . '-' . $POST['month'] . '-' . $POST['day'];
    
    $target_dir = "Photos/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Check file size
    if ($_FILES["image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $query = "INSERT INTO `Photos` (`src`, `description`, `date`, `doc`) VALUES ('$src', '$description', '$date', 0);";
            
            if(mysqli_query($conn, $query)){
                echo "The file ". basename( $_FILES["image"]["name"]). " has been uploaded.";
            }else {
                echo $query;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>

<main>
<section>
<?php 
if($admin == 1){ ?>
<section class="modal" id="popup-form">
    <form class="w3-container" action="photos.php" method="post" enctype="multipart/form-data">
        <label for="image">Image</label>
        <input type="file" name="image">
         <label for="description">Description</label>
        <textarea name="description" cols="40" rows="4"></textarea>
        <label for="year">Year (YYYY)</label>
        <input class="w3-input" type="text" name="year" size="4">
        <label for="month">Month (MM)</label>
        <input class="w3-input" type="text" name="month" size="2">
        <label for="day">Day (DD)</label>
        <input class="w3-input" type="text" name="day" size="2">
        <input type="submit" name="submit">
    </form>
    </section>
     <a class="btn btn-primary" href="#popup-form" rel="modal:open">New Photo</a>
<?php } ?>
</section>
<section class="gallery">
<?php 
    $sql = "SELECT * FROM `Photos` WHERE `doc` = 0 ORDER BY `date` ASC";
    $result = mysqli_query($conn, $sql);
    $num_rows = mysqli_num_rows($result);

    while($row = mysqli_fetch_assoc($result)){
        echo  "<div><img src='Photos/" . $row['src'] . "' alt='" . $row['description'] . "'>
               <p>" . $row['description'] . "<br>Year Taken: " . date("Y",strtotime($row['date'])) ."</p>";
        if($admin == 1){ echo "<p><a href='edit-photo.php?id=". $row['id'] . "'>Edit Details</a></p>";}
        echo "</div>";
    }
        
?>
</section>
</main>

<?php include("footer.php"); ?>
