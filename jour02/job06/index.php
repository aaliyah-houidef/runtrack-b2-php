<?php
function find_ordered_students() {
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=lp_official', 'root', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = '
        SELECT g.name AS grade_name, 
            s.id AS student_id, s.email, s.fullname, s.birthdate, s.gender,
            grade_counts.student_count
        FROM grade g
        LEFT JOIN student s ON g.id = s.grade_id
        LEFT JOIN (
            SELECT grade_id, COUNT(*) AS student_count
            FROM student
            GROUP BY grade_id
        ) AS grade_counts ON g.id = grade_counts.grade_id
        ORDER BY grade_counts.student_count DESC;
        ';
        
        $stmt = $pdo->prepare($query);
        $stmt->execute();

        $ordered_students = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $ordered_students;

    } catch (PDOException $e) {
        echo 'Erreur : ' . $e->getMessage();
        return [];
    }
}

$ordered_students = find_ordered_students();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Étudiants triés par promotions</title>
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

<h1>Liste des étudiants par promotion</h1>

<table>
    <thead>
        <tr>
            <th>Nom de la promotion</th>
            <th>ID étudiant</th>
            <th>Email</th>
            <th>Nom et prénom</th>
            <th>Date de naissance</th>
            <th>Genre</th>
            <th>Nombre d'étudiants dans la promotion</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($ordered_students) > 0): ?>
            <?php foreach ($ordered_students as $student): ?>
                <tr>
                    <td><?= htmlspecialchars($student['grade_name']) ?></td>
                    <td><?= htmlspecialchars($student['student_id']) ?></td>
                    <td><?= htmlspecialchars($student['email']) ?></td>
                    <td><?= htmlspecialchars($student['fullname']) ?></td>
                    <td><?= htmlspecialchars($student['birthdate']) ?></td>
                    <td><?= htmlspecialchars($student['gender']) ?></td>
                    <td><?= htmlspecialchars($student['student_count']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">Aucun étudiant trouvé.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>
