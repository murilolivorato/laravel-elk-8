<?php

namespace App\Http\Controllers;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception;
use Illuminate\Validation\ValidationException;

class MBAPLayerController extends Controller
{
    protected $elasticSeach;
    protected $index = 'mba_players_list';

    public function __construct()
    {
        $this->elasticSeach = ClientBuilder::create()->setHosts([config('services.elk.host')])->setBasicAuthentication(config('services.elk.username'), config('services.elk.password'))->build();
    }

    public function show_mapping ()
    {
        try {
            return $this->elasticSeach->indices()->getMapping([
                'index' => $this->index
            ]);
        }
        catch (\Exception $e) {
            return  ['message' => [$e->getMessage()]];
        }

    }
    public function create_mapping ()
    {
        $this->elasticSeach->indices()->create([
            'index' => $this->index,
            'body' => [
                'mappings' => [
                    'properties' => ['first_name' => ['type' => 'text'], 'last_name' => ['type' => 'text'], 'date_of_birth' => ['type' => 'date'], 'position' => ['type' => 'keyword'], 'team' => ['type' => 'keyword'], 'avg_scoring' => ['type' => 'float'], 'avg_rebound' => ['type' => 'float'], 'avg_assist' => ['type' => 'float'], 'country' => ['type' => 'keyword']]
                ]
            ]
        ]);
    }

    public function show($id)
    {
        try {
            return $this->elasticSeach->get(['index' => $this->index, 'id' => $id]);
         } catch (\Exception $e) {
           return  ['message' => [$e->getMessage()]];
        }
    }

    public function create_many()
    {

        $list_of_nba_players = [
            ['first_name' => 'LeBron', 'last_name' => 'James', 'date_of_birth' => '1984-12-30', 'position' => 'PF', 'team' => 'Lakers',
                'avg_scoring' => 25.4, 'avg_rebound' => 7.9, 'avg_assist' => 7.9, 'country' => 'USA'],
            ['first_name' => 'Stephen', 'last_name' => 'Curry', 'date_of_birth' => '1988-03-14', 'position' => 'PG',
                'team' => 'Warriors', 'avg_scoring' => 24.2, 'avg_rebound' => 4.4, 'avg_assist' => 6.5, 'country' => 'USA'],
            ['first_name' => 'Kevin', 'last_name' => 'Durant', 'date_of_birth' => '1988-09-29', 'position' => 'SF', 'team' => 'Nets',
                'avg_scoring' => 28.4, 'avg_rebound' => 7.4, 'avg_assist' => 4.4, 'country' => 'USA'],
            ['first_name' => 'Joel', 'last_name' => 'Embiid', 'date_of_birth' => '1994-03-16', 'position' => 'C', 'team' => '76ers',
                'avg_scoring' => 26.7, 'avg_rebound' => 11.5, 'avg_assist' => 3.0, 'country' => 'Cameroon'],
            ['first_name' => 'Giannis', 'last_name' => 'Antetokounmpo', 'date_of_birth' => '1994-12-06', 'position' => 'PF',
                'team' => 'Bucks', 'avg_scoring' => 28.3, 'avg_rebound' => 11.3, 'avg_assist' => 6.3, 'country' => 'Greece'],
            ['first_name' => 'Nikola', 'last_name' => 'Jokic', 'date_of_birth' => '1995-02-19', 'position' => 'C', 'team' => 'Nuggets',
                'avg_scoring' => 25.8, 'avg_rebound' => 10.7, 'avg_assist' => 8.5, 'country' => 'Serbia'],
            ['first_name' => 'Luka', 'last_name' => 'Doncic', 'date_of_birth' => '1999-02-28', 'position' => 'PG',
                'team' => 'Mavericks', 'avg_scoring' => 25.7, 'avg_rebound' => 8.4, 'avg_assist' => 7.7, 'country' => 'Slovenia'],
            ['first_name' => 'Damian', 'last_name' => 'Lillard', 'date_of_birth' => '1990-07-15', 'position' => 'PG',
                'team' => 'Trail Blazers', 'avg_scoring' => 28.8, 'avg_rebound' => 4.2, 'avg_assist' => 7.5, 'country' => 'USA'],
            ['first_name' => 'James', 'last_name' => 'Harden', 'date_of_birth' => '1989-08-26', 'position' => 'SG', 'team' => 'Nets',
                'avg_scoring' => 24.8, 'avg_rebound' => 5.1, 'avg_assist' => 10.4, 'country' => 'USA'],
            ['first_name' => 'Kawhi', 'last_name' => 'Leonard', 'date_of_birth' => '1991-06-29', 'position' => 'SF',
                'team' => 'Clippers', 'avg_scoring' => 25.8, 'avg_rebound' => 6.9, 'avg_assist' => 5.0, 'country' => 'USA'],
            ['first_name' => 'Anthony', 'last_name' => 'Davis', 'date_of_birth' => '1993-03-11', 'position' => 'PF',
                'team' => 'Lakers', 'avg_scoring' => 21.8, 'avg_rebound' => 8.6, 'avg_assist' => 3.1, 'country' => 'USA'],
            ['first_name' => 'Kyrie', 'last_name' => 'Irving', 'date_of_birth' => '1992-03-23', 'position' => 'PG', 'team' => 'Nets',
                'avg_scoring' => 24.9, 'avg_rebound' => 4.4, 'avg_assist' => 6.4, 'country' => 'USA'],
            ['first_name' => 'Karl-Anthony', 'last_name' => 'Towns', 'date_of_birth' => '1995-11-15', 'position' => 'C',
                'team' => 'Timberwolves', 'avg_scoring' => 21.8, 'avg_rebound' => 10.5, 'avg_assist' => 2.8,
                'country' => 'Dominican Republic', 'insertion_to_elastic' => '2023-04-07 11 =>19 =>25'],
            ['first_name' => 'Russell', 'last_name' => 'Westbrook', 'date_of_birth' => '1988-11-12', 'position' => 'PG',
                'team' => 'Wizards', 'avg_scoring' => 20.3, 'avg_rebound' => 9.7, 'avg_assist' => 9.7, 'country' => 'USA'],
            ['first_name' => 'Devin', 'last_name' => 'Booker', 'date_of_birth' => '1996-10-30', 'position' => 'SG', 'team' => 'Suns',
                'avg_scoring' => 25.6, 'avg_rebound' => 4.2, 'avg_assist' => 4.3, 'country' => 'USA'],
            ['first_name' => 'Jayson', 'last_name' => 'Tatum', 'date_of_birth' => '1998-03-03', 'position' => 'SF',
                'team' => 'Celtics', 'avg_scoring' => 25.7, 'avg_rebound' => 7.4, 'avg_assist' => 4.3, 'country' => 'USA'],
            ['first_name' => 'Bradley', 'last_name' => 'Beal', 'date_of_birth' => '1993-06-28', 'position' => 'SG',
                'team' => 'Wizards', 'avg_scoring' => 31.3, 'avg_rebound' => 4.7, 'avg_assist' => 4.4, 'country' => 'USA'],
            ['first_name' => 'Trae', 'last_name' => 'Young', 'date_of_birth' => '1998-09-19', 'position' => 'PG', 'team' => 'Hawks',
                'avg_scoring' => 25.3, 'avg_rebound' => 3.9, 'avg_assist' => 9.4, 'country' => 'USA'],
            ['first_name' => 'Zion', 'last_name' => 'Williamson', 'date_of_birth' => '2000-07-06', 'position' => 'PF',
                'team' => 'Pelicans', 'avg_scoring' => 26.9, 'avg_rebound' => 7.2, 'avg_assist' => 3.7, 'country' => 'USA'],
            ['first_name' => 'Chris', 'last_name' => 'Paul', 'date_of_birth' => '1985-05-06', 'position' => 'PG', 'team' => 'Suns',
                'avg_scoring' => 16.4, 'avg_rebound' => 4.5, 'avg_assist' => 8.9, 'country' => 'USA'],
            ['first_name' => 'Donovan', 'last_name' => 'Mitchell', 'date_of_birth' => '1996-09-07', 'position' => 'SG',
                'team' => 'Jazz', 'avg_scoring' => 24.3, 'avg_rebound' => 4.3, 'avg_assist' => 4.3, 'country' => 'USA'],
            ['first_name' => 'Ja', 'last_name' => 'Morant', 'date_of_birth' => '1999-08-10', 'position' => 'PG', 'team' => 'Grizzlies',
                'avg_scoring' => 19.1, 'avg_rebound' => 3.9, 'avg_assist' => 7.4, 'country' => 'USA']
        ];





        $params = ['body' => []];

        foreach ($list_of_nba_players as $key =>  $item) {

            $params['body'][] = [
                'create' => [
                    '_index' => $this->index,
                    '_id'    => $key + 1
                ]
            ];

            $params['body'][] = $item;
        }


        return $this->elasticSeach->bulk($params);
        /*foreach ($list_of_nba_players as $key => $player) {
            $params = [
                'index' => 'mba_player_2',
                'id' => $key + 1,
                'body' => $player
            ];



        }*/

        $this->elasticSeach->bulk(['body' => $list_of_nba_players ]);
    }

    public function update($id)
    {

        try {
            return $this->elasticSeach->update(['index' => $this->index, 'id' => $id, 'body' =>
                ['doc' =>
                    ['first_name' => 'Stephen', 'last_name' => 'Green 3', 'date_of_birth' => '1988-03-14', 'position' => 'PG',
                'team' => 'Warriors', 'avg_scoring' => 24.2, 'avg_rebound' => 4.4, 'avg_assist' => 6.5, 'country' => 'USA']
                 ]
            ]);
        }catch (\Exception $e) {
            return  ['message' => [$e->getMessage()]];
        }
    }

    public function search_first_name($first_name)
    {
        try {
            return  $this->elasticSeach->search(['index' => $this->index,
                                                'scrow' => '30s',
                                                'size' => 40,
                                               // 'body' => ['query' => ['match_all' => new \stdClass() ] ]
                                                'body' => ['query' => ['match' => ['first_name' => $first_name] ] ]
                                                ]);


        }catch (\Exception $e) {
            return  ['message' => [$e->getMessage()]];
        }
    }

    public function fuzzy_search_first_name($first_name)
    {
        try {
            return  $this->elasticSeach->search(['index' => $this->index,
                'scrow' => '30s',
                'size' => 40,
                // 'body' => ['query' => ['match_all' => new \stdClass() ] ]
                'body' => ['query' => ['fuzzy' =>  ['first_name' => ['value' => $first_name] ] ] ]
            ]);


        }catch (\Exception $e) {
            return  ['message' => [$e->getMessage()]];
        }
    }


    public function search_aggregate()
    {
        try {
            return  $this->elasticSeach->search(['index' => $this->index,
                'scrow' => '30s',
                'size' => 40,
                // 'body' => ['query' => ['match_all' => new \stdClass() ] ]
                'body' => ['aggs' => ['avg_rebound_count' => ['terms' => ['field' => 'avg_rebound', 'size' => 50] ] ] ]
            ]);
        } catch (\Exception $e) {
            return  ['message' => [$e->getMessage()]];
        }
    }

    public function search_paginate()
    {
        try {
            $response =  $this->elasticSeach->search(['index' => $this->index,
                'scroll' => '30s',          // how long between scroll requests. should be small!
                'size'   => 4,             // how many results *per shard* you want back
                'body'   => [
                    'query' => [
                        'match_all' => new \stdClass()
                    ]
                ]
            ]);


            // Now we loop until the scroll "cursors" are exhausted
            while (isset($response['hits']['hits']) && count($response['hits']['hits']) > 0) {

                // **
                // Do your work here, on the $response['hits']['hits'] array
                // **

                // When done, get the new scroll_id
                // You must always refresh your _scroll_id!  It can change sometimes
                $scroll_id = $response['_scroll_id'];

                // Execute a Scroll request and repeat
                return $this->elasticSeach->scroll([
                    'body' => [
                        'scroll_id' => $scroll_id,  //...using our previously obtained _scroll_id
                        'scroll'    => '30s'        // and the same timeout window
                    ]
                ]);
            }


        }catch (\Exception $e) {
            return  ['message' => [$e->getMessage()]];
        }
    }

    public function delete($id)
    {
        try {
            return $this->elasticSeach->delete(['index' => $this->index, 'id' => $id ]);
        }catch (\Exception $e) {
            return  ['message' => [$e->getMessage()]];
        }
    }

    public function delete_index()
    {
        try {
            return $this->elasticSeach->indices()->delete(['index' => $this->index]);
        }catch (\Exception $e) {
            return  ['message' => [$e->getMessage()]];
        }
    }


}
