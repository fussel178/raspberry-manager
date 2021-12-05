<?php /** @noinspection PhpUndefinedVariableInspection */
function get_active_state_class(array $service): string
{
    switch ($service['ActiveState']) {
        case 'failed':
            return 'secondary';
        case 'active':
            return 'tertiary';
        case 'activating':
        case 'deactivating':
            return 'warning';
        case 'inactive':
            return 'disabled';
        default:
            return '';
    }
}

function get_sub_state_class(array $service): string
{
    switch ($service['SubState']) {
        case 'failed':
            return 'secondary';
        case 'mounted':
        case 'running':
        case 'active':
            return 'tertiary';
        case 'exited':
        case 'dead':
            return 'disabled';
        default:
            return '';
    }
}

function get_load_state_class(array $service): string
{
    switch ($service['LoadState']) {
        case 'not-found':
            return 'secondary';
        default:
            return '';
    }
}

?>

<?php if (count($errors) > 0): foreach ($errors as $error): ?>
    <div class="card error">
        <h3>Error</h3>
        <p><?= $error ?></p>
    </div>
<?php endforeach; endif; ?>

<p>Currently installed services on your machine:</p>

<table class="striped no-limits">
    <thead>
    <tr>
        <th>Name</th>
        <th>State</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>

    <?php foreach ($services as $index => $service): ?>
        <tr>
            <td data-label="Name">
                <h5 class="no-margin"><?= $service['Id'] ?>
                    <small><?= htmlspecialchars($service['Description']) ?></small></h5>
            </td>
            <td data-label="State">
                <p class="no-margin-beside">
                    <mark class="tag <?= get_active_state_class($service) ?>"><?= htmlspecialchars($service['ActiveState']) ?></mark>
                    <mark class="tag <?= get_sub_state_class($service) ?>"><?= htmlspecialchars($service['SubState']) ?></mark>
                    <mark class="tag <?= get_load_state_class($service) ?>"><?= htmlspecialchars($service['LoadState']) ?></mark>
                </p>
            </td>
            <td data-label="Actions">
                <div class="row">
                    <form class="no-styling no-margin-children" method="post">
                        <input type="hidden" name="controller" value="<?= $controller ?>">
                        <input type="hidden" name="unit" value="<?= $service['unit'] ?>">

                        <?php

                        echo render_element('action-modal', [
                            'id' => $controller . '-modal-start-' . $index,
                            'description' => 'Would you like to start the unit "' . $service['Id'] . '"?',
                            'button_type' => 'small primary',
                            'button_title' => 'Start',
                            'button_name' => 'action',
                            'button_value' => $service['start_value']
                        ]);

                        echo render_element('action-modal', [
                            'id' => $controller . '-modal-reload-' . $index,
                            'description' => 'Would you like to reload the unit "' . $service['Id'] . '"?',
                            'button_type' => 'small inverse',
                            'button_title' => 'Reload',
                            'button_name' => 'action',
                            'button_value' => $service['reload_value']
                        ]);

                        echo render_element('action-modal', [
                            'id' => $controller . '-modal-stop-' . $index,
                            'description' => 'Would you like to stop the unit "' . $service['Id'] . '"?',
                            'button_type' => 'small secondary',
                            'button_title' => 'Stop',
                            'button_name' => 'action',
                            'button_value' => $service['stop_value']
                        ]);

                        echo render_element('action-modal', [
                            'id' => $controller . '-modal-restart-' . $index,
                            'description' => 'Would you like to restart the unit "' . $service['Id'] . '"?',
                            'button_type' => 'small secondary',
                            'button_title' => 'Restart',
                            'button_name' => 'action',
                            'button_value' => $service['restart_value']
                        ]);

                        ?>
                    </form>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>