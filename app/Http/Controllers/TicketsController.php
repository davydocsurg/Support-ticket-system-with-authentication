<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Ticket;
use App\Http\Requests\TicketFormRequest;
use App\Mailers\AppMailer;
use Illuminate\Support\Facades\Auth;

class TicketsController extends Controller
{

    public function index()
    {
        $tickets = Ticket::all();
        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('tickets.create', compact('categories'));
    }

    public function store(Request $request, AppMailer $mailer)
    {
    $this->validate($request, [
            'title'     => 'required',
            'category'  => 'required',
            'priority'  => 'required',
            'message'   => 'required'
        ]);

        $ticket = new Ticket([
            'title'     => $request->input('title'),
            'user_id'   => Auth::user()->id,
            'ticket_id' => strtoupper(str_random(10)),
            'category_id'  => $request->input('category'),
            'priority'  => $request->input('priority'),
            'message'   => $request->input('message'),
            'status'    => "Open",
        ]);

        $ticket->save();

        $mailer->sendTicketInformation(Auth::user(), $ticket);

        return redirect()->back()->with("status", "A ticket with ID: #$ticket->ticket_id has been opened.");
    }

    public function show($ticket_id)
    {
        $ticket = Ticket::whereTicket_Id($ticket_id)->firstOrFail();
        // $comments = $ticket->comments()->get();
        return view('tickets.show', compact('ticket'));
    }
    
    public function edit($ticket_id)
    {
        $ticket = Ticket::whereTicket_id($ticket_id)->firstOrFail();

        return view('tickets.edit', compact('ticket'));
    }

    public function update($ticket_id, TicketFormRequest $request)
    {
        $ticket = Ticket::whereTicket_id($ticket_id)->firstOrFail();
        $ticket->title = $request->get('title');
        $ticket->content = $request->get('content');
        if($request->get('status') != null) {
        $ticket->status = 0;
    } 
    else {
        $ticket->status = 1;
    }
    $ticket->save();
    return redirect(action('TicketsController@edit', $ticket->ticket_id))->with('status', 'The ticket '.$ticket_id.' has been updated!');
    
    }

    public function destroy($ticket_id)
    {
        $ticket = Ticket::whereTicket_id($ticket_id)->firstOrFail();
        $ticket->delete();

          $data = array(
            'ticket' => $ticket_id,
        ); 
        return redirect('/tickets')->with('status', 'The ticket '.$ticket_id.' has been deleted!');

}
}