<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;


class NotificationController extends Controller
{
    // Fetch unread notifications
    public function fetchNotifications()
    {
        if (Auth::check()) {
            $notifications = Notification::where('user_id', Auth::id())
                ->where('is_read', false)
                ->latest()
                ->get();
                
            return response()->json($notifications);
        }
        
        return response()->json([]);
    }

    // Mark notification as read
    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }
}

////////////////////021225

    //   public function markAsRead($id)
    // {
    //     $notification = Auth::user()->notifications()->find($id);

    //     if ($notification) {
    //         $notification->markAsRead();
    //     }

    //     return redirect()->back();
    // }


//     public function markAsRead($id)
//     {
//         $notification = Notification::findOrFail($id);
//         $notification->is_read = true;
//         $notification->save();

//         return redirect()->back();
//     }
// }


