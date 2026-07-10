<!-- 메인 상단 -->
<section style="text-align: center; padding: 50px 0;">
    <h2>안녕하세요, 개발자 [장한음]입니다.</h2>
    <p>저는 실제 서비스를 고민하고, 코드로 문제를 해결하는 것을 좋아합니다.</p>
</section>

<!-- 메인 하단: 프로젝트 리스트 -->
<section>
    <h3>작업 프로젝트</h3>
    <div class="project-grid">
        <!-- 프로젝트 카드 반복문이 들어갈 자리 -->
        <?php foreach ($projects as $row): ?>
            <div class="card" style="border: 1px solid #ddd; padding: 15px;">
                <h4>
                    <span class="project-title"><?= htmlspecialchars($row['title']) ?></span>
                    <span class="project-seed">(<?= htmlspecialchars($row['seed']) ?>)</span>
                </h4>
                <p><?php echo $row['description']; ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<script src="/assets/js/common.js"></script>