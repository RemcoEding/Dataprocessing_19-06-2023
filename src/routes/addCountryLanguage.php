<?php
        
    //json validator and scheme
    $data = (object)$request->getParams();
    $schema = json_decode(file_get_contents(__DIR__ . '/schemes/Json.json'), false);
    $validator = new League\JsonGuard\Validator($data, $schema);
  
    if ($validator->passes()){
      
      $CountryCode = $request->getParam('CountryCode');
      $Language = $request->getParam('Language');
      $IsOfficial = $request->getParam('IsOfficial');
      $Percentage = $request->getParam('Percentage');
  
      
      $sql = "INSERT INTO countrylanguage (CountryCode,Language,IsOfficial,Percentage) VALUES
      (:CountryCode,:Language,:IsOfficial,:Percentage)";
  
      try{
          //get DB Object
          $db = new db();
          // Connect
          $db = $db->connect();
  
          $stmt = $db->prepare($sql);
  
          $stmt->bindParam('CountryCode', $CountryCode);
          $stmt->bindParam('Language', $Language);
          $stmt->bindParam('IsOfficial', $IsOfficial);
          $stmt->bindParam('Percentage', $Percentage);
  
          $stmt->execute();
  
          echo '{"notice": {"text": "Countrylanguage Added"}';
  
      } catch(PDOException $e){
          echo '{"error": {"text": '.$e->getMessage().'}';
      }
    }
    else { 
        echo json_encode($validator->errors());
       
    }
  ?>