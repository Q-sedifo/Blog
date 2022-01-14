<div><strong>Logs history</strong></div>
<div>
    <?php if ($logs): ?>
        <?php foreach ($logs as $log): ?>
            <div><?= $log ?></div>
        <?php endforeach; ?>
    <?php else: ?>
        <div>Logs list is clear</div>
    <?php endif; ?>
</div>