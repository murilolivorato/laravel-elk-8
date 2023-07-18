<?php

namespace App\Http\Controllers;
use Elastic\Elasticsearch\ClientBuilder;
use Spatie\ElasticsearchQueryBuilder\Aggregations\MaxAggregation;
use Spatie\ElasticsearchQueryBuilder\Builder;
use Spatie\ElasticsearchQueryBuilder\Queries\MatchQuery;
use Spatie\ElasticsearchQueryBuilder\Queries\RangeQuery;
use ItvisionSy\EsMapper\QueryBuilder;
class ElkBuilderController extends Controller
{
    // https://github.com/roaatech/php-es-mapper
    public function index ()
    {

        $builder = QueryBuilder::make();

//build the query using different methods
        $query = $builder
            ->where('category','one') //term clause
            ->toArray();

        dd($query);
    }
}
