<?php


namespace App\External\Settings;


class CssSelector
{
    private string $cssSelector;

    /**
     * CssSelector constructor.
     *
     * @param string $cssSelector
     */
    public function __construct(string $cssSelector)
    {
        $this->cssSelector = $cssSelector;
    }

    /**
     * @return string
     */
    public function getCssSelector(): string
    {
        return $this->cssSelector;
    }
}