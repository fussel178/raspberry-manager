<p>The Raspberry Pi has the following network configurations:</p>

<div class="collapse">
    <?php foreach ($interfaces as $interface): ?>
        <input type="checkbox" id="<?= 'collapse-section-' . htmlspecialchars($interface['name']) ?>" aria-hidden="true">
        <label for="<?= 'collapse-section-' . htmlspecialchars($interface['name']) ?>" aria-hidden="true">
            Interface <?= htmlspecialchars($interface['name']) ?>
        </label>
        <div>
            <p>The interface has the following configuration:</p>
            <pre><?= htmlspecialchars($interface['status']) ?></pre>
        </div>
    <?php endforeach; ?>
</div>