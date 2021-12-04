<?php /** @noinspection PhpUndefinedVariableInspection */

if (isset($error)): ?>
    <div class="card error">
        <h3>Error</h3>
        <p><?= $error ?></p>
    </div>
<?php endif; ?>

<p>Export the mongo database to the backup drive:</p>

<div class="row">
    <form name="<?= $controller ?>" class="no-styling" method="post">
        <input type="hidden" name="controller" value="<?= $controller ?>">
        <?php
        echo render_element('action-modal', [
            'id' => $controller . '-modal',
            'description' => 'Would you like to export the MongoDB database to the backup drive now?',
            'button_type' => 'primary',
            'button_title' => 'Export',
            'button_name' => 'action',
            'button_value' => 'export'
        ]);
        ?>
    </form>
</div>