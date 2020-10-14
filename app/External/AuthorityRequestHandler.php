<?php


namespace App\External;


use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class AuthorityRequestHandler
{
    /**
     * @param string $url
     *
     * @return array|mixed
     */
    public function getJson(string $url)
    {
        return $this->getViewSource($url)
                    ->json();
    }

    /**
     * @param string $url
     *
     * @return Response
     */
    public function getViewSource(string $url): Response
    {
        return Http::get($url);
    }
}