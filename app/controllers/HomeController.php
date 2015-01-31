<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
		if (Auth::check()){
            $user_id = Auth::user()->id;
            $user_type = Auth::user()->type;

            if($user_type=="customer"){
                $active_order = Order::where('user_id', '=' , $user_id)->where('status','active')->count();
                $all_order	  = Order::where('user_id', '=' , $user_id)->count();
                $all_ticket	  = Ticket::where('sender_id', '=' , $user_id)->whereRaw('message_id = id')->count();
            }else{
                $active_order = Order::where('status','active')->count();
                $all_order	  = Order::count();
                $all_ticket	  = Ticket::whereRaw('message_id = id')->count();
            }

            $onprogress = 'onprogress';
            $order_limited = Order::where('user_id','=',$user_id)->where('status','=',$onprogress)->orderBy('created_at' , 'DESC')->limit('4')->get();

            $user = array(
            "active_order"=>$active_order,
            "all_order" => $all_order,
            "all_ticket"=> $all_ticket,
            "fullname" => Auth::user()->fname." ".Auth::user()->lname,
            "order_limited"=>$order_limited
            );
            return View::make('main')->with('user_info',$user);
		}
		else{
			return View::make('login');
		}
	}
	
	public function showMain(){
        if(Auth::check()){
            $user_id = Auth::user()->id;

            $user_type = Auth::user()->type;
            if($user_type=="customer"){
                $active_order = Order::where('user_id', '=' , $user_id)->where('status','active')->count();
                $all_order	  = Order::where('user_id', '=' , $user_id)->count();
                $all_ticket	  = Ticket::where('sender_id', '=' , $user_id)->whereRaw('message_id = id')->count();
            }else{
                $active_order = Order::where('status','active')->count();
                $all_order	  = Order::count();
                $all_ticket	  = Ticket::whereRaw('message_id = id')->count();
            }

            $onprogress = 'onprogress';
            $order_limited = Order::where('user_id','=',$user_id)->where('status','=',$onprogress)->orderBy('created_at' , 'DESC')->limit('4')->get();

            $user = array(
            "active_order"=>$active_order,
            "all_order" => $all_order,
            "all_ticket"=> $all_ticket,
            "fullname" => Auth::user()->fname." ".Auth::user()->lname,
            "order_limited"=>$order_limited
            );
            return View::make('main')->with('user_info',$user);
        }else{
            return Redirect::to('/');
        }
	}
	
	public function showProfile(){
        if(Auth::check()){
            $user_id = Auth::user()->id;
            $onprogress = 'onprogress';
            $order_limited = Order::where('user_id','=',$user_id)->where('status','=',$onprogress)->orderBy('created_at' , 'DESC')->limit('4')->get();

            $user = array(
            "fullname" => Auth::user()->fname." ".Auth::user()->lname,
            "fname" => Auth::user()->fname,
            "lname" => Auth::user()->lname,
            "email" => Auth::user()->email,
            "order_limited"=>$order_limited
            );
            return View::make('profile')->with('user_info',$user);
        }else{
            return Redirect::to('/');
        }
	}

	public function showAccounts(){
        if(Auth::check()){
			$user_id = Auth::user()->id;
			$onprogress = 'onprogress';
			$order_limited = Order::where('user_id','=',$user_id)->where('status','=',$onprogress)->orderBy('created_at' , 'DESC')->limit('4')->get();
			
			$user = array(
			"fullname" => Auth::user()->fname." ".Auth::user()->lname,
			"order_limited"=>$order_limited
			);
	    	return View::make('account')->with('user_info',$user);
		}
		else{
			return Redirect::to('/');
		}
	}
	
	public function showRegister(){
		return View::make('register');
	}

	public function passwordActivate($code){
		$activation = Activation::where('code','=',$code)->first();
		
		if(!$activation)
			return Redirect::to('/')->with('wrong_code',true);
			
		$user_id = $activation->user_id;
		
		$user = User::where('id','=',$user_id)->first();
		
		if($user->status=="passive"){
			$user->status = 'active';
			
			if($user->save()){
				return Redirect::to('/')->with('activation_success',true);
			}else{
				return Redirect::to('/')->with('activation_error',true);
			}
		}else{
			return Redirect::to('/')->with('already_activated',true);
		}
	}

	public function doLogin()
	{
		$remember = (Input::has('remember')) ? true : false;
		$rules = array(
			'email'    => 'required|email',
			'password' => 'required|min:6'
		);
		
		$validator = Validator::make(Input::all(), $rules);
		
		if ($validator->fails()) {
			return Redirect::to('/')
				->withErrors($validator)
				->withInput(Input::except('password'));
		}else{
			
			$email = Input::get('email');
			$user_check = User::where('email','=',$email)->first();
			
			if($user_check){
				if($user_check->status=="active"){
					$userdata = array(
		            'email' => Input::get('email'),
		            'password' => Input::get('password'),
                    'status'=>'active'
		        	);
			 
			        if(Auth::attempt($userdata,$remember)) {
			            return Redirect::to('main');
			        }
			        else{
			            return Redirect::to('/')->with('error_info',true);
			        }
		        }else{
		        	return Redirect::to('/')->with('activation_required',true);
		        }
	        }else{
	        	return Redirect::to('/')->with('no_user',true);
	        }
		}
	}

	public function showPasswordForget(){
		return View::make("password.forget");
	}
	
	public function createReset(){
		$email = Input::get('email');
		$user_obj = User::where('email','=',$email)->first();
		
		if($user_obj){
			$user_id = $user_obj->id;
			$reset_user = Reset::where('user_id','=',$user_id)->first();
			$reset_code = substr(md5(Date("d m y H i s")),10,15);
			
			//If user already request reset password , update reset code
			if($reset_user){	
				$reset_user->code = $reset_code;
				$reset_user->save();
			}else{
				$new_reset = new Reset();
				$new_reset->code = $reset_code;
				$new_reset->user_id = $user_id;
				$new_reset->save();
			}
			
			$data = array(
				"fname" => $user_obj->fname,
				"lname" => $user_obj->lname,
				"email" => $user_obj->email,
				"reset_code" => $reset_code
			);

			Mail::send("password.forgetText", $data,function($message) use ($data)
			{
				$message->to($data['email'], $data['fname'] ." ".$data['lname'])->subject('Şifre Sıfırlama!');
			});
			return Redirect::to('/')->with('reset_send',true);
		}
		return Redirect::to('password/forget');
	}
	
	public function passwordReset($reset_code){
		$reset_check = Reset::where('code','=',$reset_code)->first();
		if($reset_check){
			return View::make('password.resetForm')->with("reset_code",$reset_code);
		}
		else{
			return Redirect::to('/');
		}
	}
	
	public function passwordUpdate()
	{
		if(Input::get('reset_code')){
			$reset_code = Crypt::decrypt(Input::get('reset_code'));
			$rules = array(
				'password'    => 'required|alphaNum|min:6',
				'password_again' => 'required|same:password'
			);
			
			$validator = Validator::make(Input::all(), $rules);
			
			if ($validator->fails()) {
				return Redirect::to('password/reset/'.$reset_code)
					->withErrors($validator)
					->withInput(Input::except('password'));
			}else{
				
				$password = Input::get('password');
				$reset_info = Reset::where('code','=',$reset_code)->first();
				$user_id = $reset_info->user_id;
				
				$user_obj = User::where('id','=',$user_id)->first();
				$user_obj->password = Hash::make($password);
				
				if($user_obj->save()){
					$reset_info->code = "";
					if($reset_info->save()){
						return Redirect::to('/')->with('password_changed',true);
					}else{
						return Redirect::to('/')->with('password_changed_error',true);
					}
				}else{
					return Redirect::to('/')->with('password_changed_error',true);
				}
			}
		}else{
			return Redirect::to('/');
		}
	}
	
	public function doLogout()
	{
		Auth::logout();
		return Redirect::to('/')->with('logout_success',true);
	}
	
	public function doRegister(){
		$rules = array(
			'fname'	   => 'required',
			'lname'	   => 'required',
			'email'    => 'required|email|unique:users',
			'password' => 'required|min:6',
			'password_again'=>'required|same:password',
			'g-recaptcha-response' => 'required|recaptcha',
		);
		
		$validator = Validator::make(Input::all(), $rules);
		
		if ($validator->fails()) {
			return Redirect::to('register')
				->withErrors($validator)
				->withInput(Input::except('password'));
		}else{
			$user = new User;
			$user->fname = Input::get('fname');
			$user->lname = Input::get('lname');
            $user->email = Input::get('email');
			$user->type  = "customer";
			$user->status = "passive";
   	        $user->password = Hash::make(Input::get('password'));
			
			//Create activation code from hash
			$temp_hash = md5(Date("d m y H i s"));
			$activation_code = substr($temp_hash, 10 , 15);
			
			$user->save();
			$user_id = $user->id;
			
			$activation = new Activation;
			$activation->code = $activation_code;
			$activation->user_id = $user_id;
			
			if($activation->save()) {
				//Sends activation code
				Mail::send("emails.welcome", array("fname" => Input::get("fname") , "lname" => Input::get("lname") , "activation_code" => $activation_code), function($message)
				{
				    $message->to(Input::get('email'), Input::get('fname')." ".Input::get('lname'))->subject('Hoşgeldiniz!');
				});
	            return Redirect::to('/')->with("success_info",true);
	        }
	        else{
	            return Redirect::to('/');
	        }
		}
	}

	public function updateProfile()
	{
		$rules = array(
			'password' => 'alphaNum|min:6|same:password_again'
		);
		
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
			return Redirect::to('profile')
				->withErrors($validator);
		}else{
			$user_id = Auth::user()->id;
			
			$user_obj = User::where('id','=',$user_id)->first();
			if(trim(Input::get('fname'))!=""){
				$user_obj->fname = Input::get('fname');
			}
			if(trim(Input::get('lname'))!=""){
				$user_obj->lname = Input::get('lname');
			}
			if(trim(Input::get('password'))!=""){
				$user_obj->password = Hash::make(Input::get('password'));
			}
			
			if($user_obj->save()) {
				if(trim(Input::get('password'))!=""){
					return Redirect::to('logout');
				}
	            return Redirect::to('profile')->with('success_info',true);
	        }
	        else{
	            return Redirect::to('profile');
	        }
		}
	}
}
