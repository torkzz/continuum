<?php

namespace App\Console\Commands;

use App\Models\Feed;
use Illuminate\Console\Command;
use App\Traits\NativeCurlTrait;

class GetFeedArticles extends Command
{
    use NativeCurlTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'msn:articles';

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

        $params = "User=m-0FBF3BAF203067F422B5290021E966C2&";
        $params .= "activityId=CB237342-8604-4713-88C2-231EB2D3161C&";
        $params .= "apikey=0QfOX3Vn51YCzitbLaRkTTBadtWpgTN8NZLW0C1SEM&";
        $params .= "audienceMode=adult&";
        $params .= "cm=en-ph&";
        $params .= "contentType=article&";
        $params .= "duotone=true&";
        $params .= "edgExpMask=512&";
        $params .= "timeOut=1000&";
        $params .= "wposchema=byregion";
        $url = "https://assets.msn.com/service/news/feed/pages/ntp?".$params;


        $sections = json_decode($response)->sections;
        foreach ($sections as $section) {
            foreach ($section->subSections as $subSection) {
                foreach ($subSection->cards as $cards) {
                    if(optional($cards)->subCards){
                        foreach ($cards->subCards as $card) {
                            if(optional($card)->title){
                                $this->saveCard($card);
                            }
                        }
                    }else{
                        if(optional($cards)->title){
                            $this->saveCard($cards);
                        }
                    }
                }
            }
        }
    }

    private function msnCall(){
        $opt = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
              'sec-ch-ua: "Chromium";v="110", "Not A(Brand";v="24", "Microsoft Edge";v="110"',
              'Referer: https://ntp.msn.com/',
              'sec-ch-ua-mobile: ?0',
              'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36 Edg/110.0.1587.56',
              'sec-ch-ua-platform: "Windows"'
            ),
        );

        $response = $this->nativeCurl($opt);
    }

    private function saveCard($card){
        $isExisting = Feed::where('news_id', $card->id)->first();
        if (!$isExisting) {
            echo "----".$card->id;
            echo PHP_EOL;
            echo $card->title;
            // echo PHP_EOL;
            // echo $card->abstract;
            // echo PHP_EOL;
            // echo $card->url;
            // echo PHP_EOL;
            echo PHP_EOL;
            echo PHP_EOL;

            $feed = new Feed();
            $feed->news_id = $card->id;
            $feed->title = $card->title;
            $feed->abstract = $card->abstract;
            $feed->url = $card->url;
            
            if (optional($card->images[0])->url) {
                echo $card->images[0]->url;
                echo PHP_EOL;
                $feed->image = $card->images[0]->url;
            }
            
            $feed->save();

        }
    }
}
