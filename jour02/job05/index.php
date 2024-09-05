<?php
function find_full_rooms() {
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=lp_official', 'root', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = '
            SELECT room.name AS room_name, room.capacity, 
                   COUNT(student.id) AS student_count, 
                   CASE WHEN COUNT(student.id) >= room.capacity THEN "Oui" ELSE "Non" END AS is_full
            FROM room
            LEFT JOIN grade ON room.id = grade.room_id
            LEFT JOIN student ON grade.id = student.grade_id
            GROUP BY room.id';
        $stmt = $pdo->prepare($query);
        $stmt->execute();

        $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $rooms;
    } catch (PDOException $e) {
        echo 'Erreur : ' . $e->getMessage();
        return [];
    }
}

$rooms = find_full_rooms();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des salles</title>
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

    <h1>Liste des salles et leur statut de remplissage</h1>

    <table>
        <thead>
            <tr>
                <th>Nom de la salle</th>
                <th>Capacité</th>
                <th>Nombre d'étudiants</th>
                <th>Est-elle pleine ?</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($rooms) > 0): ?>
                <?php foreach ($rooms as $room): ?>
                    <tr>
                        <td><?= htmlspecialchars($room['room_name']) ?></td>
                        <td><?= htmlspecialchars($room['capacity']) ?></td>
                        <td><?= htmlspecialchars($room['student_count']) ?></td>
                        <td><?= htmlspecialchars($room['is_full']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">Aucune salle trouvée.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>
