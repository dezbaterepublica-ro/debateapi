<?php

namespace App\Jobs;

use App\External\AuthorityRequestHandler;
use App\External\Settings\UrlFactory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
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
     * @param UrlFactory              $urlFactory
     *
     * @return void
     */
    public function handle(AuthorityRequestHandler $requestHandler, UrlFactory $urlFactory)
    {
        Log::info(
            'Processing initial list for ' . $this->initialList->getAuthority()
                                                               ->getName()
        );
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
            if (!$detailUrlsElements->count()) {
                Log::warning("No elements found for selector $selector");
            }
            $detailUrlsElements->each(
                function (Crawler $detailUrlsElement) use ($urlFactory, $authorityListSettings) {
                    if (strtolower($detailUrlsElement->nodeName()) === 'a') {
                        $detailJob = new Detail(
                            $this->initialList->getAuthority(), $this->initialList->getSettings(), $urlFactory->fromLink(
                            $authorityListSettings->getInitialUrl(),
                            $detailUrlsElement->attr('href')
                        )
                        );
                        ProcessDetail::dispatch($detailJob);
                    } else {
                        Log::error("Detail css selector is not an anchor element, it is an {$detailUrlsElement->nodeName()}");
                    }
                }
            );
        } else {
            Log::debug("{$this->initialList->getAuthority()->getName()} doesn't have a details css selector.");
        }
    }
}
