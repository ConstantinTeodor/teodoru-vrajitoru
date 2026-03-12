<?php

namespace App\Filament\Resources\ExerciseResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Table;

class EquipmentRelationManager extends RelationManager
{
    protected static string $relationship = 'equipment';

    protected static ?string $title = 'Required Equipment';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('pivot.is_primary')
                    ->label('Primary')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->label('Attach equipment')
                    ->preloadRecordSelect()
                    ->recordSelectSearchColumns(['name'])
                    ->form(fn (AttachAction $action): array => [
                        $action->getRecordSelect(),
                        Forms\Components\Toggle::make('is_primary')
                            ->label('Primary equipment')
                            ->default(false),
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('toggle_primary')
                    ->label(fn ($record): string => $record->pivot?->is_primary ? 'Unset primary' : 'Set primary')
                    ->icon('heroicon-o-star')
                    ->color(fn ($record): string => $record->pivot?->is_primary ? 'gray' : 'warning')
                    ->action(function ($record): void {
                        $isCurrentlyPrimary = (bool) $record->pivot?->is_primary;

                        if ($isCurrentlyPrimary) {
                            $this->getRelationship()->updateExistingPivot($record->getKey(), ['is_primary' => false]);

                            return;
                        }

                        $this->getRelationship()
                            ->newPivotStatement()
                            ->where('exercise_id', $this->ownerRecord->getKey())
                            ->update(['is_primary' => false]);

                        $this->getRelationship()->updateExistingPivot($record->getKey(), ['is_primary' => true]);
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
