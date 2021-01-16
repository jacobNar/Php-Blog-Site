<?php
include("authenticate.php");
include("connect.php");


$id = $_GET['id'];

$query = "SELECT * FROM Bios WHERE `bio_id` = $id";

if($result = mysqli_query($conn, $query)){
    $rows = mysqli_fetch_assoc($result);
    $id = $rows['bio_id'];
    $biofname = $rows['fname'];
    $lname = $rows['lname'];
    $name = "$biofname $lname";
    $bdate = (isset($rows['birth_date'])) ? $rows['birth_date'] : "";
    $ddate = (isset($rows['death_date'])) ? $rows['death_date'] : "";
    $bio = $rows['bio'];
    $image = $rows['featured_img'];
    $success = true;
}else {
    $success = false;
}

$title = "Biography: $name";
include("header.php");
?>

<main>
    
    <?php
    if($success){
        echo "<div class='bioimg'><img src='Photos/$image' alt='$name'></div>
        <h2>$name</h2>
        <h3>$bdate - $ddate</h3>";
        if($admin == 1){ echo "<a href='edit-bio.php?id=$id'>Edit Biography</a>"; }
        echo "<div id='post' class='container'>$bio</div>";
    }else {
        echo "<h1>Failed to load post.</h1>";
    }
    ?>
</main>
</div>
</body>
</html>