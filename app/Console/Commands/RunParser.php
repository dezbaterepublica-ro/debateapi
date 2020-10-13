<?php

namespace App\Console\Commands;

use App\External\GitHub;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;
use Symfony\Component\Console\Exception\CommandNotFoundException;
use Symfony\Component\Console\Exception\RuntimeException;

class RunParser extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'parser:run {action}';
    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Runs the debates parser';
    /**
     * @var GitHub
     */
    private GitHub $gitHub;

    /**
     * Create a new command instance.
     *
     * @param GitHub $gitHub
     */
    public function __construct(GitHub $gitHub)
    {
        parent::__construct();
        $this->gitHub = $gitHub;
    }

    /**
     * Execute the console command.
     * @return int
     */
    public function handle()
    {
        $action = $this->argument('action');
        $this->info('Attempting to run: ' . $action);
        switch ($action) {
            case 'list':
                return $this->listInitialUrls();
            default:
                throw new CommandNotFoundException('Command not found: ' . $action);
        }
    }

    /**
     *
     */
    private function listInitialUrls(): int
    {
        // Get the repository
        $categories = $this->gitHub->getFolder(
            Config::get('github.organization'),
            Config::get('github.parsing_reference_repo'),
        );

        $categories = $categories->filter(
            function ($category) {
                return $category['type'] === 'dir';
            }
        );

        $this->info(
            'Found ' . count($categories) . ' category in github repository: ' . $categories->pluck('name')
        );

        // Foreach Categories
        foreach ($categories as $category) {
            $authorities = $this->gitHub->getFolder(
                Config::get('github.organization'),
                Config::get('github.parsing_reference_repo'),
                'master',
                $category['name']
            );

            $this->info(
                'Found ' . count($authorities) . ' authorities for category ' . $category['name'] . ': ' . $authorities->pluck(
                    'name'
                )
            );

            foreach ($authorities as $authority) {
                // Check if there is a list file
                $settingsFiles = $this->gitHub->getFolder(
                    Config::get('github.organization'),
                    Config::get('github.parsing_reference_repo'),
                    'master',
                    "{$category['name']}/{$authority['name']}"
                );

                $listFile = $settingsFiles->first(
                    function ($item) {
                        return $item['name'] === 'list.txt' && $item['type'] === 'file';
                    }
                );

                if (!$listFile) {
                    throw new RuntimeException("Couldn't find a list file for {$category['name']}/{$authority['name']}");
                } else {
                    $this->info("Found list file for {$category['name']}/{$authority['name']}");
                }

                // Download the settings file
                $listFileContent = Http::get($listFile['download_url'])
                                       ->json();

                // Put the initial url and the settings into queue
                if (empty($listFileContent['initial-url'])) {
                    throw new RuntimeException("Couldn't find an initial url for {$category['name']}/{$authority['name']}");
                }

                $queueItem = new \stdClass();
                $queueItem->category = $category;
                $queueItem->authority = $authority;
                $queueItem->listFile = $listFileContent;

                $this->info('Pushing initial url scanning queue job.');

                Queue::pushOn('initial-url-scanning', $queueItem);
            }
        }


        // Get the initial url

        // Put the initial url into queue along with the settings

        return 0;
    }
}
