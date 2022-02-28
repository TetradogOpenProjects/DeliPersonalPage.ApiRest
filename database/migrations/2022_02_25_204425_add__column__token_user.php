<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\TokenUser;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('TokenUsers', function ($table) {
            $table->string('tokenOwn',TokenUser::LENGTH_TOKENOWN)->unique()->after('token');
 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('TokenUsers', function ($table) {
            $table->dropColumn('tokenOwn');
         });
    }
};
