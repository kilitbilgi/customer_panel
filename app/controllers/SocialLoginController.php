<?php

class SocialLoginController extends BaseController{

    public function loginWithFacebook() {
        ob_start();
        // get data from input
        $code = Input::get( 'code' );

        // get fb service
        $fb = OAuth::consumer( 'Facebook' );

        // check if code is valid

        // if code is provided get user data and sign in
        if ( !empty( $code ) ) {

            // This was a callback request from facebook, get the token
            $token = $fb->requestAccessToken( $code );

            // Send a request with it
            $result = json_decode( $fb->request( '/me' ), true );

            //Var_dump
            //display whole array().
            //print_r($result);

            $facebook_id = $result["id"];
            $email = $result["email"];
            $first_name = $result["first_name"];
            $last_name = $result["last_name"];

            $user = User::where('email','=',$email)->first();

            if($user){
                if($user->facebook_id == 0) {
                    $user->facebook_id = $facebook_id;
                    $user->save();
                }
            }else{
                $user = new User();
                $user->fname = $first_name;
                $user->lname = $last_name;
                $user->email = $email;
                $user->facebook_id = $facebook_id;
                $user->type="customer";
                $user->status="active";
                $user->password = Hash::make(Date('d m y h i s'));
                $user->save();
            }

            Auth::login($user);

            if(Auth::check()){
                return Redirect::to('main');
            }
        }
        // if not ask for permission first
        else {
            // get fb authorization
            $url = $fb->getAuthorizationUri();

            // return to facebook login url
            return Redirect::to( (string)$url );
        }

    }

    public function loginWithTwitter() {
        // get data from input
        $token = Input::get( 'oauth_token' );
        $verify = Input::get( 'oauth_verifier' );

        // get twitter service
        $tw = $tw = OAuth::consumer( 'Twitter');

        // check if code is valid

        // if code is provided get user data and sign in
        if ( !empty( $token ) && !empty( $verify ) ) {

            // This was a callback request from twitter, get the token
            $token = $tw->requestAccessToken( $token, $verify );

            // Send a request with it
            $result = json_decode( $tw->request( 'account/verify_credentials.json' ), true );

            $twitter_id = $result["id"];
            $name = $result["name"];

            $user = User::where('twitter_id','=',$twitter_id)->first();

            if($user){

            }else{
                $user = new User();
                $user->fname = $name;
                $user->email = "user-".substr(md5(Date('d m y H i s')),0,7)."@kilitbilgi.com";
                $user->twitter_id = $twitter_id;
                $user->type="customer";
                $user->status="active";
                $user->password = Hash::make(Date('d m y h i s'));
                $user->save();
            }

            Auth::login($user);

            if(Auth::check()){
                return Redirect::to('main');
            }

        }
        // if not ask for permission first
        else {
            // get request token
            $reqToken = $tw->requestRequestToken();

            // get Authorization Uri sending the request token
            $url = $tw->getAuthorizationUri(array('oauth_token' => $reqToken->getRequestToken()));

            // return to twitter login url
            return Redirect::to( (string)$url );
        }


    }

    public function loginWithGoogle() {

        // get data from input
        $code = Input::get( 'code' );

        // get google service
        $googleService = OAuth::consumer( 'Google' );

        // check if code is valid

        // if code is provided get user data and sign in
        if ( !empty( $code ) ) {

            // This was a callback request from google, get the token
            $token = $googleService->requestAccessToken( $code );

            // Send a request with it
            $result = json_decode( $googleService->request( 'https://www.googleapis.com/oauth2/v1/userinfo' ), true );

            $google_id = $result["id"];
            $email = $result["email"];
            $first_name = $result["given_name"];
            $last_name = $result["family_name"];

            $user = User::where('email','=',$email)->first();

            if($user){
                if($user->google_id == 0) {
                    $user->google_id = $google_id;
                    $user->save();
                }
            }else{
                $user = new User();
                $user->fname = $first_name;
                $user->lname = $last_name;
                $user->email = $email;
                $user->facebook_id = $google_id;
                $user->type="customer";
                $user->status="active";
                $user->password = Hash::make(Date('d m y h i s'));
                $user->save();
            }

            Auth::login($user);

            if(Auth::check()){
                return Redirect::to('main');
            }

        }
        // if not ask for permission first
        else {
            // get googleService authorization
            $url = $googleService->getAuthorizationUri();

            // return to google login url
            return Redirect::to( (string)$url );
        }
    }

}