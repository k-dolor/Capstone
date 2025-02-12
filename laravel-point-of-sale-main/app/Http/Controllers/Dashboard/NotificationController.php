<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller; // ✅ Add this line
use Illuminate\Http\Request;
use App\Models\Notification; // ✅ Add this line if missing

class NotificationController extends Controller
{
    public function show(Notification $notification)
    {
        // Mark the notification as read
        $notification->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }


    // Get unread notifications count
    public function getUnreadCount()
    {
        $count = auth()->user()->unreadNotifications->count();
        return response()->json(['count' => $count]);
    }

////////////////////021225

      public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->find($id);

        if ($notification) {
            $notification->markAsRead();
        }

        return redirect()->back();
    }
}


    // // Mark all notifications as read
    // public function markAllAsRead()
    // {
    //     auth()->user()->unreadNotifications->markAsRead();
    //     return response()->json(['message' => 'Notifications marked as read']);
    // }

//     public function markAsRead(Request $request)
// {
//     $notification = \App\Models\Notification::find($request->id);
//     if ($notification) {
//         $notification->update(['is_read' => true]); // Mark as read
//         return response()->json(['success' => true]);
//     }
//     return response()->json(['success' => false]);
// }
// public function markAsRead(Request $request)
//     {
//         // Validate the notification ID
//         $notification = Notification::find($request->id);

//         if ($notification) {
//             // Mark the notification as read
//             $notification->update(['is_read' => true]);

//             return response()->json(['success' => true]);
//         }

//         return response()->json(['success' => false, 'message' => 'Notification not found'], 404);
//     }
