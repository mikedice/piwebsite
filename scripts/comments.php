<?php

$method = $_SERVER['REQUEST_METHOD'];
if ($method == 'GET')
{
    $commentFilePath = $_GET['articlePath'];
    $serverFilePath = $_SERVER['DOCUMENT_ROOT'] . '/comments/' . $commentFilePath;

    if (file_exists($serverFilePath)){
        $str = file_get_contents($serverFilePath);
        header('Content-Type: application/json');
        echo $str;
    }
    else{
        echo "[]";
    }
}
else if ($method == 'POST')
{
    $commentFilePath = $_GET['articlePath'];
    $serverFilePath = $_SERVER['DOCUMENT_ROOT'] . '/comments/' . $commentFilePath;
    $commentsJson = null;

    if (file_exists($serverFilePath)){
        $str = file_get_contents($serverFilePath);
        $commentsJson = json_decode($str);    
    }
    else{
        $commentsJson = array();
    }
    $post_data = file_get_contents("php://input");
    $post_json = json_decode($post_data, true);

    $new_entry = array('user'=>$post_json['user'], 'text'=>$post_json['text'], 'timestamp'=>$post_json['timestamp']);
    array_push($commentsJson, $new_entry);

    $result = json_encode($commentsJson);
    file_put_contents($serverFilePath, $result, LOCK_EX);
    echo $serverFilePath;
}
else{
    echo 'Unknown method';
}
?>
