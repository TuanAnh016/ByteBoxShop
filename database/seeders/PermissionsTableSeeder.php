<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('permissions')->delete();
        
        \DB::table('permissions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'ViewAny:Role',
                'guard_name' => 'web',
                'created_at' => '2026-05-10 08:27:56',
                'updated_at' => '2026-05-10 08:27:56',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'View:Role',
                'guard_name' => 'web',
                'created_at' => '2026-05-10 08:27:56',
                'updated_at' => '2026-05-10 08:27:56',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Create:Role',
                'guard_name' => 'web',
                'created_at' => '2026-05-10 08:27:56',
                'updated_at' => '2026-05-10 08:27:56',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Update:Role',
                'guard_name' => 'web',
                'created_at' => '2026-05-10 08:27:56',
                'updated_at' => '2026-05-10 08:27:56',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Delete:Role',
                'guard_name' => 'web',
                'created_at' => '2026-05-10 08:27:56',
                'updated_at' => '2026-05-10 08:27:56',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'DeleteAny:Role',
                'guard_name' => 'web',
                'created_at' => '2026-05-10 08:27:56',
                'updated_at' => '2026-05-10 08:27:56',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Restore:Role',
                'guard_name' => 'web',
                'created_at' => '2026-05-10 08:27:56',
                'updated_at' => '2026-05-10 08:27:56',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'ForceDelete:Role',
                'guard_name' => 'web',
                'created_at' => '2026-05-10 08:27:56',
                'updated_at' => '2026-05-10 08:27:56',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'ForceDeleteAny:Role',
                'guard_name' => 'web',
                'created_at' => '2026-05-10 08:27:56',
                'updated_at' => '2026-05-10 08:27:56',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'RestoreAny:Role',
                'guard_name' => 'web',
                'created_at' => '2026-05-10 08:27:56',
                'updated_at' => '2026-05-10 08:27:56',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Replicate:Role',
                'guard_name' => 'web',
                'created_at' => '2026-05-10 08:27:56',
                'updated_at' => '2026-05-10 08:27:56',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Reorder:Role',
                'guard_name' => 'web',
                'created_at' => '2026-05-10 08:27:56',
                'updated_at' => '2026-05-10 08:27:56',
            ),
        ));
        
        
    }
}