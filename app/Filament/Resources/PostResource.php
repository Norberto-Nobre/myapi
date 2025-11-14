<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Grid;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\TagsInput;
use Illuminate\Support\Str;
use Filament\Forms\Components\MarkdownEditor;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    
        public static function getNavigationBadge(): ?string
    {
        return Post::count() > 0 ? (string) Post::count() : null;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                     ->label('Título')
    ->required()
    ->debounce(5000) // reduz chamadas rápidas demais
    ->afterStateUpdated(function ($state, callable $set) {
        if (!empty($state)) {
            $set('slug', Str::slug($state));
        }
    })
    ->maxLength(255),
                Forms\Components\TextInput::make('slug')
                     ->disabled()
                    ->dehydrated()
                    ->maxLength(255),
                Forms\Components\TextInput::make('excerpt')
                    ->label('Resumo'),
                Forms\Components\FileUpload::make('featured_image')
                    ->label('Capa (tamanho recomendado: 4656x3104)')
                    ->image(),
                Forms\Components\RichEditor::make('content')
                    ->toolbarButtons([
                        'attachFiles',
                        'blockquote',
                        'bold',
                        'bulletList',
                        'codeBlock',
                        'h1',
                        'h2',
                        'h3',
                        'italic',
                        'link',
                        'orderedList',
                        'redo',
                        'strike',
                        'underline',
                        'undo',
                    ])
                    ->label('Conteudo')
                    ->required()
                    ->columnSpanFull(),
                Grid::make(3) // ← 3 colunas na mesma linha
                    ->schema([
                         Forms\Components\Select::make('author_id')
                            ->label('Autor')
                            ->relationship('author', 'name')
                            ->required(),
                        Forms\Components\Select::make('category_id')
                            ->label('Categoria')
                            ->relationship('category', 'name')
                            ->required(),
                        Forms\Components\Select::make('status')
                            ->options([
                                'draft' => 'Rascunho',
                                'archived' => 'Arquivado',
                                'published' => 'Publicado',
                            ])
                    ]),
                Grid::make(3) // ← 3 colunas na mesma linha
                    ->schema([
                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('Data da Publicação'),
                        Forms\Components\TextInput::make('views_count')
                            ->label('Visualizações')
                            ->required()
                            ->numeric()
                            ->default(0),
                        Forms\Components\Select::make('tags')
                            ->relationship('tags', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->label('Tags')
                    ]),
                        Forms\Components\TextInput::make('meta_title')
                            ->maxLength(255)
                            ->default(null),
                        Forms\Components\Textarea::make('meta_description'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image'),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('author.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                     ->formatStateUsing(function (string $state): string {
                        return match ($state) {
                            'draft' => 'Rascunho',
                            'published' => 'Publicado',
                            'archived' => 'Arquivado',
                            default => ucfirst($state),
                        };
                    })
                    ->colors([
                        'draft' => 'gray',
                        'published' => 'success',
                        'archived' => 'danger',
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('meta_title')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('views_count')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
