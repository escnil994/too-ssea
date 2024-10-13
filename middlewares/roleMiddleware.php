<?php

function role($role)
{
	session_start();
	if (!isset($_SESSION['user_id'])) {
		header('Location: /login');
	} else {
		if ($_SESSION['user_role'] !== $role) {
			http_response_code(403);
			require_once __DIR__ . '/../app/views/403.php';
			exit;
		}
	}
}
