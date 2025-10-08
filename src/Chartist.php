<?php

declare(strict_types=1);

namespace BeastBytes\Yii\Chartist;

use JsonException;
use RuntimeException;
use Yiisoft\Assets\AssetManager;
use Yiisoft\Assets\Exception\InvalidConfigException;
use Yiisoft\Html\Html;
use Yiisoft\Json\Json;
use Yiisoft\View\WebView;
use Yiisoft\Widget\Widget;

final class Chartist extends Widget
{
    public const ID_PREFIX = 'chart_';

    private ?string $type = null;
    private array $attributes = [];
    private array $data = [];
    private array $options = [];
    private array $responsiveOptions = [];

    public function __construct(private readonly AssetManager $assetManager, private readonly WebView $webView)
    {
    }

    public function addAttributes(array $valuesMap): self
    {
        $new = clone $this;
        $new->attributes = array_merge($this->attributes, $valuesMap);
        return $new;
    }

    public function addClass(string $value): self
    {
        $new = clone $this;
        Html::addCssClass($new->attributes, $value);
        return $new;
    }

    public function attributes(array $valuesMap): self
    {
        $new = clone $this;
        $new->attributes = $valuesMap;
        return $new;
    }

    public function id(string $value): self
    {
        $new = clone $this;
        $new->attributes['id'] = $value;
        return $new;
    }

    public function data(array $data): self
    {
        $new = clone $this;
        $new->data = $data;
        return $new;
    }

    public function getId(): string
    {
        if (!isset($this->attributes['id'])) {
            $this->attributes['id'] = Html::generateId(self::ID_PREFIX);
        }

        return $this->attributes['id'];
    }

    public function options(array $options): self
    {
        $new = clone $this;
        $new->options = $options;
        return $new;
    }

    public function render(): string
    {
        $this->registerJs();

        return Html::div('', $this->attributes)->render();
    }

    public function responsiveOptions(array $plugins): self
    {
        $new = clone $this;
        $new->responsiveOptions = $plugins;
        return $new;
    }

    public function type(ChartType $chartType): self
    {
        $new = clone $this;
        $new->type = $chartType->name . 'Chart';
        return $new;
    }

    /**
     * @throws InvalidConfigException
     * @throws JsonException
     */
    private function registerJs(): void
    {
        if ($this->type === null) {
            throw new RuntimeException('Chart type must be set');
        }
        if (empty($this->data)) {
            throw new RuntimeException('Chart data must be set');
        }

        $this->assetManager->register(ChartistAsset::class);

        $js = sprintf(
            "import { %s } from '%s';\n",
            $this->type,
            $this->assetManager->getUrl(ChartistAsset::class, 'index.js')
        );
        $js .= sprintf(
            'const %1$s = new %2$s(\'#%1$s\', %3$s, %4$s, %5$s);' . "\n",
            $this->getId(),
            $this->type,
            Json::encode($this->data),
            Json::encode($this->options),
            Json::encode($this->responsiveOptions)
        );

        $this->webView->registerScriptTag(Html::script($js, ['type' => 'module']));
    }
}