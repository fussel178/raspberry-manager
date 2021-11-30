<?php

class RemoteAccessController extends Controller
{
    private string $ssh_user;

    private string $ssh_hostname;

    private string $ssh_password;

    public function __construct(string $ssh_user, string $ssh_hostname, string $ssh_password)
    {
        $this->ssh_user = $ssh_user;
        $this->ssh_hostname = $ssh_hostname;
        $this->ssh_password = $ssh_password;
    }

    function getKeys(): array
    {
        return [];
    }

    function getId(): string
    {
        return 'remote-access';
    }

    function getTitle(): string
    {
        return 'Remote Access';
    }

    function handle(array $args): void
    {
        // TODO: Implement handle() method.
    }

    function render(): string
    {
        return render_view('RemoteAccess', [
            'user' => $this->ssh_user,
            'hostname' => $this->ssh_hostname,
            'password' => $this->ssh_password
        ]);
    }
}
