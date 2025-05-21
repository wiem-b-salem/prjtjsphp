<?php
// l ymes el page hethy bch ylbs pc , nbki fehaa yhdikom , khadmtha brouh rouhi tal3tttttttttttttttttttttttttttttttt
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../config/database.php';
$pdo = getDBConnection();

try {
    $stmt = $pdo->query("SELECT id, title, description, DATE_FORMAT(event_date, '%Y-%m-%d') as event_date, TIME_FORMAT(event_time, '%H:%i') as event_time, location FROM events ORDER BY event_date, event_time");
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
    error_log("Events loaded from database: " . print_r($events, true));
} catch(PDOException $e) {
    $events = [];
    error_log("Error fetching events: " . $e->getMessage());
}

$eventsJson = json_encode($events, JSON_PRETTY_PRINT);
error_log("Events JSON: " . $eventsJson);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendrier - École Maternelle</title>
    <link rel="stylesheet" href="../css/calendar.css">
    <link href="https://fonts.googleapis.com/css2?family=Comic+Neue:wght@400;700&family=Bubblegum+Sans&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <h1>Calendrier des Événements 📅</h1>
        <p>Restez informés des événements de l'École des Petits Génies! 🌟</p>
    </header>

    <nav>
        <a href="dashboard.php">← Retour à la page d'accueil</a>
    </nav>

    <main>
        <div class="calendar-container">
            <div class="calendar-header">
                <button id="prevMonth">←</button>
                <h2 id="currentMonth">Mois Année</h2>
                <button id="nextMonth">→</button>
            </div>

            <div class="calendar-grid">
                <div class="weekdays">
                    <div>Dim</div>
                    <div>Lun</div>
                    <div>Mar</div>
                    <div>Mer</div>
                    <div>Jeu</div>
                    <div>Ven</div>
                    <div>Sam</div>
                </div>
                <div id="calendarDays" class="days"></div>
            </div>
        </div>

        <div id="eventModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2 id="eventTitle">Titre de l'événement</h2>
                <div id="eventDetails">
                    <p id="eventDate">Date</p>
                    <p id="eventTime">Heure</p>
                    <p id="eventLocation">Lieu</p>
                    <p id="eventDescription">Description</p>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <p>🏫 École des Petits Génies</p>
        <p>🌟 Où chaque enfant est une étoile qui brille</p>
        <p>📞 Contactez-nous : support@petitsgenies.fr</p>
        <p>© 2024 Tous droits réservés idk why 2024 mwa5rin b aam </p>
    </footer>

    <script>
        window.events = <?php echo json_encode($events); ?>;
    </script>
    <script src="../js/calendar.js?v=<?php echo time(); ?>" defer></script>
</body>
</html> 