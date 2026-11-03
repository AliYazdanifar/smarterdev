<?php
/** Closes the document and loads scripts. Laravel mapping: @stack('scripts') at the end of layouts/app.blade.php. */
?>
<script src="<?= e(asset('js/main.js')) ?>" defer></script>
<?php foreach ($page['js'] as $js): ?>
<script src="<?= e(asset('js/' . $js)) ?>" defer></script>
<?php endforeach; ?>
</body>
</html>
