<?php $this->layout("/layouts/session-default", ["title" => 'Home']); ?>

<?=$this->start('styles-content')?>
<link rel="stylesheet" href="/css/home-index.css">
<?=$this->stop()?>

<div id="cit-content"></div>

<script src="/js/manifest.js" type="application/javascript"></script>
<script src="/js/vendor.js" type="application/javascript"></script>
<script src="/js/home-index.js" type="application/javascript"></script>