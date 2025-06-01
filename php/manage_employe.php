<?php
session_start();
include 'session_check.php';
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zooarcadiaa_zoo";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete'])) {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        if ($id) {
            $stmt = $conn->prepare("DELETE FROM employe WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
        } else {
            echo "ID non valide.";
        }
    } elseif (isset($_POST['update'])) {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
        $position = filter_input(INPUT_POST, 'position', FILTER_SANITIZE_SPECIAL_CHARS);
        $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_SPECIAL_CHARS);
        $habitat = filter_input(INPUT_POST, 'habitat', FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);

        if (!empty($_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            // Mets à jour le mot de passe
            $stmt = $conn->prepare("UPDATE employe SET name = ?, username = ?, password = ?, position = ?, role = ?, habitat_name = ?, email = ? WHERE id = ?");
            $stmt->bind_param("sssssssi", $name, $username, $password, $position, $role, $habitat, $email, $id);
        } else {
            // Ne change pas le mot de passe si le champ est vide
            $stmt = $conn->prepare("UPDATE employe SET name = ?, username = ?, position = ?, role = ?, habitat_name = ?, email = ? WHERE id = ?");
            $stmt->bind_param("ssssssi", $name, $username, $position, $role, $habitat, $email, $id);
        }

        $stmt->execute();
        $stmt->close();
    } else {
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
        $password = $_POST['password'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $position = filter_input(INPUT_POST, 'position', FILTER_SANITIZE_SPECIAL_CHARS);
        $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_SPECIAL_CHARS);
        $habitat = filter_input(INPUT_POST, 'habitat', FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);

        if ($name && $username && $hashed_password && $position && $role && $email) {
            $stmt = $conn->prepare("INSERT INTO employe (name, username, password, position, role, habitat_name, email) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $name, $username, $hashed_password, $position, $role, $habitat, $email);
            $stmt->execute();
            $stmt->close();
        } else {
            echo "Veuillez remplir tous les champs.";
        }
    }
}

// Affichage des demandes d'inscription
$requests = $conn->query("SELECT id, name, email, role FROM registration_requests");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - Zoo-Arcadia</title>
    <link rel="stylesheet" href="\css\dashboard.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a href="/php/logout.php" class="btn btn-danger">Déconnexion</a>
            <img src="\image\presentation\logo.webp" alt="Logo" style="height: 100px;">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="admin_dashboard.php">Tableau de bord</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_habitats.php">Gérer les habitats</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_animals.php">Gérer les animaux</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_services.php">Gérer les services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_employe.php">Gérer les utilisateurs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_events.php">Gérer les articles événements</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-4">
        <h1 class="text-center mb-4">Gestion des employés</h1>
        <div class="row">
            <div class="col-12 col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header">Ajouter un employé</div>
                    <div class="card-body">
                        <form method="post" action="">
                            <div class="form-group">
                                <label for="name">Nom</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="username">Nom d'utilisateur</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Mot de passe</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="form-group">
                                <label for="position">Poste</label>
                                <input type="text" class="form-control" id="position" name="position" required>
                            </div>
                            <div class="form-group">
                                <label for="role">Rôle</label>
                                <select class="form-control" id="role" name="role" required>
                                    <option value="admin">Admin</option>
                                    <option value="veterinaire">Vétérinaire</option>
                                    <option value="employe">Employé</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="habitat">Habitat (pour les employés)</label>
                                <select class="form-control" id="habitat" name="habitat">
                                    <option value="">Aucun</option>
                                    <option value="savane">Savane</option>
                                    <option value="jungle">Jungle</option>
                                    <option value="marais">Marais</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <?php
                            if (empty($_SESSION['csrf_token'])) {
                                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
                            }
                            ?>
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                            <button type="submit" class="btn btn-primary">Ajouter</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">Liste des employés</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nom de l'employé</th>
                                        <th>Nom d'utilisateur</th>
                                        <th>Mot de passe</th>
                                        <th>Poste</th>
                                        <th>Rôle</th>
                                        <th>Habitat</th>
                                        <th>Email</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = $conn->query("SELECT id, name, username, password, position, role, habitat_name, email FROM employe");
                                    while ($row = $result->fetch_assoc()):
                                    ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                                        <td>••••••••</td>
                                        <td><?php echo htmlspecialchars($row['position']); ?></td>
                                        <td><?php echo htmlspecialchars($row['role']); ?></td>
                                        <td><?php echo htmlspecialchars($row['habitat_name'] ?? '') !== '' ? htmlspecialchars($row['habitat_name']) : 'Aucun'; ?></td>
                                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                                        <td>
                                            <form method="post" action="" style="display:inline;">
                                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                <button type="submit" name="delete" class="btn btn-danger">Supprimer</button>
                                            </form>
                                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editModal"
                                                data-id="<?php echo $row['id']; ?>"
                                                data-name="<?php echo $row['name']; ?>"
                                                data-username="<?php echo $row['username']; ?>"
                                                data-password="<?php echo $row['password']; ?>"
                                                data-position="<?php echo $row['position']; ?>"
                                                data-role="<?php echo $row['role']; ?>"
                                                data-habitat="<?php echo $row['habitat_name']; ?>"
                                                data-email="<?php echo $row['email']; ?>">
                                                Modifier
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Demandes d'inscription -->
        <div class="card mt-4">
            <div class="card-header">Demandes d'inscription en attente</div>
            <div class="card-body">
                <?php if ($requests->num_rows > 0): ?>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Rôle</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php while ($req = $requests->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($req['name']); ?></td>
                                <td><?php echo htmlspecialchars($req['email']); ?></td>
                                <td><?php echo htmlspecialchars($req['role']); ?></td>
                                <td>
                                    <form method="post" action="approve_registration.php" style="display:inline;">
                                        <input type="hidden" name="request_id" value="<?php echo $req['id']; ?>">
                                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                        <button type="submit" class="btn btn-success btn-sm">Approuver</button>
                                    </form>
                                    <form method="post" action="process_request.php" style="display:inline;">
                                        <input type="hidden" name="action" value="reject">
                                        <input type="hidden" name="id" value="<?php echo $req['id']; ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">Rejeter</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="alert alert-info">Aucune demande d'inscription en attente.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Modifier l'employé</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="">
                        <input type="hidden" id="edit-id" name="id">
                        <div class="form-group">
                            <label for="edit-name">Nom</label>
                            <input type="text" class="form-control" id="edit-name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-username">Nom d'utilisateur</label>
                            <input type="text" class="form-control" id="edit-username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-password">Mot de passe</label>
                            <input type="password" class="form-control" id="edit-password" name="password" placeholder="Nouveau mot de passe">
                        </div>
                        <div class="form-group">
                            <label for="edit-position">Poste</label>
                            <input type="text" class="form-control" id="edit-position" name="position" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-role">Rôle</label>
                            <select class="form-control" id="edit-role" name="role" required>
                                <option value="admin">Admin</option>
                                <option value="veterinaire">Vétérinaire</option>
                                <option value="employe">Employé</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit-habitat">Habitat (pour les employés)</label>
                            <select class="form-control" id="edit-habitat" name="habitat">
                                <option value="">Aucun</option>
                                <option value="savane">Savane</option>
                                <option value="jungle">Jungle</option>
                                <option value="marais">Marais</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit-email">Email</label>
                            <input type="email" class="form-control" id="edit-email" name="email" required>
                        </div>
                        <button type="submit" name="update" class="btn btn-primary">Enregistrer les modifications</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var name = button.data('name');
            var username = button.data('username');
            var password = button.data('password');
            var position = button.data('position');
            var role = button.data('role');
            var habitat = button.data('habitat');
            var email = button.data('email');

            var modal = $(this);
            modal.find('#edit-id').val(id);
            modal.find('#edit-name').val(name);
            modal.find('#edit-username').val(username);
            modal.find('#edit-password').val('');
            modal.find('#edit-position').val(position);
            modal.find('#edit-role').val(role);
            modal.find('#edit-habitat').val(habitat);
            modal.find('#edit-email').val(email);
        });
    </script>
</body>
</html>

