<?php


namespace App\External;


use App\External\Settings\AuthoritySettings;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class GithubRepository
{
    /**
     * @var GithubRequestHandler
     */
    private GithubRequestHandler $gitHub;
    /**
     * @var GithubConverter
     */
    private GithubConverter $converter;

    public function __construct(GithubRequestHandler $requestHandler, GithubConverter $converter)
    {
        $this->gitHub = $requestHandler;
        $this->converter = $converter;
    }

    /**
     * @return Collection
     */
    public function getCategories()
    {
        $categories = $this->gitHub->getFolder(
            Config::get('github.organization'),
            Config::get('github.parsing_reference_repo'),
        );

        $categories = $categories->filter(
            function ($category) {
                return $category['type'] === 'dir';
            }
        );

        return $categories->map(
            function (array $item) {
                return new CategoryOnGithub($item['name']);
            }
        );
    }

    /**
     * @param CategoryOnGithub $categoryOnGithub
     *
     * @return Collection
     */
    public function getAuthorities(CategoryOnGithub $categoryOnGithub)
    {
        $authorities = $this->gitHub->getFolder(
            Config::get('github.organization'),
            Config::get('github.parsing_reference_repo'),
            'master',
            $categoryOnGithub->getName()
        );

        return $authorities->map(
            fn(array $item) => new AuthorityOnGithub($categoryOnGithub, $item['name'])
        );
    }

    /**
     * @param AuthorityOnGithub $authority
     *
     * @return AuthoritySettings
     * @throws Exception
     */
    public function getAuthoritySettings(AuthorityOnGithub $authority)
    {
        // Check if there is a list file
        $settingsFiles = $this->gitHub->getFolder(
            Config::get('github.organization'),
            Config::get('github.parsing_reference_repo'),
            'master',
            "{$authority->getCategory()->getName()}/{$authority->getName()}"
        );

        $listFile = $settingsFiles->first(
            fn($item) => $item['name'] === 'list.txt' && $item['type'] === 'file'
        );

        $detailFile = $settingsFiles->first(
            fn($item) => $item['name'] === 'detail.txt' && $item['type'] === 'file'
        );

        // This should not happen; if an authority folder is created, it should have a list file
        if (!$listFile) {
            throw new Exception(
                "Couldn't find a list file for {$authority->getCategory()->getName()}/{$authority->getName()}"
            );
        }

        // Download the settings file
        $listFileContent = Http::get($listFile['download_url'])
                               ->json();

        if (empty($listFileContent['initial-url'])) {
            throw new Exception(
                "Couldn't find an initial url for {$authority->getCategory()->getName()}/{$authority->getName()}"
            );
        }

        $listSettings = $this->converter->convertListSettings($listFileContent);

        if ($detailFile) {
            // Download the settings file
            $detailFileContent = Http::get($detailFile['download_url'])
                                     ->json();
            $detailSettings = $this->converter->convertDetailSettings($detailFileContent);
        } else {
            $detailSettings = null;
        }

        return new AuthoritySettings($listSettings, $detailSettings);
    }
}