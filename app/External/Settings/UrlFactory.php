<?php


namespace App\External\Settings;


use Enrise\Uri;

class UrlFactory
{
    /**
     * Generates an URL from an absolute or relative link and uses
     * the source domain and schema if the URL is relative
     *
     * @param Url    $currentlyOnURL
     * @param string $absoluteOrRelativeLink
     *
     * @return Url
     */
    public function fromLink(Url $currentlyOnURL, string $absoluteOrRelativeLink): Url
    {
        $link = new Uri($absoluteOrRelativeLink);
        if ($link->isRelative() || $link->isSchemeless()) {
            $currentUrl = new Uri($currentlyOnURL->getUrl());
            $currentUrl->setPath($link->getPath());

            return new Url($currentUrl->getUri());
        } else {
            return new Url($absoluteOrRelativeLink);
        }
    }
}