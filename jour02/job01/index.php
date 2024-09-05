<?php
function find_all_students() : array {
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=lp_official', 'root', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = 'SELECT * FROM student';
        $stmt = $pdo->prepare($query);
        $stmt->execute();

        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $students;
    } catch (PDOExecption $e) {
        echo 'Erreur : ' . $e->getMessage();
        return [];
    }
}

$students = find_all_students();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des étudiants</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
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

    <h1>Liste des étudiants</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom et prénom</th>
                <th>Email</th>
                <th>Date de naissance</th>
                <th>Genre</th>

            </tr>
        </thead>
        <tbody>
            <?php if (count($students) > 0): ?>
                <?php foreach ($students as $student): ?>
                    <tr>
                        <td><?= htmlspecialchars($student['id']) ?></td>
                        <td><?= htmlspecialchars($student['fullname']) ?></td>
                        <td><?= htmlspecialchars($student['email']) ?></td>
                        <td><?= htmlspecialchars($student['birthdate']) ?></td>
                        <td><?= htmlspecialchars($student['gender']) ?></td>

                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">Aucun étudiant trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>