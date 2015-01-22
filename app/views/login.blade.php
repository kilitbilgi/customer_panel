<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@lang("site_lang.title")</title>

    <!-- Bootstrap Core CSS -->
    {{ HTML::style('css/bootstrap.css') }}
    <!-- Custom CSS -->
    {{ HTML::style('css/sb-admin-2.css') }}
    <!-- Custom Fonts -->
    {{ HTML::style('font-awesome-4.1.0/css/font-awesome.min.css') }}

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">@lang("site_lang.title")</h3>
                    </div>
                    <div class="panel-body">
                    	{{ Form::open(array('url' => 'login')) }}
                            <fieldset>
                            	<?php if(Session::get('already_activated')){?>
                            		<div class="has-info">
                            			<label class="control-label">Hesabınız önceden aktif edilmiştir</label>
                            		</div>
                            	<?php }?>
                                <?php if(Session::get('reset_send')){?>
                            		<div class="has-success">
                            			<label class="control-label">Şifre sıfırlama linki e-posta adresinize gönderildi</label>
                            		</div>
                            	<?php }?>
                            	<?php if(Session::get('no_user')){?>
                            		<div class="has-danger">
                            			<label class="control-label">Böyle bir hesap mevcut değil</label>
                            		</div>
                            	<?php }?>
                            	<?php if(Session::get('logout_success')){?>
                            		<div class="has-info">
                            			<label class="control-label">Başarıyla çıkış yaptınız</label>
                            		</div>
                            	<?php }?>
                            	<?php if(Session::get('wrong_code')){?>
                            		<div class="has-error">
                            			<label class="control-label">Aktivasyon kodu hatalı</label>
                            		</div>
                            	<?php }?>
                            	<?php if(Session::get('activation_error')){?>
                            		<div class="has-error">
                            			<label class="control-label">Aktivasyon işlemi başarısız</label>
                            		</div>
                            	<?php }?>
                            	<?php if(Session::get('activation_success')){?>
                            		<div class="has-success">
                            			<label class="control-label">Aktivasyon işlemi başarılı</label>
                            		</div>
                            	<?php }?>
                            	<?php if(Session::get('error_info')){?>
                            		<div class="has-error">
                            			<label class="control-label">Üye girişi başarısız</label>
                            		</div>
                            	<?php }?>
                            	<?php if(Session::get('password_changed')){?>
                            		<div class="has-success">
                            			<label class="control-label">Şifre başarıyla değiştirildi</label>
                            		</div>
                            	<?php }?>
                            	<?php if(Session::get('password_changed_error')){?>
                            		<div class="has-error">
                            			<label class="control-label">Şifre sıfırlama hatası</label>
                            		</div>
                            	<?php }?>
                            	<?php if(Session::get('activation_required')){?>
                            		<div class="has-error">
                            			<label class="control-label">Giriş yapabilmek için üyeliğinizi aktif ediniz.</label>
                            		</div>
                            	<?php }?>
                            	<?php if(Session::get('success_info')){?>
                            		<div class="has-success">
                            			<label class="control-label">Kayıt işlemi başarılı,aktivasyon için e-posta kutunuzu kontrol ediniz.</label>
                            		</div>
                            	<?php }?>
                                <div class="form-group" style="padding-bottom: 30px;">
                                    <div class="col-md-4" style="padding:0 5px 0 0;">
                                        <a class="btn btn-block btn-social btn-sm btn-facebook" href="connect/facebook"><i class="fa fa-facebook"></i>Facebook</a>
                                    </div>
                                    <div class="col-md-4" style="padding:0 0 0 5px;">
                                        <a class="btn btn-block btn-social btn-sm btn-twitter" href="connect/twitter"><i class="fa fa-twitter"></i>Twitter</a>
                                    </div>
                                    <div class="col-md-4" style="padding:0 0 0 5px;">
                                        <a class="btn btn-block btn-social btn-sm btn-google-plus" href="connect/google"><i class="fa fa-google"></i>Google</a>
                                    </div>
                                </div>
                                <div>
                                    <hr/>
                                </div>

                                <div class="form-group <?php if($errors->first('email')){?>has-error<?php }?>">
                                	<?php if($errors->first('email')){?><label class="control-label">{{ $errors->first('email') }}</label><?php }?>
                                	<?php echo Form::email('email',"",array("placeholder"=>"E-Posta","class"=>"form-control"));?>
                                </div>
                                <div class="form-group <?php if($errors->first('password')){?>has-error<?php }?>">
                                	<?php if($errors->first('password')){?><label class="control-label">{{ $errors->first('password') }}</label><?php }?>
                                	<?php echo Form::password('password',array("placeholder"=>"Şifre","class"=>"form-control"));?>
                                </div>
                                <div class="checkbox">
                                    <label for="remember">
                                        <input id="remember" name="remember" type="checkbox"> Beni Hatırla
                                    </label>
                                    <a href="password/forget" class="pull-right">Şifremi Unuttum</a>
                                </div>
                                <div class="form-group">
                               		<button type="submit" class="btn btn-lg btn-success btn-block">Giriş Yap</button>
                                </div>
                                <div class="text-center">
                                        Henüz üye olmadıysanız , <a href="register">Kayıt Ol</a>
                                </div>

                            </fieldset>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>