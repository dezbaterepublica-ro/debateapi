<?php

namespace App\Jobs;

use App\External\AuthorityRequestHandler;
use App\External\Settings\Url;
use DOMElement;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\DomCrawler\Crawler;

class ProcessInitialList implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var InitialList
     */
    private InitialList $initialList;

    /**
     * Create a new job instance.
     *
     * @param InitialList $initialList
     */
    public function __construct(InitialList $initialList)
    {
        $this->initialList = $initialList;
    }

    /**
     * Execute the job.
     *
     * @param AuthorityRequestHandler $requestHandler
     *
     * @return void
     */
    public function handle(AuthorityRequestHandler $requestHandler)
    {
        $authorityListSettings = $this->initialList->getSettings()
                                                   ->getAuthorityListSettings();
        $source = $requestHandler->getViewSource(
            $authorityListSettings->getInitialUrl()
                                  ->getUrl()
        );
        $crawler = new Crawler($source->body());

        // Handle pagination to generate further requests

        // Handle detail pages
        if ($authorityListSettings->getDetailUrlCssSelector()) {
            $selector = $authorityListSettings->getDetailUrlCssSelector()
                                              ->getCssSelector();
            $detailUrlsElements = $crawler->filter($selector);
            /** @var DOMElement $detailUrlsElement */
            foreach ($detailUrlsElements as $detailUrlsElement) {
                if (strtolower($detailUrlsElement->tagName) === 'a') {
                    $detailJob = new Detail(
                        $this->initialList->getAuthority(),
                        $this->initialList->getSettings(),
                        new Url($detailUrlsElement->getAttribute('href'))
                    );
                    ProcessDetail::dispatch($detailJob);
                }
            }
        }

    }
}
