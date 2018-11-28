<?php
namespace App\Api\ServiceHouse;
use App\Project;
use GuzzleHttp\Client;

/**
 * Created by PhpStorm.
 * User: KevinPC
 * Date: 28-11-2018
 * Time: 23:11
 */
class EnergyApi
{
    private $baseUrl = 'https://sustainables-reporting.servicehouse.nl/projects/';

    private $energyProejcts;

    private $client;

    public function __construct()
    {
        $this->energyProejcts = Project::all();
        $this->client = new Client();
    }

    public function gatherEnergyData()
    {
        foreach($this->energyProejcts as $project){
            $result = $this->client->get($this->baseUrl . '/' . $project->id . '/energy');
            $contents[$project->id] = $result->getBody()->getContents();
        }
        return $contents;
    }

}