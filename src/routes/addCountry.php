<?php

    //json validator and scheme
    $data = (object)$request->getParams();
    $schema = json_decode(file_get_contents(__DIR__ . '/schemes/Json.json'), false);
    $validator = new League\JsonGuard\Validator($data, $schema);

    if ($validator->passes()){
    $Code = $request->getParam('Code');
    $Name = $request->getParam('Name');
    $Continent = $request->getParam('Continent');
    $Region = $request->getParam('Region');
    $SurfaceArea = $request->getParam('SurfaceArea');
    $IndepYear = $request->getParam('IndepYear');
    $Population = $request->getParam('Population');
    $LifeExpectancy = $request->getParam('LifeExpectancy');
    $GNP = $request->getParam('GNP');
    $GNPOld = $request->getParam('GNPOld');
    $LocalName = $request->getParam('LocalName');
    $GovernmentForm = $request->getParam('GovernmentForm');
    $HeadOfState = $request->getParam('HeadOfState');
    $Capital = $request->getParam('Capital');
    $Code2 = $request->getParam('Code2');

    
    $sql = "INSERT INTO country (Code,Name,Continent,Region,SurfaceArea,IndepYear,Population,LifeExpectancy,GNP,GNPOld,LocalName,GovernmentForm,HeadOfState,Capital,Code2) VALUES
    (:Code,:Name,:Continent,:Region,:SurfaceArea,:IndepYear,:Population,:LifeExpectancy,:GNP,:GNPOld,:LocalName,:GovernmentForm,:HeadOfState,:Capital,:Code2)";

    try{
        //get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam('Code', $Code);
        $stmt->bindParam('Name', $Name);
        $stmt->bindParam('Continent', $Continent);
        $stmt->bindParam('Region', $Region);
        $stmt->bindParam('SurfaceArea', $SurfaceArea);
        $stmt->bindParam('IndepYear', $IndepYear);
        $stmt->bindParam('Population', $Population);
        $stmt->bindParam('LifeExpectancy', $LifeExpectancy);
        $stmt->bindParam('GNP', $GNP);
        $stmt->bindParam('GNPOld', $GNPOld);
        $stmt->bindParam('LocalName', $LocalName);
        $stmt->bindParam('GovernmentForm', $GovernmentForm);
        $stmt->bindParam('HeadOfState', $HeadOfState);
        $stmt->bindParam('Capital', $Capital);
        $stmt->bindParam('Code2', $Code2);

        $stmt->execute();

        echo '{"notice": {"text": "Country Added"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
}
 else { 
     echo json_encode($validator->errors());
    
 }
 
?>