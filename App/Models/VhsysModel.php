<?php

namespace App\Models;

use Core\Model;

class VhsysModel extends Model
{
    private function requestAPI(string $endpoint, string $method = "GET"): string
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => API_VHSYS_URL . API_VHSYS_VERSION . $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => array(
                "Access-Token:" . API_VHSYS_TOKEN,
                "Secret-Access-Token:" . API_VHSYS_ACCESS,
                "Content-Type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $erro = curl_error($curl);
        return $response;
        
    }

    public function requestGet(string $endpoint, array $params = []): string
    {
        array_filter($params);
        if(!empty($params)){
            foreach($params as $key => $value) {
                $result[] =  $key . "=" . $value;
            }
            $params = "/?". implode("&", $result);
        }else {
            $params = "";
        }
        $endpoint = $endpoint . $params;
        return $response = $this->requestAPI($endpoint);
    }
}
