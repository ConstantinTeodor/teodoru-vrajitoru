<?php

namespace App\Filament\Resources\EquipmentResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Table;

class ExercisesRelationManager extends RelationManager
{
    protected static string $relationship = 'exercises';

    protected static ?string $title = 'Supported Exercises';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('muscle_group')
                    ->label('Muscle Group')
                    ->badge(),
                Tables\Columns\IconColumn::make('pivot.is_primary')
                    ->label('Primary')
                    ->boolean(),
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->label('Attach exercise')
                    ->preloadRecordSelect()
                    ->recordSelectSearchColumns(['name'])
                    ->form(fn (AttachAction $action): array => [
                        $action->getRecordSelect(),
                        Forms\Components\Toggle::make('is_primary')
                            ->label('Primary for this exercise')
                            ->default(false),
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('toggle_primary')
                    ->label(fn ($record): string => $record->pivot?->is_primary ? 'Unset primary' : 'Set primary')
                    ->icon('heroicon-o-star')
                    ->color(fn ($record): string => $record->pivot?->is_primary ? 'gray' : 'warning')
                    ->action(function ($record): void {
                        $this->getRelationship()->updateExistingPivot(
                            $record->getKey(),
                            ['is_primary' => ! ((bool) $record->pivot?->is_primary)]
                        );
                    })
                    ->requiresConfirmation(),
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ]);
    }
}
