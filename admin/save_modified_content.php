<?php
include 'callAPI.php';
include 'admin_token.php';
$contentBodyJson = file_get_contents('php://input');
$content = json_decode($contentBodyJson, true);

//FOR TIMEZONES - POSTING LAST SYNC DETAILS   02/11/19 
$timezone = $content['timezone'];  // $_GET['timezone_offset_minutes']
error_log($timezone);
// Convert minutes to seconds
$timezone_name = timezone_name_from_abbr("", $timezone*60, false);
date_default_timezone_set($timezone_name);
$blogId = $content['pageId'];
error_log('Blog id ' . $blogId);
$userId = $content['userId'];
$title = trim($content['title']);
$contents = $content['content'];
$url = $content['pageURL'];
$isAvailbleTo = $content['availability'];
$isVisibleTo = $content['visibility'];
$metadesc = $content['metadesc'];
$shortURL = $content['pageURLshort'];
$imgUrl = $content['imgUrl'];
$meta = array('title' => $title , 'desc'=> $metadesc,'imgUrl'=>$imgUrl);
$meta2 = json_encode($meta);

error_log($userId);
error_log('Title ' . $title);
error_log('URL ' . $url);
error_log('Metadesc ' . $metadesc);
error_log('content ' . $contents);
error_log('available to ' . $isAvailbleTo);
error_log('isvisible to ' . $isVisibleTo);

$baseUrl = getMarketplaceBaseUrl();
$admin_token = getAdminToken();
$customFieldPrefix = getCustomFieldPrefix();

$data = [
    'Title' => $title,
    'Content' => $contents,
    'ExternalURL'=> $url,
    'ModifiedDateTime' => "",
    'Active' => true,
    'Available' => $isAvailbleTo,
    'VisibleTo' => $isVisibleTo,
    'Meta' => $meta2,     
];
$url = $baseUrl . '/api/v2/content-pages/'.$blogId;
$result = callAPI("PUT", $admin_token['access_token'], $url, $data);
error_log(json_encode($result));
//add for another api edit url
?>