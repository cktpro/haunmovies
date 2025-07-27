<?php

class halim_drive_google_com extends HALIM_GetLink
{
    function get_link($link)
    {
    	$id = HALIMHelper::getDriveId($link);
		$videoUrl = $this->getDownloadLink($id);
		$result[] = array(
			'file' => $videoUrl,
			'label' => 'FULL HD',
			'type' => 'video/mp4'
		);
		return json_encode($result);
    }

	function getDownloadLink($fileId) {
		$driveUrl	= "https://drive.google.com/uc?id=".urlencode($fileId)."&export=download";
		$returnUrl = $this->parseUrl($driveUrl);
		return $returnUrl;
	}

	function parseUrl($url, $cookies = null) {
        $ip = array(
            'REMOTE_ADDR: 127.0.0.1',
            'HTTP_X_FORWARDED_FOR: 127.0.0.1'
        );

		$fileId = null;
		$idPos = strpos($url, 'id=');

		if ($idPos !== false) {
			$fileId = substr($url, $idPos+3);
			$fileId = substr($fileId, 0, strpos($fileId, '&'));
		}
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_COOKIESESSION, true);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $ip);
		if ($cookies != null && is_array($cookies) && count($cookies) > 0) {
			curl_setopt($ch, CURLOPT_COOKIE, implode('; ', $cookies));
		}

		$response = curl_exec($ch);

		$headers = substr($response, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
		$headers = explode("\r\n", $headers);

		$redirect = null;
		$cookies = array();

		foreach ($headers as $header) {
			$delimeterPos = strpos($header, ':');
			if ($delimeterPos === false)
				continue;

			$key = trim(strtolower(substr($header, 0, $delimeterPos)));
			$value	= trim(substr($header, $delimeterPos+1));

			if ($key == 'location') {
				$redirect = $value;
			}

			if (strpos($key, 'cookie') !== false) {
				$cookies[] = substr($value, 0, strpos($value, ';'));
			}
		}

		if ($redirect == null) {
			$confirm = strpos($response, "confirm=");

			if ($confirm !== false) {
				$confirm = substr($response, $confirm, strpos($response, '"'));
				$confirm = substr($confirm, strpos($confirm, '=')+1);
				$confirm = substr($confirm, 0, strpos($confirm, '&'));
				$redirect = $this->parseUrl("https://drive.google.com/uc?export=download&confirm=".urlencode($confirm)."&id=".urlencode($fileId), $cookies);
			}
		}

		return $redirect;
	}
}
