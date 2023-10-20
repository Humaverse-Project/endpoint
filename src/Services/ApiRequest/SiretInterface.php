<?php

namespace App\Services\ApiRequest;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class SiretInterface
{
    private $client;
    private $baseUrl = "https://api.insee.fr/token";
    private $clientId = 'MHBjVVhxN1MzdDhaUXY0OTZiYjJwNFFXdFpjYTpDZnRmVUlxTXZ6dlVIaWZ3Q2lFMDhhU2JmM1Fh';

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function authetification(): array
    {
        $response = $this->client->request(
            'POST',
            $this->baseUrl,
            [
                "headers" => [
                    'Content-Type'=> 'application/x-www-form-urlencoded',
                    'Authorization'=> 'Basic '.$this->clientId
                ],
                "body" => [
                    'grant_type' => 'client_credentials'
                ]
            ]
        );
        try {
            $content = $response->getContent();
            $content = $response->toArray();
            return $content;
        } catch (\Throwable $th) {
            dd("erreur connexion pôle emplois");
        }
    }
}