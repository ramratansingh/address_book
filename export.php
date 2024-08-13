<?php
include 'config/database.php';

if (!isset($_GET['format'])) {
    die('Invalid format');
}

$format = $_GET['format'];

// Fetch all entries
$sql = "SELECT e.id, e.name, e.first_name, e.email, e.street, e.zip_code, c.name as city 
        FROM entries e 
        JOIN cities c ON e.city_id = c.id";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$entries = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($format === 'json') {
    // Export as JSON
    header('Content-Type: application/json');
    echo json_encode($entries, JSON_PRETTY_PRINT);
} elseif ($format === 'xml') {
    // Export as XML
    header('Content-Type: text/xml');
    $xml = new SimpleXMLElement('<entries/>');
    
    foreach ($entries as $entry) {
        $entryXML = $xml->addChild('entry');
        $entryXML->addChild('id', $entry['id']);
        $entryXML->addChild('name', htmlspecialchars($entry['name']));
        $entryXML->addChild('first_name', htmlspecialchars($entry['first_name']));
        $entryXML->addChild('email', htmlspecialchars($entry['email']));
        $entryXML->addChild('street', htmlspecialchars($entry['street']));
        $entryXML->addChild('zip_code', htmlspecialchars($entry['zip_code']));
        $entryXML->addChild('city', htmlspecialchars($entry['city']));
    }
    
    echo $xml->asXML();
} else {
    die('Invalid format specified');
}
