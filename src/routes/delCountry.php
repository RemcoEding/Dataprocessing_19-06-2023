<?php

$code = $request->getAttribute('code');

$sql = "DELETE FROM country WHERE code = :code";

try {
    // Get DB Object
    $db = new db();
    // Connect
    $db = $db->connect();

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':code', $code);
    $stmt->execute();
    $db = null;

    echo '{"notice": {"text": "Country Deleted"}';

} catch(PDOException $e) {
    echo '{"error": {"text": '.$e->getMessage().'}';
}



?>