<?php

namespace App\Filament\Resources\Prospectuses;

use App\Filament\Resources\Prospectuses\Pages\ManageProspectuses;
use App\Models\Subject;
use App\Models\Curriculum;
use App\Models\Prospectus;
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

class ProspectusResource extends Resource
{
    protected static ?string $model = Prospectus::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleGroup;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('curriculum_id')
                    ->label('Curriculum')
                    ->options(
                        Curriculum::all()->pluck('id')->mapWithKeys(function ($id) {
                            $curriculum = Curriculum::find($id);
                            return [$id => "{$curriculum->curriculum} - {$curriculum->course->code}"];
                        })
                    )
                    ->native(false)
                    ->required(),
                Select::make('subject_id')
                    ->label('Subject')
                    ->options(
                        Subject::all()->pluck('id')->mapWithKeys(function ($id) {
                            $subject = Subject::find($id);
                            return [$id => "{$subject->code} - {$subject->description}"];
                        })
                    )
                    ->native(false)
                    ->required(),
                Select::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ])
                    ->native(false)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('curriculum.curriculum')
                    ->label('Curriculum')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('subject.code')
                    ->label('Subject')
                    ->sortable()
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
            'index' => ManageProspectuses::route('/'),
        ];
    }
}
