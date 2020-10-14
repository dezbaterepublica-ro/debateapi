<?php


namespace App\External\Settings;


class Url
{
    private string $link;

    /**
     * Url constructor.
     *
     * @param string $link
     */
    public function __construct(string $link)
    {
        $this->link = $link;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }
}