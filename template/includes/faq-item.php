<?php
/** FAQ accordion item. Vars: $faq [question, answer], $id (unique). Blade: <x-faq-item :question :answer /> */
?>
<div class="faq-item">
  <h3><button class="faq-btn" type="button" id="faq-btn-<?= e($id) ?>" aria-controls="faq-panel-<?= e($id) ?>" aria-expanded="true">
    <span><?= e($faq[0]) ?></span><i class="bi bi-plus-lg" aria-hidden="true"></i>
  </button></h3>
  <div class="faq-a" id="faq-panel-<?= e($id) ?>" role="region" aria-labelledby="faq-btn-<?= e($id) ?>">
    <div><p><?= e($faq[1]) ?></p></div>
  </div>
</div>
