<?php

class SerialController extends Controller
{
    public static array $default_baudrates = [
        '2400',
        '4800',
        '7600',
        '9600',
        '19200',
        '38400',
        '51200',
        '115200'
    ];

    private array $errors = [];

    private array $baudrates;

    private array $devices = [];

    private $current_device = NULL;

    private $current_baudrate = NULL;

    private string $state = 'unknown';

    function __construct($baudrates = NULL)
    {
        $this->baudrates = $baudrates ?? self::$default_baudrates;
    }

    function getId(): string
    {
        return 'serial';
    }

    function getTitle(): string
    {
        return 'Serial';
    }

    function getKeys(): array
    {
        return ['action', 'device', 'baudrate'];
    }

    function handle(array $args): void
    {
        if (!is_string($args['action'])) return;

        if ($args['action'] == 'connect') {
            // arg check
            if (!is_string($args['device']) || !is_string($args['baudrate'])) return;

            $this->exec_cmd(
                'connect',
                escapeshellarg($args['device']) . ' ' . escapeshellarg($args['baudrate']),
                'Cannot connect the serial device');
        } elseif ($args['action'] == 'disconnect') {
            $this->exec_cmd(
                'disconnect',
                '',
                'Cannot disconnect the serial device'
            );
        }
    }

    function render(): string
    {
        $this->get_information();
        return render_view('Serial', [
            'controller' => $this->getId(),
            'errors' => $this->errors,
            'state' => $this->state,
            'devices' => $this->devices,
            'baudrates' => $this->baudrates,
            'current_device' => $this->current_device,
            'current_baudrate' => $this->current_baudrate
        ]);
    }

    private function get_information(): void
    {
        $output = $this->exec_cmd('status', '', 'Cannot get serial connection information');
        if (isset($output)) {
            $this->state = $output[0];
        }

        $output = $this->exec_cmd('list', '', 'Cannot get available serial devices');
        if (isset($output)) {
            $this->devices = $output;
        }

        $output = $this->exec_cmd('device', '', 'Cannot get connected serial device');
        if (isset($output) && $output[0] != 'none') {
            $this->current_device = $output[0];
        }

        $output = $this->exec_cmd('baudrate', '', 'Cannot get connected serial device');
        if (isset($output) && $output[0] != 'none') {
            $this->current_baudrate = $output[0];
        }
    }

    private function exec_cmd(string $command, string $args, string $error_msg)
    {
        $output = [];
        $retval = 0;

        $cmd = 'sudo /usr/local/bin/serial-device-manager ' . $command . ' ' . $args;
        exec($cmd, $output, $retval);
        if ($retval > 0) {
            array_push($this->errors, count($output) > 0 ? join(PHP_EOL, $output) : $error_msg);
            return NULL;
        } else {
            return $output;
        }
    }
}
