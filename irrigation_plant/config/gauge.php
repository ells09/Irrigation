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
            'databaseColumnName' => 'temperature',
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
            'databaseColumnName' => 'temperature2',
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
            'databaseColumnName' => 'hygrometer',
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
    ]
];