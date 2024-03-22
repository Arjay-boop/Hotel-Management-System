<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        //
        $usersData = [
            [
            'first_name' => 'Arjay',
            'middle_name' => 'DG.',
            'last_name' => 'Hagid',
            'gender' => 'Male',
            'phone_no' => '0976 006 3233',
            'birthdate' => now(),
            'email' => 'arjayhagid@gmail.com',
            'password' => Hash::make('123456789'),
            'position' => 1,
            ],
            [
                'first_name' => 'Mike Angelo',
                'middle_name' => 'J.',
                'last_name' => 'Mariano',
                'gender' => 'Male',
                'phone_no' => '0943 432 6531',
                'birthdate' => now(),
                'email' => 'mikeangelo@gmail.com',
                'password' => Hash::make('987654321'),
                'position' => 2,
            ],
            [
                'first_name' => 'Jhon Paul Mikko',
                'middle_name' => 'C.',
                'last_name' => 'Ramos',
                'gender' => 'Male',
                'phone_no' => '0943 412 4323',
                'birthdate' => now(),
                'email' => 'jhonpaul@gmail.com',
                'password' => Hash::make('qwerty'),
                'position' => 3,
            ]
        ];
        foreach ($usersData as $key => $val){
            User::create($val);
        }
    }
}
