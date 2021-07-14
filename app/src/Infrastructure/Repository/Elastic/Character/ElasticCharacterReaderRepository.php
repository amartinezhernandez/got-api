<?php

namespace App\Infrastructure\Repository\Elastic\Character;

use App\Domain\Character\CharacterSearchReaderRepositoryInterface;
use Elasticsearch\Client;

class ElasticCharacterReaderRepository implements CharacterSearchReaderRepositoryInterface
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function search(string $search): array
    {
        $search = $this->client->search([
            'index' => 'characters',
            'body'  => [
                'query' => [
                    'bool' => [
                        'must' => [
                            [
                                'match' => [
                                    'characterName' => $search
                                ]
                            ],
                        ]
                    ]
                ]
            ]
        ]);

        return array_map(function ($hits) {
            return $hits['_source'];
        }, $search['hits']['hits']);
    }
}
