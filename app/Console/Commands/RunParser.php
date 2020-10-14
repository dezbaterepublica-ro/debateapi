<?php

namespace App\Console\Commands;

use App\External\CategoryOnGithub;
use App\External\GithubRepository;
use App\Jobs\InitialList;
use App\Jobs\ProcessInitialList;
use Exception;
use Illuminate\Console\Command;
use Symfony\Component\Console\Exception\CommandNotFoundException;

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
     * @var GithubRepository
     */
    private GithubRepository $githubRepository;

    /**
     * Create a new command instance.
     *
     * @param GithubRepository $githubRepository
     */
    public function __construct(GithubRepository $githubRepository)
    {
        parent::__construct();
        $this->githubRepository = $githubRepository;
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
        $categories = $this->githubRepository->getCategories();

        $this->info(
            'Found ' . count($categories) . ' category in github repository: ' . $categories->implode(',')
        );

        // Foreach Categories
        /** @var CategoryOnGithub $category */
        foreach ($categories as $category) {
            $authorities = $this->githubRepository->getAuthorities($category);

            $this->info(
                'Found ' . count($authorities) . ' authorities for category ' . $category->getName(
                ) . ': ' . $authorities->implode(',')
            );

            foreach ($authorities as $authority) {
                try {
                    $authoritySettings = $this->githubRepository->getAuthoritySettings($authority);
                } catch (Exception $e) {
                    $this->error(
                        "Could not find settings for {$authority->getCategory()->getName()}/{$authority->getAuthorityName()}"
                    );
                    $this->error($e->getMessage());
                    continue;
                }

                $queueItem = new InitialList($authority, $authoritySettings);

                $this->info('Pushing initial url scanning queue job.');

                ProcessInitialList::dispatch($queueItem);
            }
        }

        return 0;
    }
}
