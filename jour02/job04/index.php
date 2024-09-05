<?php
function find_all_students_grades() {
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=lp_official', 'root', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = '
            SELECT student.email, student.fullname, grade.name AS grade_name 
            FROM student 
            JOIN grade ON student.grade_id = grade.id';
        $stmt = $pdo->prepare($query);
        $stmt->execute();

        $students_grades = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $students_grades;
    } catch (PDOException $e) {
        echo 'Erreur : ' . $e->getMessage();
        return [];
    }
}

$students_grades = find_all_students_grades();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des étudiants et promotions</title>
    <style>
        table {
            width: 100%;
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

    <h1>Liste des étudiants et leurs promotions</h1>

    <table>
        <thead>
            <tr>
                <th>Email</th>
                <th>Nom et prénom</th>
                <th>Nom de la promotion</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($students_grades) > 0): ?>
                <?php foreach ($students_grades as $student): ?>
                    <tr>
                        <td><?= htmlspecialchars($student['email']) ?></td>
                        <td><?= htmlspecialchars($student['fullname']) ?></td>
                        <td><?= htmlspecialchars($student['grade_name']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">Aucune donnée trouvée.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>
