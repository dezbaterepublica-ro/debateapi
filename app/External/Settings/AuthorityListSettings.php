<?php


namespace App\External\Settings;


class AuthorityListSettings
{
    /**
     * @var Url
     */
    private Url $initialUrl;
    /**
     * @var CssSelector|null
     */
    private ?CssSelector $detailUrlCssSelector;

    /**
     * AuthorityListSettings constructor.
     *
     * @param Url              $initialUrl
     * @param CssSelector|null $detailUrlCssSelector
     */
    public function __construct(Url $initialUrl, ?CssSelector $detailUrlCssSelector)
    {
        $this->initialUrl = $initialUrl;
        $this->detailUrlCssSelector = $detailUrlCssSelector;
    }

    /**
     * @return Url
     */
    public function getInitialUrl(): Url
    {
        return $this->initialUrl;
    }

    /**
     * @return CssSelector|null
     */
    public function getDetailUrlCssSelector(): ?CssSelector
    {
        return $this->detailUrlCssSelector;
    }
}