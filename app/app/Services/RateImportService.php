<?php

namespace App\Services;

use App\Models\Currency;
use App\Models\Rate;
use Symfony\Component\DomCrawler\Crawler;

class RateImportService
{
    public string $fileUrl;

    private function loadRemoteXmlContents($url): ?string
    {
        $c = curl_init();
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_URL, $url);
        $contents = curl_exec($c);
        curl_close($c);

        if ($contents) {
            return $contents;
        }

        return null;
    }

    private function createOrGetCurrency(string $name): Currency
    {
        $currency = Currency::query()->where('name', $name)->first();
        if (null === $currency) {
            $currency = new Currency();
            $currency->created_at = new \DateTime();
            $currency->name = $name;
            $currency->save();
        }

        return $currency;
    }

    public function import(): void
    {
        $crawler = new Crawler($this->loadRemoteXmlContents($this->fileUrl));

        $crawler->setDefaultNamespacePrefix('DataSet');
        $dataSetChildren = $crawler->filterXPath('//DataSet:Body')->children();

        /** @var \DOMElement $child */
        foreach ($dataSetChildren as $child) {
            // Setting the reference currency
            if ($child->nodeName == 'OrigCurrency') {
                $refCurrencyName = $child->nodeValue;
                $refCurrency = $this->createOrGetCurrency($refCurrencyName);
            }

            // Importing the rates
            if ($child->nodeName == 'Cube' && isset($refCurrency) && $refCurrency instanceof Currency) {
                $createdAt = $child->getAttribute('date');

                /** @var \DOMNodeList $cubeChildren */
                $cubeChildren = $child->getElementsByTagName('Rate');

                /** @var \DOMText $rateNode */
                foreach ($cubeChildren as $rateNode) {
                    /** @var \DOMNamedNodeMap $attributes */
                    $attributes = $rateNode->attributes;

                    $currency = $attributes['currency']->nodeValue;
                    $value = (float)$rateNode->nodeValue;

                    /** @var \DOMAttr $multiplier */
                    $multiplier = $attributes->getNamedItem('multiplier');
                    if (null !== $multiplier) {
                        $multiplier = $multiplier->nodeValue;
                    }

                    $currency = $this->createOrGetCurrency($currency);

                    $rate = Rate::query()
                        ->where('created_at', $createdAt)
                        ->where('currency_id', $currency->id)
                        ->first();

                    if (null === $rate) {
                        $rate = new Rate();
                        $rate->created_at = $createdAt;
                        $rate->currency_id = $currency->id;
                        $rate->ref_currency_id = $refCurrency->id;
                    }

                    $rate->value = $value;
                    $rate->multiplier = $multiplier;
                    
                    $rate->save();
                }
            }
        }
    }
}
