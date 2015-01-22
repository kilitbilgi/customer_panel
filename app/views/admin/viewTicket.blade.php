@include('common/header')
    <div id="wrapper">

        @include('common/navbar')
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header" style="font-size:28px;"><?php echo Lang::get("site_lang.ticket_details");
                    $first_ticket = $user_info['first_ticket'];
                    ?>
                    <div class="pull-right form-group">
	                 	{{ Form::open(array('url'=>'updateTicket','class'=>'form-horizontal'))}}
	                    	<div class="col-sm-6">
		                    	<select class="form-control control-label" name="status">
		                    		<option <?php if($first_ticket->status=='open'){echo "selected";}?> value="open">Açık</option>
		                    		<option <?php if($first_ticket->status=='closed'){echo "selected";}?> value="closed">Kapalı</option>
		                    	</select>
	                    	</div>
	                    	<div class="col-sm-6">
	                    		<button class="btn btn-primary form-control" type="submit">Güncelle</button>
	                    	</div>
	                    	<input name="ticket_id" type="hidden" value="<?php echo Crypt::encrypt($first_ticket->id);?>"/>
	                   </form>
                   </div>
                    </h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
            	<div class="col-lg-12">
            		<?php $tickets = $user_info["ticket"];?>
                            <ul class="timeline">
                                <?php $i=0;foreach ($tickets as $ticket) {?>
                                <li<?php if($i%2==1){?> class="timeline-inverted"<?php }?>>
                                    <div class="timeline-badge"><i class="fa fa-check"></i>
                                    </div>
                                    <div class="timeline-panel">
                                        <div class="timeline-heading">
                                            <h4 class="timeline-title"><?php echo $ticket->subject;?></h4>
                                            <p><small class="text-muted"><i class="fa fa-user"></i> <?php echo $ticket->fname." ".$ticket->lname;?><i style="padding-left:10px;" class="fa fa-clock-o"></i> <?php $dt = new DateTime($ticket->created_at);echo $dt->format('d-m-Y H:i:s');?></small>
                                            </p>
                                        </div>
                                        <div class="timeline-body">
                                            <p><?php echo $ticket->message;?></p>
                                        </div>
                                    </div>
                                </li>
                                <?php $i++;}?>
                            </ul>
                            <?php echo $user_info["ticket"]->links(); ?>
                           	<p class="text-center"><button class="btn btn-lg btn-primary" type="button" data-toggle="modal" data-target="#showOrder">Cevap Yaz</button></p>
            				</form>
            	</div>
            	
            	            <!-- Modal -->
<div class="modal fade" id="showOrder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    	{{ Form::open(array('url' => 'answerCreate')) }}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Sipariş Ver</h4>
      </div>
      <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Cevap Yaz (Max 100 Karakter)</label>
                                            <textarea name="answer" maxlength="100" class="form-control" rows="3"></textarea>
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
      <input type="hidden" name="message_id" value="<?php echo Crypt::encrypt($user_info["message_id"]);?>"/>
      {{ Form::close() }}
    </div>
  </div>
</div>
            	
            </div>
        </div>
        <!-- /#page-wrapper -->
@include('common/footer')
