<?php
    require_once("templates/header.php");
    require_once("globals.php");
    require_once("dao/movieDAO.php");

    // Movies DAO
    $movieDAO = new MovieDAO($conn , $BASE_URL);

    // Rescue user search
    $q = filter_input(INPUT_GET, "q");

    $movies = $movieDAO->findByTitle($q);

?>
<div id="main-container" class="container-fluid">
    <h2 class="section-title" id="search-title">Searching for: <span id="search-result"><?= $q ?></span></h2>
    <p class="section-description">Results for your search.</p>
    <div class="movies-container">
        <?php foreach ($movies as $movie):?>
            <?php require("templates/moviecard.php"); ?>
        <?php endforeach; ?>
        <?php if(count($movies) === 0): ?>
                <p class="empty-list">No movies found for your search, <a href="<?= $BASE_URL ?>" class="back-link">Back</a></p>
        <?php endif ?>
    </div>
</div>

<?php
    require_once("templates/footer.php");
?>