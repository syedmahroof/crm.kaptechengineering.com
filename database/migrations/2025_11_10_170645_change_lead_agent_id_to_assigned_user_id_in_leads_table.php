<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Skip if column already renamed
        if (Schema::hasColumn('leads', 'assigned_user_id')) {
            return;
        }

        // Check if column exists before trying to modify
        if (Schema::hasColumn('leads', 'lead_agent_id')) {
            $connection = Schema::getConnection();
            $driver = $connection->getDriverName();
            
            // Drop foreign key and index safely
            Schema::table('leads', function (Blueprint $table) use ($driver) {
                // Drop the old foreign key if it exists
                try {
                    if ($driver !== 'sqlite') {
                        $table->dropForeign(['lead_agent_id']);
                    }
                } catch (\Exception $e) {
                    // Foreign key might not exist, continue
                }
                
                // Drop index if it exists (SQLite compatible)
                try {
                    if ($driver === 'sqlite') {
                        // For SQLite, drop index by name if it exists
                        $indexName = 'leads_lead_agent_id_index';
                        DB::statement("DROP INDEX IF EXISTS {$indexName}");
                    } else {
                        $table->dropIndex(['lead_agent_id']);
                    }
                } catch (\Exception $e) {
                    // Index might not exist, continue
                }
            });

            // Rename the column (SQLite compatible)
            if ($driver === 'sqlite') {
                // SQLite: Use table recreation method
                DB::statement('PRAGMA foreign_keys=off;');
                
                $columns = Schema::getColumnListing('leads');
                $selectCols = [];
                foreach ($columns as $col) {
                    if ($col === 'lead_agent_id') {
                        $selectCols[] = 'lead_agent_id as assigned_user_id';
                    } else {
                        $selectCols[] = $col;
                    }
                }
                $columnList = implode(', ', $selectCols);
                
                DB::statement("CREATE TABLE leads_new AS SELECT {$columnList} FROM leads");
                DB::statement('DROP TABLE leads');
                DB::statement('ALTER TABLE leads_new RENAME TO leads');
                DB::statement('PRAGMA foreign_keys=on;');
            } else {
                DB::statement('ALTER TABLE leads CHANGE lead_agent_id assigned_user_id BIGINT UNSIGNED NULL');
            }
        } else {
            // If lead_agent_id doesn't exist, just add assigned_user_id
            Schema::table('leads', function (Blueprint $table) {
                if (!Schema::hasColumn('leads', 'assigned_user_id')) {
                    $table->foreignId('assigned_user_id')->nullable()->constrained('users')->onDelete('set null');
                }
            });
        }

        // Add foreign key and index if they don't exist
        Schema::table('leads', function (Blueprint $table) {
            if (!Schema::hasColumn('leads', 'assigned_user_id')) {
                return;
            }
            
            $connection = Schema::getConnection();
            $driver = $connection->getDriverName();
            
            // Add index
            try {
                $table->index('assigned_user_id');
            } catch (\Exception $e) {
                // Index might already exist
            }
            
            // Add foreign key (SQLite handles this differently)
            if ($driver !== 'sqlite') {
                try {
                    $table->foreign('assigned_user_id')->references('id')->on('users')->onDelete('set null');
                } catch (\Exception $e) {
                    // Foreign key might already exist
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            // Drop the new foreign key and index
            $table->dropForeign(['assigned_user_id']);
            $table->dropIndex(['assigned_user_id']);
        });

        // Rename the column back
        DB::statement('ALTER TABLE leads CHANGE assigned_user_id lead_agent_id BIGINT UNSIGNED NULL');

        Schema::table('leads', function (Blueprint $table) {
            // Restore the old foreign key to lead_agents table
            $table->foreign('lead_agent_id')->references('id')->on('lead_agents')->onDelete('set null');
            // Restore index
            $table->index('lead_agent_id');
        });
    }
};
