<?php 
require "config.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="home.css?v=<?php echo time(); ?>">
    <title>Document</title>
</head>
<body>
<header>
    <nav class="navBar">
        <img src="images/logo.png" alt="">
        <section class="filter">
        <form method="POST" action="">
            <select name="categorieCriteria" id="categorieCriteria">
                <option value="">Chercher par la catégorie</option>
                <option value="plat-principal">Plat principal</option>
                <option value="dessert">Dessert</option>
                <option value="entrée">Entrée</option>
            </select>

            <select name="typeCriteria" id="typeCriteria">
                <option value="">Chercher par le type de cuisine</option>
                <option value="marocaine">Marocaine</option>
                <option value="italienne">Italienne</option>
                <option value="chinoise">Chinoise</option>
                <option value="espagnole">Espagnole</option>
                <option value="francaise">Française</option>
            </select>

            <button type="submit" id="searchBtn" name="search">
                <i class="fa-solid fa-magnifying-glass"></i> Recherche
            </button>
            <button type="button" id="clearBtn" onclick="window.location.href='home.php'">
                <i class="fa-regular fa-circle-xmark"></i> Clair
            </button>
        </form>
    </section>
        <div class="navMenu">
            <ul>
                <li>Accueil</li>
                <li>Contacter-nous</li>
            </ul>
        </div>
    </nav>

</header>
<main>
    <section class="heroSection">
        <div class="food-image">
            
        </div>

        <div class="text-Search">

        </div>

        
    </section>
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
                        <button id="OrderBtn">Order now</button>
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