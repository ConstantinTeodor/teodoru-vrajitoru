<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WorkoutResource\Pages;
use App\Models\Exercise;
use App\Models\User;
use App\Models\Workout;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class WorkoutResource extends Resource
{
    protected static ?string $model = Workout::class;

    protected static ?string $navigationIcon = 'heroicon-o-heart';

    protected static ?string $navigationGroup = 'Training';

    protected static ?int $navigationSort = 20;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Workout Details')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('Athlete')
                            ->relationship(
                                name: 'user',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn (Builder $query) => $query->orderBy('name')
                            )
                            ->getOptionLabelFromRecordUsing(fn (User $record): string => "{$record->name} ({$record->email})")
                            ->searchable(['name', 'email'])
                            ->preload()
                            ->required(),
                        Forms\Components\DateTimePicker::make('performed_at')
                            ->label('Performed At')
                            ->seconds(false)
                            ->default(fn (): \DateTimeInterface => now())
                            ->required(),
                        Forms\Components\TextInput::make('title')
                            ->maxLength(255)
                            ->placeholder('Push Day / Upper Body / Leg Day...'),
                        Forms\Components\TextInput::make('duration_minutes')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(1000)
                            ->suffix('min'),
                        Forms\Components\Textarea::make('notes')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                Forms\Components\Section::make('Exercise Log')
                    ->description('Capture each exercise and every performed set.')
                    ->schema([
                        Forms\Components\Repeater::make('workoutExercises')
                            ->relationship()
                            ->label('Exercises')
                            ->addActionLabel('Add exercise')
                            ->defaultItems(1)
                            ->reorderableWithButtons()
                            ->orderColumn('order')
                            ->cloneable()
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => data_get($state, 'exercise_name_snapshot'))
                            ->schema([
                                Forms\Components\Select::make('exercise_id')
                                    ->label('Exercise')
                                    ->relationship('exercise', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function (?int $state, Set $set): void {
                                        if (blank($state)) {
                                            return;
                                        }

                                        $exerciseName = Exercise::query()->whereKey($state)->value('name');

                                        if (filled($exerciseName)) {
                                            $set('exercise_name_snapshot', $exerciseName);
                                        }
                                    }),
                                Forms\Components\TextInput::make('exercise_name_snapshot')
                                    ->label('Snapshot Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->helperText('Saved to preserve historical logs if the exercise name changes.'),
                                Forms\Components\Textarea::make('notes')
                                    ->rows(2)
                                    ->columnSpanFull(),
                                Forms\Components\Repeater::make('sets')
                                    ->relationship()
                                    ->label('Sets')
                                    ->addActionLabel('Add set')
                                    ->defaultItems(1)
                                    ->orderColumn('set_number')
                                    ->collapsible()
                                    ->collapsed()
                                    ->itemLabel(fn (array $state): string => 'Set ' . (data_get($state, 'set_number') ?? '?'))
                                    ->schema([
                                        Forms\Components\TextInput::make('reps')
                                            ->numeric()
                                            ->minValue(0)
                                            ->maxValue(1000)
                                            ->required(),
                                        Forms\Components\TextInput::make('weight')
                                            ->numeric()
                                            ->minValue(0)
                                            ->step(0.25),
                                        Forms\Components\Select::make('weight_unit')
                                            ->options([
                                                'kg' => 'kg',
                                                'lb' => 'lb',
                                            ])
                                            ->default('kg')
                                            ->required(),
                                        Forms\Components\Toggle::make('is_warmup')
                                            ->label('Warm-up')
                                            ->default(false),
                                        Forms\Components\TextInput::make('rpe')
                                            ->numeric()
                                            ->minValue(1)
                                            ->maxValue(10)
                                            ->step(0.5),
                                        Forms\Components\TextInput::make('rest_seconds')
                                            ->numeric()
                                            ->minValue(0),
                                        Forms\Components\DateTimePicker::make('performed_at')
                                            ->seconds(false),
                                    ])
                                    ->columns(4)
                                    ->columnSpanFull(),
                            ])
                            ->columns(2)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('performed_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('performed_at')
                    ->label('Performed')
                    ->dateTime('M j, Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Athlete')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->placeholder('Untitled workout'),
                Tables\Columns\TextColumn::make('duration_minutes')
                    ->label('Duration')
                    ->formatStateUsing(fn (?int $state): string => filled($state) ? "{$state} min" : '-'),
                Tables\Columns\TextColumn::make('workout_exercises_count')
                    ->counts('workoutExercises')
                    ->label('Exercises')
                    ->sortable(),
                Tables\Columns\TextColumn::make('workout_sets_count')
                    ->counts('workoutSets')
                    ->label('Sets')
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime('M j, Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('user')
                    ->label('Athlete')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),
                Tables\Filters\Filter::make('performed_at')
                    ->form([
                        Forms\Components\DatePicker::make('from'),
                        Forms\Components\DatePicker::make('until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'] ?? null, fn (Builder $subQuery, string $date) => $subQuery->whereDate('performed_at', '>=', $date))
                            ->when($data['until'] ?? null, fn (Builder $subQuery, string $date) => $subQuery->whereDate('performed_at', '<=', $date));
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWorkouts::route('/'),
            'create' => Pages\CreateWorkout::route('/create'),
            'edit' => Pages\EditWorkout::route('/{record}/edit'),
        ];
    }
}

