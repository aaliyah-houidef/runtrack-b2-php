<?php
function insert_student($email, $fullname, $gender, $birthdate, $grade_id) {
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=lp_official', 'root', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = 'INSERT INTO student (email, fullname, gender, birthdate, grade_id) 
                  VALUES (:email, :fullname, :gender, :birthdate, :grade_id)';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':fullname', $fullname);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':birthdate', $birthdate);
        $stmt->bindParam(':grade_id', $grade_id);
        
        $stmt->execute();

        return "L'étudiant a été inséré avec succès.";
    } catch (PDOException $e) {
        return 'Erreur : ' . $e->getMessage();
    }
}

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['input-email'] ?? '';
    $fullname = $_POST['input-fullname'] ?? '';
    $gender = $_POST['input-gender'] ?? '';
    $birthdate = $_POST['input-birthdate'] ?? '';
    $grade_id = $_POST['input-grade_id'] ?? '';

    $message = insert_student($email, $fullname, $gender, $birthdate, $grade_id);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un étudiant</title>
    <style>
        form {
            width: 300px;
            margin: 0 auto;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }
        button {
            margin-top: 15px;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <h1>Ajout d'un nouvel étudiant</h1>

    <form method="post" action="">
        <label for="input-email">Email :</label>
        <input type="email" id="input-email" name="input-email" required>

        <label for="input-fullname">Nom et prénom :</label>
        <input type="text" id="input-fullname" name="input-fullname" required>

        <label for="input-gender">Genre :</label>
        <select id="input-gender" name="input-gender" required>
            <option value="male">Homme</option>
            <option value="female">Femme</option>
        </select>

        <label for="input-birthdate">Date de naissance :</label>
        <input type="date" id="input-birthdate" name="input-birthdate" required>

        <label for="input-grade_id">ID du grade :</label>
        <input type="number" id="input-grade_id" name="input-grade_id" required>

        <button type="submit">Ajouter l'étudiant</button>
    </form>

    <?php if ($message): ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

</body>
</html>
