<?php


namespace App\External\Settings;


class AuthoritySettings
{
    /**
     * @var AuthorityListSettings
     */
    private AuthorityListSettings $authorityListSettings;
    /**
     * @var AuthorityDetailsSettings|null
     */
    private ?AuthorityDetailsSettings $authorityDetailsSettings;

    public function __construct(AuthorityListSettings $authorityListSettings, ?AuthorityDetailsSettings $authorityDetailsSettings)
    {
        $this->authorityListSettings = $authorityListSettings;
        $this->authorityDetailsSettings = $authorityDetailsSettings;
    }

    /**
     * @return AuthorityDetailsSettings|null
     */
    public function getAuthorityDetailsSettings(): ?AuthorityDetailsSettings
    {
        return $this->authorityDetailsSettings;
    }

    /**
     * @return AuthorityListSettings
     */
    public function getAuthorityListSettings(): AuthorityListSettings
    {
        return $this->authorityListSettings;
    }
}