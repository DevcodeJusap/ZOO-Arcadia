<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zooarcadiaa_zoo";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) { die("Erreur connexion : " . $conn->connect_error); }

$services = [];
$sql = "SELECT * FROM services";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $row['images'] = [];
    $sql_img = "SELECT image_url, alt_text FROM service_images WHERE service_id = " . intval($row['id']);
    $res_img = $conn->query($sql_img);
    while ($img = $res_img->fetch_assoc()) {
        $row['images'][] = $img;
    }
    $services[] = $row;
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-Content-Type-Options" content="nosniff">
        <meta http-equiv="Strict-Transport-Security" content="max-age=31536000; includeSubDomains">
        <meta name="description" content="Zoo-Arcadia, un parc zoologique en Bretagne, engagé dans le bien-être animal et la conservation de la biodiversité.">
        <meta name="keywords" content="zoo, parc zoologique, Bretagne, bien-être animal, biodiversité">
        <link rel="icon" type="image" href="image/presentation/logo.webp">
        <title>Zoo-Arcadia - services</title>
        <link rel="preload" href="css/service.css" as="style">
        <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" as="style">
        <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" as="style">
        <link rel="stylesheet" href="css/service.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <link rel="preload" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" as="style">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" media="print" onload="this.media='all'">
        <noscript>
            <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
        </noscript>
    </head>
    <body id="service.html">
        <header class="header">
            <a href="service.html" id="logo-link">
                <img src="image/presentation/logo.webp" alt="Logo de Zoo-Arcadia" id="logo" loading="lazy" width="200" height="100">
            </a>
            <nav aria-label="Navigation principale">
                <ul class="centered">
                    <li><button class="btn-headers accueil-btn" id="accueil-btn" onclick="location.href='index.html'" aria-label="Aller à l'accueil">Accueil</button></li> 
                    <li><button class="btn-headers service-btn" id="service-btn" onclick="location.href='service.php'" aria-label="Aller à la page des services">Service</button></li> 
                    <li><button class="btn-headers habitat-btn" id="habitat-btn" onclick="location.href='habitat.php'" aria-label="Aller à la page des habitats">Habitat</button></li> 
                    <li><button class="btn-headers contact-btn" id="contact-btn" onclick="location.href='contact.html'" aria-label="Aller à la page de contact">Contact</button></li> 
                </ul>
                <button class="btn-headers login-btn" id="login-btn" onclick="location.href='login.html'" style="float: right;" aria-label="Aller à la page de connexion">login</button>
            </nav>
        </header>
        <main>
            <section class="services">
                <h1 class="title">Nos services</h1>
                <p class="description">Le Zoo-Arcadia offre une variété de services pour rendre votre visite encore plus agréable :</p>
            </section>
            <section class="service-paragraphes">
                <?php foreach ($services as $service): ?>
                    <div class="service.owl-carousel">
                        <div class="fond-blanc">
                            <h2 class="title"><?php echo htmlspecialchars($service['service_name']); ?></h2>
                            <p class="paragraph"><?php echo htmlspecialchars($service['paragraph']); ?></p>
                            <div class="owl-carousel">
                                <?php foreach ($service['images'] as $img): ?>
                                    <div class="item">
                                        <img src="<?php echo htmlspecialchars($img['image_url']); ?>"
                                            alt="<?php echo htmlspecialchars($img['alt_text']); ?>"
                                            class="service-photo droite" loading="lazy">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="service.plan">
                    <div class="fond-blanc">
                        <h2 class="title">Plan du Zoo TELECHARGABLE</h2>
                        <div class="service plan">
                            <button type="button">
                                <a href="image/services/plan.pdf" download="plan du zoo">Télécharger la carte en PDF</a>
                            </button>
                            <img src="image/services/Capture d'écran 2024-09-04 132806.webp" alt="Plan du Zoo Arcadia" loading="lazy">
                        </div>
                    </div>
                </div>
            </section>
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
                                <li>Email : <a href="mailto:contact@zoo-arcadia.fr" aria-label="Envoyer un email à contact@zoo-arcadia.fr">contact@zoo-arcadia.fr</a></li>
                            </ul>
                        </div>
                    </div>
                    <p class="copyright text-muted">&copy; 2024 Zoo-Arcadia. Tous droits réservés. Créé par <a href="https://codelinky.com" target="_blank" rel="noopener noreferrer" aria-label="Visiter le site de C@deLinky">C@deLinky</a></p>
                </div>
            </footer>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
            <script src="/javascript/services.js"></script>
    </body>
</html>