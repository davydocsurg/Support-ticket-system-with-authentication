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

    public function store(TicketFormRequest $request, AppMailer $mailer)
    {

        $this->validate($request, [
            'title'     => 'required',
            'category'  => 'required',
            'priority'  => 'required',
            'message'   => 'required'
        ]);

        $slug = uniqid();
        $ticket = new Ticket(array(
        'title' => $request->get('title'),
        'category' => $request->get('category'),
        'priority' => $request->get('priority'),
        'slug' => $slug
        ));

  

        $ticket = new Ticket([
            
            'title'     => $request->input('title'),
            'user_id'   => Auth::user()->id,
            'slug' => $slug,
            'category_id'  => $request->input('category'),
            'priority'  => $request->input('priority'),
            'message'   => $request->input('message'),
            'status'    => "Open",
        ]);

        $ticket->save();

        $mailer->sendTicketInformation(Auth::user(), $ticket);

        return redirect()->back()->with("status", "Your ticket has been opened, you can view it via your email. Its ID is "  .$slug );
    }

    public function show($slug)
    {
        $ticket = Ticket::whereSlug($slug)->firstOrFail();
        // $comments = $ticket->comments()->get();
        return view('tickets.show', compact('ticket'));
    }
    
    public function edit($slug)
    {
        $ticket = Ticket::whereSlug($slug)->firstOrFail();

        return view('tickets.edit', compact('ticket'));
    }

    public function update($slug, TicketFormRequest $request)
    {
        $ticket = Ticket::whereSlug($slug)->firstOrFail();
        $ticket->title = $request->get('title');
        $ticket->priority = $request->get('priority');
        $ticket->message = $request->get('message');
        if($request->get('status') != null) {
        $ticket->status = 0;
    } 
    else {
        $ticket->status = 1;
    }
    $ticket->save();
    return redirect(action('TicketsController@edit', $ticket->slug))->with('status', 'The ticket '.$slug.' has been updated!');
    
    }

    public function destroy($slug)
    {
        $ticket = Ticket::whereSlug($slug)->firstOrFail();
        $ticket->delete();
        return redirect('/tickets')->with('status', 'Your ticket '.$slug.' has been deleted!');

    }


}