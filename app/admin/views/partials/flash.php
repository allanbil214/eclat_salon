<?php $flashes = take_flash(); if ($flashes): ?>
    <div class="adm-flashes">
        <?php foreach ($flashes as $f): ?>
            <div class="adm-flash adm-flash--<?= e($f['type']) ?>"><?= e($f['msg']) ?></div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
