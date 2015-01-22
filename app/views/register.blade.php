<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo Lang::get('site_lang.register_title');?></title>

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
                        <h3 class="panel-title"><?php echo Lang::get('site_lang.register_title');?></h3>
                    </div>
                    <div class="panel-body">
                        {{ Form::open(array('url' => 'register')) }}
                            <fieldset>
                                <div class="form-group <?php if($errors->first('fname')){?>has-error<?php }?>">
                                	<?php if($errors->first('fname')){?><label class="control-label">{{ $errors->first('fname') }}</label><?php }?>
                                	<?php echo Form::text('fname',"",array("autofocus"=>"","placeholder"=>"Adınız","class"=>"form-control"));?>
                                </div>
                                <div class="form-group <?php if($errors->first('lname')){?>has-error<?php }?>">
                                	<?php if($errors->first('lname')){?><label class="control-label">{{ $errors->first('lname') }}</label><?php }?>
                                	<?php echo Form::text('lname',"",array("placeholder"=>"Soyadınız","class"=>"form-control"));?>
                                </div>
                                <div class="form-group <?php if($errors->first('email')){?>has-error<?php }?>">
                                	<?php if($errors->first('email')){?><label class="control-label">{{ $errors->first('email') }}</label><?php }?>
                                	<?php echo Form::email('email',"",array("placeholder"=>"E-Posta","class"=>"form-control"));?>
                                </div>
                                <div class="form-group <?php if($errors->first('password')){?>has-error<?php }?>">
                                	<?php if($errors->first('password')){?><label class="control-label">{{ $errors->first('password') }}</label><?php }?>
                                	<?php echo Form::password('password',array("placeholder"=>"Şifre","class"=>"form-control"));?>
                                </div>
                                <div class="form-group <?php if($errors->first('password_again')){?>has-error<?php }?>">
                                	<?php if($errors->first('password_again')){?><label class="control-label">{{ $errors->first('password_again') }}</label><?php }?>
                                	<?php echo Form::password('password_again',array("placeholder"=>"Şifre Onayı","class"=>"form-control"));?>
                                </div>
                               <div class="form-group">
                               	<?php if($errors->first('recaptcha_response_field')){?><label class="control-label">{{ $errors->first('recaptcha_response_field') }}</label><?php }?>
                               	{{Form::captcha()}}
                               </div>
                               <div class="form-group">
                               	<button type="submit" class="btn btn-lg btn-success btn-block"><?php echo Lang::get('site_lang.register_title');?></button>
                               </div>
                               <div class="col-md-6">
                                	<a href="/" class="btn btn-block btn-info">Giriş Yap</a>
                                </div>
                                <div class="col-md-6">
                                	<a href="password/forget" class="btn btn-block btn-warning">Şifremi Unuttum</a>
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
