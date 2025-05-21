<?php
session_start();

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: login.php");
    exit();
}

require_once '../../config/database.php';
$pdo = getDBConnection();

//ala ases anna stats ahna zeda
try {
    $stmt = $pdo->query("SELECT COUNT(*) FROM parents");
    $totalParents = $stmt->fetchColumn();

    $stmt = $pdo->query("SELECT COUNT(*) FROM children");
    $totalChildren = $stmt->fetchColumn();

    $stmt = $pdo->query("SELECT COUNT(*) FROM parents WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
    $recentRegistrations = $stmt->fetchColumn();

} catch(PDOException $e) {
    error_log("Dashboard error: " . $e->getMessage());
    $error = "Erreur lors du chargement des statistiques.";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - Administration</title>
    <link rel="stylesheet" href="../../css/admin.css">
    <link href="https://fonts.googleapis.com/css2?family=Comic+Neue:wght@400;700&family=Bubblegum+Sans&display=swap" rel="stylesheet">
</head>
<body>
    <div class="admin-dashboard">
        <header class="admin-header">
            <h1>Tableau de bord administrateur</h1>
            <div class="admin-info">
                <span>Bienvenue, <?php echo htmlspecialchars($_SESSION['admin_name']); ?></span>
                <a href="logout.php" class="btn-logout">Déconnexion</a>
            </div>
        </header>

        <nav class="admin-nav">
            <ul>
                <li><a href="dashboard.php" class="active">Tableau de bord</a></li>
                <li><a href="parents.php">Parents</a></li>
                <li><a href="teachers.php">Enseignants</a></li>
                <li><a href="events.php" >Événements</a></li>
                <li><a href="settings.php">Paramètres</a></li>
            </ul>
        </nav>

        <main class="admin-content">
            <div class="stats-container">
                <div class="stat-card">
                    <h3>Total Parents</h3>
                    <p class="stat-number"><?php echo $totalParents; ?></p>
                </div>
                <div class="stat-card">
                    <h3>Total Enfants</h3>
                    <p class="stat-number"><?php echo $totalChildren; ?></p>
                </div>
                <div class="stat-card">
                    <h3>Nouvelles inscriptions</h3>
                    <p class="stat-number"><?php echo $recentRegistrations; ?></p>
                    <p class="stat-period">(7 derniers jours)</p>
                </div>
            </div>

            <div class="recent-activity">
                <h2>Activité récente</h2>
                <div class="activity-list">
                    <!-- Wwink wink -->
                    <p>Fonctionnalité en cours de développement...bkodrt rabbi 10 snin o5rin </p>
                </div>
            </div>
        </main>
    </div>
</body>
</html> 