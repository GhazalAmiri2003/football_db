<?php
session_start();
$table = $_GET['table'] ?? '';
$action = $_GET['action'] ?? '';
$role = $_SESSION['role'] ?? '';

if (!$table || !$action || !$role) {
    echo "Missing parameters.";
    exit;
}

switch ($action) {
    case 'view':
        header("Location: view.php?table=$table");
        break;
    case 'search':
        header("Location: search.php?table=$table");
        break;
    case 'insert':
        if ($role === 'manager') {
            header("Location: insert_$table.php");
        } else {
            echo "Access denied.";
        }
        break;
    case 'update':
        if ($role === 'manager') {
            header("Location: update.php?table=$table");
        } else {
            echo "Access denied.";
        }
        break;
    case 'delete':
        if ($role === 'manager') {
            header("Location: delete.php?table=$table");
        } else {
            echo "Access denied.";
        }
        break;
    default:
        echo "Unknown action.";
}
exit;

