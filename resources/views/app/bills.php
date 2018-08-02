<?php $this->layout("/layouts/session-default", ["title" => 'FACTURAS']); ?>

<?=$this->start('styles-content')?>
<link rel="stylesheet" href="/css/bills-index.css">
<?=$this->stop()?>

<div id="cit-content"></div>

<script src="/js/manifest.js" type="application/javascript"></script>
<script src="/js/vendor.js" type="application/javascript"></script>
<script src="/js/bills-index.js" type="application/javascript"></script>