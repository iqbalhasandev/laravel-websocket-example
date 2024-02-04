<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\TestNotification;
use App\Http\Resources\NotificationResource;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return \view('pages.admin.notification.show');
    }


    // public function list()
    // {
    //     return response()->success([
    //         "unreadNotifications" => NotificationResource::collection(auth()->user()->unreadNotifications()->latest()->get()),
    //         "readNotifications"   => NotificationResource::collection(auth()->user()->readNotifications()->latest()->take(4)->get()),
    //     ], 'Notification Fetch Success');
    // }

    public function list()
    {
        return response()->success([
            "unreadNotifications" => NotificationResource::collection(auth()->user()->unreadNotifications()->latest()->take(20)->get()),
            "readNotifications"   => NotificationResource::collection(auth()->user()->readNotifications()->latest()->take(4)->get()),
        ], 'Notification Fetch Success');
    }
    public function read($notification)
    {
        $notification = auth()->user()->unreadNotifications()->where('id', $notification)->first();
        if ($notification) {
            $notification->markAsRead();
        }

    }

    public function readAll()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return response()->success([], 'All Notifications Marked As Read');

    }

    public function clearAll()
    {
        auth()->user()->notifications()->delete();
        return response()->success([], 'All Notifications Cleared');
    }


    public function notify()
    {
        $data = [
            "id"    => rand(1, 100),
            "title" => 'This is demo notification 1',
            "body"  => 'Donec id elit non mi porta.',
            "image" => 'https://via.placeholder.com/150',
            "icon"  => 'fa fa-bell',
            "data"  => [
                "click_action" => 'https://google.com',
                "created_at"   => '2019-01-01 00:00:00'
            ]
        ];
        return auth()->user()->notify(new TestNotification($data));
    }
}
