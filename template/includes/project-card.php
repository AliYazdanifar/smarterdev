<?php
/** Case-study / demo project card. Vars: $project, $delay. Blade: <x-project-card :project="$project" /> */
$delay = $delay ?? 0;
?>
<article class="pcard reveal"<?= $delay ? ' data-delay="' . e($delay) . '"' : '' ?>>
  <div class="pcard__mock" aria-hidden="true">
    <span class="pcard__bar pcard__bar--a"></span><span class="pcard__bar pcard__bar--b"></span><span class="pcard__bar pcard__bar--c"></span>
    <i class="bi <?= e($project['icon']) ?> pcard__ico"></i>
  </div>
  <div class="pcard__body">
    <div class="pcard__meta">
      <?php if (!empty($project['demo'])): ?><span class="chip chip--demo"><i class="bi bi-lightbulb" aria-hidden="true"></i>نمونهٔ مفهومی</span><?php endif; ?>
      <span class="chip"><?= e($project['category']) ?></span>
    </div>
    <h3><?= e($project['name']) ?></h3>
    <dl>
      <div><dt>مسئله</dt><dd><?= e($project['problem']) ?></dd></div>
      <div><dt>راهکار پیشنهادی</dt><dd><?= e($project['solution']) ?></dd></div>
    </dl>
    <div class="pcard__tech" aria-label="فناوری‌ها">
      <?php foreach ($project['tech'] as $t): ?><span class="chip chip--tech"><?= e($t) ?></span><?php endforeach; ?>
    </div>
  </div>
</article>
