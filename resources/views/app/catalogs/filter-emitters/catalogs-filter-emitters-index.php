<?php $this->layout("/layouts/session-default", ["title" => 'Filtro de emisores']); ?>

<?=$this->start('styles-content')?>
<link rel="stylesheet" href="/css/catalogs-filter-emitter-form.css">
<?php # todo: remove this link tag and add the font from js (vuejs) ?>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
<?=$this->stop()?>

<div id="cit-content"></div>

<script src="/js/manifest.js" type="application/javascript"></script>
<script src="/js/vendor.js" type="application/javascript"></script>
<script src="/js/filter-emitters-index.js" type="application/javascript"></script>