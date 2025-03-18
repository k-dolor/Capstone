<?php

namespace App\Http\Controllers\Dashboard;

use File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;


class DatabaseBackupController extends Controller
{    

    public function index(Request $request)
    {
        
        $backupPath = storage_path('app/POS');
        $search = $request->input('search');
        $orderDate = $request->input('order_date');
    
        $files = collect(\File::allFiles($backupPath))->map(function ($file) {
            return [
                'filename' => $file->getFilename(),
                'size' => number_format($file->getSize() / 1024, 2) . ' KB',
                'path' => $file->getPathname(),
                'date' => date('Y-m-d', $file->getCTime()), // Extract date from file created time
            ];
        });
    
        // Apply search filter
        if ($search) {
            $files = $files->filter(function ($file) use ($search) {
                return stripos($file['filename'], $search) !== false;
            });
        }
    
        // Apply date filter
        if ($orderDate) {
            $files = $files->filter(function ($file) use ($orderDate) {
                return $file['date'] === $orderDate;
            });
        }
    
        return view('database.index', compact('files', 'search', 'orderDate'));
    }
    
//     public function index()
// {
//     $backupPath = storage_path('app/POS');

//     if (!File::exists($backupPath)) {
//         abort(404, 'Backup folder not found.');
//     }

//     $files = collect(File::allFiles($backupPath))->map(function ($file) {
//         return [
//             'filename' => $file->getFilename(),
//             'size' => number_format($file->getSize() / 1024, 2) . ' KB',
//             'path' => $file->getPathname()
//         ];
//     });
    

//     return view('database.index', compact('files'));
// }

// CREATE WITH CUSTOM NAME IN ZIP----------------------------------------

// public function create()
// {
//     // Custom backup filename
//     $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
//     $backupFilename = "Database_{$timestamp}.zip"; // Example: Database_2025-03-08_15-30-00.zip

//     // Run the backup command
//     Artisan::call('backup:run --only-db');

//     // Get the latest backup file and rename it
//     $backupPath = storage_path('app/Laravel'); // Adjust if needed
//     $latestBackup = collect(\File::allFiles($backupPath))
//                         ->sortByDesc(fn($file) => $file->getMTime())
//                         ->first();

//     if ($latestBackup) {
//         $newPath = $backupPath . '/' . $backupFilename;
//         \File::move($latestBackup->getPathname(), $newPath);
//     }

//     return redirect()->back()->with('success', 'Database backup created successfully.');
// }

public function create()
{
    $databaseName = env('DB_DATABASE');
    $username = env('DB_USERNAME');
    $password = env('DB_PASSWORD');
    $backupPath = storage_path('app/POS/' . date('Y-m-d_H-i') . '.sql');

    

    $command = "D:\\APPS\\Xampp2\\mysql\\bin\\mysqldump --user={$username} --password={$password} {$databaseName} > {$backupPath}";

    exec($command, $output, $result);

    if ($result === 0) {
        return redirect()->back()->with('success', 'Database backup created successfully.');
    } else {
        return redirect()->back()->with('error', 'Failed to create backup.');
    }
}



    public function download($filename)
{
    $filePath = storage_path("app/POS/{$filename}");

    if (!File::exists($filePath)) {
        abort(404, 'File not found.');
    }

    return response()->download($filePath);
}

public function delete($filename)
{
    $filePath = storage_path("app/POS/{$filename}");

    if (File::exists($filePath)) {
        File::delete($filePath);
        return redirect()->back()->with('success', 'Backup deleted successfully.');
    }

    return redirect()->back()->with('error', 'File not found.');
}


//     public function download($filename)
// {
//     $filePath = storage_path("app/Laravel/{$filename}");

//     if (!File::exists($filePath)) {
//         abort(404, 'File not found.');
//     }

//     return response()->download($filePath);
// }


//     public function delete($getFileName)
//     {
//         $filePath = storage_path('app/POS/' . $getFileName);

//         if (file_exists($filePath)) {
//             unlink($filePath);
//             return Redirect::route('backup.index')->with('success', 'Backup Deleted Successfully!');
//         }

//         return Redirect::route('backup.index')->with('error', 'File not found.');
//     }
}


// namespace App\Http\Controllers\Dashboard;

// use File;
// use Illuminate\Http\Request;
// use App\Http\Controllers\Controller;
// use Illuminate\Support\Facades\Storage;
// use Illuminate\Support\Facades\Redirect;

// class DatabaseBackupController extends Controller
// {    public function index()
//     {
//         return view('database.index', [
//             'files' => File::allFiles(storage_path('/app/POS'))
//         ]);
//     }

    // Backup database is not working, and you need to enter manually in terminal with command php artisan backup:run.
//     public function create(){
//         \Artisan::call('backup:run');

//         return Redirect::route('backup.index')->with('success', 'Database Backup Successfully!');
//     }

//     public function download(String $getFileName)
//     {
//         $path = storage_path('app\POS/' . $getFileName);

//         return response()->download($path);
//     }

//     public function delete(String $getFileName)
//     {
//         Storage::delete('POS/' . $getFileName);

//         return Redirect::route('backup.index')->with('success', 'Database Deleted Successfully!');
//     }
// }
