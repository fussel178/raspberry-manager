<?php

class ExportController extends Controller
{
    private $error = NULL;

    function getKeys(): array
    {
        return ['action'];
    }

    function getId(): string
    {
        return 'export';
    }

    function getTitle(): string
    {
        return 'Export';
    }

    function handle(array $args): void
    {
        $output = [];
        $retval = 0;

        if ($args['action'] == 'export') {
            exec('sudo /usr/local/bin/mongo-export-to-backup-drive', $output, $retval);
            if ($retval > 0) {
                $this->error = count($output) > 0 ? end($output) : 'Cannot export data';
            }
        }
    }

    function render(): string
    {
        return render_view('Export', [
            'controller' => $this->getId(),
            'error' => $this->error
        ]);
    }
}
