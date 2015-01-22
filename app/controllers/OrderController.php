<?php

class OrderController extends BaseController
{

    /*
	|--------------------------------------------------------------------------
	| Ticket Controller
	|--------------------------------------------------------------------------
	|
    */

    public function showOrders(){
        if (Auth::user()->status=="active" && Auth::user()->type=="customer"){
            $user_id = Auth::user()->id;
            $orders = Order::where('user_id', '=' , $user_id)->orderBy('created_at' , 'DESC')->paginate(5);

            $onprogress = 'onprogress';
            $order_limited = Order::where('user_id','=',$user_id)->where('status','=',$onprogress)->orderBy('created_at' , 'DESC')->limit('4')->get();

            if(!$orders->first()){
                $orders = false;
            }

            $user = array(
                "fullname" => Auth::user()->fname." ".Auth::user()->lname,
                "orders" => $orders,
                "order_limited" => $order_limited
            );

            return View::make('order')->with('user_info',$user);
        }
        else{
            return Redirect::to('/');
        }
    }

    public function showOrdersAdmin(){
        if (Auth::user()->status=="active" && Auth::user()->type=="admin"){
            //$user_id = Auth::user()->id;
            $orders = Order::orderBy('created_at','DESC')->paginate(5);
            $user = array(
                "fullname" => Auth::user()->fname." ".Auth::user()->lname,
                "orders" => $orders
            );

            return View::make('admin/order')->with('user_info',$user);
        }
        else{
            return Redirect::to('/');
        }
    }

    public function viewOrder($order_id){
        $user_id = Auth::user()->id;
        $order = Order::where('id', '=' , $order_id)->where('user_id','=',$user_id)->first();

        $dateCreated = new DateTime($order->created_at);
        $dateNow = new DateTime();

        $remaining_day = $dateCreated->diff($dateNow);

        $remaining = $order->finish_day - $remaining_day->format("%d");

        if($remaining<0){
            $remaining=0;
            $percentage= 100;
        }else{
            $percentage = round(($remaining * 100) / $order->finish_day);
        }

        $onprogress = 'onprogress';
        $order_limited = Order::where('user_id','=',$user_id)->where('status','=',$onprogress)->limit('4')->get();

        $user = array(
            "fullname" => Auth::user()->fname." ".Auth::user()->lname,
            "order" => $order,
            "remaining"=>$remaining,
            "percentage"=>$percentage,
            "order_limited"=>$order_limited
        );

        if(!$order)
            return Redirect::to('orders');

        return View::make('viewOrder')->with('user_info',$user);
    }

    public function viewOrderAdmin($order_id){
        if (Auth::user()->type=="customer"){
            return Redirect::to('/');
        }

        //$user_id = Auth::user()->id;
        //$order = Order::where('id', '=' , $order_id)->first();
        $order = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->where('orders.id' , '=' , $order_id)
            ->select('orders.id','users.fname','users.lname','users.email','orders.created_at','orders.document','orders.title','orders.short_info','orders.finish_day','orders.price','orders.payment_type','orders.status')
            ->orderby('orders.created_at')
            ->first();

        $dateCreated = new DateTime($order->created_at);
        //$fdateCreated = $dateCreated->format('d m Y');
        $dateNow = new DateTime();

        $remaining_day = $dateCreated->diff($dateNow);

        $remaining = abs($order->finish_day - $remaining_day->format("%d"));

        $user = array(
            "fullname" => Auth::user()->fname." ".Auth::user()->lname,
            "order" => $order,
            "remaining"=>$remaining
        );

        if(!$order)
            return Redirect::to('orders');

        return View::make('admin/viewOrder')->with('user_info',$user);
    }

    public function updateOrderAdmin(){
        $status = Input::get('status');
        $url	= Input::get('url');
        $order_id = Crypt::decrypt(Input::get('order_id'));

        $order_obj = Order::where('id','=',$order_id)->first();
        $order_obj->status = $status;

        if($status=="active")
            $order_obj->document = $url;

        if($order_obj->save()){
            return Redirect::to('admin/viewOrder/'.$order_id);
        }else{
            return Redirect::to('/');
        }
    }

    public function doOrders()
    {
        $rules = array(
            'title'	   => 'required',
            'price'	   => 'required',
            'finish_day'    => 'required',
            'short_info' => 'required|max:100',
        );

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::to('orders')
                ->withErrors($validator);
        }else{
            $order = new Order;
            $order->title = Input::get('title');
            $order->price = Input::get('price');
            $order->finish_day = Input::get('finish_day');
            $order->short_info  = Input::get('short_info');
            $order->payment_type  = Input::get('payment_type');
            $order->user_id = Auth::id();
            if($order->save()) {
                return Redirect::to('orders')->with('success_info',true);
            }
            else{
                return Redirect::to('orders');
            }
        }
    }

}