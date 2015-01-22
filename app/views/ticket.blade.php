@include('common/header')
    <div id="wrapper">

        @include('common/navbar')

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><?php echo Lang::get("site_lang.ticket_head");?>
                    	<button class="pull-right btn btn-primary" type="button" data-toggle="modal" data-target="#showTicket">Destek Talebi Oluştur</button>
                    </h1>
                	<?php if(Session::get('success_info')){?><div style="margin-bottom:15px;"><div class="alert alert-success">Destek Talebi Başarıyla Oluşturuldu.</div></div><?php }?>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
				<div class="col-lg-12">
                    <div class="panel-group" id="accordion">
                    	<?php 
                    	if($user_info["tickets"]!=false){
                    	foreach ($user_info["tickets"] as $value) {?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $value->id;?>"><?php echo $value->subject;?></a>
                                    <?php if($value->status=='open'){?><label class="label label-success">Açık</label>
                                    <?php }else{?><label class="label label-danger">Kapalı</label><?php }?>
                                	<a class="btn btn-primary btn-xs pull-right" style="color: #FFFFFF" href="<?php echo url('viewTicket/'.$value->id);?>">Detayları Görüntüle</a>
                                </h4>
                            </div>
                            <div id="collapse<?php echo $value->id;?>" class="panel-collapse collapse">
                                <div class="panel-body">
									<?php echo $value->message;?>
                                </div>
                            </div>
                        </div>
                        <?php }?>
                    </div>
                    <?php echo $user_info["tickets"]->links();}else{?>
					<div class="alert alert-info">Henüz hiç destek talebi oluşturmadınız.</div>
					<?php }?>
				</div>
            </div>
<!-- Modal -->
<div class="modal fade" id="showTicket" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    	{{ Form::open(array('url' => 'tickets')) }}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Destek Talebi Oluştur</h4>
      </div>
      <div class="modal-body">
      	<div class="row">
	         <div class="col-lg-12">
	            <div class="form-group">
	                <label>Konu</label>
	                <input name="subject" placeholder="Çalışma hakkında" class="form-control">
	            </div>
	            <div class="form-group">
	                <label>Mesajınız</label>
	               	<textarea name="message" placeholder="Çalışma hakkında sorular" maxlength="255" class="form-control" rows="3"></textarea>
	            </div>
	        </div>
	        <!-- /.col-lg-12 -->
	    </div>
	    <!-- /.row -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Vazgeç</button>
        <button type="submit" class="btn btn-primary">Gönder</button>
      </div>
      {{ Form::close() }}
    </div>
  </div>
</div>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
@include('common/footer')
