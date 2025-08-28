<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * jadi seeder ini buat bikin role dan permission default
     * pake spatie/laravel-permission buat manage role dan permission
     * https://spatie.be/docs/laravel-permission/v5/introduction
     * pengertiannya Seeder adalah fitur di Laravel yang digunakan untuk mengisi database dengan data awal atau data contoh (dummy data) secara otomatis. Seeder membantu mempermudah proses pengujian dan pengembangan aplikasi dengan menyediakan data yang konsisten tanpa harus memasukkan data secara manual satu per satu. 
     */
    public function run(): void
    {
        $permission = [ //ini buat permission apa aja
            'manage cities',
            'manage categories',
            'manage hotels',
            'manage hotel bookings',
            'checkout hotel',
            'view hotel booking',
        ];

        foreach ($permission as $perm) {
            Permission::firstOrCreate([ //ini buat permission
                'name' => $perm]);
        }

        $CustomerRole = Role::firstOrCreate([ //ini buat role customer
            'name' => 'Customer'
        ]);

        $CustomerPermissions = [ //ini untuk permission yang dimiliki role customer
            'checkout hotel',
            'view hotel booking',
        ];

        $CustomerRole->syncPermissions($CustomerPermissions); //ini buat tau spatie kalo role customer punya permission apa aja

        $SuperAdminRole = Role::firstOrCreate([ //ini buat role super admin
            'name' => 'Super Admin'
        ]);

        $user = User::create([ //ini buat user super admin default
            'name' => 'Super Admin',
            'email' => 'admin@bobo.com',
            'password' => bcrypt('password'), // ganti dengan password yang diinginkan
            'avatar' => 'default.png',
        ]);

        $user->assignRole($SuperAdminRole); //ini buat assign role super admin ke user

    }
}
