<?php

/*
Plugin Name:  urlHelper
Version    :  1.0
Description:  providing links to your footer
Author     :  Xavier Kouassi
Author URI :  https://www.test.com/
License    :  GPLv2 or later
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  urlHelper
*/

function callAPI()
{
    //getting url of current page
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        $url = "https://";
    } else {
        $url = "http://";
    }
    //append the host(domain name, ip) to the URL.
    $url .= $_SERVER['HTTP_HOST'];
    //append the requested resource location to the URL
    $url .= $_SERVER['REQUEST_URI'];
    
    $data = '{"url":"' . $url . '"}';
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
function createFooter()
{
    $dataTest = callAPI();
    if (!is_null($dataTest)) {
        $escaped_data = str_replace('\\', '', $dataTest);
        $dataArr = json_decode($escaped_data);
        $newFooterData = '<footer><ul>';
        foreach ($dataArr->links as $link) {
            $newFooterData = $newFooterData . '<li><a href="' . $link->target . '">' . $link->target . '</a></li>';
        };
        $newFooterData = $newFooterData . '</ul></footer>';
        echo "<script>
        function printFooter()
        {
            window.addEventListener('DOMContentLoaded', () => {
                 let bodyElement = document.getElementsByTagName('body');bodyElement[0].insertAdjacentHTML('afterend', '" . $newFooterData . "');
            })
        }
        printFooter();
        </script>";
    }
}
//passing data to wordpress
add_action('init', 'createFooter');
