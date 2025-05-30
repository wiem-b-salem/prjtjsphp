<?php
session_start();

//ttl3ch mkch connected ?
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


$isPending = isset($_SESSION['account_status']) && $_SESSION['account_status'] === 'pending';
$daysRemaining = isset($_SESSION['days_remaining']) ? $_SESSION['days_remaining'] : 0;

require_once '../config/database.php';
$pdo = getDBConnection();

// bch njbdlk dousietek
$stmt = $pdo->prepare("SELECT * FROM parents WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$parent = $stmt->fetch(PDO::FETCH_ASSOC);

// dousiet weldek
$stmt = $pdo->prepare("SELECT * FROM children WHERE parent_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$children = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord - École Maternelle</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Comic+Neue:wght@400;700&family=Bubblegum+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<!--c vrai famma fichier cssamma b5lt bch naaml copier coller w tbh ykhdm nkhaf nmessou -->
    <style>
        .warning-message {
            background-color: #fff3cd;
            color: #856404;
            border: 2px solid #ffeeba;
            padding: 20px;
            margin: 20px auto;
            max-width: 800px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            animation: fadeIn 0.5s ease-in;
        }
        
        .warning-message h2 {
            color: #856404;
            margin-bottom: 15px;
        }
        
        .warning-message p {
            margin-bottom: 10px;
            line-height: 1.5;
        }
        
        .countdown {
            font-size: 1.2em;
            font-weight: bold;
            color: #dc3545;
            margin: 15px 0;
        }
        
        .required-docs {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 4px;
            margin: 15px 0;
            text-align: left;
        }
        
        .required-docs ul {
            list-style-type: none;
            padding: 0;
            margin: 10px 0;
        }
        
        .required-docs li {
            margin: 8px 0;
            padding-left: 25px;
            position: relative;
        }
        
        .required-docs li:before {
            content: "📄";
            position: absolute;
            left: 0;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <header>
            <h1>Bienvenue, <?php echo htmlspecialchars($_SESSION['user_name']); ?>! 🌟</h1>
            <nav>
                <a href="logout.php" class="logout-btn">Déconnexion</a>
                <a href="schedule.html">Emploi du Temps</a>
                <a href="calendar.php">Calendrier</a>
                <a href="contact.html">Contact</a>
            </nav>
        </header>

        <?php if ($isPending): ?>
            <!-- WARNINGGGGG HEZZ AWRA9EKKKKKKKK-->
            <div class="warning-message">
                <h2>⚠️ Attention: Compte en attente d'approbation</h2>
                <p>Votre compte est actuellement en attente d'approbation. Pour finaliser votre inscription, veuillez fournir les documents suivants à l'administration :</p>
                
                <div class="required-docs">
                    <ul>
        <!--ken mechi lidara tounseya hawina kol nhar warka , hetha kn najmet -->
                        <li>Copie de la carte d'identité du parent</li>
                        <li>Copie du livret de famille</li>
                        <li>Certificat de naissance de l'enfant</li>
                        <li>Carnet de santé de l'enfant (pages de vaccination)</li>
                        <li>Justificatif de domicile</li>
                    </ul>
                </div>
                
                <p>Veuillez fournir ces documents dès que possible. Votre compte sera supprimé dans :</p>
                <div class="countdown">
                    <?php echo $daysRemaining; ?> jour<?php echo $daysRemaining > 1 ? 's' : ''; ?>
                </div>
                
                <p>Pour toute question, veuillez contacter l'administration au :<br>
                📞 matklmounech ❤️ <br>
                📧 administration@petitsgenies.fr f sure may5dmch t domaine fr ❤️</p>
            </div>
        <?php endif; ?>

        <main>
            <div class="dashboard-grid">
                <!-- info -->
                <section class="dashboard-card">
                    <h2>👶 Informations des enfants</h2>
                    <?php foreach ($children as $child): ?>
                        <div class="child-info">
                            <h3>esm weldek:<?php echo htmlspecialchars($child['first_name']); ?></h3>
                            <p>omrou: <?php echo htmlspecialchars($child['age']); ?> ans</p>
                            <p>Niveau: <?php echo htmlspecialchars($child['level']); ?></p>
                            <?php if ($child['allergies']): ?>
                                <p class="health-info">⚠️ Allergies: <?php echo htmlspecialchars($child['allergies_details']); ?></p>
                            <?php endif; ?>
                            <?php if ($child['disability']): ?>
                                <p class="health-info">⭐ Besoins particuliers: <?php echo htmlspecialchars($child['disability_details']); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </section>

                <section class="dashboard-card">
                    <h2>📞 Informations de contact</h2>
                    <p>Email: <?php echo htmlspecialchars($parent['email']); ?></p>
                    <p>Téléphone: <?php echo htmlspecialchars($parent['phone']); ?></p>
                    <?php if ($parent['phone_secondary']): ?>
                        <p>Téléphone secondaire: <?php echo htmlspecialchars($parent['phone_secondary']); ?></p>
                    <?php endif; ?>
                </section>


            </div>
        </main>
    </div>

    <script>
        //nrmlm kn sad9ni rabbi bch y5dm w yaaml countdown taa layamet , ken 5dem , aamlneh lbereh jsp 
        <?php if ($isPending): ?>
        function updateCountdown() {
            const countdownElement = document.querySelector('.countdown');
            let days = <?php echo $daysRemaining; ?>;
            
            const timer = setInterval(() => {
                days--;
                if (days <= 0) {
                    clearInterval(timer);
                    window.location.href = 'logout.php';
                } else {
                    countdownElement.textContent = days + ' jour' + (days > 1 ? 's' : '');
                }
            }, 86400000); //ahwa el boss taa el update jk idk
        }
        
        updateCountdown();
        <?php endif; ?>
    </script>
</body>
</html> 