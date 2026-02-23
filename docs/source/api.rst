API
===

Yii Chartist API documentation

.. php:namespace:: BeastBytes\Yii\Chartist

.. php:class:: Chartist

    .. php:staticmethod:: Chartist::widget(Yiisoft\Assets\AssetManager $assetManager, Yiisoft\View\WebView $view)

        Instantiate a Chartist instance

        :param Yiisoft\Assets\AssetManager $assetManager: The asset manager that will publish the required JavaScript
        :param Yiisoft\View\WebView $view: The view in which to render the chart
        :returns: A new Chartist instance
        :rtype: Chartist

    .. php:staticmethod:: jsExpression(string $value)

        Marks the value as a JavaScript expression to ensure correct encoding

        :returns: The value marked as a JavaScript expression
        :rtype: string

    .. php:method:: id(string $id)

        Sets the widget id

        If not called the widget generates a unique id that matches the regex `chart_\\d{15}`

        See :php:meth:`Chartist::getId`

        :param string $id: The widget id
        :returns: A new Chartist instance with the id
        :rtype: Chartist

    .. php:method:: data(array $data)

        Defines the chart data and labels

        :returns: A new Chartist instance with the data
        :rtype: Chartist

    .. php:method:: getId()

        See :php:meth:`Chartist::id`

        :returns: The widget id
        :rtype: string

    .. php:method:: options(array $options)

        Set Chart options

        :param array<string, mixed> $options: Widget options
        :returns: A new Chartist instance with the options
        :rtype: Chartist

    .. php:method:: responsiveOptions(array $responsiveOptions)

        Set Chart responsive design options

        :param array<string, mixed> $options: Widget responsive design options
        :returns: A new Chartist instance with the responsive design options

    .. php:method:: type(ChartType $type)

        Define the chart type to render

        :param ChartType $type: The chart type
        :returns: A new Chartist instance with the chart type defined
        :rtype: Chartist

.. php:enum:: ChartType

    Defines supported chart types

    .. php:case:: Bar
    .. php:case:: Line
    .. php:case:: Pie
