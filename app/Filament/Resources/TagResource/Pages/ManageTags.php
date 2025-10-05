<?php

namespace App\Filament\Resources\TagResource\Pages;

use App\Filament\Resources\TagResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Tag;

class ManageTags extends ManageRecords
{
    protected static string $resource = TagResource::class;

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
                 ->badge(Tag::count()),
            'activos' => Tab::make()
                ->icon('heroicon-o-check-circle')
                ->badgeColor('success')
                 ->badge(Tag::query()->where('is_active', true)->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_active', true)),
            'inactivos' => Tab::make()
                ->icon('heroicon-o-x-circle')
                ->badgeColor('warning')
                ->badge(Tag::query()->where('is_active', false)->count())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_active', false)),
        ];
    }
}
