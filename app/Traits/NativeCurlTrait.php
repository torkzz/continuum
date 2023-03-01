<?php
namespace App\Traits;

trait NativeCurlTrait
{

    public $response;

    public function nativeCurl($opt){
        $curl = curl_init();

        curl_setopt_array($curl, $opt);

        $response = curl_exec($curl);
        $this->response = $response;
        curl_close($curl);
        
        return $this->response;


    }
}