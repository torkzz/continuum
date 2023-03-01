<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Traits\NativeCurlTrait;
use App\Models\Currency;

class CurrencyStaticData extends Command
{
    use NativeCurlTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currency:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $opt = array(
            CURLOPT_URL => 'https://assets.msn.com/service/Finance/Calculator/CurrenciesStaticData?apikey=0QfOX3Vn51YCzitbLaRkTTBadtWpgTN8NZLW0C1SEM&ocid=finance-utils-peregrine&cm=en-ph&localizeFor=en-ph',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'authority: assets.msn.com',
                'accept: */*',
                'accept-language: en-US,en;q=0.9',
                'origin: https://www.msn.com',
                'referer: https://www.msn.com/',
                'sec-ch-ua: "Not_A Brand";v="99", "Microsoft Edge";v="109", "Chromium";v="109"',
                'sec-ch-ua-mobile: ?0',
                'sec-ch-ua-platform: "Windows"',
                'sec-fetch-dest: empty',
                'sec-fetch-mode: cors',
                'sec-fetch-site: same-site',
                'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36 Edg/109.0.1518.78'
            ),
        );

        $response = $this->nativeCurl($opt);

        foreach (json_decode($response) as $key => $value) {
            // checking if currency is existing
            $isExisting = Currency::where('currency_code', $value->CurrencyCode)->first();
            if (!$isExisting) {
                Currency::create([
                    'country_code' => $value->CountryCode,
                    'country_name' => $value->CountryName,
                    'currency_code' => $value->CurrencyCode,
                    'currency_name' => $value->CurrencyName,
                    'currency_symbol' => $value->CurrencySymbol,
                ]);
            }
        }
    }
}
