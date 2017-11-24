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
			$text = $event['message']['text'];
			if ($text == "1087")
			{
				$text = "คุณกิตติศักดิ์ เสนาการ\nติดต่อคุณ ประวิทย์ มั่นคง\nห้อง 301";
			}elseif ($text == "1111")
			{
				$text = "คุณสมชาย ทองดี \nติดต่อคุณ นวัตกรณ์ บุญศิริ\nห้อง 1012";
			}elseif ($text == "2222")
			{
				$text = "คุณยอดยุทธิ์ ประมุขผล \nติดต่อคุณ ชูวิทย์ กลิ่นดี\nห้อง 722";
			}elseif (strpos($text, 'หอ') !== false) {
				$text = "ทดสอบ";
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
