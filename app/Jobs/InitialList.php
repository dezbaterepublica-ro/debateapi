<?php


namespace App\Jobs;


use App\External\AuthorityOnGithub;
use App\External\Settings\AuthoritySettings;

class InitialList
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
     * InitialList constructor.
     *
     * @param AuthorityOnGithub $authority
     * @param AuthoritySettings $settings
     */
    public function __construct(AuthorityOnGithub $authority, AuthoritySettings $settings)
    {
        $this->authority = $authority;
        $this->settings = $settings;
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
}