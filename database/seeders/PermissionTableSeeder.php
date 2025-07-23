<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{

    public function run(): void
    {
        $permissions = [
            'setting',

            // المستخدمين
            'users',
            'create_user',
            'edit_user',
            'delete_user',
            'show_user',

            // الصلاحيات
            'roles',
            'add_role',
            'edit_role',
            'delete_role',
            'show_role',
            'search_role',


            // الصلاحيات
            'permissions',
            'permission_add',
            'permission_edit',
            'permission_delete',



            'coupons',
            'add_coupon',
            'edit_coupon',
            'delete_coupon',
            'show_coupon',
            'search_coupon',

            'containers',
            'add_container',
            'edit_container',
            'delete_container',
            'show_container',
            'search_container',

            'campaigns',
            'add_campaign',
            'edit_campaign',
            'delete_campaign',
            'show_campaign',
            'search_campaign',

            // حملات الولاء - بطاقات الولاء
            'loyalty_cards',
            'add_loyalty_card',
            'edit_loyalty_card',
            'delete_loyalty_card',
            'show_loyalty_card',
            'search_loyalty_card',

            // حملات الولاء
            'loyalty_campaigns',
            'add_loyalty_campaign',
            'edit_loyalty_campaign',
            'delete_loyalty_campaign',
            'show_loyalty_campaign',
            'search_loyalty_campaign',
            'send_loyalty_campaign',
            'export_loyalty_campaigns',

            // المدن
            'cities',
            'add_city',
            'edit_city',
            'delete_city',
            'show_city',
            'search_city',

            // المجموعات
            'groups',
            'add_group',
            'edit_group',
            'delete_group',
            'show_group',
            'search_group',

            // الفروع
            'branches',
            'add_branch',
            'edit_branch',
            'delete_branch',
            'show_branch',
            'search_branch',

            // العملاء
            'customers',
            'add_customer',
            'edit_customer',
            'delete_customer',
            'show_customer',
            'search_customer',
            'import_customers',
            'export_customers',



        ];

        foreach ($permissions as $permission) {
            if (!Permission::where('name', $permission)->exists()) {
                Permission::create(['name' => $permission]);
            }
        }
    }
}
