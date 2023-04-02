<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;

use function Pest\Laravel\delete;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      return view('admin.event.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $file = $request->picture->store('pictures', 'public');
         $start_date = Carbon::createFromFormat('m/d/Y', $request->start )->format('Y-m-d') . " 00:00:00";
       $end_date = Carbon::createFromFormat('m/d/Y', $request->end )->format('Y-m-d') . " 00:00:00";
       $event = Event::create([
            'name' => $request->name,
            'description' => $request->description,
            'address' => $request->address,
            'start_date' => $start_date,
            'end_date' =>  $end_date,
            'picture' => $file
       ]);

       foreach($request->ticket as $key => $value) {
        Ticket::create([
            'event_id' => $event->id,
            'type' => config('ticket_type')[$key],
                'price' => $value ?? 0
        ]);
       }

       return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $event = Event::with('tickets')->where('id', $id)->first();
        if($event) {
            return view('admin.event.edit', compact('event'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $event = Event::where('id' , $id)->first();

        $start_date = Carbon::createFromFormat('m/d/Y', $request->start )->format('Y-m-d') . " 00:00:00";
       $end_date = Carbon::createFromFormat('m/d/Y', $request->end )->format('Y-m-d') . " 00:00:00";

        $update_array = [
            'name' => $request->name,
            'description' => $request->description,
            'address' => $request->address,
            'start_date' => $start_date,
            'end_date' =>  $end_date,
        ];


        if ($request->hasFile('picture')) {
            $file = $request->picture->store('pictures','public');
            $update_array['picture'] = $file;
        }

        $event = $event->update($update_array);

        Ticket::where('event_id' , $id)->delete();
        foreach($request->ticket as $key => $value) {
            Ticket::create([
                'event_id' => $id,
                'type' => config('ticket_type')[$key],
                    'price' => $value ?? 0
            ]);
           }


        return redirect()->route('dashboard');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        //
        Event::where('id' , $id)->delete();
        Ticket::where('event_id',$id)->delete();

        return redirect()->route('dashboard');

    }
}
