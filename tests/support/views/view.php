<?php

declare(strict_types=1);

/* @var $assetManager Yiisoft\Assets\AssetManager */
/* @var $content string */
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
<?= $content ?>

<?php $this->endBody(); ?>

</body>
</html>
<?php $this->endPage(); ?>