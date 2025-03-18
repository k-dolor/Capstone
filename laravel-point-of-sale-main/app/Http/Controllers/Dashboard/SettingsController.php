<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth; // ✅ Correct import
use Illuminate\Support\Facades\File;
class SettingsController extends Controller
{
    //
//     public function index()
//     {
//         $totalUsers = User::count();
//         $notifications = Notification::latest()->take(5)->get(); // Get the latest 5 notifications
    
//         return view('settings.index', compact('totalUsers', 'notifications'));
//     }
// }
 public function index()
    {
        $users = User::with('roles')->get();
        $totalUsers = User::count();
        $superAdmins = User::whereHas('roles', function ($query) {
            $query->where('name', 'SuperAdmin');
        })->count();
        $admins = User::whereHas('roles', function ($query) {
            $query->where('name', 'Admin');
        })->count();
        $notifications = Notification::latest()->take(5)->get(); // Fetch all notifications

        $backupPath = storage_path('app/POS'); // Path to your backup folder

        // Check if the backup folder exists
        if (!File::exists($backupPath)) {
            $backups = collect([]); // Return empty collection if no backups exist
        } else {
            $backups = collect(File::allFiles($backupPath))->map(function ($file) {
                return [
                    'filename' => $file->getFilename(),
                    'size' => number_format($file->getSize() / 1024, 2) . ' KB',
                    'path' => $file->getPathname(),
                    'date' => date('m-d-Y | H:i', $file->getMTime()), // File modified time
                ];
            });
        }

        return view('settings.index', compact('users','totalUsers', 'superAdmins', 'admins', 'notifications', 'backups'));
    }


public function toggleNightMode()
{
    if (session('nightMode')) {
        session()->forget('nightMode'); // Disable Night Mode
        return response()->json(['status' => 'disabled']);
    } else {
        session(['nightMode' => true]); // Enable Night Mode
        return response()->json(['status' => 'enabled']);
    }
}

}

// public function markNotificationAsRead($id)
// {
//     $notification = Auth::user()->notifications()->find($id);
    
//     if ($notification) {
//         $notification->markAsRead();
//     }

//     return back();
// }

