<!DOCTYPE html>
<html>
<head>
    <?=$this->insert('/partials/global-metas')?>

    <title><?=$title ?? ''?> | OKUA - Connect IT</title>

    <?=$this->section('meta-content')?>

    <?=$this->section('styles-content')?>
</head>
<body class="<?=!isset($bodyDisplay) ? 'visible' : $this->e($bodyDisplay)?> w-full h-screen">
<?=$this->section('content')?>

<?=$this->section('scripts-content')?>
</body>
</html>
