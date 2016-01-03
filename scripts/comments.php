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

    // The total length of the posted payload should not be longer than 1000 bytes
    if (strlen(post_data) > 1000)
    {
    	echo "Bad Request. Posted payload is too long";
    	http_response_code(400);
    	return;
    }
    
    // Decode the posted requeset JSON
    $post_json = json_decode($post_data, true);
    if ($post_json == null)
    {
    	echo "Server error decoding JSON";
    	http_response_code(500);
    	return;
    }
    
    if (strlen($post_json['user']) > 50 || strlen($post_json['user']) <= 0)
    {
    	echo "Bad Request. User name is too long";
    	http_response_code(400);
    	return;
    }
    
    if (strlen($post_json['text']) > 500 || strlen($post_json['text']) <= 0)
    {
    	echo "Bad Request. Posted message is too long";
    	http_response_code(400);
    	return;
    }
	 
	 if (count($commentsJson) > 500){
		echo "Bad Request. Too many messages in conversation";
		http_response_code(400);
		return;	 
	 }

    $new_entry = array('user'=>$post_json['user'], 'text'=>$post_json['text'], 'timestamp'=>$post_json['timestamp']);
    array_push($commentsJson, $new_entry);

    $result = json_encode($commentsJson);
    file_put_contents($serverFilePath, $result, LOCK_EX);
    // echo $serverFilePath;
}
else{
    echo 'Unknown method';
}
?>
