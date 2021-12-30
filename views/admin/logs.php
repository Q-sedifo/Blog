<strong>Logs history</strong>
<div><a href="?controller=admin&action=clearLogs">Clear logs</a></div>
<div>
    <div>Filesize: <?= $fileSize?> bytes</div>
    <?php if ($logs): ?>
        <?php foreach ($logs as $log): ?>
            <div><?= $log ?></div>
        <?php endforeach; ?>
    <?php else: ?>
        <div>Logs list is clear</div>
    <?php endif; ?>
</div>