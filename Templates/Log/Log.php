
<?php if (count($view['events'])): ?>
    <ul>
    <?php foreach($view['events'] as $event): ?>
        <li><?=$event->description?></li>
    <?php endforeach; ?>
    </ul>
<?php else: ?>
<div class="message error">Нет записей в логе.</div>
<?php endif; ?>