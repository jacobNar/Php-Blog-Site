<?php
if(isset($_POST["deleteSubmit"])){
    $POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);
    $id = $POST['id'];
    $doc = $POST['doc'];

    $query = "DELETE FROM `Photos` WHERE `id` = $id LIMIT 1;";
            
    if(mysqli_query($conn, $query)){
        $delete_success = true;
        if($doc == 1) { header("Location: documents.php"); }else { header("Location: photos.php"); }
    }else {
        header("Location: index.php");
    }
}