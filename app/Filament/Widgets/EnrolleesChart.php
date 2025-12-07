<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class EnrolleesChart extends ChartWidget
{

    protected ?string $heading = 'Enrollees Chart';
    protected static ?int $sort = 5;

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Enrollees',
                    // put data copilot suggested
                    'data' => [165, 159, 180, 181, 156, 155, 140, 145, 160, 170, 175, 190],
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#9BD0F5',
                ],
            ],
            'labels' => ['2013', '2014', '2015', '2016', '2017', '2018', '2019', '2020', '2021', '2022', '2023', '2024'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
