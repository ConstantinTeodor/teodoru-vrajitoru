<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $now = now();

        /*
         * Dataset notes:
         * - Aligned with a modern commercial gym setup (like Boris Gym: strength + cardio zones).
         * - Large practical starter catalog for production use.
         */
        $equipmentCatalog = [
            ['slug' => 'bodyweight', 'name' => 'Bodyweight', 'description' => 'No external equipment required.'],
            ['slug' => 'barbell', 'name' => 'Barbell', 'description' => 'Olympic barbell variations and loaded lifts.'],
            ['slug' => 'ez-bar', 'name' => 'EZ Bar', 'description' => 'Curved bar commonly used for arm movements.'],
            ['slug' => 'dumbbell', 'name' => 'Dumbbell', 'description' => 'Free weights for unilateral and bilateral work.'],
            ['slug' => 'kettlebell', 'name' => 'Kettlebell', 'description' => 'Ballistic and strength-focused weighted tool.'],
            ['slug' => 'trap-bar', 'name' => 'Trap Bar', 'description' => 'Hex bar for deadlift and carry variations.'],
            ['slug' => 'landmine', 'name' => 'Landmine Attachment', 'description' => 'Barbell anchor point for landmine patterns.'],
            ['slug' => 'resistance-band', 'name' => 'Resistance Band', 'description' => 'Elastic resistance for mobility and strength.'],
            ['slug' => 'medicine-ball', 'name' => 'Medicine Ball', 'description' => 'Weighted ball for throws, slams, and core work.'],
            ['slug' => 'battle-ropes', 'name' => 'Battle Ropes', 'description' => 'Conditioning ropes for high-output intervals.'],
            ['slug' => 'jump-rope', 'name' => 'Jump Rope', 'description' => 'Skipping rope for cardio and coordination.'],
            ['slug' => 'ab-wheel', 'name' => 'Ab Wheel', 'description' => 'Rollout wheel for anti-extension core training.'],
            ['slug' => 'pull-up-bar', 'name' => 'Pull-Up Bar', 'description' => 'Fixed bar for pull-up and hanging core work.'],
            ['slug' => 'dip-bars', 'name' => 'Dip Bars', 'description' => 'Parallel bars used for dip variations.'],
            ['slug' => 'flat-bench', 'name' => 'Flat Bench', 'description' => 'Bench for pressing and supported movements.'],
            ['slug' => 'adjustable-bench', 'name' => 'Adjustable Bench', 'description' => 'Bench with incline/decline settings.'],
            ['slug' => 'squat-rack', 'name' => 'Squat Rack', 'description' => 'Rack with J-hooks/safeties for squats and presses.'],
            ['slug' => 'power-rack', 'name' => 'Power Rack', 'description' => 'Full cage for heavy compound training.'],
            ['slug' => 'smith-machine', 'name' => 'Smith Machine', 'description' => 'Guided bar path machine for assisted lifts.'],
            ['slug' => 'cable-machine', 'name' => 'Cable Machine', 'description' => 'Pulley-based machine for varied resistance vectors.'],
            ['slug' => 'lat-pulldown-machine', 'name' => 'Lat Pulldown Machine', 'description' => 'Machine for vertical pulling patterns.'],
            ['slug' => 'seated-row-machine', 'name' => 'Seated Row Machine', 'description' => 'Machine for horizontal pulling patterns.'],
            ['slug' => 'chest-press-machine', 'name' => 'Chest Press Machine', 'description' => 'Machine pressing movement for chest and triceps.'],
            ['slug' => 'pec-deck-machine', 'name' => 'Pec Deck Machine', 'description' => 'Machine fly movement for chest isolation.'],
            ['slug' => 'shoulder-press-machine', 'name' => 'Shoulder Press Machine', 'description' => 'Machine pressing movement for deltoids.'],
            ['slug' => 'assisted-pull-up-machine', 'name' => 'Assisted Pull-Up Machine', 'description' => 'Counterweighted pull-up and dip station.'],
            ['slug' => 'leg-press-machine', 'name' => 'Leg Press Machine', 'description' => 'Machine for lower body pressing.'],
            ['slug' => 'hack-squat-machine', 'name' => 'Hack Squat Machine', 'description' => 'Guided squat pattern machine.'],
            ['slug' => 'leg-extension-machine', 'name' => 'Leg Extension Machine', 'description' => 'Machine for quadriceps isolation.'],
            ['slug' => 'leg-curl-machine', 'name' => 'Leg Curl Machine', 'description' => 'Machine for hamstring isolation.'],
            ['slug' => 'calf-raise-machine', 'name' => 'Calf Raise Machine', 'description' => 'Machine for gastrocnemius and soleus work.'],
            ['slug' => 'ab-crunch-machine', 'name' => 'Ab Crunch Machine', 'description' => 'Machine-assisted spinal flexion movement.'],
            ['slug' => 'back-extension-bench', 'name' => 'Back Extension Bench', 'description' => 'Bench for posterior chain extension work.'],
            ['slug' => 'hip-thrust-machine', 'name' => 'Hip Thrust Machine', 'description' => 'Machine for glute-dominant hip extension.'],
            ['slug' => 'glute-drive-machine', 'name' => 'Glute Drive Machine', 'description' => 'Dedicated glute drive movement station.'],
            ['slug' => 'weighted-sled', 'name' => 'Weighted Sled', 'description' => 'Push/pull conditioning and power tool.'],
            ['slug' => 'treadmill', 'name' => 'Treadmill', 'description' => 'Indoor running and incline walking machine.'],
            ['slug' => 'stationary-bike', 'name' => 'Stationary Bike', 'description' => 'Low-impact cycling cardio machine.'],
            ['slug' => 'air-bike', 'name' => 'Air Bike', 'description' => 'Fan bike for high-intensity interval training.'],
            ['slug' => 'elliptical', 'name' => 'Elliptical', 'description' => 'Low-impact full-body cardio machine.'],
            ['slug' => 'rower', 'name' => 'Rower', 'description' => 'Ergometer for rowing-based conditioning.'],
            ['slug' => 'stair-climber', 'name' => 'Stair Climber', 'description' => 'Cardio machine simulating stair ascent.'],
            ['slug' => 'ski-erg', 'name' => 'Ski Erg', 'description' => 'Upper-body dominant ergometer machine.'],
            ['slug' => 'heavy-bag', 'name' => 'Heavy Bag', 'description' => 'Boxing and striking conditioning bag.'],
            ['slug' => 'foam-roller', 'name' => 'Foam Roller', 'description' => 'Recovery and mobility self-myofascial release tool.'],
        ];

        DB::table('equipment')->upsert(
            collect($equipmentCatalog)->map(fn (array $item): array => [
                'slug' => $item['slug'],
                'name' => $item['name'],
                'description' => $item['description'],
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ])->all(),
            ['slug'],
            ['name', 'description', 'is_active', 'updated_at']
        );

        $exerciseCatalog = [
            // Legs
            ['name' => 'Back Squat', 'muscle_group' => 'legs', 'equipment' => ['barbell', 'squat-rack']],
            ['name' => 'Front Squat', 'muscle_group' => 'legs', 'equipment' => ['barbell', 'squat-rack']],
            ['name' => 'Goblet Squat', 'muscle_group' => 'legs', 'equipment' => ['dumbbell']],
            ['name' => 'Hack Squat', 'muscle_group' => 'legs', 'equipment' => ['hack-squat-machine']],
            ['name' => 'Leg Press', 'muscle_group' => 'legs', 'equipment' => ['leg-press-machine']],
            ['name' => 'Walking Lunge', 'muscle_group' => 'legs', 'equipment' => ['dumbbell']],
            ['name' => 'Reverse Lunge', 'muscle_group' => 'legs', 'equipment' => ['dumbbell']],
            ['name' => 'Bulgarian Split Squat', 'muscle_group' => 'legs', 'equipment' => ['dumbbell', 'adjustable-bench']],
            ['name' => 'Step-Up', 'muscle_group' => 'legs', 'equipment' => ['dumbbell', 'flat-bench']],
            ['name' => 'Romanian Deadlift', 'muscle_group' => 'legs', 'equipment' => ['barbell']],
            ['name' => 'Stiff-Leg Deadlift', 'muscle_group' => 'legs', 'equipment' => ['barbell']],
            ['name' => 'Conventional Deadlift', 'muscle_group' => 'legs', 'equipment' => ['barbell']],
            ['name' => 'Sumo Deadlift', 'muscle_group' => 'legs', 'equipment' => ['barbell']],
            ['name' => 'Trap Bar Deadlift', 'muscle_group' => 'legs', 'equipment' => ['trap-bar']],
            ['name' => 'Hip Thrust', 'muscle_group' => 'legs', 'equipment' => ['barbell', 'flat-bench']],
            ['name' => 'Glute Bridge', 'muscle_group' => 'legs', 'equipment' => ['bodyweight']],
            ['name' => 'Machine Hip Thrust', 'muscle_group' => 'legs', 'equipment' => ['hip-thrust-machine']],
            ['name' => 'Glute Drive', 'muscle_group' => 'legs', 'equipment' => ['glute-drive-machine']],
            ['name' => 'Leg Extension', 'muscle_group' => 'legs', 'equipment' => ['leg-extension-machine']],
            ['name' => 'Seated Leg Curl', 'muscle_group' => 'legs', 'equipment' => ['leg-curl-machine']],
            ['name' => 'Lying Leg Curl', 'muscle_group' => 'legs', 'equipment' => ['leg-curl-machine']],
            ['name' => 'Standing Calf Raise', 'muscle_group' => 'legs', 'equipment' => ['calf-raise-machine']],
            ['name' => 'Seated Calf Raise', 'muscle_group' => 'legs', 'equipment' => ['calf-raise-machine']],
            ['name' => 'Cossack Squat', 'muscle_group' => 'legs', 'equipment' => ['bodyweight']],
            ['name' => 'Box Jump', 'muscle_group' => 'legs', 'equipment' => ['bodyweight']],

            // Chest
            ['name' => 'Barbell Bench Press', 'muscle_group' => 'chest', 'equipment' => ['barbell', 'flat-bench']],
            ['name' => 'Incline Barbell Bench Press', 'muscle_group' => 'chest', 'equipment' => ['barbell', 'adjustable-bench']],
            ['name' => 'Decline Barbell Bench Press', 'muscle_group' => 'chest', 'equipment' => ['barbell', 'adjustable-bench']],
            ['name' => 'Dumbbell Bench Press', 'muscle_group' => 'chest', 'equipment' => ['dumbbell', 'flat-bench']],
            ['name' => 'Incline Dumbbell Press', 'muscle_group' => 'chest', 'equipment' => ['dumbbell', 'adjustable-bench']],
            ['name' => 'Dumbbell Fly', 'muscle_group' => 'chest', 'equipment' => ['dumbbell', 'flat-bench']],
            ['name' => 'Cable Chest Fly', 'muscle_group' => 'chest', 'equipment' => ['cable-machine']],
            ['name' => 'Pec Deck Fly', 'muscle_group' => 'chest', 'equipment' => ['pec-deck-machine']],
            ['name' => 'Machine Chest Press', 'muscle_group' => 'chest', 'equipment' => ['chest-press-machine']],
            ['name' => 'Smith Machine Bench Press', 'muscle_group' => 'chest', 'equipment' => ['smith-machine', 'flat-bench']],
            ['name' => 'Push-Up', 'muscle_group' => 'chest', 'equipment' => ['bodyweight']],
            ['name' => 'Weighted Push-Up', 'muscle_group' => 'chest', 'equipment' => ['bodyweight']],
            ['name' => 'Chest Dip', 'muscle_group' => 'chest', 'equipment' => ['dip-bars']],
            ['name' => 'Svend Press', 'muscle_group' => 'chest', 'equipment' => ['dumbbell']],

            // Back
            ['name' => 'Pull-Up', 'muscle_group' => 'back', 'equipment' => ['pull-up-bar']],
            ['name' => 'Chin-Up', 'muscle_group' => 'back', 'equipment' => ['pull-up-bar']],
            ['name' => 'Assisted Pull-Up', 'muscle_group' => 'back', 'equipment' => ['assisted-pull-up-machine']],
            ['name' => 'Lat Pulldown', 'muscle_group' => 'back', 'equipment' => ['lat-pulldown-machine']],
            ['name' => 'Wide Grip Lat Pulldown', 'muscle_group' => 'back', 'equipment' => ['lat-pulldown-machine']],
            ['name' => 'Close Grip Lat Pulldown', 'muscle_group' => 'back', 'equipment' => ['lat-pulldown-machine']],
            ['name' => 'Seated Cable Row', 'muscle_group' => 'back', 'equipment' => ['cable-machine']],
            ['name' => 'Machine Seated Row', 'muscle_group' => 'back', 'equipment' => ['seated-row-machine']],
            ['name' => 'Barbell Row', 'muscle_group' => 'back', 'equipment' => ['barbell']],
            ['name' => 'Pendlay Row', 'muscle_group' => 'back', 'equipment' => ['barbell']],
            ['name' => 'One-Arm Dumbbell Row', 'muscle_group' => 'back', 'equipment' => ['dumbbell', 'flat-bench']],
            ['name' => 'Chest Supported Row', 'muscle_group' => 'back', 'equipment' => ['dumbbell', 'adjustable-bench']],
            ['name' => 'T-Bar Row', 'muscle_group' => 'back', 'equipment' => ['landmine']],
            ['name' => 'Face Pull', 'muscle_group' => 'back', 'equipment' => ['cable-machine']],
            ['name' => 'Straight Arm Pulldown', 'muscle_group' => 'back', 'equipment' => ['cable-machine']],
            ['name' => 'Inverted Row', 'muscle_group' => 'back', 'equipment' => ['squat-rack']],
            ['name' => 'Back Extension', 'muscle_group' => 'back', 'equipment' => ['back-extension-bench']],
            ['name' => 'Good Morning', 'muscle_group' => 'back', 'equipment' => ['barbell']],

            // Shoulders
            ['name' => 'Standing Overhead Press', 'muscle_group' => 'shoulders', 'equipment' => ['barbell']],
            ['name' => 'Seated Dumbbell Shoulder Press', 'muscle_group' => 'shoulders', 'equipment' => ['dumbbell', 'adjustable-bench']],
            ['name' => 'Arnold Press', 'muscle_group' => 'shoulders', 'equipment' => ['dumbbell', 'adjustable-bench']],
            ['name' => 'Machine Shoulder Press', 'muscle_group' => 'shoulders', 'equipment' => ['shoulder-press-machine']],
            ['name' => 'Lateral Raise', 'muscle_group' => 'shoulders', 'equipment' => ['dumbbell']],
            ['name' => 'Cable Lateral Raise', 'muscle_group' => 'shoulders', 'equipment' => ['cable-machine']],
            ['name' => 'Front Raise', 'muscle_group' => 'shoulders', 'equipment' => ['dumbbell']],
            ['name' => 'Rear Delt Fly', 'muscle_group' => 'shoulders', 'equipment' => ['dumbbell', 'adjustable-bench']],
            ['name' => 'Cable Rear Delt Fly', 'muscle_group' => 'shoulders', 'equipment' => ['cable-machine']],
            ['name' => 'Upright Row', 'muscle_group' => 'shoulders', 'equipment' => ['ez-bar']],
            ['name' => 'Landmine Press', 'muscle_group' => 'shoulders', 'equipment' => ['landmine']],

            // Biceps
            ['name' => 'Barbell Curl', 'muscle_group' => 'biceps', 'equipment' => ['barbell']],
            ['name' => 'EZ Bar Curl', 'muscle_group' => 'biceps', 'equipment' => ['ez-bar']],
            ['name' => 'Alternating Dumbbell Curl', 'muscle_group' => 'biceps', 'equipment' => ['dumbbell']],
            ['name' => 'Hammer Curl', 'muscle_group' => 'biceps', 'equipment' => ['dumbbell']],
            ['name' => 'Incline Dumbbell Curl', 'muscle_group' => 'biceps', 'equipment' => ['dumbbell', 'adjustable-bench']],
            ['name' => 'Concentration Curl', 'muscle_group' => 'biceps', 'equipment' => ['dumbbell']],
            ['name' => 'Preacher Curl', 'muscle_group' => 'biceps', 'equipment' => ['ez-bar']],
            ['name' => 'Cable Curl', 'muscle_group' => 'biceps', 'equipment' => ['cable-machine']],
            ['name' => 'Reverse Curl', 'muscle_group' => 'biceps', 'equipment' => ['ez-bar']],

            // Triceps
            ['name' => 'Close Grip Bench Press', 'muscle_group' => 'triceps', 'equipment' => ['barbell', 'flat-bench']],
            ['name' => 'Skull Crusher', 'muscle_group' => 'triceps', 'equipment' => ['ez-bar', 'flat-bench']],
            ['name' => 'Cable Triceps Pushdown', 'muscle_group' => 'triceps', 'equipment' => ['cable-machine']],
            ['name' => 'Overhead Cable Triceps Extension', 'muscle_group' => 'triceps', 'equipment' => ['cable-machine']],
            ['name' => 'Rope Triceps Extension', 'muscle_group' => 'triceps', 'equipment' => ['cable-machine']],
            ['name' => 'Dumbbell Overhead Triceps Extension', 'muscle_group' => 'triceps', 'equipment' => ['dumbbell']],
            ['name' => 'Bench Dip', 'muscle_group' => 'triceps', 'equipment' => ['flat-bench']],
            ['name' => 'Dumbbell Kickback', 'muscle_group' => 'triceps', 'equipment' => ['dumbbell']],
            ['name' => 'Assisted Dip', 'muscle_group' => 'triceps', 'equipment' => ['assisted-pull-up-machine']],

            // Core
            ['name' => 'Plank', 'muscle_group' => 'core', 'equipment' => ['bodyweight']],
            ['name' => 'Side Plank', 'muscle_group' => 'core', 'equipment' => ['bodyweight']],
            ['name' => 'Dead Bug', 'muscle_group' => 'core', 'equipment' => ['bodyweight']],
            ['name' => 'Bird Dog', 'muscle_group' => 'core', 'equipment' => ['bodyweight']],
            ['name' => 'Hanging Leg Raise', 'muscle_group' => 'core', 'equipment' => ['pull-up-bar']],
            ['name' => 'Toes to Bar', 'muscle_group' => 'core', 'equipment' => ['pull-up-bar']],
            ['name' => 'Cable Crunch', 'muscle_group' => 'core', 'equipment' => ['cable-machine']],
            ['name' => 'Machine Ab Crunch', 'muscle_group' => 'core', 'equipment' => ['ab-crunch-machine']],
            ['name' => 'Ab Wheel Rollout', 'muscle_group' => 'core', 'equipment' => ['ab-wheel']],
            ['name' => 'Russian Twist', 'muscle_group' => 'core', 'equipment' => ['medicine-ball']],
            ['name' => 'Pallof Press', 'muscle_group' => 'core', 'equipment' => ['cable-machine']],
            ['name' => 'Reverse Crunch', 'muscle_group' => 'core', 'equipment' => ['bodyweight']],
            ['name' => 'V-Up', 'muscle_group' => 'core', 'equipment' => ['bodyweight']],
            ['name' => 'Mountain Climber', 'muscle_group' => 'core', 'equipment' => ['bodyweight']],

            // Full body / conditioning
            ['name' => 'Clean and Press', 'muscle_group' => 'full_body', 'equipment' => ['barbell']],
            ['name' => 'Dumbbell Thruster', 'muscle_group' => 'full_body', 'equipment' => ['dumbbell']],
            ['name' => 'Kettlebell Swing', 'muscle_group' => 'full_body', 'equipment' => ['kettlebell']],
            ['name' => 'Turkish Get-Up', 'muscle_group' => 'full_body', 'equipment' => ['kettlebell']],
            ['name' => 'Man Maker', 'muscle_group' => 'full_body', 'equipment' => ['dumbbell']],
            ['name' => 'Burpee', 'muscle_group' => 'full_body', 'equipment' => ['bodyweight']],
            ['name' => 'Farmer Carry', 'muscle_group' => 'full_body', 'equipment' => ['dumbbell']],
            ['name' => 'Sled Push', 'muscle_group' => 'full_body', 'equipment' => ['weighted-sled']],
            ['name' => 'Sled Pull', 'muscle_group' => 'full_body', 'equipment' => ['weighted-sled']],
            ['name' => 'Battle Rope Slams', 'muscle_group' => 'full_body', 'equipment' => ['battle-ropes']],
            ['name' => 'Medicine Ball Slam', 'muscle_group' => 'full_body', 'equipment' => ['medicine-ball']],
            ['name' => 'Heavy Bag Rounds', 'muscle_group' => 'full_body', 'equipment' => ['heavy-bag']],
            ['name' => 'Landmine Squat to Press', 'muscle_group' => 'full_body', 'equipment' => ['landmine']],

            // Cardio
            ['name' => 'Treadmill Run', 'muscle_group' => 'cardio', 'equipment' => ['treadmill']],
            ['name' => 'Incline Treadmill Walk', 'muscle_group' => 'cardio', 'equipment' => ['treadmill']],
            ['name' => 'Stationary Bike Ride', 'muscle_group' => 'cardio', 'equipment' => ['stationary-bike']],
            ['name' => 'Air Bike Intervals', 'muscle_group' => 'cardio', 'equipment' => ['air-bike']],
            ['name' => 'Elliptical Steady State', 'muscle_group' => 'cardio', 'equipment' => ['elliptical']],
            ['name' => 'Rowing Intervals', 'muscle_group' => 'cardio', 'equipment' => ['rower']],
            ['name' => 'Stair Climber Intervals', 'muscle_group' => 'cardio', 'equipment' => ['stair-climber']],
            ['name' => 'Ski Erg Intervals', 'muscle_group' => 'cardio', 'equipment' => ['ski-erg']],
            ['name' => 'Jump Rope Singles', 'muscle_group' => 'cardio', 'equipment' => ['jump-rope']],
            ['name' => 'Jump Rope Double Unders', 'muscle_group' => 'cardio', 'equipment' => ['jump-rope']],

            // Other / mobility-recovery
            ['name' => 'Band Pull Apart', 'muscle_group' => 'other', 'equipment' => ['resistance-band']],
            ['name' => 'Banded Glute Bridge', 'muscle_group' => 'other', 'equipment' => ['resistance-band']],
            ['name' => 'Shoulder External Rotation', 'muscle_group' => 'other', 'equipment' => ['resistance-band']],
            ['name' => 'Foam Roll Quads', 'muscle_group' => 'other', 'equipment' => ['foam-roller']],
            ['name' => 'Foam Roll Lats', 'muscle_group' => 'other', 'equipment' => ['foam-roller']],
        ];

        DB::table('exercises')->upsert(
            collect($exerciseCatalog)->map(function (array $item) use ($now): array {
                return [
                    'name' => $item['name'],
                    'slug' => Str::slug($item['name']),
                    'description' => null,
                    'muscle_group' => $item['muscle_group'],
                    'is_active' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            })->all(),
            ['slug'],
            ['name', 'description', 'muscle_group', 'is_active', 'updated_at']
        );

        $equipmentIds = DB::table('equipment')
            ->whereIn('slug', collect($equipmentCatalog)->pluck('slug'))
            ->pluck('id', 'slug');

        $exerciseIds = DB::table('exercises')
            ->whereIn('slug', collect($exerciseCatalog)->map(fn (array $item): string => Str::slug($item['name'])))
            ->pluck('id', 'slug');

        $pivotRows = [];
        foreach ($exerciseCatalog as $exercise) {
            $exerciseSlug = Str::slug($exercise['name']);
            $exerciseId = $exerciseIds[$exerciseSlug] ?? null;
            if (! $exerciseId) {
                continue;
            }

            foreach ($exercise['equipment'] as $index => $equipmentSlug) {
                $equipmentId = $equipmentIds[$equipmentSlug] ?? null;
                if (! $equipmentId) {
                    continue;
                }

                $pivotRows["{$exerciseId}:{$equipmentId}"] = [
                    'exercise_id' => $exerciseId,
                    'equipment_id' => $equipmentId,
                    'is_primary' => $index === 0,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        if (! empty($pivotRows)) {
            DB::table('exercise_equipment')->upsert(
                array_values($pivotRows),
                ['exercise_id', 'equipment_id'],
                ['is_primary', 'updated_at']
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $equipmentSlugs = [
            'bodyweight',
            'barbell',
            'ez-bar',
            'dumbbell',
            'kettlebell',
            'trap-bar',
            'landmine',
            'resistance-band',
            'medicine-ball',
            'battle-ropes',
            'jump-rope',
            'ab-wheel',
            'pull-up-bar',
            'dip-bars',
            'flat-bench',
            'adjustable-bench',
            'squat-rack',
            'power-rack',
            'smith-machine',
            'cable-machine',
            'lat-pulldown-machine',
            'seated-row-machine',
            'chest-press-machine',
            'pec-deck-machine',
            'shoulder-press-machine',
            'assisted-pull-up-machine',
            'leg-press-machine',
            'hack-squat-machine',
            'leg-extension-machine',
            'leg-curl-machine',
            'calf-raise-machine',
            'ab-crunch-machine',
            'back-extension-bench',
            'hip-thrust-machine',
            'glute-drive-machine',
            'weighted-sled',
            'treadmill',
            'stationary-bike',
            'air-bike',
            'elliptical',
            'rower',
            'stair-climber',
            'ski-erg',
            'heavy-bag',
            'foam-roller',
        ];

        $exerciseSlugs = [
            'back-squat',
            'front-squat',
            'goblet-squat',
            'hack-squat',
            'leg-press',
            'walking-lunge',
            'reverse-lunge',
            'bulgarian-split-squat',
            'step-up',
            'romanian-deadlift',
            'stiff-leg-deadlift',
            'conventional-deadlift',
            'sumo-deadlift',
            'trap-bar-deadlift',
            'hip-thrust',
            'glute-bridge',
            'machine-hip-thrust',
            'glute-drive',
            'leg-extension',
            'seated-leg-curl',
            'lying-leg-curl',
            'standing-calf-raise',
            'seated-calf-raise',
            'cossack-squat',
            'box-jump',
            'barbell-bench-press',
            'incline-barbell-bench-press',
            'decline-barbell-bench-press',
            'dumbbell-bench-press',
            'incline-dumbbell-press',
            'dumbbell-fly',
            'cable-chest-fly',
            'pec-deck-fly',
            'machine-chest-press',
            'smith-machine-bench-press',
            'push-up',
            'weighted-push-up',
            'chest-dip',
            'svend-press',
            'pull-up',
            'chin-up',
            'assisted-pull-up',
            'lat-pulldown',
            'wide-grip-lat-pulldown',
            'close-grip-lat-pulldown',
            'seated-cable-row',
            'machine-seated-row',
            'barbell-row',
            'pendlay-row',
            'one-arm-dumbbell-row',
            'chest-supported-row',
            't-bar-row',
            'face-pull',
            'straight-arm-pulldown',
            'inverted-row',
            'back-extension',
            'good-morning',
            'standing-overhead-press',
            'seated-dumbbell-shoulder-press',
            'arnold-press',
            'machine-shoulder-press',
            'lateral-raise',
            'cable-lateral-raise',
            'front-raise',
            'rear-delt-fly',
            'cable-rear-delt-fly',
            'upright-row',
            'landmine-press',
            'barbell-curl',
            'ez-bar-curl',
            'alternating-dumbbell-curl',
            'hammer-curl',
            'incline-dumbbell-curl',
            'concentration-curl',
            'preacher-curl',
            'cable-curl',
            'reverse-curl',
            'close-grip-bench-press',
            'skull-crusher',
            'cable-triceps-pushdown',
            'overhead-cable-triceps-extension',
            'rope-triceps-extension',
            'dumbbell-overhead-triceps-extension',
            'bench-dip',
            'dumbbell-kickback',
            'assisted-dip',
            'plank',
            'side-plank',
            'dead-bug',
            'bird-dog',
            'hanging-leg-raise',
            'toes-to-bar',
            'cable-crunch',
            'machine-ab-crunch',
            'ab-wheel-rollout',
            'russian-twist',
            'pallof-press',
            'reverse-crunch',
            'v-up',
            'mountain-climber',
            'clean-and-press',
            'dumbbell-thruster',
            'kettlebell-swing',
            'turkish-get-up',
            'man-maker',
            'burpee',
            'farmer-carry',
            'sled-push',
            'sled-pull',
            'battle-rope-slams',
            'medicine-ball-slam',
            'heavy-bag-rounds',
            'landmine-squat-to-press',
            'treadmill-run',
            'incline-treadmill-walk',
            'stationary-bike-ride',
            'air-bike-intervals',
            'elliptical-steady-state',
            'rowing-intervals',
            'stair-climber-intervals',
            'ski-erg-intervals',
            'jump-rope-singles',
            'jump-rope-double-unders',
            'band-pull-apart',
            'banded-glute-bridge',
            'shoulder-external-rotation',
            'foam-roll-quads',
            'foam-roll-lats',
        ];

        DB::table('exercises')->whereIn('slug', $exerciseSlugs)->delete();
        DB::table('equipment')->whereIn('slug', $equipmentSlugs)->delete();
    }
};

