<?php

$ID = $request->getAttribute('ID');

$sql = "DELETE FROM city WHERE ID = :ID";

try {
    // Get DB Object
    $db = new db();
    // Connect
    $db = $db->connect();

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':ID', $ID);
    $stmt->execute();
    $db = null;

    echo '{"notice": {"text": "City Deleted"}';

} catch(PDOException $e) {
    echo '{"error": {"text": '.$e->getMessage().'}';
}


?>