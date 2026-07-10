<div class="business-card">
    <div class="card-name">PHP , Vue3 개발자 장한음</div>
    <div style="height: 1px; background: rgba(255,255,255,0.3); margin: 10px 0;"></div>

    <?php foreach ($contact as $item): ?>
        <div class="contact-item">
            <strong><?= $item['title'] ?>:</strong>
            <?php if ($item['title'] == '이메일'): ?>
                <a href="mailto:<?= $item['content'] ?>" style="color:white;"><?= $item['content'] ?></a>
            <?php elseif ($item['title'] == '전화번호'): ?>
                <a href="tel:<?= $item['content'] ?>" style="color:white;"><?= $item['content'] ?></a>
            <?php elseif ($item['title'] == 'GitHub'): ?>
                <a href="https://<?= $item['content'] ?>" target="_blank" style="color:white;"><?= $item['content'] ?></a>
            <?php else: ?>
                <?= $item['content'] ?>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>