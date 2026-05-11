<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'email' => 'admin@bytebox.com',
                'password' => '$2y$12$PPTOG6h9ptqb0w/XyOS1/ucbkqzLv2c3EVIVwAaWrmCKEVz.cBAAm',
                'name' => 'Admin Atelier',
                'role' => 'admin',
                'gender' => 'male',
                'date_of_birth' => '2006-05-10',
                'remember_token' => NULL,
                'created_at' => '2026-05-04 07:00:03',
                'updated_at' => '2026-05-10 09:53:08',
            ),
            1 => 
            array (
                'id' => 2,
                'email' => 'tuananh011106@gmail.com',
                'password' => '$2y$12$DtnNNlbH9QWrA7sEirXwL.dpKUev0qkX9aXtaJ0dfiT3ArqzY9cUO',
                'name' => 'Anh Tuan',
                'role' => 'customer',
                'gender' => 'female',
                'date_of_birth' => '2001-04-30',
                'remember_token' => NULL,
                'created_at' => '2026-05-04 07:01:34',
                'updated_at' => '2026-05-10 09:53:08',
            ),
            2 => 
            array (
                'id' => 3,
                'email' => 'tuananh@admin.com',
                'password' => '$2y$12$xoSJ3hBUqzyOTftwO2mpIODFzbQMegsY4C1iEGfAACPAd5JOEEEFS',
                'name' => 'TuanAnh',
                'role' => 'admin',
                'gender' => 'other',
                'date_of_birth' => '1996-04-20',
                'remember_token' => 'iya9M2kyhPMbN0cS56cK6yrKjsu9QGw9V1cmWQQgoix7BZ5GhSscNChTFk4i',
                'created_at' => '2026-05-10 07:54:44',
                'updated_at' => '2026-05-10 09:53:08',
            ),
            3 => 
            array (
                'id' => 4,
                'email' => 'tuanem123@gmail.com',
                'password' => '$2y$12$V0VI6Mmk.cgOpzsh49.QgOnzPKC9ZJkWoOLt9fjgQHc18li1yrU66',
                'name' => 'Nguyen Le Tuan Em',
                'role' => 'customer',
                'gender' => 'male',
                'date_of_birth' => '2013-05-09',
                'remember_token' => NULL,
                'created_at' => '2026-05-10 09:55:27',
                'updated_at' => '2026-05-10 09:55:27',
            ),
            4 => 
            array (
                'id' => 5,
                'email' => 'tester1@gmail.com',
                'password' => '$2y$12$BSelzMYobA455J3AD4yv1.JnG4sCA/2PovDfUwfasanek1F2xNyRm',
                'name' => 'Tester1',
                'role' => 'customer',
                'gender' => 'male',
                'date_of_birth' => '2013-05-01',
                'remember_token' => NULL,
                'created_at' => '2026-05-10 10:20:54',
                'updated_at' => '2026-05-10 10:20:54',
            ),
            5 => 
            array (
                'id' => 6,
                'email' => 'tester2@gmail.com',
                'password' => '$2y$12$k7q7bLn5d6CnHrS/LxS3lOy4qDARriugwTgnX9BU83Ce8vHqm0DFm',
                'name' => 'tester2',
                'role' => 'customer',
                'gender' => 'male',
                'date_of_birth' => '2006-01-31',
                'remember_token' => NULL,
                'created_at' => '2026-05-10 10:41:42',
                'updated_at' => '2026-05-10 10:41:42',
            ),
        ));
        
        
    }
}