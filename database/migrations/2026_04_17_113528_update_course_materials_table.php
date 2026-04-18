<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCourseMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('course_materials', function (Blueprint $table) {
            $table->string('type')->default('file')->after('instructor_id');
            $table->string('link_url')->nullable()->after('file_path');
            $table->longText('content')->nullable()->after('link_url');
        });

        DB::statement('ALTER TABLE course_materials MODIFY file_path VARCHAR(255) NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('course_materials', function (Blueprint $table) {
            $table->dropColumn(['type', 'link_url', 'content']);
        });

        DB::statement('ALTER TABLE course_materials MODIFY file_path VARCHAR(255) NOT NULL');
    }
}
