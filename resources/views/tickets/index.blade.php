@extends('layouts.app')

@section('title', 'Tickets')

@section('content')

<div class='container'>
   <div class="row justify-content-center">
      <div class="card ">
         <div class='card-header'>Tickets</div>
         <div class='card-body'>
          <table class="table " id="">
           <thead>
              <tr>
                 <th>Category</th>
                 <th>Title</th>
                 <th>Status</th>
                 <th>Last updated</th>
              </tr>
           </thead>
           <tbody>
              @foreach($tickets as $ticket)
              <tr>
                 <td>{{ $ticket->category->name }}</td>
                 <td>{{ $ticket->title }}</td>
                 <td><a href="{{ action('TicketsController@show', $ticket->slug) }}" class='btn btn-success'>{{ $ticket->status ? 'Open' : 'Closed'}}</a></td>
                 <td>{{ date('Y-m-d', strtotime ($ticket->created_at)) }}</td>
               
              </tr>
              @endforeach
           </tbody>
          </table>
         </div>
       </div> 
   </div>
</div>
@endsection