<?php 
include("authenticate.php");
$title = "Blog";
include("header.php");
?>
<link rel="stylesheet" href="stories.css">
<main>
<section id="header">
    <?php if($blog == 1){ ?>
    <a class='btn btn-primary' href="#newThreadContainer" rel="modal:open">Create Thread</a>
    <?php } ?>
</section>
<section id="threads">
    <?php
    include("getthreads.php");
    ?>
</section>
</main>
</div>
<div class="modal" id="newThreadContainer">
<form id="newThreadForm" method="post" action="createThread.php">
  <label for="newThreadName">Post Name: </label><input class="w3-input" type="text" id="newThreadName" name="newThreadName"> 
  <label for="newPostedBy">Your Name: </label><input class="w3-input" type="text" id="newPostedBy" name="newPostedBy">
  <label for="postContents">Post Contents: </label><textarea name="postContents" id="postContents" form="newThreadForm">Enter text here...</textarea>
  <input id="submitNewThread" name="submit" type="submit" value="Submit">
</form>
</div>
<script src='stories.js'></script>
<?php include("footer.php");