<?php


namespace App\External;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class GithubRequestHandler
{
    /**
     * @param string      $organization
     * @param string      $repository
     * @param string      $branch
     * @param string|null $folder
     *
     * @return Collection
     */
    public function getFolder(
        string $organization,
        string $repository,
        string $branch = 'master',
        string $folder = null
    ): Collection {
        $githubApiAddress = Config::get('github.api_address');
        $folder = $folder ? "/$folder" : '';
        $response = Http::get("$githubApiAddress/repos/$organization/$repository/contents$folder?ref=$branch");

        return Collection::make($response->json());
    }
}