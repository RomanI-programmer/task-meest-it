<?php

use dosamigos\chartjs\ChartJs;

/** @var $statistic array */

echo "<h1>Your statistic Parcel:</h1>";

echo ChartJs::widget(
    [
        'type' => 'pie',
        'id' => 'structurePie',
        'data' => [
            'radius' => "90%",
            'labels' => array_keys($statistic), // Your labels
            'datasets' => [
                [
                    'data' => array_values($statistic), // Your dataset
                    'label' => '',
                    'backgroundColor' => [
                        '#ADC3FF',
                        '#FF9A9A',
                        'rgba(190, 124, 145, 0.8)'
                    ],
                    'borderColor' => [
                        '#fff',
                        '#fff',
                        '#fff'
                    ],
                    'borderWidth' => 1,
                    'hoverBorderColor' => ["#999", "#999", "#999"],
                ]
            ]
        ],
        'clientOptions' => [
            'legend' => [
                'display' => true,
                'position' => 'top',
                'labels' => [
                    'fontSize' => 14,
                    'fontColor' => "#425062",
                ]
            ],
            'tooltips' => [
                'enabled' => true,
                'intersect' => true
            ],
            'hover' => [
                'mode' => false
            ],
            'maintainAspectRatio' => false,

        ],
    ]
);

$css = <<<CSS
#structurePie{
    width: 70% !important;
    height: 70% !important;
}
CSS;

$this->registerCss($css);
