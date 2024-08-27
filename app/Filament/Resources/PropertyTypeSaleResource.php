<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PropertyTypeSaleResource\Pages;
use App\Filament\Resources\PropertyTypeSaleResource\RelationManagers;
use App\Models\PropertyTypeSale;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PropertyTypeSaleResource extends Resource
{
    protected static ?string $model = PropertyTypeSale::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->live(debounce: 200)
                        ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state) {
                            if (($get('slug') ?? '') !== Str::slug($old)) {
                                return;
                            }

                            $set('slug', Str::slug($state));
                        })
                        ->maxLength(255),
                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->readOnly()
                        ->unique(PropertyTypeSale::class, 'slug', fn($record) => $record)
                        ->maxLength(255),
                    Forms\Components\Textarea::make('description')
                        ->rows(5)
                        ->columnSpanFull()
                        ->required()
                        ->maxLength(255),
                ])->columns(['sm' => 2])->columnSpan(2),
                Forms\Components\Section::make([
                    Forms\Components\Placeholder::make('created at')
                        ->content(fn(?PropertyTypeSale $record): string => $record ? $record->created_at->diffForHumans() : ''),
                    Forms\Components\Placeholder::make('updated at')
                        ->content(fn(?PropertyTypeSale $record): string => $record ? $record->updated_at->diffForHumans() : '')
                ])->columnSpan(1),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->since()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
            'index' => Pages\ListPropertyTypeSales::route('/'),
            'create' => Pages\CreatePropertyTypeSale::route('/create'),
            'edit' => Pages\EditPropertyTypeSale::route('/{record}/edit'),
        ];
    }
}
