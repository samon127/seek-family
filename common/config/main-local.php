<?php
if (YII_ENV == 'dev')
{
    $mysql_password = '';
}
else {
    $mysql_password = 'ElhkM31O9UzwnFAi';
}

return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=family',
            'username' => 'root',
            'password' => $mysql_password,
            'charset' => 'utf8',
        ],
        'gllueDB' => [
                'class' => 'yii\db\Connection',
                'dsn' => 'mysql:host=localhost;dbname=gllue',
                'username' => 'root',
                'password' => $mysql_password,
                'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
    ],
];
