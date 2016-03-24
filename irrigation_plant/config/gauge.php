<?php
/**
 * Created by PhpStorm.
 * User: inkre1
 * Date: 15-06-03
 * Time: 15:12
 */

return [

    'gauges' => [
        'Temp1' => [
            'Title' => 'Jordtemperatur',
            'unit' => '℃',
            'databaseColumnName' => 'temperature_1',
            'databaseColumnAlias' => 'temperature_1',
            'options' => [
                'datatable' => '',
                'width' => 150,
                'yellowColor' => '#0000ff',
                'yellowFrom' => 0,
                'yellowTo' => 10,
                'greenFrom' => 10,
                'greenTo' => 30,
                'redFrom' => 30,
                'redTo' => 40,
                'max' => 40,
                'majorTicks' => [
                    'Kall',
                    'Normal',
                    'Het'
                ],
            ]
        ],
        'Temp2' => [
            'Title' => 'Växthus',
            'unit' => '℃',
            'databaseColumnName' => 'temperature_2',
            'databaseColumnAlias' => 'temperature_2',
            'options' => [
                'datatable' => '',
                'width' => 150,
                'yellowColor' => '#0000ff',
                'yellowFrom' => 0,
                'yellowTo' => 10,
                'greenFrom' => 10,
                'greenTo' => 30,
                'redFrom' => 30,
                'redTo' => 40,
                'max' => 40,
                'majorTicks' => [
                    'Kall',
                    'Normal',
                    'Het'
                ],
            ]
        ],
        'Humidity' => [
            'Title' => 'Luftfuktighet',
            'unit' => '%',
            'databaseColumnName' => 'humidity',
            'databaseColumnAlias' => 'humidity',
            'options' => [
                'datatable' => '',
                'width' => 150,
                'yellowColor' => '#0000ff',
                'yellowFrom' => 0,
                'yellowTo' => 25,
                'greenFrom' => 25,
                'greenTo' => 75,
                'redFrom' => 75,
                'redTo' => 100,
                'max' => 100,
                'majorTicks' => [
                    'Torr',
                    'Normal',
                    'Blöt'
                ],
            ]
        ],
        'Hygrometer' => [
            'Title' => 'Jordfuktighet',
            'unit' => '%',
            'databaseColumnName' => 'hygro_raw',
            'databaseColumnAlias' => 'hygro_raw',
            'options' => [
                'datatable' => '',
                'width' => 150,
                'yellowColor' => '#0000ff',
                'yellowFrom' => 0,
                'yellowTo' => 12,
                'greenFrom' => 12,
                'greenTo' => 38,
                'redFrom' => 38,
                'redTo' => 50,
                'max' => 50,
                'majorTicks' => [
                    'Torr',
                    'Normal',
                    'Blöt'
                ],
            ]
        ],
    ]
];
