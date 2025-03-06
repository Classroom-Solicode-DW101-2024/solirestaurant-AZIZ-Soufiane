<?php
require 'config.php';

if (!isset($_SESSION['isLogin']) || !$_SESSION['isLogin']) {
    header('Location: login.php');
    exit();
}


$sql = "SELECT * FROM commande WHERE DATE(dateCmd) = CURDATE()";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);


$sql = "SELECT COUNT(*) FROM commande";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$totalOrders = $stmt->fetchColumn();


$sql = "SELECT COUNT(*) FROM commande WHERE Statut = 'annulée'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$canceledOrders = $stmt->fetchColumn();


$sql = "SELECT COUNT(*) FROM client";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$totalClients = $stmt->fetchColumn();


$sql = "SELECT plat.nomPlat, SUM(commande_plat.qte) as total_quantity
        FROM commande_plat
        JOIN plat ON commande_plat.idPlat = plat.idPlat
        JOIN commande ON commande_plat.idCmd = commande.idCmd
        WHERE DATE(commande.dateCmd) = CURDATE()
        GROUP BY plat.nomPlat";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$orderedDishes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-header">
        <img src="images/logo.png" alt="Logo">
    </div>
    <nav class="sidebar-menu">
        <ul>
            <li>Home</li>
            <li>clients</li>
            <li>Orders</li>
        </ul>
    </nav>
</aside>

<main>
    <section class="heroSection">
        <h1 class="admin-title">Admin Dashboard</h1>
        <div class="statistics">
            <div class="stat-box">
                <h3>Total Orders</h3>
                <p><?= $totalOrders ?></p>
            </div>
            <div class="stat-box">
                <h3>Total Clients</h3>
                <p><?= $totalClients ?></p>
            </div>
            <div class="stat-box">
                <h3>Canceled Orders</h3>
                <p><?= $canceledOrders ?></p>
            </div>
        </div>

        <div class="orders-section">
            <h2>Orders of the Day</h2>
            <?php if (!empty($orders)): ?>
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Update Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?= $order['idCmd'] ?></td>
                                <td><?= $order['dateCmd'] ?></td>
                                <td><?= $order['Statut'] ?></td>
                                <td>
                                    <form method="POST" action="update_order_status.php">
                                        <input type="hidden" name="order_id" value="<?= $order['idCmd'] ?>">
                                        <select name="status">
                                            <option value="en attente" <?= $order['Statut'] == 'en attente' ? 'selected' : '' ?>>En attente</option>
                                            <option value="en cours" <?= $order['Statut'] == 'en cours' ? 'selected' : '' ?>>En cours</option>
                                            <option value="expédiée" <?= $order['Statut'] == 'expédiée' ? 'selected' : '' ?>>Expédiée</option>
                                            <option value="livrée" <?= $order['Statut'] == 'livrée' ? 'selected' : '' ?>>Livrée</option>
                                            <option value="annulée" <?= $order['Statut'] == 'annulée' ? 'selected' : '' ?>>Annulée</option>
                                        </select>
                                        <button type="submit">Update</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No orders for today.</p>
            <?php endif; ?>
        </div>

        <div class="dishes-section">
            <h2>Dishes Ordered Today</h2>
            <ul>
                <?php if (!empty($orderedDishes)): ?>
                    <?php foreach ($orderedDishes as $dish): ?>
                        <li><?= htmlspecialchars($dish['nomPlat']) ?> - <?= $dish['total_quantity'] ?> orders</li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No dishes ordered today.</p>
                <?php endif; ?>
            </ul>
        </div>
    </section>
</main>

<footer></footer>

</body>
</html>
