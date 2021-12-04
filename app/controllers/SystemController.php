<?php

use http\Exception\InvalidArgumentException;

class SystemController extends Controller
{
    private $error = NULL;

    function getKeys(): array
    {
        return ['button'];
    }

    function getId(): string
    {
        return "system";
    }

    function getTitle(): string
    {
        return "System";
    }

    function handle(array $args): void
    {
        $output = [];
        $retval = 0;

        if ($args['button'] == 'reboot') {
            exec('sudo /usr/bin/systemctl reboot', $output, $retval);
            if ($retval > 0) {
                $this->error = count($output) > 0 ? end($output) : 'Cannot reboot Raspberry Pi';
            }
        } elseif ($args['button'] == 'poweroff') {
            exec('sudo /usr/bin/systemctl poweroff', $output, $retval);
            if ($retval > 0) {
                $this->error = count($output) > 0 ? end($output) : 'Cannot power off Raspberry Pi';
            }
        }
    }

    function render(): string
    {
        $buttons = [
            [
                'title' => 'Reboot',
                'type' => 'inverse',
                'value' => 'reboot',
            ],
            [
                'title' => 'Poweroff',
                'type' => 'secondary',
                'value' => 'poweroff'
            ]
        ];

        return render_view('System', [
            'controller' => $this->getId(),
            'buttons' => $buttons,
            'load' => $this->get_system_load(),
            'meminfo' => $this->get_meminfo(),
            'error' => $this->error
        ]);
    }

    function get_system_load(): string
    {
        $output = [];
        $retval = 0;

        exec('cat /proc/loadavg', $output, $retval);
        if ($retval > 0) {
            return 'System load not available';
        }

        return join(PHP_EOL, $output);
    }

    function get_meminfo(): string
    {
        $output = [];
        $retval = 0;

        exec('/usr/bin/free -h', $output, $retval);
        if ($retval > 0) {
            return 'Memory information not available';
        }

        return join(PHP_EOL, $output);
    }
}
