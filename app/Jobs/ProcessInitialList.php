<?php

namespace App\Jobs;

use App\External\AuthorityRequestHandler;
use App\External\Settings\Url;
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
        $source = $requestHandler->getViewSource($authorityListSettings->getInitialUrl());
        $crawler = new Crawler($source);

        // Handle pagination to generate further requests

        // Handle detail pages
        /** @noinspection PhpArrayUsedOnlyForWriteInspection */
        $detailUrlPages = [];
        if ($authorityListSettings->getDetailUrlCssSelector()) {
            $detailUrlsElements = $crawler->filter($authorityListSettings->getDetailUrlCssSelector());
            /** @var Crawler $detailUrlsElement */
            foreach ($detailUrlsElements as $detailUrlsElement) {
                if (strtolower($detailUrlsElement->nodeName()) === 'a') {
                    $detailUrlPages [] = new Url($detailUrlsElement->attr('href'));
                }
            }
        }
    }
}
