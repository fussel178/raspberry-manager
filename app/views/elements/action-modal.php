<?php /** @noinspection PhpUndefinedVariableInspection */ ?>

<label for="<?= $id ?>" class="button <?= $button_type ?>">
    <?= $button_title ?>
</label>

<input type="checkbox" id="<?= $id ?>" class="modal">
<div>
    <div class="card">
        <label for="<?= $id ?>" class="modal-close"></label>
        <h3 class="section">Confirm action</h3>
        <p class="section"><?= $description ?></p>
        <p class="section">
            <button class="<?= $button_type ?>" type="submit" name="<?= $button_name ?>" value="<?= $button_value ?>">
                <?= $button_title ?>
            </button>
        </p>
    </div>
</div>
