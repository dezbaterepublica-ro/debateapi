<?php


namespace App\Jobs;


use App\External\AuthorityOnGithub;
use App\External\Settings\AuthoritySettings;
use App\External\Settings\Url;

class Detail
{
    /**
     * @var AuthorityOnGithub
     */
    private AuthorityOnGithub $authority;
    /**
     * @var AuthoritySettings
     */
    private AuthoritySettings $settings;
    /**
     * @var Url
     */
    private Url $detailUrl;

    /**
     * Detail constructor.
     *
     * @param AuthorityOnGithub $authority
     * @param AuthoritySettings $settings
     * @param Url               $detailUrl
     */
    public function __construct(AuthorityOnGithub $authority, AuthoritySettings $settings, Url $detailUrl)
    {
        $this->authority = $authority;
        $this->settings = $settings;
        $this->detailUrl = $detailUrl;
    }

    /**
     * @return AuthorityOnGithub
     */
    public function getAuthority(): AuthorityOnGithub
    {
        return $this->authority;
    }

    /**
     * @return AuthoritySettings
     */
    public function getSettings(): AuthoritySettings
    {
        return $this->settings;
    }

    /**
     * @return Url
     */
    public function getDetailUrl(): Url
    {
        return $this->detailUrl;
    }
}