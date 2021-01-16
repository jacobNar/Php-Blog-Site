<?php 
include("authenticate.php");
include("connect.php");
$title = "Home";

include("header.php"); 

function format_bio($bio){
    str_replace("<", "&lt;", $bio);
    str_replace("<", "&gt;", $bio);
    str_replace('"', "&apos;", $bio);
    str_replace('"', "&quot;", $bio);
    
    return $bio;
}

if(isset($_POST['figureText-submit'])){
    //$POST = $POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);
    $figureText = format_bio($_POST['figureText']);
    $sql = "UPDATE `Home` SET `figureText` = '$figureText' WHERE `id` = 1";
    if(mysqli_query($conn, $sql)){
            $updateSuccess = true;
    }else {
            $updateSuccess = false;
            echo mysqli_error($conn);
    }
    
}

if(isset($_POST['body-submit'])){
    //$POST = $POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);
    $body = format_bio($_POST['body']);
    $sql = "UPDATE `Home` SET `body` = '$body' WHERE `id` = 1";
    if(mysqli_query($conn, $sql)){
            $updateSuccess = true;
    }else {
            $updateSuccess = false;
            echo mysqli_error($conn);
    }
    
}


?>

<main>
<section>
    <?php
        if($admin == 1){
            echo "<a class='text-center' href='index.php?edit=1'>Edit Page</a>";
        }
        if(isset($updateSuccess)){
            if($updateSuccess == true){
                echo "<p class='text-center'>Update was successful</p>";
            } 
            if($updateSuccess == false) {
                echo "<p class='text-center'>Update failed</p>";
                echo $sql;
              echo mysqli_error($conn);
            }
        }
        
    ?>
</section>
<section>
        <img src="Photos/Marcus_Eva_Burin_Family.jpg" alt="family portrait" class="img responsive">
        <p style="text-align: center;">
            <?php
            $query = "SELECT * FROM `Home` WHERE id=1";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            $figureText = $row['figureText'];
            $body = $row['body'];
            
            if($admin == 1){
                if($_GET['edit'] == 1){
                    echo "<form action='index.php' method='post'>
                        <textarea class='form-control' name='figureText'>$figureText</textarea>
                        <input type='submit' name='figureText-submit' ?>
                        </form>";
                }else {
                    if($figureText != ""){
                    echo $figureText;          
                    }else {
                    echo "<h1>Failed to load content</h1>";
                    }
                }
                
            }else {
                    if($figureText != ""){
                    echo $figureText;          
                    }else {
                    echo "<h1>Failed to load content</h1>";
                    }
            }
                
            ?>
            <!--Standing from left to right (Top): Max Burin (Son), Paul Burin (Son), Alfred Burin (Son), Julius Burin (Son), Erich Burin (Son).<br>-->
            <!--Sitting from left to right: Jenny Burin (Daughter), Eva Burin (Mother), Marcus Burin (Father), Julia Burin (Daughter).<br><br>-->
            <!--This is a picture of Marcus and Eva Burin, who lived in Berlin Germany.-->
            <!--It was taken in summer 1919 at a family reunion on the occasion of their son Alfred's first visit from New York -->
            <!--after World War I, and their son Eric's release from a prisonar of war camp in France.-->
        <p>
</section>
    <section>
        <?php
        if($admin == 1){
                if($_GET['edit'] == 1){
                    echo "<form action='index.php' method='post'>
                        <textarea class='form-control' name='body'>$body</textarea>
                        <input type='submit' name='body-submit' ?>
                        </form>";
                }else {
                    if($body != ""){
                    echo $body;          
                    }else {
                    echo "<h1>Failed to load content</h1>";
                    }
                }
                
            }else {
                    if($body != ""){
                    echo $body;          
                    }else {
                    echo "<h1>Failed to load content</h1>";
                    }
            }
        ?>
    </section>
    </main>
    <script>
        $(function(){
            $("textarea").jqte();
        })
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-te/1.4.0/jquery-te.min.css">

<?php include("footer.php"); ?>