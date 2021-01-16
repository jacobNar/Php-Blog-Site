<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $title; ?></title>
        <meta charset="utf-8">
         <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <!-- jQuery Modal -->
        <link href="https://font.sgoogleapis.com/css?family=Prata|Source+Sans+Pro&dispaly=swap" rel="stylsheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="main.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-te/1.4.0/jquery-te.min.js"></script>
    </head>
    <body>
        <header>
            <nav>
                <a href="index.php">Home</a>
                <a href="familyTrees/familytree.php">Family Tree</a>
                <a href="biographies.php">Biographies</a>
                <a href="photos.php">Photos</a>
                 <a href="documents.php">Documents</a>
                <a href="stories.php">Blog</a>
                <a href="websites.php">Related Links</a>
                <?php if($admin == 1){ echo "<a href='approve.php'>Permissions</a>"; } ?>
            </nav>
            <h2 class="familytext">The Marcus and Eva Burin Descendants' Project</h2>
            <h2 class="familytext">Portrait of a Family</h2>
        </header>