<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\StatsOverviewWidget;
use App\Filament\Widgets\KonflikByLocationWidget;
use App\Filament\Widgets\KonflikByTypeWidget;
use App\Filament\Widgets\StatusProgressWidget;
use App\Filament\Widgets\MonthlyTrendWidget;
use App\Filament\Widgets\RecentActivitiesWidget;
use App\Filament\Widgets\AlertSystemWidget;
use App\Filament\Widgets\MapWidget;
use App\Filament\Widgets\AdditionalStatsWidget;
use Filament\Pages\Dashboard as BaseDashboard;
use BackedEnum;
class Dashboard extends BaseDashboard
{
    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-home';
    protected static string $routePath = '/dashboard';

    public function getWidgets(): array
    {
        return [
            StatsOverviewWidget::class,
            KonflikByLocationWidget::class,
            KonflikByTypeWidget::class,
            StatusProgressWidget::class,
            MonthlyTrendWidget::class,
            RecentActivitiesWidget::class,
            AlertSystemWidget::class,
            MapWidget::class,
            AdditionalStatsWidget::class,
        ];
    }

    public function getColumns(): int | array
    {
        return [
            'sm' => 1,
            'md' => 2,
            'xl' => 3,
        ];
    }

    public function getTitle(): string
    {
        return 'Dashboard Konflik';
    }
}
