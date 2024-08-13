<?php
include 'config/database.php';
include 'templates/header.php';

// Fetch all entries
$sql = "SELECT e.id, e.name, e.first_name, e.email, e.street, e.zip_code, c.name as city 
        FROM entries e 
        JOIN cities c ON e.city_id = c.id";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$entries = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<a href="create.php" class="btn btn-primary mb-3">Add New Entry</a>
<a href="export.php?format=json" class="btn btn-secondary mb-3">Export JSON</a>
<a href="export.php?format=xml" class="btn btn-secondary mb-3">Export XML</a>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Name</th>
            <th>First Name</th>
            <th>Email</th>
            <th>Street</th>
            <th>Zip Code</th>
            <th>City</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($entries as $entry): ?>
            <tr>
                <td><?= htmlspecialchars($entry['name']) ?></td>
                <td><?= htmlspecialchars($entry['first_name']) ?></td>
                <td><?= htmlspecialchars($entry['email']) ?></td>
                <td><?= htmlspecialchars($entry['street']) ?></td>
                <td><?= htmlspecialchars($entry['zip_code']) ?></td>
                <td><?= htmlspecialchars($entry['city']) ?></td>
                <td>
                    <a href="edit.php?id=<?= $entry['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete.php?id=<?= $entry['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include 'templates/footer.php'; ?>
