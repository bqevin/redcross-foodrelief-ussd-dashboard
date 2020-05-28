<?php

namespace App;

use Goutte\Client;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpClient\HttpClient;

/**
 * @property string|null cases
 * @property string|null deaths
 * @property string|null recoveries
 * @property string|null creation
 */
class Stats extends Model
{
    protected $fillable = ['cases', 'deaths', 'recoveries', 'meta', 'creation',];

    public static function fetchKEData()
    {
        try {
            $client = new Client(HttpClient::create(['timeout' => 7]));
            $crawler = $client->request(
                'GET',
                'https://www.worldometers.info/coronavirus/country/kenya/'
            );
            $lastUpdated = $crawler->filter('.content-inner > div')->eq(1)->text();
            $resultsBag = $crawler->filter(
                '.maincounter-number'
            )->each(
                function ($node) {
                    return $node->filter('span')->text();
                }
            );
            $resultsBag[] = $lastUpdated;

            return self::create([
                'cases' => $resultsBag[0],
                'deaths' => $resultsBag[1],
                'recoveries' => $resultsBag[2],
                'meta' => json_encode([]),
                'creation' => $lastUpdated
            ]);
        } catch (\Exception $exception) {
            return [];
        }
    }
}
