<?php


class DiscordHelper {
	/**
	 *
	 * Test send with
	 * curl -X POST -H "Content-Type: application/json" -d '{"msg":"<@183177012679147520> You got mail!","channel_id": 246646272327417856}' http://167.71.38.238:8090/msg
	 * TrophyBot needs read/write access to the channel
	 * @param string $message message to send
	 * @param int $channelId discord channel id
	 * @return bool|void
	 */
	public static function postTrophyBotMessage(string $message, int $channelId) :bool {
		if (!$message || !$channelId) {
			logger()->error('Discord Trophy Bot Send error: message and channel required', compact('message', 'channelId'));
			return false;
		}
		$data = [
			'msg' => $message,
			'channel_id' => $channelId,
		];
		$url = 'http://167.71.38.238:8090/msg';
		$curl = curl_init($url);
		$json = json_encode($data);
		curl_setopt_array($curl, [
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => $json,
			CURLOPT_HTTPHEADER => [
				'Content-Type: application/json',
				'Content-Length: ' . strlen($json),
			],
			CURLOPT_RETURNTRANSFER => true,
		]);
		$response = curl_exec($curl);
//		if (!$response) \Log::error('Could not post to discord');
		curl_close($curl);
		return $response === 'Accepted';
	}
}
