<?php

namespace App\Services\ApiRequest;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class RomeInterface
{
    private $client;
    private $baseUrl = "https://entreprise.pole-emploi.fr";
    private $clientId = 'PAR_humaverse_037f8107c29931a29e9ac891692aab1865a81cdb5477cf462443e7bbd9afb860';
    private $clientSecret = 'bd8be64e6c7090e20a4dfebad4292d21f9831318995f2964e6ec8e4b87197d1f';

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function authetification(string $scope): array
    {
        $url = '/connexion/oauth2/access_token?realm=%2Fpartenaire';
        $response = $this->client->request(
            'POST',
            $this->baseUrl.$url,
            [
                "headers" => [
                    'Content-Type'=> 'application/x-www-form-urlencoded',
                ],
                "body" => [
                    'grant_type' => 'client_credentials',
                    'client_id' => $this->clientId,
                    'client_secret' => $this->clientSecret,
                    'scope' => $scope,
                ]
            ]
        );
        $content = $response->getContent();
        $content = $response->toArray();

        return $content;
    }

    public function getFicheMetierData(string $access): array
    {
        $response = $this->client->request(
            'GET',
            'https://api.pole-emploi.io/partenaire/rome-metiers/v1/metiers/metier?champs=accesEmploi,code,libelle,definition',
            [
                "headers"=> [
                    "Authorization"=> 'Bearer '.$access
                ]
            ],
        );
        $content = $response->getContent();
        $content = $response->toArray();
        return $content;
    }
    public function getFicheMetierDatainformation(string $access, string $code): array
    {
        $response = $this->client->request(
            'GET',
            'https://api.pole-emploi.io/partenaire/rome-fiches-metiers/v1/fiches-rome/fiche-metier/'.$code,
            [
                "headers"=> [
                    "Authorization"=> 'Bearer '.$access
                ]
            ],
        );
        $content = $response->getContent();
        $content = $response->toArray();
        return $content;
    }
    public function getFicheMetierDataLier(string $projectDir): array
    {

        $data = [];
        $file = fopen($projectDir,"r");
        $tete = fgetcsv($file);
        while(! feof($file))
        {
            $datarome = fgetcsv($file);
            if ($datarome) {
                if (!key_exists($datarome[0], $data)) {
                    $data[$datarome[0]]= [];
                }
                $data[$datarome[0]][]= [
                    "code_rome_cible"=> $datarome[1],
                    "code_type_mobilite"=> $datarome[4]
                ];
            }
        }
        fclose($file);
        return $data;
    }
}