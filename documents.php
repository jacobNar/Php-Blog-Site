<?php
include("authenticate.php");
$title = "Documents";
include("header.php");
include("connect.php");

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
            $query = "INSERT INTO `Photos` (`src`, `description`, `date`, `doc`) VALUES ('$src', '$description', '$date', 1);";
            
            if(mysqli_query($conn, $query)){
                echo "The file ". basename( $_FILES["image"]["name"]). " has been uploaded.";
                
            }else {
                echo $query;
                echo "Sorry, there was an error uploading your file.";
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
    <form class="w3-container" action="documents.php" method="post" enctype="multipart/form-data">
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
      <a class="btn btn-primary" href="#popup-form" rel="modal:open">New Document</a>
<?php } ?>
</section>

<?php 
$sql = "SELECT MIN(date) AS 'Min Date' FROM `Photos`";
$result = mysqli_query($conn, $sql);
$minDateArray = mysqli_fetch_assoc($result);
$minDate = $minDateArray['Min Date'];
$minDate = date_parse($minDate);
$minDate = $minDate['year'];

$sql = "SELECT MAX(date) AS 'Max Date' FROM `Photos`";
$result = mysqli_query($conn, $sql);
$maxDateArray = mysqli_fetch_assoc($result);
$maxDate = $maxDateArray['Max Date'];
$maxDate = date_parse($maxDate);
$maxDate = $maxDate['year'];

$date = $minDate;

while($date <= $maxDate){
   
    $sql = "SELECT * FROM `Photos` WHERE `date` BETWEEN '$date-01-01' AND '" . ($date + 9) . "-01-01' AND `doc` = 1 ORDER BY `date` ASC";
    $result = mysqli_query($conn, $sql);
    $num_rows = mysqli_num_rows($result);
    
    if($num_rows != 0){ echo "<h2>$date - " . ($date + 9) . "</h2><section class='gallery'>";} else {echo "";}
    
    while($row = mysqli_fetch_assoc($result)){
        echo  "<div><img src='Photos/" . $row['src'] . "' alt='" . $row['description'] . "'>
               <p>" . $row['description'] . "<br>" . $row['date'] ."</p>";
               if($admin == 1){ echo "<p><a href='edit-photo.php?id=". $row['id'] . "'>Edit Details</a></p>";}
               echo "</div>";
    }
        
    if($num_rows != 0){ echo "</section>"; }else{echo ""; }

    $date += 10;
}
?>
</main>
<?php include("footer.php"); ?>
