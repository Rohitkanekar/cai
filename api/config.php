<?php
define('SMTP_HOST', getenv('SMTP_HOST') ?: 'smtp.gmail.com');
define('SMTP_PORT', (int) (getenv('SMTP_PORT') ?: 587));
define('SMTP_USER', getenv('SMTP_USER') ?: '');
define('SMTP_PASS', getenv('SMTP_PASS') ?: '');
define('MAIL_TO', getenv('MAIL_TO') ?: '');
define('MAIL_OWNER', getenv('MAIL_OWNER') ?: MAIL_TO);
