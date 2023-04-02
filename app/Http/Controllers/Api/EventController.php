<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Clients;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function get(Request $request)
    {
        $events = Event::with('tickets');

        if ($request->has('address') && !empty($request->address)) {
            $events = $events->where('address' , 'LIKE' , '%' . $request->address . '%');
        }

        if ($request->has('start_date') && !empty($request->start_date)) {
            $events = $events->where('start_date' , '>=' , $request->start_date . " 00:00:00");
        }

        if ($request->has('end_date') && !empty($request->end_date)) {
            $events = $events->where('end_date' , '<=' , $request->end_date . " 00:00:00");
        }

        $events = $events->get();
        foreach($events as $event){
            $event->picture = config('app.url')."/storage/" .$event->picture;
        }

        return $events;
    }
}
