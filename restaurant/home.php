<?php 
require "config.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="home.css">
    <title>Document</title>
</head>
<body>
<header>

</header>
<main>
    <?php foreach ($platsByCuisine as $typeCuisine => $plats): ?>
        <div class="cuisine-section">
            <h2 class="cuisine-title"><?= htmlspecialchars($typeCuisine) ?></h2>
            <?php foreach ($plats as $plat): ?>
                <div class="card">
                    <img src="<?= htmlspecialchars($plat['image']) ?>" alt="<?= htmlspecialchars($plat['nomPlat']) ?>">
                    <div class="card-content">
                        <h3><?= htmlspecialchars($plat['nomPlat']) ?></h3>
                        <p>Category : <?= htmlspecialchars($plat['categoriePlat']) ?></p>
                        <p>Price : <?= htmlspecialchars($plat['prix']) ?> $</p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
    </main>


<footer>

</footer>
</body>
</html>