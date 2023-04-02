<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a class="ml-3" href="{{route('admin.event.create')}}">
                {{ __('Add EVent') }}
            </a>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <table class="border-collapse w-full text-sm border border-slate-400">
                    <thead>
                        <tr>
                          <th class="border border-slate-300 ...">id</th>

                          <th class="border border-slate-300 ...">Picture</th>
                          <th class="border border-slate-300 ...">Name</th>
                          <th class="border border-slate-300 ...">Description</th>
                          <th class="border border-slate-300 ...">Address</th>
                          <th class="border border-slate-300 ...">Start Date</th>
                          <th class="border border-slate-300 ...">End Date</th>
                          <th class="border border-slate-300 ...">Price</th>

                          <th class="border border-slate-300 ...">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($events as $event)

                        <tr>
                          <td class="border border-slate-300 ...">

                            <figure class="max-w-lg">
                                <img class="h-auto max-w-full rounded-lg" src="{{url('storage/' . $event->picture)}}" alt="image description" height="100px" width="100px">
                              </figure>

                          </td>
                          <td class="border border-slate-300 ...">{{$event->id}}</td>

                          <td class="border border-slate-300 ...">{{$event->name}}</td>
                          <td class="border border-slate-300 ...">{{$event->description}}</td>
                          <td class="border border-slate-300 ...">{{$event->address}}</td>
                          <td class="border border-slate-300 ...">{{Carbon\Carbon::parse($event->start_date)->format('Y-m-d')}}</td>
                          <td class="border border-slate-300 ...">{{Carbon\Carbon::parse($event->end_date)->format('Y-m-d')}}</td>
                          @if (!empty($event->tickets ))
                            <td class="border border-slate-300 ...">
                                <ol>
                                @foreach ($event->tickets as $item)
                                    <li>  {{$item->type}} - {{$item->price}} </li>
                                @endforeach
                                </ol>
                            </td>
                              @else
                          <td class="border border-slate-300 ..."></td>

                          @endempty

                          <td class="border border-slate-300 ..."><a href="{{route('admin.event.edit' , $event->id)}}">edit</a> |
                             <a href="{{route('admin.event.delete' , $event->id)}}">Remove</a></td>

                        </tr>
                        @endforeach

                      </tbody>
                  </table>
            </div>
        </div>
    </div>
</x-app-layout>
