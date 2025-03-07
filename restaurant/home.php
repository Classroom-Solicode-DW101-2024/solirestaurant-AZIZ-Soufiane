<?php
require 'config.php';

if (isset($_GET["destroy"])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION["client"])) {
    header("Location: login.php");
    exit();
}

$plats = [];
$sql = "SELECT * FROM plat";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["search"])) {
    $type = $_POST["typeCriteria"];
    $category = $_POST["categorieCriteria"];
    
    if ($type && $category) {
        $sql = "SELECT * FROM plat WHERE TypeCuisine = '$type' AND categoriePlat = '$category'";
    } elseif ($type) {
        $sql = "SELECT * FROM plat WHERE TypeCuisine = '$type'";
    } elseif ($category) {
        $sql = "SELECT * FROM plat WHERE categoriePlat = '$category'";
    }
}

$result = $pdo->query($sql);
$plats = $result->fetchAll(PDO::FETCH_ASSOC);


$platsByCuisine = [];
foreach ($plats as $plat) {
    $platsByCuisine[$plat['TypeCuisine']][] = $plat;
}

if (isset($_POST['add_to_cart'])) {
    $plat_id = $_POST['plat_id'];
    $plat_name = $_POST['plat_name'];
    $plat_price = $_POST['plat_price'];
    $plat_image = $_POST['plat_image'];
    $quantity = 1;

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $found = false;

    
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $plat_id) {
            $item['quantity'] += $quantity;
            $found = true;
            break;
        }
    }
    unset($item);

    
    if (!$found) {
        $_SESSION['cart'][] = [
            'id' => $plat_id,
            'name' => $plat_name,
            'price' => $plat_price,
            'image' => $plat_image,
            'quantity' => $quantity
        ];
    }

    header("Location: home.php");
    exit();
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="home.css?v=<?php echo time(); ?>">
    <title>Delish</title>
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

            <button type="submit" name="search">
                <i class="fa-solid fa-magnifying-glass"></i> Recherche
            </button>
        </form>
    </section>
        <div class="navMenu">
        <form method="POST" action="cart.php">
            <button type="submit" style="background: none; border: none; padding: 0; cursor: pointer;">
                <img id="cartImage" src="images/cart.png" alt="">
            </button>
        </form>
        <form method="POST" action="login.php">
            <button type="submit" name="logout" style="background: none; border: none; padding: 0; cursor: pointer;">
        <ul>
                <li>Déconnexion</li>
            </ul>
            </button>
        </form>
            
        </div>
    </nav>
</header>

<main>
    <section class="heroSection">
        <h1 class="hero-text">Deishious Food awaits you</h1>
    </section>

    <?php if (!empty($platsByCuisine)): ?>
        <?php foreach ($platsByCuisine as $typeCuisine => $plats): ?>
            <div class="cuisine-section">
                <h2 class="cuisine-title"><?= htmlspecialchars($typeCuisine) ?></h2>
                <?php foreach ($plats as $plat): ?>
                    <div class="card">
                        <img src="<?= htmlspecialchars($plat['image']) ?>" alt="<?= htmlspecialchars($plat['nomPlat']) ?>">
                        <div class="card-content">
                            <h3><?= htmlspecialchars($plat['nomPlat']) ?></h3>
                            <p>Categorie : <?= htmlspecialchars($plat['categoriePlat']) ?></p>
                            <p>Prix : <?= htmlspecialchars($plat['prix']) ?> $</p>
                            <form method="POST">
                                <input type="hidden" name="plat_id" value="<?=$plat['idPlat']?>">
                                <input type="hidden" name="plat_name" value="<?=$plat['nomPlat']?>">
                                <input type="hidden" name="plat_price" value="<?=$plat['prix']?>">
                                <input type="hidden" name="plat_image" value="<?=$plat['image']?>">
                                <input type="hidden" name="quantity" value="1">
                                <button id="OrderBtn" name="add_to_cart">Commander</button>
                            </form>
                            
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Aucun plat trouvé.</p>
    <?php endif; ?>
</main>

<footer>
<div class="footer-content">
        <div class="footer-logo">
            <img src="images/logo.png" alt="Delish Logo">
        </div>
        <div class="footer-links">
            <ul>
                <li><a href="#">Accueil</a></li>
                <li><a href="cart.php">pannier</a></li>
            </ul>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 Delish. All rights reserved.</p>
        </div>
    </div>
</footer>
</body>
</html>