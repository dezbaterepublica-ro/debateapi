<?php


namespace App\External;


use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GithubRequestHandler
{
    /**
     * @param string      $organization
     * @param string      $repository
     * @param string      $branch
     * @param string|null $folder
     *
     * @return Collection
     * @throws Exception
     */
    public function getFolder(
        string $organization,
        string $repository,
        string $branch = 'master',
        string $folder = null
    ): Collection {
        $folder = $folder ? "/$folder" : '';
        $response = $this->makeApiRequest("/repos/$organization/$repository/contents$folder?ref=$branch");

        return Collection::make($response);
    }

    /**
     * @param string $url
     *
     * @return array
     * @throws Exception
     */
    public function makeApiRequest(string $url): array
    {
        $cacheKey = self::makeCacheKey($url);
        $response = Cache::get($cacheKey);
        if (!$response) {
            Log::debug("Github: cache miss on $url.");
            $githubApiAddress = Config::get('github.api_address');
            $response = Http::get("$githubApiAddress$url")
                            ->json();

            if (!empty($response['message'])) {
                throw new Exception("Github getCategories error: {$response['message']}");
            }

            Cache::add($cacheKey, $response);
        } else {
            Log::debug("Github: cache hit on $url.");
        }

        return $response;
    }

    private static function makeCacheKey(string $url)
    {
        return 'GITHUB:' . md5($url);
    }
}