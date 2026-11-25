<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Keep the migration name used by installations that already have the v5 schema.
        if (! Schema::hasColumn('activity_log', 'attribute_changes')) {
            Schema::table('activity_log', function (Blueprint $table) {
                $table->json('attribute_changes')->nullable()->after('causer_id');
            });
        }

        $changeKeys = ['attributes' => true, 'old' => true];

        DB::table('activity_log')
            ->select('id', 'properties')
            ->whereNull('attribute_changes')
            ->where(function ($query) {
                $query->whereNotNull('properties->attributes')->orWhereNotNull('properties->old');
            })
            ->eachById(function ($activity) use ($changeKeys) {
                $properties = (array) json_decode($activity->properties, flags: JSON_THROW_ON_ERROR);
                $changes = array_intersect_key($properties, $changeKeys);
                $remaining = array_diff_key($properties, $changeKeys);

                DB::table('activity_log')->where('id', $activity->id)->update([
                    'attribute_changes' => json_encode((object) $changes, JSON_THROW_ON_ERROR),
                    'properties' => $remaining === [] ? null : json_encode((object) $remaining, JSON_THROW_ON_ERROR),
                ]);
            });

        // Preserve historical batch identifiers wherever they are still populated.
        if (Schema::hasColumn('activity_log', 'batch_uuid') && DB::table('activity_log')->whereNotNull('batch_uuid')->doesntExist()) {
            Schema::table('activity_log', function (Blueprint $table) {
                $table->dropColumn('batch_uuid');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasColumn('activity_log', 'batch_uuid')) {
            Schema::table('activity_log', function (Blueprint $table) {
                $table->uuid('batch_uuid')->nullable()->after('properties');
            });
        }

        if (! Schema::hasColumn('activity_log', 'attribute_changes')) {
            return;
        }

        DB::table('activity_log')
            ->select('id', 'properties', 'attribute_changes')
            ->whereNotNull('attribute_changes')
            ->eachById(function ($activity) {
                $properties = (array) json_decode($activity->properties ?? '{}', flags: JSON_THROW_ON_ERROR);
                $changes = (array) json_decode($activity->attribute_changes, flags: JSON_THROW_ON_ERROR);

                DB::table('activity_log')->where('id', $activity->id)->update([
                    'properties' => json_encode((object) array_replace($properties, $changes), JSON_THROW_ON_ERROR),
                ]);
            });

        Schema::table('activity_log', function (Blueprint $table) {
            $table->dropColumn('attribute_changes');
        });
    }
};
