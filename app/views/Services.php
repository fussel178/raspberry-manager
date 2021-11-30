<?php
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

<p>Currently installed services on your Raspberry Pi:</p>

<table class="striped no-limits">
    <thead>
    <tr>
        <th>Name</th>
        <th>State</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>

    <?php foreach ($services as $service): ?>
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
                        <button class="small primary" type="submit" name="action"
                                value="<?= $service['start_value'] ?>">
                            Start
                        </button>
                        <button class="small inverse" type="submit" name="action"
                                value="<?= $service['reload_value'] ?>">Reload
                        </button>
                        <button class="small secondary" type="submit" name="action"
                                value="<?= $service['stop_value'] ?>">Stop
                        </button>
                        <button class="small secondary" type="submit" name="action"
                                value="<?= $service['restart_value'] ?>">Restart
                        </button>
                    </form>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>