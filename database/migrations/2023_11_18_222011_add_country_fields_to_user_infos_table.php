<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\UserInfo;

class AddCountryFieldsToUserInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_infos', function (Blueprint $table) {
            $table->Integer('country_id')->after('address')->default(169)->nullable();
            $table->string('country_name')->after('address')->default('Philippines')->nullable();
            $table->string('province_name')->after('province_id')->nullable();
            $table->string('city_name')->after('city_id')->nullable();
        });

        $userInfos = UserInfo::all();

        foreach ($userInfos as $userInfo) {
            $provinceId = $userInfo->province_id;
            $cityId = $userInfo->city_id;

            $provinceName = DB::table('provinces')
                ->where('provCode', $provinceId)
                ->value('provDesc');

            $cityName = DB::table('cities')
                ->where('citymunCode', $cityId)
                ->value('citymunDesc');

            UserInfo::where('id', $userInfo->id)
                ->update([
                    'province_name' => $this->customUcwords($provinceName),
                    'city_name' => $this->customUcwords($cityName)
                ]);
        }
    }

    protected function customUcwords($str)
    {
        return ucwords(strtolower($str));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_infos', function (Blueprint $table) {
            //
        });
    }
}
