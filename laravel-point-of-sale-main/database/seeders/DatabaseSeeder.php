<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Supplier;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
{
    // Create admin and user
    $admin = \App\Models\User::factory()->create([
        'name' => 'Admin',
        'username' => 'admin',
        'email' => 'admin@gmail.com',
        'password' => bcrypt('admin'),
    ]);

    $user = \App\Models\User::factory()->create([
        'name' => 'User',
        'username' => 'user',
        'email' => 'user@gmail.com',
    ]);

    // Create other entities
    Employee::factory(5)->create();
    Customer::factory(15)->create();
    Supplier::factory(5)->create();

    // Create specific categories
    $categories = [
        'LPG',
        'Oxygen',
        'Accessories',
    ];

    foreach ($categories as $categoryName) {
        Category::create([
            'name' => $categoryName,
            'slug' => $this->generateSlug($categoryName),
        ]);
    }

    // Create specific products with buying and expiry dates
    $randomSupplierId1 = Supplier::inRandomOrder()->first()->id;
    Product::create([
        'product_name' => 'LPG Gas 11kg',
        'product_code' => IdGenerator::generate([
            'table' => 'products',
            'field' => 'product_code',
            'length' => 4,
            'prefix' => 'PC'
        ]),
        'supplier_id' => $randomSupplierId1,
        'category_id' => 1,
        'buying_price' => 1170,
        'selling_price' => 1350,
        'product_store' => 50, // example stock
        'buying_date' => Carbon::now()->subDays(30)->toDateString(), // days ago
        'expire_date' => Carbon::now()->addDays(90)->toDateString(), // expires in days
    ]);

    $randomSupplierId2 = Supplier::inRandomOrder()->first()->id;
    Product::create([
        'product_name' => 'Medical Oxygen 105lbs',
        'product_code' => IdGenerator::generate([
            'table' => 'products',
            'field' => 'product_code',
            'length' => 4,
            'prefix' => 'PC'
        ]),
        'supplier_id' => $randomSupplierId2,
        'category_id' => 2,
        'buying_price' => 200,
        'selling_price' => 240,
        'product_store' => 100, // example stock
        'buying_date' => Carbon::now()->subDays(60)->toDateString(), // days ago
        'expire_date' => Carbon::now()->addDays(70)->toDateString(), // expires in days
    ]);

    $randomSupplierId3 = Supplier::inRandomOrder()->first()->id;
    Product::create([
        'product_name' => 'LPG Gas 22kg',
        'product_code' => IdGenerator::generate([
            'table' => 'products',
            'field' => 'product_code',
            'length' => 4,
            'prefix' => 'PC'
        ]),
        'supplier_id' => $randomSupplierId3,
        'category_id' => 1,
        'buying_price' => 2000,
        'selling_price' => 2140,
        'product_store' => 20, // example stock
        'buying_date' => Carbon::now()->subDays(15)->toDateString(), // days ago
        'expire_date' => Carbon::now()->addDays(95)->toDateString(), // expires in days
    ]);

    $randomSupplierId4 = Supplier::inRandomOrder()->first()->id;
    Product::create([
        'product_name' => 'LPG Gas 2.7kg',
        'product_code' => IdGenerator::generate([
            'table' => 'products',
            'field' => 'product_code',
            'length' => 4,
            'prefix' => 'PC'
        ]),
        'supplier_id' => $randomSupplierId4,
        'category_id' => 1,
        'buying_price' => 960,
        'selling_price' => 1200,
        'product_store' => 5, // example stock
        'buying_date' => Carbon::now()->subDays(25)->toDateString(), // days ago
        'expire_date' => Carbon::now()->addDays(105)->toDateString(), // expires in days
    ]);

    $randomSupplierId5 = Supplier::inRandomOrder()->first()->id;
    Product::create([
        'product_name' => 'Medical Oxygen 20lbs',
        'product_code' => IdGenerator::generate([
            'table' => 'products',
            'field' => 'product_code',
            'length' => 4,
            'prefix' => 'PC'
        ]),
        'supplier_id' => $randomSupplierId5,
        'category_id' => 2,
        'buying_price' => 1200,
        'selling_price' => 1350,
        'product_store' => 5, // example stock
        'buying_date' => Carbon::now()->subDays(5)->toDateString(), // days ago
        'expire_date' => Carbon::now()->addDays(105)->toDateString(), // expires in days
    ]);

    // Define permissions and roles
    Permission::create(['name' => 'pos.menu', 'group_name' => 'pos']);
    Permission::create(['name' => 'employee.menu', 'group_name' => 'employee']);
    Permission::create(['name' => 'customer.menu', 'group_name' => 'customer']);
    Permission::create(['name' => 'supplier.menu', 'group_name' => 'supplier']);
    Permission::create(['name' => 'sales.menu', 'group_name' => 'sales']);
    Permission::create(['name' => 'transactions.menu', 'group_name' => 'transactions']);
    Permission::create(['name' => 'salary.menu', 'group_name' => 'salary']);
    Permission::create(['name' => 'attendence.menu', 'group_name' => 'attendence']);
    Permission::create(['name' => 'category.menu', 'group_name' => 'category']);
    Permission::create(['name' => 'product.menu', 'group_name' => 'product']);
    Permission::create(['name' => 'orders.menu', 'group_name' => 'orders']);
    Permission::create(['name' => 'stock.menu', 'group_name' => 'stock']);
    Permission::create(['name' => 'roles.menu', 'group_name' => 'roles']);
    Permission::create(['name' => 'user.menu', 'group_name' => 'user']);
    Permission::create(['name' => 'database.menu', 'group_name' => 'database']);

    Role::create(['name' => 'SuperAdmin'])->givePermissionTo(Permission::all());
    Role::create(['name' => 'Admin'])->givePermissionTo(['customer.menu', 'user.menu', 'supplier.menu']);
    Role::create(['name' => 'Account'])->givePermissionTo(['customer.menu', 'user.menu', 'supplier.menu']);
    Role::create(['name' => 'Manager'])->givePermissionTo(['stock.menu', 'orders.menu', 'product.menu', 'salary.menu', 'employee.menu']);

    $admin->assignRole('SuperAdmin');
    $user->assignRole('Account');
}


    /**
     * Function to generate a random slug or use the same as the name.
     *
     * @param string $categoryName
     * @return string
     */
    private function generateSlug($categoryName)
    {
        return strtolower(str_replace(' ', '-', $categoryName));
    }
}
