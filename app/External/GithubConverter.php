<?php


namespace App\External;


use App\External\Settings\AuthorityDetailsSettings;
use App\External\Settings\AuthorityListSettings;
use App\External\Settings\Url;

class GithubConverter
{
    /**
     * @param array $listItem
     *
     * @return AuthorityListSettings
     */
    public function convertListSettings(array $listItem): AuthorityListSettings
    {
        return new AuthorityListSettings(new Url($listItem['initial-url']));
    }

    /**
     * @param array $detailItem
     *
     * @return AuthorityDetailsSettings
     * @noinspection PhpUnusedParameterInspection
     */
    public function convertDetailSettings(array $detailItem): AuthorityDetailsSettings
    {
        return new AuthorityDetailsSettings();
    }
}