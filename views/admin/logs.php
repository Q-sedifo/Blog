<div><strong>Logs history</strong></div>
<div>
    <div>Filesize: <?= $fileSize?> bytes <a href="?controller=admin&action=cleanLogs">Clear logs</a></div>
    <?php if ($logs): ?>
        <?php foreach ($logs as $log): ?>
            <div><?= $log ?></div>
        <?php endforeach; ?>
    <?php else: ?>
        <div>Logs list is clear</div>
    <?php endif; ?>
</div>