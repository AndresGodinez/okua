<?php $this->layout("/layouts/session-default", ["title" => 'BITÁCORA DE MOVIMIENTOS']); ?>

<?=$this->start('styles-content')?>
<link rel="stylesheet" href="/css/movements-log-index.css">
<?=$this->stop()?>

<div id="cit-content"></div>

<script src="/js/manifest.js" type="application/javascript"></script>
<script src="/js/vendor.js" type="application/javascript"></script>
<script src="/js/movements-log-index.js" type="application/javascript"></script>