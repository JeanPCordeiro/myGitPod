<?php

use GuzzleHttp\Client;

require_once('vendor/autoload.php');

echo getenv('PORTAINER_USR');
echo "\n";

$client = new GuzzleHttp\Client();
$res = $client->request('POST', getenv("PORTAINER_URL").'/api/auth', [
    'json' => [
        'Username' => getenv("PORTAINER_USR"),
        'Password' => getenv("PORTAINER_PWD")
    ]
]);
$body = json_decode($res->getBody(), true);
$token = $body['jwt'];
echo "Token: ".$token;
echo "\n";
$response2 = $client->get(getenv("PORTAINER_URL").'/api/endpoints/2/docker/containers/json', [
    'headers' => [
        'Authorization' => 'Bearer '.$token
    ],
    'query' => ['all' => 'true']
]);
$bodies = json_decode( $response2->getBody(),true);
foreach ($bodies as $body){
    echo "Id: ".$body['Id'];
    echo "\n";
}
echo "\n";

?>