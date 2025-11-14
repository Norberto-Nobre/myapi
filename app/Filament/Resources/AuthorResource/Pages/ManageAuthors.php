<?php

namespace App\Filament\Resources\AuthorResource\Pages;

use App\Filament\Resources\AuthorResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Author;

class ManageAuthors extends ManageRecords
{
    protected static string $resource = AuthorResource::class;

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
             ->badge(Author::count()),
        'activos' => Tab::make()
            ->icon('heroicon-o-check-circle')
            ->badgeColor('success')
             ->badge(Author::query()->where('is_active', true)->count())
            ->modifyQueryUsing(fn (Builder $query) => $query->where('is_active', true)),
        'inactivos' => Tab::make()
            ->icon('heroicon-o-x-circle')
            ->badgeColor('warning')
            ->badge(Author::query()->where('is_active', false)->count())
            ->modifyQueryUsing(fn (Builder $query) => $query->where('is_active', false)),
    ];
}
}
