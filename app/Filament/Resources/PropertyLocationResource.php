<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PropertyLocationResource\Pages;
use App\Filament\Resources\PropertyLocationResource\RelationManagers;
use App\Models\PropertyLocation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Filament\Forms\Get;
use Filament\Forms\Set;

class PropertyLocationResource extends Resource
{
    protected static ?string $model = PropertyLocation::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';

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
                        }),
                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->readOnly()
                        ->unique(PropertyLocation::class, 'slug', fn($record) => $record),
                    Forms\Components\Textarea::make('description')
                        ->required()
                        ->maxLength(255)
                        ->rows(5)
                        ->columnSpanFull()
                ])->columns(['sm' => 2])->columnSpan(2),
                Forms\Components\Section::make([
                    Forms\Components\Placeholder::make('created at')
                        ->content(fn(?PropertyLocation $record) => $record ? $record->created_at->diffForHumans() : "-"),
                    Forms\Components\Placeholder::make('updated at')
                        ->content(fn(?PropertyLocation $record) => $record ? $record->updated_at->diffForHumans() : "-"),
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
            ])
            ->defaultSort('property_location_id')
            ->actions([])
            ->bulkActions([]);
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
            'index' => Pages\ListPropertyLocations::route('/'),
            'create' => Pages\CreatePropertyLocation::route('/create'),
            'edit' => Pages\EditPropertyLocation::route('/{record}/edit'),
        ];
    }
}
