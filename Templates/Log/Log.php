
<?php if (count($view['events'])): ?>
    <ul>
    <?php foreach($view['events'] as $event): ?>
        <li><i><?=$event->date?> (<?=$event->login?>): </i><?=$event->description?></li>
    <?php endforeach; ?>
    </ul>
<?php else: ?>
<div class="message error">Нет записей в логе.</div>
<?php endif; ?>