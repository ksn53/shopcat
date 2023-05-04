<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Role;
use App\Models\User;

class CreateAdminUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Role::factory(['name' => 'administrator', 'slug' => 'admin'])->create();
        User::factory(['name' => 'admin', 'email' => 'admin@test.local', 'phone' => '+79025534587','password' => Hash::make('password')])->create();
        User::factory(['name' => 'guest', 'email' => '', 'phone' => '','password' => Hash::make('password')])->create();
        DB::table('role_user')->insert(['user_id' => 1, 'role_id' => 1]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
