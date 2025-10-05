<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Post;

class ListPosts extends ListRecords
{
    protected static string $resource = PostResource::class;
    

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    
    public function getTabs(): array
{
    return [
        'Todos' => Tab::make()
            ->icon('heroicon-o-squares-2x2')
             ->badgeColor('info')
             ->badge(Post::count()),
        'Publicado' => Tab::make()
            ->icon('heroicon-o-check-circle')
            ->badgeColor('success')
            ->badge(Post::query()->wherestatus('published', true)->count())
            ->modifyQueryUsing(fn (Builder $query) => $query->wherestatus('published', true)),
        'Rascunho' => Tab::make()
            ->icon('heroicon-o-pencil-square')
            ->badgeColor('gray')
            ->badge(Post::query()->wherestatus('draft', true)->count())
            ->modifyQueryUsing(fn (Builder $query) => $query->wherestatus('draft', false)),
        'Arquivado' => Tab::make()
            ->icon('heroicon-o-archive-box')
            ->badgeColor('warning')
            ->badge(Post::query()->wherestatus('archived', true)->count())
            ->modifyQueryUsing(fn (Builder $query) => $query->wherestatus('archived', false)),
    ];
}
}
