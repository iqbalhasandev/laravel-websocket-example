<?php

namespace App\Http\Controllers;

use App\Events\TestEvent;
use Illuminate\Http\Request;
use App\Notifications\TestNotification;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    /**
     * Show the application dashboard.
     *
     */
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
        // return auth()->user()->notify(new TestNotification($data));


        // call event
        // return event(new TestEvent());
        broadcast(new TestEvent());

    }
}
