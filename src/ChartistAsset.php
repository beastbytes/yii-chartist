<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Chartist;

use Yiisoft\Assets\AssetBundle;
use Yiisoft\View\WebView;

class ChartistAsset extends AssetBundle
{
    public array $css = ['index.css'];
    public array $js = ['index.js'];
    public array $jsOptions = [
        'type' => 'module',
    ];
    public ?int $jsPosition = WebView::POSITION_END;
    public array $jsStrings = [];
    public ?string $sourcePath = '@npm/chartist/dist';
}