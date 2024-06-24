<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            // [
            //     'name'      => 'dashboard_access',
            // ],


            [
                'name'      => 'user_manager_access',
            ],
            [
                'name'      => 'user_show',
            ],
            [
                'name'      => 'user_create',
            ],
            [
                'name'      => 'user_edit',
            ],
            [
                'name'      => 'user_deposit_edit',
            ],
            [
                'name'      => 'user_delete',
            ],


            [
                'name'      => 'customer_access',
            ],

            [
                'name'      => 'order_access',
            ],
            [
                'name'      => 'order_show',
            ],
            [
                'name'      => 'order_print',
            ],
            [
                'name'      => 'order_delete',
            ],
            [
                'name'      => 'order_edit',
            ],
            [
                'name'      => 'order_status_edit',
            ],


            [
                'name'      => 'catalog_access',
            ],
            [
                'name'      => 'category_create',
            ],
            [
                'name'      => 'category_edit',
            ],
            [
                'name'      => 'category_show',
            ],
            [
                'name'      => 'category_delete',
            ],


            [
                'name'      => 'product_access',
            ],
            [
                'name'      => 'product_create',
            ],
            [
                'name'      => 'product_edit',
            ],
            [
                'name'      => 'product_show',
            ],
            [
                'name'      => 'product_delete',
            ],



            [
                'name'      => 'service_access',
            ],
            [
                'name'      => 'service_create',
            ],
            [
                'name'      => 'service_edit',
            ],
            [
                'name'      => 'service_show',
            ],
            [
                'name'      => 'service_delete',
            ],



            [
                'name'      => 'banner_access',
            ],
            [
                'name'      => 'banner_create',
            ],
            [
                'name'      => 'banner_edit',
            ],
            [
                'name'      => 'banner_show',
            ],
            [
                'name'      => 'banner_delete',
            ],


            [
                'name'      => 'area_access',
            ],
            [
                'name'      => 'area_create',
            ],
            [
                'name'      => 'area_edit',
            ],
            [
                'name'      => 'area_show',
            ],
            [
                'name'      => 'area_delete',
            ],


            [
                'name'      => 'payment_method_access',
            ],
            [
                'name'      => 'payment_method_create',
            ],
            [
                'name'      => 'payment_method_edit',
            ],
            [
                'name'      => 'payment_method_show',
            ],
            [
                'name'      => 'payment_method_delete',
            ],


            [
                'name'      => 'coupon_access',
            ],
            [
                'name'      => 'coupon_create',
            ],
            [
                'name'      => 'coupon_edit',
            ],
            [
                'name'      => 'coupon_show',
            ],
            [
                'name'      => 'coupon_delete',
            ],

            [
                'name'      => 'settings_access',
            ],
            [
                'name'      => 'settings_edit',
            ],

            [
                'name'      => 'web_mail_access',
            ],

        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
