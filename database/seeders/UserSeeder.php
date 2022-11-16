<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_list = Permission::create(['name'=>'users-list']);
        $user_view = Permission::create(['name'=>'users-view']);
        $user_create = Permission::create(['name'=>'users-create']);
        $user_update = Permission::create(['name'=>'users-update']);
        $user_delete = Permission::create(['name'=>'users-delete']);

        $role_list = Permission::create(['name'=>'role-list']);
        $role_view = Permission::create(['name'=>'role-view']);
        $role_create = Permission::create(['name'=>'role-create']);
        $role_update = Permission::create(['name'=>'role-update']);
        $role_delete = Permission::create(['name'=>'role-delete']);

        $product_list = Permission::create(['name'=>'product-list']);
        $product_view = Permission::create(['name'=>'product-view']);
        $product_create = Permission::create(['name'=>'product-create']);
        $product_update = Permission::create(['name'=>'product-update']);
        $product_delete = Permission::create(['name'=>'product-delete']);

        $recipe_list = Permission::create(['name'=>'recipe-list']);
        $recipe_view = Permission::create(['name'=>'recipe-view']);
        $recipe_create = Permission::create(['name'=>'recipe-create']);
        $recipe_update = Permission::create(['name'=>'recipe-update']);
        $recipe_delete = Permission::create(['name'=>'recipe-delete']);

        $ingredient_list = Permission::create(['name'=>'ingredient-list']);
        $ingredient_view = Permission::create(['name'=>'ingredient-view']);
        $ingredient_create = Permission::create(['name'=>'ingredient-create']);
        $ingredient_update = Permission::create(['name'=>'ingredient-update']);
        $ingredient_delete = Permission::create(['name'=>'ingredient-delete']);

        $plan_list = Permission::create(['name'=>'plan-list']);
        $plan_view = Permission::create(['name'=>'plan-view']);
        $plan_create = Permission::create(['name'=>'plan-create']);
        $plan_update = Permission::create(['name'=>'plan-update']);
        $plan_delete = Permission::create(['name'=>'plan-delete']);

        $admin_role = Role::create(['name' => 'admin']);
        $admin_role->givePermissionTo([
            $user_create,
            $user_list,
            $user_update,
            $user_view,
            $user_delete,

            $role_list,
            $role_view,
            $role_create,
            $role_update,
            $role_delete,

            $product_list,
            $product_view,
            $product_create,
            $product_update,
            $product_delete,

            $recipe_list,
            $recipe_view,
            $recipe_create,
            $recipe_update,
            $recipe_delete,

            $ingredient_list,
            $ingredient_view,
            $ingredient_create,
            $ingredient_update,
            $ingredient_delete,

            $plan_list,
            $plan_view,
            $plan_create,
            $plan_update,
            $plan_delete,
        ]);

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password')
        ]);

        $admin->assignRole($admin_role);
        $admin->givePermissionTo([
            $user_create,
            $user_list,
            $user_update,
            $user_view,
            $user_delete,

            $role_list,
            $role_view,
            $role_create,
            $role_update,
            $role_delete,

            $product_list,
            $product_view,
            $product_create,
            $product_update,
            $product_delete,

            $recipe_list,
            $recipe_view,
            $recipe_create,
            $recipe_update,
            $recipe_delete,

            $ingredient_list,
            $ingredient_view,
            $ingredient_create,
            $ingredient_update,
            $ingredient_delete,

            $plan_list,
            $plan_view,
            $plan_create,
            $plan_update,
            $plan_delete,
        ]);

        $manager_role = Role::create(['name' => 'manager']);
        $manager_role->givePermissionTo([
            $user_list,
            $user_update,
            $user_create,

            $role_list,
            $role_update,
            $role_create,

            $product_list,
            $product_update,
            $product_create,

            $ingredient_list,
            $ingredient_update,
            $ingredient_create,

            $recipe_list,
            $recipe_update,
            $recipe_create,

            $plan_list,
            $plan_update,
            $plan_create,
        ]);

        $manager = User::create([
            'name' => 'manager',
            'email' => 'manager@manager.com',
            'password' => bcrypt('password')
        ]);

        $manager->assignRole($manager_role);
        $manager_role->givePermissionTo([
            $user_list,
            $user_update,
            $user_create,

            $role_list,
            $role_update,
            $role_create,

            $product_list,
            $product_update,
            $product_create,

            $ingredient_list,
            $ingredient_update,
            $ingredient_create,

            $recipe_list,
            $recipe_update,
            $recipe_create,

            $plan_list,
            $plan_update,
            $plan_create,
        ]);


        $user = User::create([
            'name' => 'user',
            'email' => 'user@user.com',
            'password' => bcrypt('password')
        ]);

        $user_role = Role::create(['name' => 'user']);

        $user->assignRole($user_role);
        $user->givePermissionTo([
            $user_list,
            $role_list,

            $product_list,
            $product_create,

            $ingredient_list,
            $ingredient_create,

            $recipe_list,
            $recipe_create,

            $plan_list,
            $plan_create,
        ]);

        $user_role->givePermissionTo([
            $user_list,
            $role_list,

            $product_list,
            $product_create,

            $ingredient_list,
            $ingredient_create,

            $recipe_list,
            $recipe_create,

            $plan_list,
            $plan_create,
        ]);



    }
}
