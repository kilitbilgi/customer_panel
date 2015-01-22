@include('common/header')
    <div id="wrapper">

        @include('common/navbar')
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><?php echo Lang::get("site_lang.order_head");?><button class="pull-right btn btn-primary" type="button" data-toggle="modal" data-target="#showOrder">Sipariş Ver</button></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
            	<div class="col-lg-12">
            		<table class="table table-bordered table-hover">
            			<thead>
            				<td>Başlık</td>
            				<td>Durum</td>
            				<td>Detaylar</td>
            			</thead>
            			<tbody>
	            			<?php foreach($user_info["orders"] as $order){?>
							<tr>
								<td><?php echo $order->title;?></td>
								<td>
									<?php if($order->status=="passive"){?>
										<span class="label label-warning">Onay Bekliyor</span>
									<?php }
									else if($order->status=="onprogress"){
									?>
										<span class="label label-default">Devam Ediyor</span>
									<?php
									}
										else if($order->status=="payment"){
									?>
										<span class="label label-info">Ödeme Bekliyor</span>
									<?php
										}
										else if($order->status=="cancel"){
										?>
										<span class="label label-danger">İptal Edildi</span>
										<?php 
										}
										else{?>
										<span class="label label-success">Tamamlandı</span>
									<?php }?>
								</td>
								<td><a class="btn btn-xs btn-primary" href="<?php echo url('admin/viewOrder/'.$order->id);?>">Görüntüle</a></td>
							</tr>
							<?php }?>
						</tbody>
					</table>
					<?php echo $user_info["orders"]->links(); ?>
            	</div>
            </div>
            <!-- Modal -->
<div class="modal fade" id="showOrder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    	{{ Form::open(array('url' => 'orders')) }}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Sipariş Ver</h4>
      </div>
      <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Proje Başlığı</label>
                                            <input name="title" placeholder="Örn:PSD to WordPress" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Proje Bütçesi</label>
                                            <input name="price" class="form-control" placeholder="Örn:500TL">
                                        </div>
                                       	<div class="form-group">
                                            <label>Ödeme Türü</label>
                                            <select name="payment_type" class="form-control">
                                            	<option value="">Seçiniz</option>
												<option value="paypal">PayPal</option>
												<option value="garanti">Garanti Bankası</option>
											</select>
                                        </div>
                                        <div class="form-group">
                                            <label>Proje Süresi</label>
                                            <input name="finish_day" class="form-control" placeholder="Örn:10">
                                        </div>
                                        <div class="form-group">
                                            <label>Proje Detayı (En Fazla 100 Karakter)</label>
                                            <textarea name="short_info" placeholder="PSD to WordPress Döküm İşi" maxlength="100" class="form-control" rows="3"></textarea>
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
@include('common/footer')
