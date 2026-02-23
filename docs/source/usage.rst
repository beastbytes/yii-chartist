Usage
=====

The Yii Chartist widget is used in a view or in another widget;
usage is the same in both cases; the example below shows how to use the widget in a view.

The widget registers `ChartistAsset` with the asset manager and the Chartist JavaScript with the view,
and renders the Chartist `div`.

.. code-block:: php
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
        ->id('my-chart')
        ->type(ChartType::Line)
        ->data($data)
        ->options($options)
        ->responsiveOptions($responsiveOptions)
        ->render()
    ;

The chart type is specified by the `ChartType` enum; Chartist supports `Bar`, `Line`, and `Pie` charts.

See the `Chartist documentation <https://chartist.dev/examples>`__ and source code for details on `$data`, `$options`,
and `$responsiveOptions`; the widget values are PHP arrays that are encoded when the widget is rendered.

.. tip::
    The widget has a convenience function, `Chartist::JsExpression()`,
    to allow JavaScript expressions to be correctly encoded.

    Example:

    `'options' => ['labelInterpolationFnc' => Chartist::jsExpression('value => String(value)[0]')]`

    is encoded as `{"labelInterpolationFnc":value => String(value)[0]}`

Additional Functionality
------------------------

Chartist does one thing; draws charts.
Additional functionality, e.g. event handlers, animation, etc. can be added by JavaScript,

To help with this the Yii Chartist widget sets a JavaScript constant whose name is the chart's *id* in snake_case,
and value is the chart instance; the ``getId()`` method provides this value;
example: an *id* of `my-chart` results in a JavaScript constant named `my_chart`.

.. note::
    If the application does not set the widget *id*, the widget will generate a unique *id* of the form `chart_\d{15}`.
    The generated id will change on each HTTP request.

Styling
-------

Chartist provides default styles for charts.
To change styles simply add the appropriate rules to your CSS; note that it is SVG that is being styled.
