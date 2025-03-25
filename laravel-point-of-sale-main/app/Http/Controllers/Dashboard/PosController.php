<?php

namespace App\Http\Controllers\Dashboard;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Gloudemans\Shoppingcart\Facades\Cart;

class PosController extends Controller
{    
    public function index()
{
    $row = (int) request('row', 20);

    if ($row < 1 || $row > 100) {
        abort(400, 'The per-page parameter must be an integer between 1 and 100.');
    }

    return view('pos.index', [
        'customers' => Customer::all()->sortBy('name'),
        'productItem' => Cart::content(),
        'products' => Product::filter(request(['search']))
            ->sortable()
            ->paginate($row)
            ->appends(request()->query()),
    ]);
}



    public function addCart(Request $request)
    {
        $rules = [
            'id' => 'required|numeric',
            'name' => 'required|string',
            'price' => 'required|numeric',
        ];

        $validatedData = $request->validate($rules);

        Cart::add([
            'id' => $validatedData['id'],
            'name' => $validatedData['name'],
            'qty' => 1,
            'price' => $validatedData['price'],
            'options' => ['size' => 'large']
        ]);

        return Redirect::back()->with('success', 'Product has been added!');
    }

    // public function updateCart(Request $request, $rowId)
    // {
    //     $rules = [
    //         'qty' => 'required|numeric',
    //     ];

    //     $validatedData = $request->validate($rules);

    //     Cart::update($rowId, $validatedData['qty']);

    //     return Redirect::back()->with('success', 'Cart has been updated!');
    // }
    public function updateCart(Request $request, $rowId)
{
    $request->validate([
        'qty' => 'required|numeric|min:1',
    ]);

    Cart::update($rowId, ['qty' => $request->qty]);

    return response()->json([
        'success' => 'Cart updated successfully!',
        'subtotal' => number_format(Cart::get($rowId)->subtotal, 2),
        'cartSubtotal' => number_format(Cart::subtotal(), 2),
        'cartTax' => number_format(Cart::tax(), 2),
        'cartTotal' => number_format(Cart::total(), 2),
    ]);
}

    

    


    public function deleteCart(String $rowId)
    {
        Cart::remove($rowId);

        return Redirect::back()->with('success', 'Cart has been deleted!');
    }

    public function createInvoice(Request $request)
    {

        $validatedData = $request->validate($rules);
        $content = Cart::content();

        return view('pos.create-invoice', [
            'content' => $content
        ]);
    }

    public function printInvoice(Request $request)
    {

        $validatedData = $request->validate($rules);
        $content = Cart::content();

        return view('pos.print-invoice', [
            'content' => $content
        ]);
    }
}
