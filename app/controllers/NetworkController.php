<?php

class NetworkController extends Controller
{
    private array $errors = [];

    private array $interfaces = [];

    public function __construct($interfaces)
    {
        $this->interfaces = array_map(function ($interface) {
            return $this->fetch_interface_status($interface);
        }, $interfaces);
        // filter out NULL values
        $this->interfaces = array_filter($this->interfaces);
    }

    public function getKeys(): array
    {
        return [];
    }

    function getId(): string
    {
        return 'network';
    }

    function getTitle(): string
    {
        return 'Network';
    }

    function handle(array $args): void
    {
        // TODO: Implement handle() method.
    }

    function render(): string
    {
        return render_view('Network', [
            'interfaces' => $this->interfaces,
            'errors' => $this->errors
        ]);
    }

    function fetch_interface_status(string $interface): ?array
    {
        $cmd = '/usr/bin/ip address show dev ' . $interface;
        $output = [];
        $retval = 0;
        exec($cmd, $output, $retval);

        return [
            'name' => $interface,
            'status' => $retval > 0 ? 'Interface information not available' : join(PHP_EOL, $output)
        ];
    }
}