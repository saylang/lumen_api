<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Model::unguard();
        // // Register the user seeder
        // $this->call(UsersTableSeeder::class);

        DB::table('users')->delete();
        DB::table('roles')->delete();
        //1) Create Admin Role
        $role = ['name' => 'admin', 'display_name' => 'Admin', 'description' => 'Full Permission'];
        $role = Role::create($role);
        //2) Set Role Permissions
        // Get all permission, swift through and attach them to the role
        $permission = Permission::get();
        foreach ($permission as $key => $value) {
            $role->attachPermission($value);
        }
        //3) Create Admin User
        $user = ['name' => 'Admin User', 'email' => 'nguyenngochoangit.tb@gmail.com', 'password' => app('hash')->make('123456')];
        $user = User::create($user);

        //4) Set User Role
        $user->attachRole($role);
        //Model::reguard();
    }
}
