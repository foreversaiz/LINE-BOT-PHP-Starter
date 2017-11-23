<?php
$post = file_get_contents('php://input');
$urlReply = 'https://api.line.me/v2/bot/message/reply';
$token = 'lQGPlOkZkpXRB761vIxVtfSgtLAyortsQkd+fL6wcXZgkgNxugKPbByBTik6hHP+JptiWQwcw+ccj1lcwXDsxEkfC1YjcEQdIKG64aS/vz8rtpUALTBb4XIFPLDLXbLdDyNSJ200q2kEZJZlUeVwpgdB04t89/1O/w1cDnyilFU=';


function postMessage($token,$packet,$urlReply)
 {
   $dataEncode = json_encode($packet);
   $headersOption = array('Content-Type: application/json','Authorization: Bearer '.$token);
   $ch = curl_init($urlReply);
   curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'POST');
   curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
   curl_setopt($ch,CURLOPT_POSTFIELDS,$dataEncode);
   curl_setopt($ch,CURLOPT_HTTPHEADER,$headersOption);
   curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
   $result = curl_exec($ch);
   curl_close($ch);
 }
/*
function getText($replyToken)
{

}
*/
//-----------------------------------------


function getTXT($replyToken)
 {
 $sendtext = array(
  'type' => 'text',
  'text' => "test"
 );

 $packet = array(
  'replyToken'=>$replyToken,
  'messages'=>array($sendtext));
 return $packet;
 }

function getSticker($replyToken)
 {
   $sticker = array(
   'type' => 'sticker',
   'packageId' => '4',
   'stickerId' => '300'
   );
   $packet = array(
   'replyToken' => $replyToken,
   'messages' => array($sticker)
   );
   return $packet;
 }
//-----------------------------------------
function getIMG($replyToken)
 {
   $sendimage = array(
   'type' => 'image',
   'originalContentUrl' => 'https://sure.co.th/full.jpg',
   'previewImageUrl' => 'https://sure.co.th/240.jpg'
   );
   $packet = array(
   'replyToken' => $replyToken,
   'messages' => array($sendimage)
   );
   return $packet;
 }
//-----------------------------------------


$res = json_decode($post, true);

if(isset($res['events']) && !is_null($res['events']))
 {
  foreach($res['events'] as $item)
   {
   if($item['type'] == 'message')
    {
    switch($item['message']['type']){
      case 'text':
       $packet = getTXT($item['replyToken']);
       postMessage($token,$packet,$urlReply);
     break;
     case 'image':
      $packet = getIMG($item['replyToken']);
       postMessage($token,$packet,$urlReply);
      
     break;
      case 'video':
      
      break;
      case 'audio':
      
      break;
      case 'location':
     break;
      case 'sticker':
       $packet = getSticker($item['replyToken']);
       postMessage($token,$packet,$urlReply);

      break;
     }


$packet = getIMG($item['replyToken']);
       postMessage($token,$packet,$urlReply);
    }
   }
 }

//RysJFpGt66ET662jmX1UzKP6lEESdj7wG8g3kothyr1xA71V+kxrewo91YxnmlIdaAWe7P7Qia7fuVFHCuocea1F/td6V6rKY0zP1X9C0Y2cYMoRA8uMDgImxZNpbfoeBZDpogggJm2eZTFcv+7C1gdB04t89/1O/w1cDnyilFU=
?>