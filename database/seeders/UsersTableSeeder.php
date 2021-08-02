<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Contracts\Role;
use App\Models\UsersRole;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $user = User::create([
            'name' => 'superadmin',
            'email' => 'superadmin@gmail.com',
            'password' =>  bcrypt('12345678'),
            'phone' => '01827537225',
        ]);

        $role = Role::select('id')
                      ->where('id' , 1)
                      ->first();

        $user->assignRole($role);

            $UserRole = new UsersRole;
            $UserRole->user_id = $user->id;
            $UserRole->role_id = $role->id;
            $UserRole->save();

    }
}
