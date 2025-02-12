<?php

namespace App\Http\Controllers\Dashboard;

use Exception;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\stockInHistory;
// use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\Notification;
use App\Notifications\LowStockNotification;
use App\Models\User;

use PhpOffice\PhpSpreadsheet\Writer\Xls;
use Picqer\Barcode\BarcodeGeneratorHTML;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $row = (int) request('row', 10);
    
        if ($row < 1 || $row > 100) {
            abort(400, 'The per-page parameter must be an integer between 1 and 100.');
        }
    
        $query = Product::with(['category', 'supplier']);
    
        // Apply search filter if present
        if (request('search')) {
            $query->filter(request(['search']));
        }
    
        // Apply category filter if selected
        if (request('category')) {
            $query->where('category_id', request('category'));
        }
    
        return view('products.index', [
            'products' => $query->sortable()
                ->paginate($row)
                ->appends(request()->query()),
            'categories' => Category::all(), // Pass all categories to the view
            'suppliers' => Supplier::all(), 
        ]);
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create', [
            'categories' => Category::all(),
            'suppliers' => Supplier::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return dd($request);

        $product_code = IdGenerator::generate([
            'table' => 'products',
            'field' => 'product_code',
            'length' => 4,
            'prefix' => 'PC'
        ]);

        $rules = [
            'product_image' => 'image|file|max:1024',
            'product_name' => 'required|string',
            'category_id' => 'required|integer',
            'supplier_id' => 'required|integer',
            // 'product_garage' => 'string|nullable',
            'product_store' => 'string|nullable',
            'buying_date' => 'date_format:Y-m-d|max:10|nullable',
            'buying_price' => 'required|integer',
            'selling_price' => 'required|integer',
        ];

        
        $validatedData = $request->validate($rules);
        // return dd($validatedData);

        // save product code value
        $validatedData['product_code'] = $product_code;

        ///
        //  * Handle upload image with Storage.
        //  *///
        if ($file = $request->file('product_image')) {
            $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();
            $path = 'public/products/';

            $file->storeAs($path, $fileName);
            $validatedData['product_image'] =  $fileName;
            

        }

        Product::create([
            'product_code' => $validatedData['product_code'],
            'product_name' => $validatedData['product_name'],
            'category_id' => $validatedData['category_id'],
            'supplier_id' => $validatedData['supplier_id'],
            // 'product_garage' => $validatedData['product_garage'],
            'product_store' => $validatedData['product_store'],
            'buying_date' => $validatedData['buying_date'],
            'buying_price' => $validatedData['buying_price'],
            'selling_price' => $validatedData['selling_price'],
            'product_image' => ($request->has('product_image')) ? $validatedData['product_image'] : null,
        ]);

        return Redirect::route('products.index')->with('success', 'Product has been created!');
    }

    /**
     * Display the specified resource.
     */
    // public function show(Product $product)
    // {
    //     // Barcode Generator
    //     $generator = new BarcodeGeneratorHTML();

    //     $barcode = $generator->getBarcode($product->product_code, $generator::TYPE_CODE_128);

    //     return view('products.show', [
    //         'product' => $product,
    //         'barcode' => $barcode,
    //     ]);
    // }
    // public function show($id)
    // {
    //     $product = Product::with(['category', 'supplier'])->findOrFail($id);
        
    //     return response()->json([
    //         'product_name' => $product->product_name,
    //         'category' => ['name' => $product->category->name],
    //         'supplier' => ['name' => $product->supplier->name],
    //         'product_store' => $product->product_store,
    //         'buying_date' => $product->buying_date,
    //         'buying_price' => $product->buying_price,
    //         'selling_price' => $product->selling_price,
    //         'product_image' => $product->product_image,
    //     ]);
    // }

    public function show($id)
    {
        $product = Product::with(['category', 'supplier'])->findOrFail($id);
        
        return response()->json([
            'product_name' => $product->product_name,
            'product_code' => $product->product_code,
            'category_name' => $product->category->name ?? 'No Category',
            'selling_price' => $product->selling_price,
            'product_store' => $product->product_store,
            'supplier_name' => $product->supplier->name ?? 'No Supplier',
            'created_at' => $product->created_at->format('F j, Y'),
            'product_image' => asset('storage/products/'.$product->product_image),
        ]);
    }
    




    /**
     * Show the form for editing the specified resource.
     */
    // public function edit($id)
    // {
    //     $product = Product::findOrFail($id);
    //     $categories = Category::all();
    //     $suppliers = Supplier::all();
    
    //     return response()->json([
    //         'product' => $product,
    //         'categories' => $categories,
    //         'suppliers' => $suppliers,
    //     ]);
    // }
    public function edit($id)
{
    $product = Product::findOrFail($id);
    $suppliers = Supplier::all();

    return response()->json([
        'product' => $product,
        'suppliers' => $suppliers,
    ]);
}

    
    /**
     * Update the specified resource in storage.
     */
//     public function update(Request $request, Product $product)
// {
//     // dd($request->all()); // Debugging step to check incoming data

//     $rules = [
//         'product_image' => 'image|file|max:1024',
//         'product_name' => 'required|string',
//         'category_id' => 'required|integer',
//         'supplier_id' => 'required|integer',
//         'product_store' => 'string|nullable',
//         'buying_date' => 'date_format:Y-m-d|max:10|nullable',
//         'buying_price' => 'required|integer',
//         'selling_price' => 'required|integer',
//         'reorder_level' => 'nullable|integer',
//     ];

//     $validatedData = $request->validate($rules);

    // if ($file = $request->file('product_image')) {
    //     $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();
    //     $path = 'public/products/';

    //     if($product->product_image){
    //         Storage::delete($path . $product->product_image);
    //     }

    //     $file->storeAs($path, $fileName);
    //     $validatedData['product_image'] = $fileName;
    // }

//     // Update product
//     $product->update($validatedData);

//     // // Check if stock is below reorder level
//     // if ($product->product_store <= $product->reorder_level) {
//     //     // Create a notification if stock is below reorder level
//     //     \App\Models\Notification::create([
//     //         'message' => 'Product "' . $product->product_name . '" is running low on stock.',
//     //         'type' => 'low_stock',
//     //         'is_read' => false,
//     //     ]);  
//     // }


//     //  // Mark notifications as read if product is updated
//     //  Notification::where('data->product_id', $id)
//     //  ->where('read_at', null) // Only unread notifications
//     //  ->update(['read_at' => now()]);
    

//     return Redirect::route('products.index')->with('success', 'Product has been updated!');
// }
public function update(Request $request, $id)
{
    $request->validate([
        'product_name' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'supplier_id' => 'required|exists:suppliers,id',
        'selling_price' => 'required|numeric',
        'buying_price' => 'required|numeric',
        'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);
    

    $product = Product::findOrFail($id);

    if ($request->hasFile('product_image')) {
        $file = $request->file('product_image');
        $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();
        $path = 'public/products/';

        if($product->product_image){
                Storage::delete($path . $product->product_image);
            }

        $file->storeAs($path, $fileName);
        $validatedData['product_image'] =  $fileName;
        
    }

    $product->product_image = $validatedData['product_image'];
    $product->product_name = $request->product_name;
    $product->category_id = $request->category_id;
    $product->supplier_id = $request->supplier_id;
    $product->selling_price = $request->selling_price;
    $product->buying_price = $request->buying_price;

    

    $product->save();

    return redirect()->route('products.index')->with('success', 'Product updated successfully.');
}





    ///////////////////////////////////////////////////////////////////

    private function sendLowStockNotification($product)
{
    $admins = User::where('role', 'admin')->get(); // Notify all admins
    Notification::send($admins, new LowStockNotification($product));
}



    ///////////////////////////////////////////////////////////////////////////////////////////////

    public function stockIn(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);
    
        $product = Product::findOrFail($request->product_id);
    
        // Update product stock
        $product->increment('product_store', $request->quantity);
    
        // Save stock-in history
        DB::table('stock_in_histories')->insert([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        return redirect()->route('inventory.index')->with('success', 'Stock added successfully!');
    }
    



public function stockInHistory(Product $product)
{
    $history = StockInHistory::where('product_id', $product->id)->get();
    return view('products.stockHistory', compact('product', 'history'));
}




////////////////////////////////////////////////////

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        /**
         * Delete photo if exists.
         */
        if($product->product_image){
            Storage::delete('public/products/' . $product->product_image);
        }

        Product::destroy($product->id);

        return Redirect::route('products.index')->with('success', 'Product has been deleted!');
    }

    /**
     * Show the form for importing a new resource.
     */
    public function importView()
    {
        return view('products.import');
    }

    public function importStore(Request $request)
{
    $request->validate([
        'upload_file' => 'required|file|mimes:xls,xlsx',
    ]);

    $the_file = $request->file('upload_file');

    try {
        $spreadsheet = IOFactory::load($the_file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $row_limit = $sheet->getHighestDataRow();
        $startcount = 2;

        foreach (range(2, $row_limit) as $row) {
            // Get data from the sheet
            $product_name = $sheet->getCell('A' . $row)->getValue();
            $category_name = $sheet->getCell('B' . $row)->getValue();
            $supplier_name = $sheet->getCell('C' . $row)->getValue();
            $product_code = $sheet->getCell('D' . $row)->getValue();
            $product_store = $sheet->getCell('E' . $row)->getValue();
            $buying_date = $sheet->getCell('F' . $row)->getValue();
            $buying_price = $sheet->getCell('H' . $row)->getValue();
            $selling_price = $sheet->getCell('I' . $row)->getValue();

            // Find category and supplier by their names
            $category = Category::where('name', $category_name)->first();
            $supplier = Supplier::where('name', $supplier_name)->first();

            // Ensure category and supplier exist
            if (!$category || !$supplier) {
                return Redirect::route('products.index')->with('error', 'Category or Supplier not found!');
            }

            // Check if product exists by product_code
            $product = Product::where('product_code', $product_code)->first();

            // If product exists, update it. Otherwise, create a new one.
            if ($product) {
                // Update the existing product
                $product->update([
                    'product_name' => $product_name,
                    'category_id' => $category->id,
                    'supplier_id' => $supplier->id,
                    'product_store' => $product_store,
                    'buying_date' => $buying_date,
                    'buying_price' => $buying_price,
                    'selling_price' => $selling_price,
                ]);
            } else {
                // Insert a new product
                Product::create([
                    'product_name' => $product_name,
                    'category_id' => $category->id,
                    'supplier_id' => $supplier->id,
                    'product_code' => $product_code,
                    'product_store' => $product_store,
                    'buying_date' => $buying_date,
                    'buying_price' => $buying_price,
                    'selling_price' => $selling_price,
                ]);
            }
        }

    } catch (Exception $e) {
        return Redirect::route('products.index')->with('error', 'There was a problem uploading the data!');
    }

    return Redirect::route('products.index')->with('success', 'Data has been successfully imported!');
}

    public function exportExcel($products){
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '4000M');

        try {
            $spreadSheet = new Spreadsheet();
            $spreadSheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(20);
            $spreadSheet->getActiveSheet()->fromArray($products);
            $Excel_writer = new Xls($spreadSheet);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="Products_ExportedData.xls"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $Excel_writer->save('php://output');
            exit();
        } catch (Exception $e) {
            return;
        }
    }

    /**
     *This function loads the customer data from the database then converts it
     * into an Array that will be exported to Excel
     */
    function exportData(){
        $products = Product::all()->sortByDesc('product_id');

        $product_array [] = array(
            'Product Name',
            'Category Name',
            'Supplier Name',
            'Product Code',
            // 'Product Image',
            'Product Store',
            'Buying Date',
            'Buying Price',
            'Selling Price',
        );

        foreach($products as $product)
        {
            $product_array[] = array(
                'Product Name' => $product->product_name,
                'Category Id' => $product->category->name,
                'Supplier Id' => $product->supplier->name,
                'Product Code' => $product->product_code,
                // 'Product Image' => $product->product_image,
                'Product Store' =>$product->product_store,
                'Buying Date' =>$product->buying_date,
                'Buying Price' =>$product->buying_price,
                'Selling Price' =>$product->selling_price,
            );
        }

        $this->ExportExcel($product_array);
    }   
}
