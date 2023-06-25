<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

function callAPI($url)
{
    $data = '{"url":"'.$url.'"}';
    header("Access-Control-Allow-Origin: *");
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://www.babbar.tech/api/url/linksInternal?api_token=2IJ7zwcAmdnpj7gIEDaNVYGZzhLralluttC9vDt15GDsvMvkQa9rgeZIPKgs",
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json"
        ],
    ]);
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) {
        echo "cURL Error #:" . $err;
        return NULL;
    } else {
        return $response;
    }
}


//TODO
function insertIntoHTML($data){
    if(!is_null($data)){
        $escaped_data = str_replace('\\', '', $data);
        $dataArr = json_decode($escaped_data);
        foreach($dataArr->links as $link ){
            echo $link->target;
        };
    }
}

$dataTest=callAPI("https://www.impots.gouv.fr/portail/");
insertIntoHTML($dataTest);
