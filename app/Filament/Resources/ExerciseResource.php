<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExerciseResource\Pages\CreateExercise;
use App\Filament\Resources\ExerciseResource\Pages\EditExercise;
use App\Filament\Resources\ExerciseResource\Pages\ListExercises;
use App\Filament\Resources\ExerciseResource\RelationManagers\EquipmentRelationManager;
use App\Models\Exercise;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ExerciseResource extends Resource
{
    protected static ?string $model = Exercise::class;

    protected static ?string $navigationIcon = 'heroicon-o-fire';

    protected static ?string $navigationGroup = 'Catalog';

    protected static ?int $navigationSort = 11;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Exercise Details')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (?string $state, Forms\Set $set, Forms\Get $get): void {
                                if (blank($get('slug'))) {
                                    $set('slug', Str::slug((string) $state));
                                }
                            }),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Forms\Components\Select::make('muscle_group')
                            ->options(self::muscleGroupOptions())
                            ->searchable()
                            ->placeholder('Select a muscle group'),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                        Forms\Components\Textarea::make('description')
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('muscle_group')
                    ->label('Muscle Group')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('equipment_count')
                    ->counts('equipment')
                    ->label('Equipment')
                    ->sortable(),
                Tables\Columns\TextColumn::make('workout_exercises_count')
                    ->counts('workoutExercises')
                    ->label('Times Used')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime('M j, Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('muscle_group')
                    ->options(self::muscleGroupOptions()),
                Tables\Filters\TernaryFilter::make('is_active')->label('Active'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            EquipmentRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListExercises::route('/'),
            'create' => CreateExercise::route('/create'),
            'edit' => EditExercise::route('/{record}/edit'),
        ];
    }

    /**
     * @return array<string, string>
     */
    protected static function muscleGroupOptions(): array
    {
        return [
            'chest' => 'Chest',
            'back' => 'Back',
            'legs' => 'Legs',
            'shoulders' => 'Shoulders',
            'biceps' => 'Biceps',
            'triceps' => 'Triceps',
            'core' => 'Core',
            'full_body' => 'Full Body',
            'cardio' => 'Cardio',
            'other' => 'Other',
        ];
    }
}
