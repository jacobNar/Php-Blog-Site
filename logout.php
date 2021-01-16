<?php 
include("header.php");

$_SESSION['fname'] = '';
$_SESSION['lname'] = '';

session_unset();
session_destroy();

?>
<main>
    <h1>You are now logged out.</h1>
</main>
<?php include("footer.php"); ?>
