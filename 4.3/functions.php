<?php
	function FormChars($text, $p2 = false) {
		return nl2br(htmlspecialchars(trim($text), ENT_QUOTES), false);
	}
	/*	
	function FormChars($text, $p2 = false) {
		global $CONNECT;
		if ($p2) return mysqli_real_escape_string($CONNECT, $text);
		else return nl2br(htmlspecialchars(trim($text), ENT_QUOTES), false);
	}
	*/
	function Location($URL) {
		if (!$URL) $URL = $_SERVER['HTTP_REFERER'];
		exit(header('Location: '.$URL));
	}
	function MessageSend($ErrotMessage, $URL = '', $redirect = true) 
	{
		$_SESSION['ErrotMessage'] = '<div class="MessageBlockInfo">'.$ErrotMessage.'</div>';
		if ($redirect) Location($URL);
	}

	function MessageShow() 
	{
		global $_SESSION;
		if (isset($_SESSION['ErrotMessage'])) echo $_SESSION['ErrotMessage'];
		$_SESSION['ErrotMessage'] = null;
	}
