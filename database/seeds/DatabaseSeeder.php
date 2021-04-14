<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(){
        //Menu
        \App\Menu::create(['id'=>1,'title'=>'Dashboards','name' => 'sidebar.dashboard','fk_parent' => 0,'is_heading'=>false,'is_active'=>false,'route'=>'','class_name'=>'','is_icon_class'=>true,'icon'=>'fas fa-chart-line', 'level_depth' => 0, 'active' => 1 ]);
        \App\Menu::create(['id'=>2,'title'=>'Ventas','name' => 'sidebar.sales','fk_parent' => 1,'is_heading'=>false,'is_active'=>false,'route'=>'dashboard.home-3','class_name'=>'','is_icon_class'=>true,'icon'=>'fas fa-cash-register', 'level_depth' => 0,'active' => 1]);
        \App\Menu::create(['id'=>3,'title'=>'Clientes','name' => 'sidebar.clients','fk_parent' => 1,'is_heading'=>false,'is_active'=>false,'route'=>'dashboard.home-4','class_name'=>'','is_icon_class'=>true,'icon'=>'fas fa-users', 'level_depth' => 1,'active' => 1 ]);
        \App\Menu::create(['id'=>20,'title'=>'Usuarios','name' => 'Usuarios','fk_parent' => 0,'is_heading'=>false,'is_active'=>false,'route'=>'', 'class_name'=>'','is_icon_class'=>true ,'icon'=>'fas fa-user-shield', 'level_depth' => 10, 'active' => 1 ]);
        \App\Menu::create(['id'=>21,'title'=>'Usuarios','name' => 'sidebar.userList','fk_parent' => 20,'is_heading'=>false,'is_active'=>false,'route'=>'users.users-list','class_name'=>'','is_icon_class'=>true ,'icon'=>'fas fa-users', 'level_depth' => 0, 'active' => 1 ]);
        

        //Perfiles
        \App\Perfil::create(['nombre' => 'prueba de perfiles', 'descripcion'=>'nuevo', 'estatus' => 0 ]);
        \App\Perfil::create(['nombre' => 'prueba', 'descripcion'=>'', 'estatus' => 1 ]);
        \App\Perfil::create(['nombre' => 'segunda prueba', 'descripcion'=>'xxxx', 'estatus' => 1 ]);
        \App\Perfil::create(['nombre' => 'prueba', 'descripcion'=>'', 'estatus' => 0 ]);
        \App\Perfil::create(['nombre' => 'nuevo nomas', 'descripcion'=>'asd', 'estatus' => 0 ]);
        \App\Perfil::create(['nombre' => 'nueva prueba', 'descripcion'=>'', 'estatus' => 1 ]);

        //Usuarios
        \App\User::create([ 'username' => 'prueba1', 'password' => \Illuminate\Support\Facades\Hash::make('123') ,  'fk_perfil' => 1, 'correo'=>'pruebas1@gmail.com',   'telefono'=>'123456',   'token'=>'',  'token_expiracion'=>null,  'estatus' => 0 ]); 
        \App\User::create(['username' => 'prueba2','password' => \Illuminate\Support\Facades\Hash::make('0123') , 'fk_perfil' => 2,'correo'=>'pruebas2@gmail.com',  'telefono'=>'123456',  'token'=>'',  'token_expiracion'=>null,   'estatus' => 1 ]); 
        \App\User::create(['username' => 'jorge','password' => \Illuminate\Support\Facades\Hash::make('admin123') , 'fk_perfil' => 3,'correo'=>'pruebas4@gmail.com',  'telefono'=>'123456',  'token'=>'',   'token_expiracion'=>null,  'estatus' => 1 ]); 
    }

}
