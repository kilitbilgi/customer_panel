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
                        <h3 class="panel-title"><?php echo Lang::get('site_lang.forget_title');?></h3>
                    </div>
                    <div class="panel-body">
                        {{ Form::open(array('url' => 'password/reset')) }}
                            <fieldset>
		                        <div class="form-group <?php if($errors->first('password')){?>has-error<?php }?>">
		                        	<?php if($errors->first('password')){?><label class="control-label">{{ $errors->first('password') }}</label><br/><?php }?>
		                            <label>Şifreniz</label>
		                            <input type="password" name="password" class="form-control" value="">
		                        </div>
		                        <div class="form-group <?php if($errors->first('password')){?>has-error<?php }?>">
		                        	<?php if($errors->first('password_again')){?><label class="control-label">{{ $errors->first('password_again') }}</label><br/><?php }?>
		                            <label>Şifre Onayı</label>
		                            <input type="password" name="password_again" class="form-control" value="">
		                        </div>
		                        <input type="hidden" name="reset_code" value="<?php echo Crypt::encrypt($reset_code);?>"/>
                               <div class="form-group">
                               	<button type="submit" class="btn btn-lg btn-success btn-block">Onayla</button>
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
