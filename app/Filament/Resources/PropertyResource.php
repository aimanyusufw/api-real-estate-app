<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PropertyResource\Pages;
use App\Filament\Resources\PropertyResource\RelationManagers;
use App\Models\Property;
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

class PropertyResource extends Resource
{
    protected static ?string $model = Property::class;

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Wizard::make([
                    Forms\Components\Wizard\Step::make('Main Data')
                        ->schema([
                            Forms\Components\TextInput::make('title')
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
                                ->unique(Property::class, 'slug', fn($record) => $record)
                                ->maxLength(255),
                            Forms\Components\Textarea::make('description_title')
                                ->required()
                                ->rows(3)
                                ->maxLength(255),
                            Forms\Components\Textarea::make('short_description')
                                ->required()
                                ->rows(3)
                                ->maxLength(255),
                            Forms\Components\Select::make('agent_id')
                                ->required()
                                ->searchable()
                                ->relationship(name: 'agent', titleAttribute: 'name'),

                            Forms\Components\TextInput::make('price')
                                ->required()
                                ->numeric()
                                ->prefix('Rp'),

                            Forms\Components\RichEditor::make('description')
                                ->required()
                                ->columnSpanFull(),
                        ]),

                    Forms\Components\Wizard\Step::make('Specification')
                        ->schema([
                            Forms\Components\Select::make('property_location_id')
                                ->prefix("📌")
                                ->required()
                                ->searchable()
                                ->relationship(name: 'location', titleAttribute: 'name'),
                            Forms\Components\Select::make('property_type_id')
                                ->required()
                                ->searchable()
                                ->relationship(name: 'type', titleAttribute: 'name'),
                            Forms\Components\TextInput::make('specification.bedroom')
                                ->prefix("🛏️")
                                ->label('Bedroom')
                                ->required(),
                            Forms\Components\TextInput::make('specification.bathroom')
                                ->prefix("🛁")
                                ->label('Bathroom')
                                ->required(),
                            Forms\Components\TextInput::make('specification.land_area')
                                ->prefix("🎍")
                                ->suffix("m²")
                                ->label('Land Area')
                                ->required(),
                            Forms\Components\TextInput::make('specification.building_area')
                                ->prefix("🏨")
                                ->suffix("m²")
                                ->label('Building Area')
                                ->required(),
                            Forms\Components\TextInput::make('specification.electricity')
                                ->prefix("⚡")
                                ->label('Electricity')
                                ->suffix("volt")
                                ->required(),
                            Forms\Components\TextInput::make('specification.rent_period')
                                ->prefix("🔃")
                                ->suffix("month")
                                ->label('Rent Period')
                                ->required(),
                            Forms\Components\TextInput::make('specification.price_per_m2')
                                ->prefix("Rp")
                                ->label('Price m2')
                                ->required(),
                            Forms\Components\CheckboxList::make('typeSales')
                                ->relationship('typeSales', 'name')
                                ->required()
                                ->columns(2),
                            Forms\Components\Radio::make('specification.certificate')
                                ->label('Certificate')
                                ->columns(2)
                                ->options([
                                    "SHM" => 'SHM',
                                    "SHB" => 'SHB',
                                    "AJB" => 'AJB',
                                    "SHSRS" => 'SHSRS',
                                ])
                                ->required()
                        ]),
                    Forms\Components\Wizard\Step::make('Galleries')
                        ->schema([
                            Forms\Components\FileUpload::make('thumbnail')
                                ->image()
                                ->columnSpanFull()
                                ->maxSize(10240)
                                ->disk('public')
                                ->directory('property')
                                ->imageEditor()
                                ->imageCropAspectRatio('16:10')
                                ->required(),
                            Forms\Components\Repeater::make('galleries')
                                ->schema([
                                    Forms\Components\FileUpload::make('image')
                                        ->image()
                                        ->maxSize(5120)
                                        ->disk('public')
                                        ->directory('property')
                                        ->imageEditor()
                                        ->imageCropAspectRatio('16:9')
                                        ->required(),
                                ])->columnSpanFull()
                                ->grid(2),
                        ]),
                ])
                    ->columns(['sm' => 2])
                    ->columnSpan(2),
                Forms\Components\Section::make([
                    Forms\Components\Placeholder::make('created at')
                        ->content(fn(?Property $record): string => $record ? $record->created_at->diffForHumans() : '-'),

                    Forms\Components\Placeholder::make('updated at')
                        ->content(fn(?Property $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
                ])
                    ->columnSpan(1),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->alignCenter()
                    ->circular(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('location.name')
                    ->label("Location")
                    ->searchable(),
                Tables\Columns\TextColumn::make('agent.name')
                    ->label("Agent")
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->formatStateUsing(fn(string $state): string => 'Rp ' . number_format($state, 0, ',', '.'))
                    ->sortable(),
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
            'index' => Pages\ListProperties::route('/'),
            'create' => Pages\CreateProperty::route('/create'),
            'edit' => Pages\EditProperty::route('/{record}/edit'),
        ];
    }
}
