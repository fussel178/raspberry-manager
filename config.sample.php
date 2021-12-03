<?php

$systemd_units = [
    'httpd.service',
    'efi.mount',
    'NetworkManager.service',
    'shadow.service',
    'php-fpm.service',
    'root.mount',
    'tlp.service'
];

$interfaces = [
    'wlan0',
    'eth0'
];

$ssh_user = 'pi';
$ssh_hostname = 'raspberry.local';
$ssh_password = 'raspberrypi';

$config = [
    "title" => "Raspberry Manager",
    "controllers" => [
        new SystemController(),
        new ServicesController($systemd_units),
        new NetworkController($interfaces),
        new RemoteAccessController($ssh_user, $ssh_hostname, $ssh_password)
    ]
];
