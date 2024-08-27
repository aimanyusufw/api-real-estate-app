<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AgentResource\Pages;
use App\Filament\Resources\AgentResource\RelationManagers;
use App\Models\Agent;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AgentResource extends Resource
{
    protected static ?string $model = Agent::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('phone')
                        ->tel()
                        ->required()
                        ->maxLength(255),
                    Forms\Components\FileUpload::make('profile_picture')
                        ->required()
                        ->image()
                        ->disk('public')
                        ->imageEditor()
                        ->imageCropAspectRatio("1:1")
                        ->maxSize(5120)
                        ->directory('agents')
                        ->columnSpan(['sm' => 2]),
                    Forms\Components\RichEditor::make('description')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('total_property')
                        ->required()
                        ->numeric(),
                    Forms\Components\TextInput::make('total_sold_property')
                        ->required()
                        ->numeric(),
                    Forms\Components\TextInput::make('price_range_property')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->required()
                        ->maxLength(255),
                    Forms\Components\DatePicker::make('joined_date')
                        ->default(now())
                        ->required(),
                    Forms\Components\Repeater::make('social_media_links')
                        ->schema([
                            Forms\Components\TextInput::make('platform')
                                ->required(),
                            Forms\Components\TextInput::make('url')
                                ->required(),
                        ]),
                ])
                    ->columns(["md" => 2])
                    ->columnSpan(2),
                Forms\Components\Section::make([
                    Forms\Components\Placeholder::make("created at")
                        ->content(fn(?Agent $record) => $record ? $record->created_at->diffForHumans() : "-"),
                    Forms\Components\Placeholder::make("updated at")
                        ->content(fn(?Agent $record) => $record ? $record->updated_at->diffForHumans() : "-")
                ])->columnSpan(1)
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('profile_picture')
                    ->circular(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('joined_date')
                    ->since()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
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
            'index' => Pages\ListAgents::route('/'),
            'create' => Pages\CreateAgent::route('/create'),
            'edit' => Pages\EditAgent::route('/{record}/edit'),
        ];
    }
}
