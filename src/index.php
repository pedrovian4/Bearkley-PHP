<?php

$request = str_replace('/src/index.php' ,'',$_SERVER['PHP_SELF']);

$time = str_replace("\/","",$request);





function sumHour($hour, $post_hour)
{
    if($hour+$post_hour>23){
        $hour=0;
       }else if($hour+$post_hour > 12){
           $hour = 1;
       }else{
         $hour+=$post_hour;
       }

    return $hour;
}

function sumMinute(&$hour, $minute, $post_minute){
    if($minute + $post_minute > 60 ){
        $hour_minutes = $minute + $post_minute;
        $hour = intval($hour_minutes/60);
        $minute = intval(($hour_minutes - intval($hour_minutes/60))*60);
    }else{
        $minute +=$post_minute;
    }

    return $minute;

}




if($time=="/setTime"){
    $hour = date('H');
    $minute = date('i');
    $post_hour = 0;
    $post_minutes = 0;
    if(isset($_POST['hour'])){
        $post_hour = intval($_POST['hour']);
        $hour = sumHour($hour, $post_hour);
        
    }
    if(isset($_POST['minutes'])){
        $post_minutes = $_POST['minutes'];
        $minute = sumMinute($hour, $minute, $post_minutes);
    }
    system('date +%T -s "$hour:$minute"');
    echo json_encode([
        'ok'=>200
    ]);
}else{
 
    echo json_encode([
        "time"=>date("H:i")
    ]);
}