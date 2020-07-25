<?php

use Illuminate\Database\Seeder;
use App\Post;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $records = factory(Post::class,200)->make()->toArray();
        DB::table('posts')->insert($records);

        /*$records = array(
            array('name'=>'Pulicación 1','content'=>'Contenido de la publiación'),
            array('name'=>'Pulicación 2','content'=>'Contenido de la publiación'),
            array('name'=>'Pulicación 3','content'=>'Contenido de la publiación'),
            array('name'=>'Pulicación 4','content'=>'Contenido de la publiación'),
            array('name'=>'Pulicación 1','content'=>'Contenido de la publiación'),
            array('name'=>'Pulicación 2','content'=>'Contenido de la publiación'),
            array('name'=>'Pulicación 3','content'=>'Contenido de la publiación'),
            array('name'=>'Pulicación 4','content'=>'Contenido de la publiación'),
            array('name'=>'Pulicación 1','content'=>'Contenido de la publiación'),
            array('name'=>'Pulicación 2','content'=>'Contenido de la publiación'),
            array('name'=>'Pulicación 3','content'=>'Contenido de la publiación'),
            array('name'=>'Pulicación 4','content'=>'Contenido de la publiación'),
            array('name'=>'Pulicación 1','content'=>'Contenido de la publiación'),
            array('name'=>'Pulicación 2','content'=>'Contenido de la publiación'),
            array('name'=>'Pulicación 3','content'=>'Contenido de la publiación'),
            array('name'=>'Pulicación 4','content'=>'Contenido de la publiación'),
            array('name'=>'Pulicación 1','content'=>'Contenido de la publiación'),
            array('name'=>'Pulicación 2','content'=>'Contenido de la publiación'),
            array('name'=>'Pulicación 3','content'=>'Contenido de la publiación'),
            array('name'=>'Pulicación 4','content'=>'Contenido de la publiación'),
            array('name'=>'Pulicación 1','content'=>'Contenido de la publiación'),
            array('name'=>'Pulicación 2','content'=>'Contenido de la publiación'),
            array('name'=>'Pulicación 3','content'=>'Contenido de la publiación'),
            array('name'=>'Pulicación 4','content'=>'Contenido de la publiación'),
            array('name'=>'Pulicación 1','content'=>'Contenido de la publiación'),
            array('name'=>'Pulicación 2','content'=>'Contenido de la publiación'),
            array('name'=>'Pulicación 3','content'=>'Contenido de la publiación'),
            array('name'=>'Pulicación 4','content'=>'Contenido de la publiación'),
        );

        DB::table('posts')->insert($records);*/
    }
}
