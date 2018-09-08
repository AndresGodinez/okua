<?php
/**
 * Created by PhpStorm.
 * User: aGodinez
 * Date: 07/09/18
 * Time: 12:13
 */

$this->layout("/layouts/session-default", ["title" => 'FIN DE SESIÓN']); ?>

<?=$this->start('styles-content')?>
<link rel="stylesheet" href="/css/logout-index.css">
<?=$this->stop()?>

<div id="cit-content"></div>

<script src="/js/manifest.js" type="application/javascript"></script>
<script src="/js/vendor.js" type="application/javascript"></script>
<script src="/js/logout-index.js" type="application/javascript"></script>