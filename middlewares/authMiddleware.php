<?php
function auth()
{
	if (!isset($_SESSION['usuario_id'])) {
		header('Location: /login');
	}
}
