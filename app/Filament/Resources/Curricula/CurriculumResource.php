<?php

namespace App\Filament\Resources\Curricula;

use App\Filament\Resources\Curricula\Pages\ManageCurricula;
use App\Models\Curriculum;
use App\Models\Course;
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

class CurriculumResource extends Resource
{
    protected static ?string $model = Curriculum::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'curriculum';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('curriculum')
                    ->required()
                    ->columnSpanFull(),
                Select::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ])
                    ->native(false)
                    ->required(),
                Select::make('course_id')
                    ->label('Course')
                    ->options(
                        Course::all()->pluck('id')->mapWithKeys(function ($id) {
                            $course = Course::find($id);
                            return [$id => "{$course->code} - {$course->description}"];
                        })
                    )
                    ->native(false)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('curriculum')
            ->columns([
                TextColumn::make('curriculum')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('course.description')
                    ->label('Course')
                    ->sortable()
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
            'index' => ManageCurricula::route('/'),
        ];
    }
}
