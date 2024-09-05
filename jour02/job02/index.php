<?php
function find_one_student($email) {
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=lp_official', 'root', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = 'SELECT * FROM student WHERE email = :email';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $student = $stmt->fetch(PDO::FETCH_ASSOC);

        return $student ? $student : null;
    } catch (PDOException $e) {
        echo 'Erreur : ' . $e->getMessage();
        return null;
    }
}

$student = null;

if (isset($_GET['input-email-student'])) {
    $email = $_GET['input-email-student'];
    $student = find_one_student($email);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche étudiant</title>
    <style>
        table {
            width: 50%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>

    <h1>Recherche d'un étudiant par email</h1>

    <form method="get" action="">
        <label for="input-email-student">Email de l'étudiant :</label>
        <input type="text" id="input-email-student" name="input-email-student" required>
        <button type="submit">Rechercher</button>
    </form>

    <?php if ($student): ?>
        <h2>Informations de l'étudiant :</h2>
        <table>
            <tr>
                <th>ID</th>
                <td><?= htmlspecialchars($student['id']) ?></td>
            </tr>
            <tr>
                <th>Nom et prénom</th>
                <td><?= htmlspecialchars($student['fullname']) ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?= htmlspecialchars($student['email']) ?></td>
            </tr>
            <tr>
                <th>Date de naissance</th>
                <td><?= htmlspecialchars($student['birthdate']) ?></td>
            </tr>
            <tr>
                <th>Genre</th>
                <td><?= htmlspecialchars($student['gender']) ?></td>
            </tr>
        </table>
    <?php elseif (isset($_GET['input-email-student'])): ?>
        <p>Aucun étudiant trouvé pour l'email : <?= htmlspecialchars($email) ?></p>
    <?php endif; ?>

</body>
</html>
