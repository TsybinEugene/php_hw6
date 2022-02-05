<?php
function auth() {
    if (empty($_POST['login']) || empty($_POST['password']) || !file_exists('./config.json')) return false;

    $config_file = file_get_contents('./config.json');

    if (strlen($config_file) == 0) return false;

    $config_file = json_decode($config_file, JSON_FORCE_OBJECT);

    if (json_last_error() != 0 || empty($config_file['auth'])) return false;

    $pass_string = $config_file['auth'];
    $login_string = $_POST['login'] . ':' . $_POST['password'];

    return password_verify($login_string, $pass_string);
}

if (empty($_SESSION['auth']) && auth()) {
    $_SESSION['auth'] = 'true';
}

if (!empty($_SESSION['auth']) && isset($_POST['logout'])) {
    unset($_SESSION['auth']);
    header('Refresh: 0');
}