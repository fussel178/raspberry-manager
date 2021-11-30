<?php if (isset($error)): ?>
    <div class="card error">
        <h3>Error</h3>
        <p><?= $error ?></p>
    </div>
<?php endif; ?>
<p>System options on your Raspberry Pi:</p>

<div class="row">
    <form class="no-styling" method="post">
        <input type="hidden" name="controller" value="<?= $controller ?>">
        <?php foreach ($buttons as $button): ?>
            <button class="<?= $button['type'] ?>" type="submit" name="button"
                    value="<?= $button['value'] ?>"><?= $button['title'] ?></button>
        <?php endforeach; ?>
    </form>
</div>
