<?php 
include("authenticate.php");
include("connect.php");

if(isset($_GET['id'])){
    $g_id = $_GET['id'];
}else {
    // header("Location: biographies.php");
}

function format_bio($bio){
    $bio = str_replace("'", "&apos;", $bio);
    $bio = str_replace('"', "&quot;", $bio);
    
    return $bio;
}

if(isset($_POST['submit'])){
    $POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);
    $fname = $POST['fname'];
    $lname = $POST['lname'];
    $bdate = $POST['byear'] . '-' . $POST['bmonth'] . '-' . $POST['bday'];
    $ddate = $POST['dyear'] . '-' . $POST['dmonth'] . '-' . $POST['dday'];
    $u_bio = format_bio($_POST['bio']);
    $id = $POST['id'];
    $military = $POST['military'];
    $country_served = $POST['country_served'];
    
    if($_FILES['featured_img']['name'] != "") {
        $target_dir = "Photos/";
        $target_file = $target_dir . $_FILES['featured_img']['name'];
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Check file size

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            //echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["featured_img"]["tmp_name"], $target_file)) {
                $query = "UPDATE `Bios` SET`fname` = '$fname', `lname` = '$lname', `birth_date` = '$bdate', `death_date` = '$ddate', `bio` = '$u_bio', `military` = $military, `country_served` = '$country_served', `featured_img` = '{$_FILES['featured_img']['name']}'  WHERE `bio_id` = $id LIMIT 1; ;";
            
                if(mysqli_query($conn, $query)){
                    $file_upload_success = true;
                   
                }else {
                    $file_upload_success = false;
                }
            } else {
            echo "Sorry, there was an error uploading your file.";
            echo $target_file;
            }
        }
    }else {
        $query = "UPDATE `Bios` SET `fname` = '$fname', `lname` = '$lname', `birth_date` = '$bdate', `death_date` = '$ddate', `military` = $military, `country_served` = '$country_served', `bio` = '$u_bio' WHERE `bio_id` = $id LIMIT 1;";
            
        if(mysqli_query($conn, $query)){
            $update_success = true;
        }else {
            $update_success = false;
        }
    }

}else {

    $sql = "SELECT * FROM `Bios` WHERE `bio_id` = $g_id";
    $result = mysqli_query($conn, $sql);
    $array = mysqli_fetch_assoc($result);

    $fname = $array['fname'];
    $lname = $array['lname'];
    $bio = $array['bio'];
    $bdate = explode("-",$array['birth_date']);
    $byear = $bdate[0];
    $bmonth = $bdate[1];
    $bday = $bdate[2];
    $ddate = explode("-", $array['death_date']);
    $dyear = $ddate[0];
    $dmonth = $ddate[1];
    $dday = $ddate[2];
    $featured_img = $array['featured_img'];
}

$title = "Edit Biography";
include("header.php");

if($update_success == true || $file_upload_success == true){
    echo "<h1>Success</h1>";
}else{
    echo "<h1>There was a problem with your update</h1>";
}

?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-te/1.4.0/jquery-te.min.js"></script>
<script>
    $(function() {
      $("textarea").jqte();
    });
      
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-te/1.4.0/jquery-te.min.css">

<main>
    <section>
    <form action="edit-bio.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $g_id; ?>">
        <input type="file" name="featured_img">
        <label for="fname">First Name</label>
        <input class="w3-input" type="text" size="50" name="fname" value="<?php echo $fname; ?>">
        <label for="lname">Last Name</label>
        <input class="w3-input" type="text" size="50" name="lname" value="<?php echo $lname; ?>">
        <h3>Birth Date</h3>
        <label="byear">Year (YYYY)</label>
        <input class="w3-input" type="text" size="4" maxlength="4" name="byear" value="<?php echo $byear; ?>">
        <label="bmonth">Month (MM)</label>
        <input class="w3-input"type="text" size="2" maxlength="2" name="bmonth" value="<?php echo $bmonth; ?>">
        <label="bmonth">Day (DD)</label>
        <input class="w3-input"type="text" size="2" maxlength="2" name="bday" value="<?php echo $bday; ?>">
         <h3>Death Date</h3>
        <label="dyear">Year (YYYY)</label>
        <input class="w3-input" type="text" size="4" maxlength="4" name="dyear" value="<?php echo $dyear; ?>">
        <label="dmonth">Month (MM)</label>
        <input class="w3-input"type="text" size="2" maxlength="2" name="dmonth" value="<?php echo $dmonth; ?>">
        <label="dmonth">Day (DD)</label>
        <input class="w3-input"type="text" size="2" maxlength="2" name="dday" value="<?php echo $dday; ?>">
        <label for="military">Military Service</label>
        <select name="military">
            <option></option>
            <option value="0">No</option>
            <option value="1">Yes</option>
        </select>
         <label for="country_served">Country Served</label>
         <select name="country_served">
            <option></option>
            <option value="USA">United States</option>
            <option value="Germany">Germany</option>
            <option value="Israel">Israel</option>
        </select>
        <textarea name="bio">
             <?php echo $bio; ?>
        </textarea>
        <input type="submit" name="submit" value="Submit">
    </form>
</section>
</main>

<?php include("footer.php");