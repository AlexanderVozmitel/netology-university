<?php
function FormChars($p1) {
	return nl2br(htmlspecialchars(trim($p1), ENT_QUOTES), false);
}