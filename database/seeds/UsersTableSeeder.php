<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$records = factory(User::class,10)->make()->toArray();
        $records = array(
            array('name'=>'Fausto','phone'=>'1234567890','email'=>'info@email.com','password'=>bcrypt('123456'),'company_id'=>1)
        );
        DB::table('users')->insert($records);
    }
}
