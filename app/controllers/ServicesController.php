<?php

class ServicesController extends Controller
{
    private array $systemd_show_properties = [
        'Id',
        'Description',
        'LoadState',
        'ActiveState',
        'SubState'
    ];

    private array $services;

    private array $errors = [];

    function __construct($services)
    {
        $this->services = $services;
    }

    function getKeys(): array
    {
        return ['unit', 'action'];
    }

    function getId(): string
    {
        return 'services';
    }

    function getTitle(): string
    {
        return 'Services';
    }

    function handle(array $args): void
    {
        $unit = $args['unit'];
        $action = $args['action'];

        if (!in_array($unit, $this->services)) {
            array_push($this->errors, 'Unit ' . $unit . ' is not in predefined service list. Ignoring');
            return;
        }

        $output = [];
        $retval = 0;

        if ($action == 'start') {
            $cmd = 'sudo /usr/bin/systemctl start ' . $unit;
            exec($cmd, $output, $retval);
            if ($retval > 0) {
                array_push($this->errors, count($output) > 0 ? join(PHP_EOL, $output) : 'Cannot start unit ' . $unit);
            }
        } elseif ($action == 'reload') {
            $cmd = 'sudo /usr/bin/systemctl reload ' . $unit;
            exec($cmd, $output, $retval);
            if ($retval > 0) {
                array_push($this->errors, count($output) > 0 ? join(PHP_EOL, $output) : 'Cannot reload unit ' . $unit);
            }
        } elseif ($action == 'stop') {
            $cmd = 'sudo /usr/bin/systemctl stop ' . $unit;
            exec($cmd, $output, $retval);
            if ($retval > 0) {
                array_push($this->errors, count($output) > 0 ? join(PHP_EOL, $output) : 'Cannot stop unit ' . $unit);
            }
        } elseif ($action == 'restart') {
            $cmd = 'sudo /usr/bin/systemctl restart ' . $unit;
            exec($cmd, $output, $retval);
            if ($retval > 0) {
                array_push($this->errors, count($output) > 0 ? join(PHP_EOL, $output) : 'Cannot restart unit ' . $unit);
            }
        }
    }

    function render(): string
    {
        $hydrated = array_map(function ($service) {
            return $this->fetch_service_information($service);
        }, $this->services);
        // filter out NULL values
        $hydrated = array_filter($hydrated);

        return render_view('Services', [
            'controller' => $this->getId(),
            'services' => $hydrated,
            'errors' => $this->errors
        ]);
    }

    private function fetch_service_information($service): ?array
    {
        $output = [];
        $retval = 0;
        $cmd = 'sudo /usr/bin/systemctl show "'
            . $service
            . '" --property '
            . join(',', $this->systemd_show_properties);

        exec($cmd, $output, $retval);

        if ($retval > 0) {
            array_push($this->errors, ['Cannot fetch information for ' . $service . ' unit']);
            return NULL;
        }

        $raw_properties = array_reduce($output, function ($acc, $raw_string) {
            $values = preg_split('/=/', $raw_string);
            $acc[$values[0]] = $values[1];
            return $acc;
        }, array());

        // merge in action URIs
        return array_merge($raw_properties, [
            'unit' => $service,
            'start_value' => 'start',
            'stop_value' => 'stop',
            'reload_value' => 'reload',
            'restart_value' => 'restart'
        ]);
    }
}
