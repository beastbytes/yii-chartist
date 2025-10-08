<?php

declare(strict_types=1);

/* @var $assetManager Yiisoft\Assets\AssetManager */
/* @var $chart string */
/* @var $this Yiisoft\View\WebView */

$this->addJsFiles($assetManager->getJsFiles());
$this->addJsStrings($assetManager->getJsStrings());
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="en-GB">
<head>
<title>Chartist Test</title>
<?php $this->head(); ?>
</head>
<body>
<?php $this->beginBody(); ?>
<?= $chart ?>

<?php $this->endBody(); ?>

</body>
</html>
<?php $this->endPage(); ?>