<?php

class TicketController extends BaseController {

    /*
	|--------------------------------------------------------------------------
	| Ticket Controller
	|--------------------------------------------------------------------------
	|
    */

    public function showTickets(){
        if (Auth::user()->type=="customer" && Auth::user()->status=="active"){
            $user_id = Auth::user()->id;
            $tickets = Ticket::where('sender_id', '=' , $user_id)->whereRaw('message_id = id')->orderBy('created_at' , 'DESC')->paginate(5);

            $onprogress = 'onprogress';
            $order_limited = Order::where('user_id','=',$user_id)->where('status','=',$onprogress)->orderBy('created_at' , 'DESC')->limit('4')->get();

            if(!$tickets->first()){
                $tickets = false;
            }

            $user = array(
                "fullname" => Auth::user()->fname." ".Auth::user()->lname,
                "tickets"  => $tickets,
                "order_limited"=>$order_limited
            );
            return View::make('ticket')->with('user_info',$user);
        }
        else{
            return Redirect::to('/');
        }
    }

    public function showTicketsAdmin(){
        if (Auth::user()->status=="active" && Auth::user()->type=="admin"){
            $tickets = Ticket::whereRaw('message_id = id')->orderBy('created_at' , 'DESC')->paginate(5);
            $user = array(
                "fullname" => Auth::user()->fname." ".Auth::user()->lname,
                "tickets"  => $tickets
            );
            return View::make('admin/ticket')->with('user_info',$user);
        }
        else{
            return Redirect::to('/');
        }
    }

    public function viewTicket($ticket_id){
        $ticket_test = Ticket::where('id', '=' , $ticket_id)->where('sender_id','=',Auth::user()->id)->whereRaw('id=message_id')->first();
        if(!$ticket_test)
            return Redirect::to('/');

        $ticket = DB::table('tickets')
            ->join('users', 'tickets.sender_id', '=', 'users.id')
            ->where('tickets.message_id' , '=' , $ticket_id)
            ->select('tickets.subject','tickets.id','tickets.created_at','tickets.message','users.fname','users.lname')
            ->orderby('tickets.created_at')
            ->paginate(3);

        $user_id = Auth::user()->id;
        $onprogress = 'onprogress';
        $order_limited = Order::where('user_id','=',$user_id)->where('status','=',$onprogress)->limit('4')->get();

        $user = array(
            "fullname" => Auth::user()->fname." ".Auth::user()->lname,
            "ticket" => $ticket,
            "message_id"=>$ticket_id,
            "first_ticket"=>$ticket_test,
            "order_limited"=>$order_limited
        );

        if(!$ticket)
            return Redirect::to('/');

        return View::make('viewTicket')->with('user_info',$user);
    }

    public function viewTicketAdmin($ticket_id){
        if(Auth::user()->type!="admin"){
            return Redirect::to('/');
        }

        $ticket_test = Ticket::where('id', '=' , $ticket_id)->whereRaw('id=message_id')->first();
        if(!$ticket_test)
            return Redirect::to('/');

        $ticket = DB::table('tickets')
            ->join('users', 'tickets.sender_id', '=', 'users.id')
            ->where('tickets.message_id' , '=' , $ticket_id)
            ->select('tickets.subject','tickets.id','tickets.created_at','tickets.message','users.fname','users.lname')
            ->orderby('tickets.created_at')
            ->paginate(3);
        $user = array(
            "fullname" => Auth::user()->fname." ".Auth::user()->lname,
            "ticket" => $ticket,
            "message_id"=>$ticket_id,
            "first_ticket"=>$ticket_test
        );

        if(!$ticket)
            return Redirect::to('/');

        return View::make('admin/viewTicket')->with('user_info',$user);
    }

    public function updateTicket(){
        $status = Input::get('status');
        $ticket_id = Crypt::decrypt(Input::get('ticket_id'));

        $ticket_obj = Ticket::where('id','=',$ticket_id)->first();
        $ticket_obj->status = $status;

        if($ticket_obj->save()){
            return Redirect::to('admin/viewTicket/'.$ticket_id);
        }else{
            return Redirect::to('/');
        }
    }

    public function doTickets()
    {
        $rules = array(
            'subject' => 'required|max:100',
            'message' => 'required|max:255'
        );

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::to('tickets')
                ->withErrors($validator);
        }else{
            $ticket = new Ticket;
            $ticket->subject = Input::get('subject');
            $ticket->message = Input::get('message');
            $ticket->sender_id = Auth::user()->id;
            $ticket->receiver_id = "1";
            if($ticket->save()){
                $message_id = $ticket->id;
                $ticket_obj = Ticket::where('id','=',$message_id)->first();
                $ticket_obj->message_id = $message_id;
                $ticket_obj->save();
                return Redirect::to('tickets')->with('success_info',true);
            }
            return Redirect::to('tickets');
        }
    }

    public function createAnswer()
    {
        $message_id = Crypt::decrypt(Input::get('message_id'));
        $ticket_first = Ticket::where('id', '=' , $message_id)->orderBy('created_at')->first();

        $ticket = new Ticket;
        $ticket->subject = $ticket_first->subject;
        $ticket->message = Input::get('answer');
        $ticket->sender_id = Auth::id();
        $ticket->receiver_id = "1";
        $ticket->message_id = $message_id;

        if($ticket->save()) {
            if(Auth::user()->type=="admin"){
                return Redirect::to('admin/viewTicket/'.$ticket->message_id)->with('success_info',true);
            }else{
                return Redirect::to('viewTicket/'.$ticket->message_id)->with('success_info',true);
            }
        }
        else{
            return Redirect::to('tickets');
        }

    }
}