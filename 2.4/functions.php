<?php
function FormChars($p1) 
{
	return nl2br(htmlspecialchars(trim($p1), ENT_QUOTES), false);
}

function GenCertificate($name, $result)
{
    header('Content-Type: image/png');
	$im = imagecreatetruecolor(450, 150);
	$CENTER = 225;
    // RGB
    $backColor = imagecolorallocate($im, 255, 255, 255);
    $textColor = imagecolorallocate($im, 0, 172, 238);
	$rightColor = imagecolorallocate($im, 84, 134, 30);
	$errorColor = imagecolorallocate($im, 223, 77, 50);
    $fontFile = ROOT.'resource/CirceWebBold.ttf';
    imagefill($im, 0, 0, $backColor);
	$box = imagettfbbox(11, 0, $fontFile, 'Имя: '.$name);
	$left = $CENTER-round(($box[2]-$box[0])/2);
	imagettftext($im, 11, 0, $left, 40, $textColor, $fontFile, 'Имя: '.$name);
	imagettftext($im, 11, 0, 20, 80, $rightColor, $fontFile, 'Правильных ответов: '.$result['right']);
	imagettftext($im, 11, 0, 20, 100, $errorColor, $fontFile, 'Неправильных ответов: '.$result['error']);
	
    imagepng($im);
    imagedestroy($im);
}

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
	if (isset($_SESSION['ErrotMessage'])) echo $_SESSION['ErrotMessage'];
	$_SESSION['ErrotMessage'] = null;
}
