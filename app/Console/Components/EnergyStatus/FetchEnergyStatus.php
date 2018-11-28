<?php

/**
 * Created by PhpStorm.
 * User: KevinPC
 * Date: 26-11-2018
 * Time: 23:28
 */
namespace App\Console\Components\WebsiteStatus;

use App\Api\ServiceHouse\EnergyApi;
use App\Events\ServiceHouse\EnergyDataFetched;
use Illuminate\Console\Command;

class FetchEnergyStatus extends Command {

    protected $signature = 'dashboard:energy';
    protected $description = 'Fetch energy stats from SH API';

    public function handle()
    {
        $energyApi = new EnergyApi();
        $contents = $energyApi->gatherEnergyData();
        foreach($contents as $project_id => $content){
            event(new EnergyDataFetched($content, $project_id));
        }
    }
}