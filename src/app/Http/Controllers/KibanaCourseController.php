<?php

namespace App\Http\Controllers;

use Elastic\Elasticsearch\ClientBuilder;

class KibanaCourseController extends Controller
{
    public function __construct()
    {
        $this->elasticSeach = ClientBuilder::create()->setHosts([config('services.elk.host')])->setBasicAuthentication(config('services.elk.username'), config('services.elk.password'))->build();
    }
    public function bulkLogs()
    {

        $doc=file_get_contents(public_path("/files/test.txt"));
        return $this->elasticSeach->bulk($doc);


    }
}
