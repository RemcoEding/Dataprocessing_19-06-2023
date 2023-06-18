<?php

    //json validator and scheme
$data = (object) $request->getParams();
$schema = json_decode(file_get_contents(__DIR__ . '/schemes/Json.json'), false);
$validator = new League\JsonGuard\Validator($data, $schema);

if ($validator->passes()) {
    $ID = $request->getAttribute('ID');
    $CountryCode = $request->getParam('CountryCode');
    $Language = $request->getParam('Language');
    $IsOfficial = $request->getParam('IsOfficial');
    $Percentage = $request->getParam('Percentage');

    $sql = "UPDATE countrylanguage SET
                CountryCode = :CountryCode,
                Language = :Language,
                IsOfficial = :IsOfficial,
                Percentage = :Percentage
            WHERE ID = :ID";

    try {
        //get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':CountryCode', $CountryCode);
        $stmt->bindParam(':Language', $Language);
        $stmt->bindParam(':IsOfficial', $IsOfficial);
        $stmt->bindParam(':Percentage', $Percentage);
        $stmt->bindParam(':ID', $ID);

        $stmt->execute();

        echo '{"notice": {"text": "Countrylanguage Updated"}';

    } catch (PDOException $e) {
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
} else {
    echo json_encode($validator->errors());
}


  ?>