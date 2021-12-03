<?php /** @noinspection PhpUndefinedVariableInspection */

if (isset($error)): ?>
    <div class="card error">
        <h3>Error</h3>
        <p><?= $error ?></p>
    </div>
<?php endif; ?>
<p>System options on your Raspberry Pi:</p>

<div class="row">
    <form name="<?= $controller ?>" class="no-styling" method="post">
        <input type="hidden" name="controller" value="<?= $controller ?>">
        <?php foreach ($buttons as $index => $button) {
            $modal_id = $controller . '-modal-' . $index;

            echo render_element('action-modal', [
                'id' => $controller . '-modal-' . $index,
                'description' => 'Would you like to ' . $button['title'] . '?',
                'button_type' => $button['type'],
                'button_title' => $button['title'],
                'button_name' => 'button',
                'button_value' => $button['value']
            ]);
        } ?>
    </form>
</div>
