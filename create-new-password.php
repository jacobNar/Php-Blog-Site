<?php
include("connect.php");
$title = "Create A New Password";
include("header.php");
?>
<main>
    <section>
        <?php
            $selector = $_GET['selector'];
            $validator = $_GET['validator'];
            
            if(empty($selector) || empty($validator)){
                echo "<p>Could not validate your request</p>";
            }else{
                if(ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false){
                ?>
                <form action="resetPassword.php" method="post">
                    <input type="hidden" name="selector" value="<?php echo $selector; ?>">
                    <input type="hidden" name="validator" value="<?php echo $validator; ?>">
                    <input type="password" name="pwd" placeholder="Enter a new password">
                    <input type="password" name="cpwd" placeholder="Repeat new password">
                    <input type="submit" name="submit" value="Submit">
                    
                </form>
                
                <?php
                }
            }
        ?>
    </section>
</main>