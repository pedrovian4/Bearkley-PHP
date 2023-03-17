<?php

$server_master = json_decode(file_get_contents("http://localhost:5000/src/index.php"), true);
$server_1 = json_decode(file_get_contents("http://localhost:7000/src/index.php"),true );
$serve_2 = json_decode(file_get_contents("http://localhost:8000/src/index.php"), true );


$media = (str_replace(':', '.', $server_master["time"]) + str_replace(':', '.', $serve_2["time"]) + str_replace(':', '.', $server_1["time"]))/3;



$server_master_resp =  abs(str_replace(':', '.', $server_master["time"]) - $media); 
$server_1_resp  = abs(str_replace(':', '.', $server_1["time"]) - $media); 
$server_2_resp = abs(str_replace(':', '.', $server_2["time"]) - $media); 



if(str_replace(':', '.', $server_master["time"]) >  str_replace(':', '.', $server_1["time"])){
    $server_1_resp = $server_1_resp*-1;
} 


if(str_replace(':', '.', $server_master["time"]) >  str_replace(':', '.', $server_2["time"])){
    $server_2_resp = $server_2_resp*-1;
} 





function httpPost($url, $data)
{
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}


// Envia ajuste de horario pro master
 httpPost("http://localhost:5000/src/index.php",[
    "hour"=>intval($server_master_resp), 
    "minute"=> $server_master_resp - intval($server_master_resp)
 ]);

//Server 2 
 httpPost("http://localhost:7000/src/index.php",[
    "hour"=>intval($server_1_resp), 
    "minute"=> $server_1_resp - intval($server_1_resp)
 ]);


// Server 3
 httpPost("http://localhost:8000/src/index.php",[
    "hour"=>intval($server_2_resp), 
    "minute"=> $server_2_resp - intval($server_2_resp)
 ]);





