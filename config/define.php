<?php

define('SITE_TITLE', 'はじめての掲示板 ver.4');
define('BASE_URI', '/bbs04/');
define('MAX_PAGE_POST', 10);

// データベース接続情報
define('DBHOST', 'localhost');
define('DBNAME', 'bbsdb04');
define('DBUSER', 'bbsuser');
define('DBPASS', 'firstbbs');

// 管理者ログイン情報
define('ADMIN_USER', 'admin');
define('ADMIN_PASS', 'xyz');

// クッキー設定情報
define('COOKIE_NAME', 'BBS_COOKIE');
define('COOKIE_EXPIRE', 60 * 60);
define('COOKIE_PATH', '/');
define('COOKIE_DOMAIN', '');

// PEAR::Log 設定情報
define('LOG_HANDLER', 'file');
define('LOG_FILE_PATH', ROOT_PATH . '/log/bbs.log');
define('LOG_ID', 'bbs');
define('LOG_FILE_MODE', 0666);
define('LOG_TIME_FORMAT', '%F %X');
define('LOG_LINE_FORMAT', '[%{timestamp}] [%{priority}] %{class}::%{function} %{message}');

define('UPLOAD_DIR_PATH', '/var/www/html' . BASE_URI . '/upload');
define('MAX_UPLOAD_SIZE', 1024000);
