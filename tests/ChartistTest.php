<?php

namespace BeastBytes\Yii\Chartist\Tests;

use BeastBytes\Yii\Chartist\Chartist;
use BeastBytes\Yii\Chartist\ChartType;
use Generator;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Yiisoft\Aliases\Aliases;
use Yiisoft\Assets\AssetLoader;
use Yiisoft\Assets\AssetManager;
use Yiisoft\Test\Support\Container\SimpleContainer;
use Yiisoft\Test\Support\EventDispatcher\SimpleEventDispatcher;
use Yiisoft\View\WebView;
use Yiisoft\Widget\WidgetFactory;

class ChartistTest extends TestCase
{
    private const TEST_ID = 'test_id';

    private WebView $view;

    #[Before]
    protected function setUp(): void
    {
        parent::setUp();

        $aliases = new Aliases(['@npm' => __DIR__]);
        $loader = new AssetLoader(
            aliases: $aliases,
            basePath: __DIR__ . DIRECTORY_SEPARATOR . 'support' . DIRECTORY_SEPARATOR . 'assets',
            baseUrl: '/'
        );

        $container = new SimpleContainer(
            [
                AssetManager::class => new AssetManager($aliases, $loader),
                WebView::class => new WebView(
                    __DIR__ . DIRECTORY_SEPARATOR . 'support' . DIRECTORY_SEPARATOR . 'views',
                    new SimpleEventDispatcher()
                ),
            ]
        );

        WidgetFactory::initialize($container, []);

        $this->view = $container
            ->get(WebView::class)
            ->setParameters(['assetManager' => $container->get(AssetManager::class)])
        ;
    }

    #[Test]
    public function id(): void
    {
        $chart = Chartist::widget();

        $this->assertMatchesRegularExpression('/^' . Chartist::ID_PREFIX . '\d{15}$/', $chart->getId());

        $chart = $chart->id(self::TEST_ID);
        self::assertSame(self::TEST_ID, $chart->getId());

        $chart = $chart->attributes(['id' => strrev(self::TEST_ID)]);
        self::assertSame(self::TEST_ID, strrev($chart->getId()));
    }

    #[Test]
    public function no_type(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage(Chartist::CHART_TYPE_NOT_SET);
        Chartist::widget()
            ->render()
        ;
    }

    #[Test]
    public function no_data(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage(Chartist::CHART_DATA_NOT_SET);
        Chartist::widget()
            ->type(ChartType::Bar)
            ->render()
        ;
    }

    #[Test]
    #[DataProvider('chartProvider')]
    public function chart(ChartType $chartType, string $id, array $data, array $options, string $expected): void
    {
        $chart = Chartist::widget()
            ->type($chartType)
            ->id($id)
            ->data($data)
            ->options($options)
            ->render()
        ;

        $this->assertSame(
            str_replace("\r\n", "\n", $expected),
            str_replace("\r\n", "\n", $this->view->render('//view', ['content' => $chart]))
        );
    }

    public static function chartProvider(): Generator
    {
        $html = <<<'HTML'
<!DOCTYPE html>
<html lang="en-GB">
<head>
<title>Chartist Test</title>
</head>
<body>
%s
<script type="module" src="//index.js"></script>
<script type="module">%s
</script>
</body>
</html>

HTML;

        yield [
            'type' => ChartType::Bar,
            'id' => 'bar-chart',
            'data' => [
                'labels' => ['XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL'],
                'series' => [20, 60, 120, 200, 180, 20, 10]
            ],
            'options' => [
                'distributeSeries' => true
            ],
            'expected' => sprintf(
                $html,
                '<div id="bar-chart"></div>',
            <<<EXPECTED
import { BarChart } from "//index.js";
const bar_chart = new BarChart("#bar-chart", {"labels":["XS","S","M","L","XL","XXL","XXXL"],"series":[20,60,120,200,180,20,10]}, {"distributeSeries":true}, []);
EXPECTED
            )
        ];

        yield [
            'type' => ChartType::Line,
            'id' => 'line-chart',
            'data' => [
                'labels' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
                'series' => [
                    [12, 9, 7, 8, 5],
                    [2, 1, 3.5, 7, 3],
                    [1, 3, 4, 5, 6]
                ]
            ],
            'options' => [
                'fullWidth' => true,
                'chartPadding' => [
                    'right' => 40
                ]
            ],
            'expected' => sprintf(
                $html,
                '<div id="line-chart"></div>',
                <<<EXPECTED
import { LineChart } from "//index.js";
const line_chart = new LineChart("#line-chart", {"labels":["Monday","Tuesday","Wednesday","Thursday","Friday"],"series":[[12,9,7,8,5],[2,1,3.5,7,3],[1,3,4,5,6]]}, {"fullWidth":true,"chartPadding":{"right":40}}, []);
EXPECTED
            )
        ];

        yield [
            'type' => ChartType::Pie,
            'id' => 'pie-chart',
            'data' => [
                'labels' => ['Bananas', 'Apples', 'Grapes'],
                'series' => [20, 15, 40]
            ],
            'options' => [
                'labelInterpolationFnc' => Chartist::jsExpression('value => String(value)[0]')
            ],
            'expected' => sprintf(
                $html,
                '<div id="pie-chart"></div>',
                <<<EXPECTED
import { PieChart } from "//index.js";
const pie_chart = new PieChart("#pie-chart", {"labels":["Bananas","Apples","Grapes"],"series":[20,15,40]}, {"labelInterpolationFnc":value => String(value)[0]}, []);
EXPECTED
            )
        ];
    }
}