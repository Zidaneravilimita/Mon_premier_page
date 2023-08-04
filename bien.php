<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projet";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

// Vérification du formulaire "Sign In"
if (isset($_POST['signin'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Vérification de l'utilisateur dans la base de données
    $sql = "SELECT * FROM 'index' WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Utilisateur authentifié, rediriger vers la page index.html
        header("Location: index.html");
        exit();
    } else {
        // Les informations de connexion sont incorrectes, afficher un message d'erreur
        echo "Email ou mot de passe incorrect";
    }
}


// Vérification du formulaire "Sign Up"
if (isset($_POST['signup'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Vérification si l'utilisateur existe déjà dans la base de données
    $sql = "SELECT * FROM 'index' WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // L'utilisateur existe déjà, afficher un message d'erreur
        echo "Cet utilisateur existe déjà";
    } else {
        // Insérer le nouvel utilisateur dans la base de données
        $sql = "INSERT INTO 'index' (username, email, password) VALUES ('$username', '$email', '$password')";
        if ($conn->query($sql) === TRUE) {
            // L'inscription est réussie, rediriger vers la page index.html
            header("Location: index.html");
            exit();

        } else {
            // Une erreur s'est produite lors de l'inscription, afficher un message d'erreur
            echo "Erreur lors de l'inscription : " . $conn->error;
        }
    }
}

// Vérification des données
if (empty($username) || empty($email) || empty($password)) {
    // Afficher un message d'erreur si des champs sont vides
    echo "Veuillez remplir tous les champs.";
} else {
    // Les champs sont remplis, vous pouvez effectuer des actions supplémentaires ici
    // Par exemple, vous pouvez vérifier si l'e-mail est au bon format, si le mot de passe est suffisamment fort, etc.

    // Exemple de vérification de l'e-mail avec filter_var()
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "L'adresse e-mail n'est pas valide.";
    } else {
        // L'e-mail est valide, vous pouvez continuer avec le traitement des données

        // Exemple de vérification de la force du mot de passe
        if (strlen($password) < 8) {
            echo "Le mot de passe doit contenir au moins 8 caractères.";
        } else {
            // Le mot de passe est suffisamment fort, vous pouvez enregistrer les données dans la base de données, par exemple
            // ...
        }
    }
}

// Fermeture de la connexion à la base de données
$conn->close();
?>
