<?php

// ensure user is signed in
if (!isset($_SESSION['user_id']) || !$_SESSION['user_id'])
{
    header('Location:'.$base_path . '?redirect=' . urlencode('/sitter_details.php?sitter_id=' . $_REQUEST['sitter_id']));
    exit;
}