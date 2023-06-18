<?php
 
    //json validator and scheme
    $data = (object)$request->getParams();
    $schema = json_decode(file_get_contents(__DIR__ . '/schemes/Json.json'), false);
    $validator = new League\JsonGuard\Validator($data, $schema);
  
    if ($validator->passes()){
  
      $ID = $request->getParam('ID');
      $Name = $request->getParam('Name');
      $CountryCode = $request->getParam('CountryCode');
      $District = $request->getParam('District');
      $Population = $request->getParam('Population');
  
      
      $sql = "INSERT INTO city (ID,Name,CountryCode,District,Population) VALUES
      (:ID,:Name,:CountryCode,:District,:Population)";
  
      try{
          //get DB Object
          $db = new db();
          // Connect
          $db = $db->connect();
  
          $stmt = $db->prepare($sql);
  
          $stmt->bindParam('ID', $ID);
          $stmt->bindParam('Name', $Name);
          $stmt->bindParam('CountryCode', $CountryCode);
          $stmt->bindParam('District', $District);
          $stmt->bindParam('Population', $Population);
  
          $stmt->execute();
  
          echo '{"notice": {"text": "City Added"}';
  
      } catch(PDOException $e){
          echo '{"error": {"text": '.$e->getMessage().'}';
      }
    }
    else { 
        echo json_encode($validator->errors());
       
    }

  ?>