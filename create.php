<?php
include 'config/database.php';
include 'templates/header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $first_name = $_POST['first_name'];
    $email = $_POST['email'];
    $street = $_POST['street'];
    $zip_code = $_POST['zip_code'];
    $city_id = $_POST['city_id'];

    $sql = "INSERT INTO entries (name, first_name, email, street, zip_code, city_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name, $first_name, $email, $street, $zip_code, $city_id]);

    header("Location: index.php");
    exit;
}

// Fetch cities
$sql = "SELECT id, name FROM cities";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$cities = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Create New Entry</h2>
<form method="post">
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="mb-3">
        <label for="first_name" class="form-label">First Name</label>
        <input type="text" class="form-control" id="first_name" name="first_name" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="mb-3">
        <label for="street" class="form-label">Street</label>
        <input type="text" class="form-control" id="street" name="street" required>
    </div>
    <div class="mb-3">
        <label for="zip_code" class="form-label">Zip Code</label>
        <input type="text" class="form-control" id="zip_code" name="zip_code" required>
    </div>
    <div class="mb-3">
        <label for="city_id" class="form-label">City</label>
        <select class="form-control" id="city_id" name="city_id" required>
            <?php foreach ($cities as $city): ?>
                <option value="<?= $city['id'] ?>"><?= htmlspecialchars($city['name']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Create</button>
    <a href="index.php" class="btn btn-secondary">Cancel</a>
</form>

<?php include 'templates/footer.php'; ?>
