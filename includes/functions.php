<?php
// Helper functions

function active_class($page_name) {
    global $page;
    return ($page == $page_name) ? 'active' : '';
}

function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
