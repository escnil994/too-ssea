<?php
function auth()
{
	if (!isset($_SESSION['user_id'])) {
		header('Location: /login');
	}
}
