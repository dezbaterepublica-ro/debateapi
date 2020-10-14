<?php


namespace App\External\Settings;


class AuthorityListSettings
{
    /**
     * @var Url
     */
    private Url $initialUrl;

    /**
     * AuthorityListSettings constructor.
     *
     * @param Url $initialUrl
     */
    public function __construct(Url $initialUrl)
    {
        $this->initialUrl = $initialUrl;
    }

    /**
     * @return Url
     */
    public function getInitialUrl(): Url
    {
        return $this->initialUrl;
    }
}