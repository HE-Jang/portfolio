<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
</head>

<body>

    <h1>Developer Profile</h1>

    <!-- 1. ME 섹션 -->
    <section class="section">
        <h2>Profile</h2>
        <?php foreach ($me as $item): ?>
            <div class="item">
                <span class="label"><?= $item['title'] ?></span> : <?= $item['content'] ?>
            </div>
        <?php endforeach; ?>
    </section>

    <!-- 2. ABOUT 섹션 -->
    <section class="section">
        <h2>About Me</h2>
        <?php foreach ($about as $item): ?>
            <div class="item">
                <?= $item['content'] ?>
            </div>
        <?php endforeach; ?>
    </section>

    <!-- 3. SKILLS 섹션 -->
    <section class="section">
        <h2>Skills</h2>
        <div class="skill-list">
            <?php foreach ($skills as $item): ?>
                <span class="skill-badge"><?= $item['title'] ?></span>
            <?php endforeach; ?>
        </div>
    </section>

</body>

</html>