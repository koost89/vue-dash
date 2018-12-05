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

    private $energyProjects;

    private $gatheredProjects = [];

    private $client;

    public function __construct()
    {
        $this->energyProjects = Project::all();
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'User-Agent' => 'Fonkel Api Consumer Dashboard Servicehouse',
                'Accept' => 'Application/json',
            ]
        ]);
    }

    public function getAllProjects()
    {
        return json_encode($this->getProjectPage());
    }

    public function getProjectPage($page = 0)
    {
        $response = $this->client->get('/projects?page='. $page);
        $content = json_decode($response->getBody()->getContents());

        // Add the projects to the total projects array.
        if(isset($content->projects) && !empty($content->projects)){
            array_push($this->gatheredProjects, $content->projects);
        }

        // if we have a result with a PAGE object and we have a follow up page we request again with the new page number
        if(isset($content->page) && $content->page->totalPages > $content->page->currentPage){
            $this->getProjectPage($content->page->curentPage++);
        }
        else {
            // @TODO: Save all projects so we can return data without querying the API...

            return $this->gatheredProjects;
        }
    }

    public function getEnergyData()
    {
        foreach($this->energyProjects as $project){
            $response = $this->client->get($this->baseUrl . '/' . $project->id . '/energy');
            $contents[$project->id] = json_decode($response->getBody()->getContents());
        }
        return $contents;
    }

}