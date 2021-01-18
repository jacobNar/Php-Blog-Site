<?php 
include("authenticate.php");
include("connect.php");
include("header.php"); 
ini_set('display_errors', 1);

function format_bio($bio){
    str_replace("<", "&lt;", $bio);
    str_replace("<", "&gt;", $bio);
    str_replace('"', "&apos;", $bio);
    str_replace('"', "&quot;", $bio);
    
    return $bio;
}

if(isset($_POST['submit'])){
    $POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);
    $src = $_FILES["featured_img"]["name"];
    $fname = $POST['fname'];
    $lname = $POST['lname'];
    $birth_date = $POST['byear'] . "-" . $POST['bmonth'] . "-" . $POST['bday'];
    $death_date = $POST['dyear'] . '-' . $POST['dmonth'] . '-' . $POST['dday'];
    $bio = format_bio($_POST['bio']);
    $p_military = $POST['military'];
    $country_served = $POST['country_served'];
    $target_dir = "Photos/";
    $target_file = $target_dir . basename($_FILES["featured_img"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Check file size
    if ($_FILES["featured_img"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["featured_img"]["tmp_name"], $target_file)) {
            $query = "INSERT INTO `Bios` (`fname`, `lname`, `birth_date`, `death_date`, `bio`,`military`, `country_served`, `featured_img`) VALUES ('$fname', '$lname', '$birth_date', '$death_date', '$bio', $p_military, '$country_served', '$src');";
            
            if(mysqli_query($conn, $query)){
                echo "The file ". basename( $_FILES["featured_img"]["name"]). " has been uploaded.";
            }else {
                echo $query;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
            
        }
    }
}

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-te/1.4.0/jquery-te.min.js"></script>
<script>
    $(function() {
      $("textarea").jqte();
    });
      
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-te/1.4.0/jquery-te.min.css">

    
<?php if($admin == 1){ ?>
<section id="popup-form" class="modal">
 <form action="biographies.php" method="post" enctype="multipart/form-data">
        <label for="fname">First Name</label>
        <input class="w3-input" type="text" size="50" name="fname">
        <label for="lname">Last Name</label>
        <input class="w3-input" type="text" size="50" name="lname">
        <h3>Birth Date</h3>
        <label="byear">Year (YYYY)</label>
        <input class="w3-input" type="text" size="4" maxlength="4" name="byear">
        <label="bmonth">Month (MM)</label>
        <input class="w3-input"type="text" size="2" maxlength="2" name="bmonth">
        <label="bmonth">Day (DD)</label>
        <input class="w3-input"type="text" size="2" maxlength="2" name="bday">
         <h3>Death Date</h3>
        <label="dyear">Year (YYYY)</label>
        <input class="w3-input" type="text" size="4" maxlength="4" name="dyear">
        <label="dmonth">Month (MM)</label>
        <input class="w3-input"type="text" size="2" maxlength="2" name="dmonth">
        <label="dmonth">Day (DD)</label>
        <input class="w3-input"type="text" size="2" maxlength="2" name="dday">
                <label for="military">Military Service</label>
        <select name="military">
            <option value="0">No</option>
            <option value="1">Yes</option>
        </select>
        <label for="military">Country Served</label>
         <select name="country_served">
            <option></option>
            <option value="USA">United States</option>
            <option value="Germany">Germany</option>
            <option value="Israel">Israel</option>
        </select>
        <input type="file" name="featured_img">

        <textarea name="bio">
        </textarea>
        
        <input type="submit" name="submit" value="Submit">
    </form>
   </section>
  <a class="btn btn-primary" href="#popup-form" rel="modal:open">New Biography</a>
<?php } ?>

    <section id="blogposts">

    <?php 
        include("connect.php");

        $query = "SELECT * FROM `Bios`ORDER BY `fname`";

        if($result = mysqli_query($conn, $query)){
            while($row = mysqli_fetch_assoc($result)){
                $id = $row['bio_id'];
                $fname = $row['fname'];
                $lname = $row['lname'];
                $name = "$fname $lname";
                $military = $row['military'];
                $country_served = $row['country_served'];
                
                // $bdate = (isset($row['birth_date'])) ? $row['birth_date'] : "";
                // $ddate = (isset($row['death_date'])) ? $row['death_date'] : "";
                $image = $row['featured_img'];

                echo "<div>
                        <a href='biography.php?id=$id'><img src='Photos/$image'alt='$name'></a>
                        <p style='color: black; display: inline;'>$name</p>";
                        echo ($military == 1 && $country_served == 'USA') ? "<img style='width: 10%; display: inline;' src='Photos/american-flag-icon.png'>" : "";
                        echo  ($military == 1 && $country_served == 'Germany') ? "<img style='width: 10%; display: inline;' src='Photos/germany-flag.jpg'>" : "";
                        echo  ($military == 1 && $country_served == 'Israel') ? "<img style='width: 10%; display: inline;' src='Photos/israel-flag.png'/>" : "";
                    
                echo "</div>";
                
            };            
        }else {
            echo "<h1>Failed to load biographies</h1>";
        }
    ?>
    
    </section>
    
</div>
</body>
</html>