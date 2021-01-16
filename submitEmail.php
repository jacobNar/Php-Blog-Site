<?php
$title = "Reset Password";
include("header.php");

?>
<main>
<h1>Reset Password</h1>
<section>
    <form action="resetRequest.php" method="post">
        <input type="email" name="email" placeholder="Enter your email">
        <input type="submit" name="submit" value="Submit">
    </form>
</section>
<section>
    <?php
        if(isset($_GET['reset']) && $_GET['reset'] == 'success'){
            echo "<p>A password reset link has been sent to your email.</p>";
        }
    ?>
</section>
</main>

<?php include("footer.php"); ?>