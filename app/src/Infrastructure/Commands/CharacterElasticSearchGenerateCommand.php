<?php

namespace App\Infrastructure\Commands;

use App\Domain\Character\CharacterReaderRepositoryInterface;
use App\Domain\Relations\RelationsBuilderDomainService;
use Elasticsearch\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CharacterElasticSearchGenerateCommand extends Command
{
    protected static $defaultName = 'got:populate-elastic';

    private Client $client;
    private CharacterReaderRepositoryInterface $characterReaderRepository;

    public function __construct(
        Client $client,
        CharacterReaderRepositoryInterface $characterReaderRepository
    ) {
        $this->client = $client;
        $this->characterReaderRepository = $characterReaderRepository;
        parent::__construct();
    }

    public function configure()
    {
        $this->setDescription(
            "This command generates all Elasticsearch indexes"
        );
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $ids = $this->characterReaderRepository->listArrayOfIds(null, null, null);

        $characters = $this->characterReaderRepository->getCharactersData(...$ids);
        $relations = $this->characterReaderRepository->getCharactersRelations(...$ids);

        $characters = RelationsBuilderDomainService::buildRelationsForMultipleCharacters($characters, $relations);

        foreach ($characters as $character) {
            $params['body'][] = [
                'index' => [
                    '_index' => 'characters',
                    '_id' => $character->id()
                ]
            ];

            $params['body'][] = $character->jsonSerialize();
        }

        $this->client->bulk($params);

        return 0;
    }
}
