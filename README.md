![Chartist Logo](Writerside/images/logo.svg)
# Yii Chartist
Yii Chartist is a widget that integrates the [Chartist](https://chartist.dev) JavaScript charting library with Yii3.

For license information see the [LICENSE](LICENSE.md) file.

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist beastbytes/yii-chartist
```

or add

```json
"beastbytes/yii-chartist": "<version-constraint>"
```

to the ```require``` section of your composer.json.

### Chartist Package

Install Leaflet using your chosen package manager, e.g.

```
pnpm add chartist
```


```
yarn add chartist
```

or add Chartist to the dependencies of your package.json.

```json
"chartist": "<version-constraint>"
```

## Usage
The Yii Chartist widget is used in a view or in another widget;
usage is the same in both cases; the example below shows how to use the widget in a view.

The widget registers ChartistAsset with the asset manager and the Chartist JavaScript in the view, and renders
the Chartist ```div```.

```php
<?php

use Loytyi\Chartist\Chartist;
use Loytyi\Chartist\ChartType;
use Yiisoft\Assets\AssetManager;
use Yiisoft\View\WebView;

/**
 * @var AssetManager $assetManager
 * @var array $data
 * @var array $options
 * @var array $responsiveOptions
 * @var WebView $this
 */
 
echo Chartist::widget($assetManager, $this)
    ->type(ChartType::Line)
    ->data($data)
    ->options($options)
    ->responsiveOptions($responsiveOptions)
    ->render()
;
```

The chart type is specified by the ```ChartType``` enum; Chartist supports ```Bar```, ```Line```, and ```Pie``` charts.

See the [Chartist documentation](https://chartist.dev/examples) for details on ```$data```, ```$options```,
and ```$responsiveOptions```; the widget values are arrays that are JSON encoded when the widget is rendered.

Chartist does one thing; draws charts. Additional functionality can be added by JavaScript,
e.g. event handlers, animation, etc.
To help with this the Yii Chartist widget sets a JavaScript constant that is the chart; the value is the chart's ID;
the ```getId()``` method provides this value.

## Styling
Chartist provides default styles for charts.
To change styles simply add the appropriate rules to your CSS; note that it is SVG that is being styled.