<?php

namespace App\Filament\Resources\Subjects;

use App\Filament\Resources\Subjects\Pages\ManageSubjects;
use App\Models\Subject;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
    use Filament\Tables\Table;
    // forms
    use Filament\Forms\Components\TextInput;
    use Filament\Forms\Components\Textarea;
    use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;


class SubjectResource extends Resource
{
    protected static ?string $model = Subject::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;

    protected static ?string $recordTitleAttribute = 'code';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Subject Details')
                    ->schema([
                        // fill this copilot
                        TextInput::make('code')
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('description')
                            ->required()
                            ->columnSpanFull(),
                        Select::make('status')
                            ->options([
                                'active' => 'Active',
                                'inactive' => 'Inactive',
                            ])
                            ->native(false)
                            ->required(),
                    ]),
                Section::make('Subject Info')
                    ->schema([
                        TextInput::make('unit')
                            ->numeric()
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('lech')
                            ->label('Lecture Hour')
                            ->numeric()
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('lecu')
                            ->label('Lecture Unit')
                            ->numeric()
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('labh')
                            ->label('Laboratory Hour')
                            ->numeric()
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('labu')
                            ->label('Laboratory Unit')
                            ->numeric()
                            ->required()
                            ->columnSpanFull(),
                        Select::make('type')
                            ->options([
                                'lecture' => 'Lecture',
                                'lab' => 'Laboratory',
                                'lec lab' => 'Lecture + Laboratory',
                            ])
                            ->native(false)
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('code')
            ->columns([
                TextColumn::make('code')
                    ->label('Subject Code')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('description')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('unit')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('lech')
                    ->label('Lec Hour')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('lecu')
                    ->label('Lec Unit')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('labh')
                    ->label('Lab Hour')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('labu')
                    ->label('Lab Unit')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('type')
                    ->searchable(),
                TextColumn::make('status')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageSubjects::route('/'),
        ];
    }
}
