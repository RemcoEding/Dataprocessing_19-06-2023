<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Spatie\ArrayToXml\ArrayToXml;

require __DIR__ . '/../vendor/autoload.php';
require '../src/config/db.php';

$app = new \Slim\App;

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});

// Get all values - functions
$app->get('/api/country' , function(Request $request, Response $response){
    require '../src/routes/allCountry.php';
    return $response;
});

$app->get('/api/city' , function(Request $request, Response $response){
    require '../src/routes/allCity.php';
    return $response;
});

$app->get('/api/countrylanguage' , function(Request $request, Response $response){
    require '../src/routes/allCountryLanguage.php';
    return $response;
});

// Get single value - functions
$app->get('/api/country/{code}' , function(Request $request, Response $response){
    require '../src/routes/oneCountry.php';
    return $response;
});

$app->get('/api/city/{ID}' , function(Request $request, Response $response){
    require '../src/routes/oneCity.php';
    return $response;
});

$app->get('/api/countrylanguage/{ID}' , function(Request $request, Response $response){
    require '../src/routes/oneCountryLanguage.php';
    return $response;
});

// Put update value - functions
$app->put('/api/country/{Code1}' , function(Request $request, Response $response){
    require '../src/routes/updCountry.php';
    return $response;
});

$app->put('/api/city/{ID}' , function(Request $request, Response $response){
    require '../src/routes/updCity.php';
    return $response;
});

$app->put('/api/countrylanguage/{ID}' , function(Request $request, Response $response){
    require '../src/routes/updCountryLanguage.php';
    return $response;
});

// Post add value - functions
$app->post('/api/country' , function(Request $request, Response $response){
    require '../src/routes/addCountry.php';
    return $response;
});

$app->post('/api/city' , function(Request $request, Response $response){
    require '../src/routes/addCity.php';
    return $response;
});

$app->post('/api/countrylanguage' , function(Request $request, Response $response){
    require '../src/routes/addCountryLanguage.php';
    return $response;
});

// Delete value - functions
$app->delete('/api/country/{code}' , function(Request $request, Response $response){
    require '../src/routes/delCountry.php';
    return $response;
});

$app->delete('/api/city/{ID}' , function(Request $request, Response $response){
    require '../src/routes/delCity.php';
    return $response;
});

$app->delete('/api/countrylanguage/{ID}' , function(Request $request, Response $response){
    require '../src/routes/delCountryLanguage.php';
    return $response;
});

$app->run();