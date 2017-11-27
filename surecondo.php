<?php
$access_token = 'lQGPlOkZkpXRB761vIxVtfSgtLAyortsQkd+fL6wcXZgkgNxugKPbByBTik6hHP+JptiWQwcw+ccj1lcwXDsxEkfC1YjcEQdIKG64aS/vz8rtpUALTBb4XIFPLDLXbLdDyNSJ200q2kEZJZlUeVwpgdB04t89/1O/w1cDnyilFU=';
// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			$getTextLine = $event['message']['text'];
			$getContent = "http://www.axcus.com/sure/lineotp.php?otp=".$getTextLine;
			$json =  file_get_contents($getContent);
			$obj = json_decode($json);
			$get = $obj->{'get'}; 
			if ($get == "1")
			{
				$name = $obj->{'name'}; 
				$surname = $obj->{'surname'}; 
				$image = $obj->{'image'}; 
				$imagepath = "http://www.axcus.com/sure/image/".$image;
				$text = "คุณ : ".$name." ".$surname."/nรูปภาพ : ".$imagepath;
			}
			if ($get == "")
			{
				$text = "หมายเลข OTP : ".$getTextLine." ไม่มีในระบบ\nกรุณาตรวจสอบความถูกต้องอีกครึ่งนึง ขอบคุณค่ะ";
			}
			// Get replyToken
			$replyToken = $event['replyToken'];
			// Build message to reply back
			$messages = [
				'type' => 'text',
				'text' => $text
			];
			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages]
			];
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);
			echo $result . "\r\n";
		}
	}
}
