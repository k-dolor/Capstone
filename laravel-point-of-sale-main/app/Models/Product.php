<?php

namespace App\Models;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Notification;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, Sortable;

    protected $fillable = [
        'product_name',
        'category_id',
        'supplier_id',
        'product_code',
        'product_image',
        'product_store',
        'buying_date',
        'buying_price',
        'selling_price',
        'reorder_level',
    ];

    public $sortable = [
        'product_name',
        'selling_price',
    ];

    protected $guarded = [
        'id',
    ];

    protected $with = [
        'category',
        'supplier'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    
    public function supplier(){
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('product_name', 'like', '%' . $search . '%');
        });
    }
public function checkStock()
{
    if ($this->product_store <= 0) {
        \App\Models\Notification::create([
            'message' => "Product {$this->product_name} is out of stock!",
            'type' => 'out_of_stock',
            'url' => route('inventory.index'), // Ensure this is pointing to the right route
        ]);
    } elseif ($this->product_store <= $this->reorder_level) {
        \App\Models\Notification::create([
            'message' => "Product {$this->product_name} is low on stock.",
            'type' => 'low_stock',
            'url' => route('inventory.index'), // Ensure this is pointing to the right route
        ]);
    }
}


public function updateStock(Request $request, $id)
{
    $product = Product::find($id);
    $product->product_store = $request->input('product_store');
    $product->save();

    if ($product->product_store <= 0) {
        Notification::create([
            'message' => "Product {$product->product_name} is out of stock.",
            'url' => route('inventory.index') // Ensure this URL points to the inventory page
        ]);
    } elseif ($product->product_store < 20) {
        Notification::create([
            'message' => "Product {$product->product_name} is low on stock.",
            'url' => route('inventory.index') // Ensure this URL points to the inventory page
        ]);
    }

    return redirect()->back()->with('success', 'Stock updated successfully.');
}


}
