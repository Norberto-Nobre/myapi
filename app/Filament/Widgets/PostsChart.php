<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PostsChart extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            stat::make('Total Posts', Post::count())
                ->description('Numero total de posts')
                ->icon('heroicon-o-document-text')
                ->color('primary')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),
                
                stat::make('Total de comentários', 27)
                ->description('Numero total de comentarios')
                ->icon('heroicon-o-chat-bubble-left-right')
                ->color('success')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),

             stat::make('Total de visualizações', Post::sum('views_count'))
                ->description('Numero total de visualizações')
                ->icon('heroicon-o-eye')
                ->color('gray')
                ->chart([0, 2, 4, 6, 8, 10, 12, 14, 16, 18]),
        ];
    }
}
