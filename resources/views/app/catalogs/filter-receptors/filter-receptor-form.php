<?php $this->layout("/layouts/session-default", ["title" => 'Edición de filtro de receptores']); ?>

<?=$this->start('meta-content')?>
<meta name="okua:id" content="<?=$this->e($id)?>">
<?=$this->stop()?>

<?=$this->start('styles-content')?>
<link rel="stylesheet" href="/css/catalogs-filter-receptor-form.css">
<?php # todo: remove this link tag and add the font from js (vuejs) ?>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
<?=$this->stop()?>

<div id="cit-content"></div>

<script src="/js/manifest.js" type="application/javascript"></script>
<script src="/js/vendor.js" type="application/javascript"></script>
<script src="/js/filter-receptor-form.js" type="application/javascript"></script>