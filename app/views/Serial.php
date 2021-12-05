<?php /** @noinspection PhpUndefinedVariableInspection */ ?>

<?php if (count($errors) > 0): foreach ($errors as $error): ?>
    <div class="card error">
        <h3>Error</h3>
        <p><?= $error ?></p>
    </div>
<?php endforeach; endif; ?>

<?php if ($state == 'connected' || $state == 'disconnected'):
    $is_connected = $state == 'connected';
    if ($is_connected) {
        $devices = [$current_device];
        $baudrates = [$current_baudrate];
    }
    ?>

    <p>Serial device is currently
        <mark class="<?= $is_connected ? 'tertiary' : 'secondary' ?>"><?= $state ?></mark>
        <?= $is_connected ? 'to' : 'from' ?> the Telestion Groundstation.
    </p>

    <div class="row">
        <form name="<?= $controller ?>" class="no-styling" method="post">
            <input type="hidden" name="controller" value="<?= $controller ?>">
            <label for="device">Device</label>
            <select id="device" name="device" <?= $is_connected ? 'disabled' : '' ?>>
                <?php foreach ($devices as $elem): ?>
                    <option value="<?= $elem ?>"><?= $elem ?></option>
                <?php endforeach; ?>
            </select>

            <label for="baudrate">Baudrate</label>
            <select id="baudrate" name="baudrate" <?= $is_connected ? 'disabled' : '' ?>>
                <?php foreach ($baudrates as $elem): ?>
                    <option value="<?= $elem ?>"><?= $elem ?></option>
                <?php endforeach; ?>
            </select>

            <?php
            echo render_element('action-modal', [
                'id' => $controller . '-modal-serial-state-change',
                'description' => 'Would you like to ' . ($is_connected ? 'disconnect' : 'connect')
                    . ' the selected serial device ' . ($is_connected ? 'from' : 'to') . ' the Telestion Groundstation?',
                'button_type' => $is_connected ? 'secondary' : 'tertiary',
                'button_title' => $is_connected ? 'Disconnect' : 'Connect',
                'button_name' => 'action',
                'button_value' => $is_connected ? 'disconnect' : 'connect'
            ]);
            ?>
        </form>
    </div>

<?php else: ?>

    <p>Cannot get any information. Please inform someone of the Groundstation team to fix this issue.</p>

<?php endif; ?>
