<?php

    $sql = "SELECT * FROM city";
  
    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();
        
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $stmtxml = $db->prepare($sql);
        $stmtxml->execute();
        $worlds = $stmt->fetchAll(PDO::FETCH_OBJ);
        $worldsxml = $stmtxml->fetchAll(PDO::FETCH_ASSOC);
        $db = null;
  
        //put data in object
        $data = (object)$worlds;
  
        // Convert data to XML format
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><world></world>');
        foreach ($worldsxml as $world) {
            $node = $xml->addChild('city');
            foreach ($world as $key => $value) {
                $node->addChild($key, $value);
            }
        }
        //$acceptHeader = 'application/xml';
        $acceptHeader = $request->getHeaderLine('Accept');
        if ($acceptHeader == 'application/xml') {
          // Check if XML is valid
          $xmlString = $xml->asXML();
          $xsdString = file_get_contents(__DIR__ . '/schemes/xsdcity.xsd');
  
          $dom = new DOMDocument();
          $dom->loadXML($xmlString);
  
          if ($dom->schemaValidateSource($xsdString)) {
              $response = $response->withHeader('Content-Type', 'application/xml');
              $response->getBody()->write($xmlString);
          } else {
              // Invalid XML
              $response = $response->withStatus(400);
              $response->getBody()->write('Invalid XML');
          }
        } else {
  
          // Load the schema from the file
          $schema = json_decode(file_get_contents(__DIR__ . '/schemes/Json.json'), false);
  
          // Now you can use the $schema variable as before
          $validator = new League\JsonGuard\Validator($data, $schema);
  
          if ($validator->passes()){            
            $response = $response->withHeader('Content-Type', 'application/json');
            $response->getBody()->write(json_encode($worlds));     
          }
          else { 
            echo json_encode($validator->errors());
        } 
        }
        return $response;
  
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }

  ?>