<?php
include 'config/database.php';
include 'templates/header.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die('Invalid ID');
}

// Fetch entry to be edited
$sql = "SELECT * FROM entries WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$entry = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$entry) {
    die('Entry not found');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input data
    $name = htmlspecialchars($_POST['name']);
    $first_name = htmlspecialchars($_POST['first_name']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $street = htmlspecialchars($_POST['street']);
    $zip_code = htmlspecialchars($_POST['zip_code']);
    $city_id = intval($_POST['city_id']);

    if ($name && $first_name && $email && $street && $zip_code && $city_id) {
        // Update the entry in the database
        $sql = "UPDATE entries SET name = ?, first_name = ?, email = ?, street = ?, zip_code = ?, city_id = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $first_name, $email, $street, $zip_code, $city_id, $id]);

        header("Location: index.php");
        exit;
    } else {
        echo "<p class='text-danger'>Please fill in all fields correctly.</p>";
    }
}

// Fetch cities for the dropdown
$sql = "SELECT id, name FROM cities";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$cities = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Edit Entry</h2>
<form method="post">
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($entry['name']) ?>" required>
    </div>
    <div class="mb-3">
        <label for="first_name" class="form-label">First Name</label>
        <input type="text" class="form-control" id="first_name" name="first_name" value="<?= htmlspecialchars($entry['first_name']) ?>" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($entry['email']) ?>" required>
    </div>
    <div class="mb-3">
        <label for="street" class="form-label">Street</label>
        <input type="text" class="form-control" id="street" name="street" value="<?= htmlspecialchars($entry['street']) ?>" required>
    </div>
    <div class="mb-3">
        <label for="zip_code" class="form-label">Zip Code</label>
        <input type="text" class="form-control" id="zip_code" name="zip_code" value="<?= htmlspecialchars($entry['zip_code']) ?>" required>
    </div>
    <div class="mb-3">
        <label for="city_id" class="form-label">City</label>
        <select class="form-control" id="city_id" name="city_id" required>
            <?php foreach ($cities as $city): ?>
                <option value="<?= $city['id'] ?>" <?= $entry['city_id'] == $city['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($city['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="index.php" class="btn btn-secondary">Cancel</a>
</form>

<?php include 'templates/footer.php'; ?>
