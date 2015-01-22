@include('common/header')
    <div id="wrapper">

        @include('common/navbar')

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><?php echo Lang::get("site_lang.profile_head");?></h1>
                    <?php if(Session::get('success_info')){?><div style="margin-bottom:15px;"><div class="alert alert-success">Profil Başarıyla Güncellendi.</div></div><?php }?>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
				<div class="col-lg-12">
					{{ Form::open(array('url' => 'updateProfile')) }}
                    	<div class="form-group <?php if($errors->first('fname')){?>has-error<?php }?>">
                        	<?php if($errors->first('fname')){?><label class="control-label">{{ $errors->first('fname') }}</label><br/><?php }?>
                        	<label>Adınız</label>
                            <input type="text" name="fname" class="form-control" placeholder="<?php echo $user_info["fname"];?>">
                       	</div>
                        <div class="form-group <?php if($errors->first('lname')){?>has-error<?php }?>">
                        	<?php if($errors->first('lname')){?><label class="control-label">{{ $errors->first('lname') }}</label><br/><?php }?>
                            <label>Soyadınız</label>
                            <input type="text" name="lname" class="form-control" placeholder="<?php echo $user_info["lname"];?>">
                        </div>
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
                        <div class="form-group">
                            <label>E-Posta Adresiniz</label>
                            <p class="form-control-static"><?php echo $user_info["email"];?></p>
                        </div>
                        <button type="submit" class="btn btn-primary">Güncelle</button>
                   </form>
				</div>
            </div>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
@include('common/footer')
