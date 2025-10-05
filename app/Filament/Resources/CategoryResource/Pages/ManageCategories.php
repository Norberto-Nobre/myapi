<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Category;

class ManageCategories extends ManageRecords
{
   
    
    protected static string $resource = CategoryResource::class;

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
             ->badge(Category::count()),
        'activos' => Tab::make()
            ->icon('heroicon-o-check-circle')
            ->badgeColor('success')
             ->badge(Category::query()->where('is_active', true)->count())
            ->modifyQueryUsing(fn (Builder $query) => $query->where('is_active', true)),
        'inactivos' => Tab::make()
            ->icon('heroicon-o-x-circle')
            ->badgeColor('warning')
            ->badge(Category::query()->where('is_active', false)->count())
            ->modifyQueryUsing(fn (Builder $query) => $query->where('is_active', false)),
    ];
}
}
