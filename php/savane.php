<?php
$conn = new mysqli("localhost", "root", "", "zooarcadiaa_zoo");
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM animals WHERE habitat_name='Savane'");
if (!$result) {
    die("Erreur lors de l'exécution de la requête : " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta http-equiv="Strict-Transport-Security" content="max-age=31536000; includeSubDomains">
    <link rel="icon" type="" href="\image\presentation\logo.png">
    <title>Savane</title>
    <link rel="stylesheet" href="/css/savane-marais-jungle.css"/>
    <link rel="stylesheet" href="/css/likes.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>
<body id="savane.php">
    <header>
        <a href="#" id="logo-link">
            <img src="/image/presentation/logo.webp" alt="Logo Zoo-Arcadia" id="logo">
        </a>
        <nav>
            <ul class="centered">
                <li><button class="btn-headers accueil-btn" id="accueil-btn" onclick="location.href='/index.html'">Accueil</button><div class="box"></div></li> 
                <li><button class="btn-headers service-btn" id="service-btn" onclick="location.href='/service.html'">Service</button></li> <span></span>
                <li><button class="btn-headers habitat-btn" id="habitat-btn" onclick="location.href='/habitat.html'">Habitat</button></li> <span></span>
                <li><button class="btn-headers contact-btn" id="contact-btn" onclick="location.href='/contact.html'">Contact</button></li> <span></span>
            </ul>
            <button class="btn-headers login-btn" id="login-btn" onclick="location.href='/login.html'" style="float: right;">login</button> <span></span>
        </nav>
    </header>

    <main>
        <h1>La savane</h1>
        <p class="bienvenue">Bienvenue dans la savane d'Afrique, un écosystème riche et varié où les animaux sauvages règnent en maîtres.</p> <br>
        <section class="savane">
            <div class="cartes-conteneur">
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="card">
                            <div class="front">
                                <?php
                                $imagePath = "" . htmlspecialchars($row['image_url']);
                                ?>
                                <img src="<?php echo $imagePath; ?>" alt="Savane">
                            </div>
                            <div class="back">
                            <h4 class="animal-info" id="animal_name_<?php echo $row['id']; ?>"> <span class="value"><?php echo htmlspecialchars($row['animal_name']); ?></span></h4><br>                               
                                <p id="species_<?php echo $row['id']; ?>"><strong>Espèce :</strong> <span class="value"><?php echo htmlspecialchars($row['species']); ?></span></p>
                                <p id="age_<?php echo $row['id']; ?>"><strong>Âge :</strong> <span class="value"><?php echo htmlspecialchars($row['age']); ?></span></p>
                                <p id="weight_<?php echo $row['id']; ?>"><strong>Poids (en Kg) :</strong> <span class="value"><?php echo htmlspecialchars($row['weight']); ?></span></p>
                                <p id="food_<?php echo $row['id']; ?>"><strong>Nourriture :</strong> <span class="value"><?php echo htmlspecialchars($row['food']); ?></span></p>
                                <p id="last_meal_<?php echo $row['id']; ?>"><strong>Dernier repas :</strong> <span class="value"><?php echo htmlspecialchars($row['last_meal']); ?></span></p>
                                <p id="food_quantity_<?php echo $row['id']; ?>"><strong>Quantité de nourriture :</strong> <span class="value"><?php echo htmlspecialchars($row['food_quantity']); ?></span></p>
                                <div class="likes-container"><br>
                                    <button type="button" class="heart-btn" id="heart-<?php echo $row['id']; ?>" onclick="likeAnimal(<?php echo $row['id']; ?>)" title="Like Animal <?php echo $row['id']; ?>"><i class="fas fa-heart"></i></button>
                                    <span id="likes-<?php echo $row['id']; ?>" class="likes-counter" data-animal-id="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['likes']); ?></span> likes
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>Aucun animal trouvé dans la savane.</p>
                <?php endif; ?>
            </div>
        </section>

        <div style="text-align: center; margin-top: 20px;">
            <a href="/habitat.html" class="btn retoure">Retour</a>
        </div>

    </main>
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-12">
                <h3 class="text-uppercase">À propos de nous</h3>
                    <p class="text-muted">Zoo-Arcadia est un parc zoologique situé en Bretagne, près de la forêt de Brocéliande. Nous sommes dédiés à la conservation de la biodiversité et au bien-être animal.</p>
                <br><h3 class="text-uppercase">Horaires d'ouverture</h3>
                <p class="text-muted">Du Mardi au  Dimanche de 9h à 18h30</p>
                <p class="text-muted">Ainsi que les jours fériers</p>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <h3 class="text-uppercase">Liens utiles</h3>
                    <ul class="list-unstyled">
                        <li><a href="service.html">Nos services</a></li>
                        <li><a href="habitat.html">Nos habitats</a></li>
                        <li><a href="contact.html">Nous contacter</a></li>
                    </ul>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <h3 class="text-uppercase">Nos coordonnées</h3>
                    <ul class="list-unstyled">
                        <li>Adresse : Zoo-Arcadia, Route de Brocéliande, 35300 Rennes, France</li>
                        <li>Téléphone : 02 99 99 99 99</li>
                        <li>Email : contact@zoo-arcadia.fr</li>
                    </ul>
                </div>
            </div>
            <p class="copyright text-muted">&copy; 2024 Zoo-Arcadia. Tous droits réservés. Créé par <a href="https://codelinky.com">C@deLinky</a></p>
        </div>
    </footer>

    <script>
        function likeAnimal(animalId) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "update_likes.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        const likesCounter = document.getElementById("likes-" + animalId);
                        likesCounter.textContent = response.new_likes;
                    } else {
                        console.error("Erreur lors de la mise à jour des likes");
                    }
                }
            };
            xhr.send("animal_id=" + animalId);
        }
    </script>
</body>
</html>
