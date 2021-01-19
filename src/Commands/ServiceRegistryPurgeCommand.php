<?php
/**
 * Created by PhpStorm.
 * User: BABATUNDE
 * Date: 1/19/2021
 * Time: 2:18 PM
 */
namespace GetriPay\ServiceRegistry\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;


class ServiceRegistryPurgeCommand extends Command
{
    public $signature = 'registry:purge';

    public $description = 'This will reload the service registry';

    public function handle()
    {
        $services = config("service-registry.services");
        $file_get_contents = file_get_contents(config("service-registry.service_remote_json"));
        if(isset($file_get_contents)){
            $remote_service_list = json_decode($file_get_contents, 1);
            $services= array_merge($services, $remote_service_list);
        }
        $collection = new Collection();

        $collection->collect($services);
        Cache::put("service_registry", $collection);
        $this->line("ended");
    }
}