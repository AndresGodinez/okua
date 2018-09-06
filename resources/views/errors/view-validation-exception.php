<?php $this->layout("/layouts/session-default", ["title" => 'Error']); ?>

<div id="cit-content">
    <h1>Error!</h1>
    <h2><?= $this->e($msg) ?></h2>
</div>
