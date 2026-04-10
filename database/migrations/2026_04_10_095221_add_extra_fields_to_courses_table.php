<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraFieldsToCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->enum('level', ['beginner', 'intermediate', 'advanced'])->default('beginner')->after('description');
            $table->string('category')->nullable()->after('level');
            $table->integer('min_age')->nullable()->after('category');
            $table->integer('max_age')->nullable()->after('min_age');
            $table->integer('min_slots')->default(1)->after('max_age');
            $table->integer('max_slots')->nullable()->after('min_slots');
            $table->dateTime('schedule_start')->nullable()->after('max_slots');
            $table->dateTime('schedule_end')->nullable()->after('schedule_start');
            $table->integer('session_count')->default(1)->after('schedule_end');
            $table->integer('session_duration_mins')->default(60)->after('session_count');
            $table->enum('recurrence', ['once', 'daily', 'weekly', 'custom'])->default('once')->after('session_duration_mins');
            $table->string('meeting_link')->nullable()->after('recurrence');
            $table->string('location')->nullable()->after('meeting_link');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn([
                'level',
                'category',
                'min_age',
                'max_age',
                'min_slots',
                'max_slots',
                'schedule_start',
                'schedule_end',
                'session_count',
                'session_duration_mins',
                'recurrence',
                'meeting_link',
                'location'
            ]);
        });
    }
}
