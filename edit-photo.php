<?php
include("authenticate.php");
include("connect.php");

if(isset($_GET['id'])){
    $g_id = $_GET['id'];
}else {
    header("Location: photos.php");
}

if(isset($_POST['submit'])){
    $POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);
    $description = $POST['description'];
    $date = $POST['year'] . '-' . $POST['month'] . '-' . $POST['day'];
    $id = $POST['id'];
    $doc = $POST['doc'];
    
    $query = "UPDATE `Photos` SET `description` = '$description', `date` = '$date', `doc` = $doc WHERE `id` = $id LIMIT 1;";
            
    if(mysqli_query($conn, $query)){
        $update_success = true;
        if($doc == 1) { header("Location: documents.php"); }else { header("Location: photos.php"); }
    }else {
        $update_success = false;
    }

}else {

    $sql = "SELECT * FROM `Photos` WHERE `id` = $g_id";
    $result = mysqli_query($conn, $sql);
    $array = mysqli_fetch_assoc($result);

    $src = $array['src'];
    $description = $array['description'];
    $date = explode("-",$array['date']);
    $year = $date[0];
    $month = $date[1];
    $day = $date[2];
    $uploaded = $array['date_uploaded'];
    $doc = $array['doc'];
}



$title = "Edit Photo";

include("header.php");
?>
<?php
if($update_success){
    echo "<h1>The photo's information was sucessfully updated</h1>";
}else {?>
    <main>
    <img style="max-width: 500px;" src="Photos/<?php echo $src; ?>" />
    <form action="edit-photo.php" method="post">
        <input type="hidden" name="id" value="<?php echo $g_id; ?>" />
        <label for="src">File Name</label>
        <input class="w3-input" type="text" size="100" name="src" value="<?php echo $src; ?>" disabled />
        <h3>Date Taken</h3>
        <label for="year">Year (YY)</label>
        <input class="w3-input number-field" type="text" maxlength="4" name="year" value="<?php echo $year; ?>" />
        <label for="month">Month (MM)</label>
        <input class="w3-input number-field" type="text" maxlength="2" name="month" value="<?php echo $month; ?>" />
        <label for="day">Day (DD)</label>
        <input class="w3-input number-field" type="text" maxlength="2" name="day" value="<?php echo $day; ?>" />
        <label for="doc">Document</label>
        <input class="w3-input number-field" type="text" maxlength="1" name="doc" value="<?php echo $doc; ?>" />
        <label for="description">Description</label>
        <textarea  cols="70" rows="10" name="description"><?php echo $description; ?></textarea>
        <input type="submit" name="submit" value="Submit">
    </form>
    <a class='btn btn-primary' href="#confirm-delete-popup" rel="modal:open">Delete</a>
    <div class="modal" id="confirm-delete-popup">
    <form action="delete-photo.php" method="post">
        <p>Are you sure you want to delete this?</p>
        <input type="hidden" name="id" value="<?php echo $g_id; ?>" />
        <input type="hidden" name="doc" value="<?php echo $doc; ?> " />
        <input type="submit" name="deleteSubmit" value="Delete" />
    </form>
    </div>
</main>
<?php } ?>

<?php include("footer.php"); ?>