
 <nav>
                <a style='color:white;' href="../index.php">Home</a>
                <a style='color:white;' href="familytree.php">Family Tree</a>
                <a style='color:white;' href="../biographies.php">Biographies</a>
                <a style='color:white;' href="../photos.php">Photos</a>
                 <a style='color:white;' href="../documents.php">Documents</a>
                <a style='color:white;' href="../stories.php">Blog</a>
                <a style='color:white;' href="../websites.php">Related Links</a>
                <?php if($admin == 1){ echo "<a href='../approve.php'>Permissions</a>"; } ?>
            </nav>
<?php include("familytree.html"); ?>

<style>

    nav {
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;
    justify-content: space-evenly;
    width: 100%;
    background-color: #073766;
    text-align: left;
}

nav a {
    color:white;
    flex: 1 1 15%;
    text-decoration: none;
    text-align: center;
    transition: 0.5s;
    padding: 10px 0;
}


nav a:hover {
    background-color: #990474;
    color: white;
    text-decoration: none;
}
</style>