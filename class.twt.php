<?php
	
	class Twt {

		protected $api = "https://api.twitter.com/";
		protected $uuid = "AA00A0A0-AA00-000A-000A-0A00000000AA";
		protected $version = "5002568";
		protected $useragent = "Twitter-Mac/5002568 Mac/10.12.1 (;x86_64)";
		protected $access_token, $gtoken;
		protected $authorization = "AUTH_TOKEN";

		public function __construct() {

			$this->gen($this->uuid);
			$token = $this->token($this->api . "oauth2/token", 'grant_type=client_credentials', $this->authorization);
			$this->token = $token->access_token;

		}


		protected function __token() {
			if ($this->token) {
				$r = $this->token($this->api . "/1.1/guest/activate.json", 'send_error_codes=1', 'Bearer ' . $this->token);
				$this->gtoken = $r->guest_token;
				return $this->gtoken;
			}
		}


		public function __xauth($username, $password) {
			$r = $this->call(
				$this->api . "/auth/1/xauth_password.json", 'send_error_codes=1&x_auth_identifier='.$username.'&x_auth_mode=client_auth&x_auth_password='.$password,
				'Bearer ' . $this->token, $this->__token());
			print_r($r);
		}

		protected function call($url, $post, $auth, $gtoken) {
				$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_HTTPHEADER, array(
						'X-Twitter-Client-Version: ' .$this->version,
						'Authorization: ' .$auth,
						'X-Guest-Token: ' .$gtoken,
						'X-Client-UUID: ' . $this->uuid,
						'X-Twitter-UTCOffset: +0530',
						'X-Twitter-Client: Twitter-Mac',
						'Content-Length: ' . strlen($post),
						'Content-Type: application/x-www-form-urlencoded;charset=UTF-8'
					));
					curl_setopt($ch, CURLOPT_USERAGENT, $this->useragent);
					curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
					curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				$server_output = json_decode(curl_exec($ch));
			return $server_output;
		}
		protected function token($url, $post, $auth) {
				$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_HTTPHEADER, array(
						'X-Twitter-Client-Version: ' .$this->version,
						'Authorization: ' .$auth,
						'X-Client-UUID: ' . $this->uuid,
						'X-Twitter-UTCOffset: +0530',
						'X-Twitter-Client: Twitter-Mac',
						'Content-Length: ' . strlen($post),
						'Content-Type: application/x-www-form-urlencoded;charset=UTF-8'
					));
					curl_setopt($ch, CURLOPT_USERAGENT, $this->useragent);
					curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
					curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				$server_output = json_decode(curl_exec($ch));
			return $server_output;
		}
		protected function gen(&$s) {
			global $a;
			$len = strlen($s);
			for ($i = 0; $i < $len; $i++) {
				if ($s[$i] == '-') continue;
				if ($s[$i] >= '0' && $s[$i] <= '9') $s[$i] = rand(1, 9);
				else
				if ($s[$i] >= 'A' && $s[$i] <= 'Z') $s[$i] = $a[rand(0, 25) ];
			}
		}

	}
