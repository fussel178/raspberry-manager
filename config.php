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
    'wlp45s0',
    'enp0s13f0u1'
];

$ssh_user = 'pi';
$ssh_hostname = 'backstein.local';
$ssh_password = 'raspberrypi';

$config = [
    "controllers" => [
        new SystemController(),
        new ServicesController($systemd_units),
        new NetworkController($interfaces),
        new RemoteAccessController($ssh_user, $ssh_hostname, $ssh_password)
    ]
];
