@include('common/header')
    <div id="wrapper">

        @include('common/navbar')
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><?php echo Lang::get("site_lang.order_details");?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
            	<div class="col-lg-12">
            		<?php $order = $user_info["order"];
            		$remaining = $user_info["remaining"];?>
            		<table class="table table-bordered table-hover">
						<tbody>
							<tr><td><strong>Müşteri Adı</strong></td><td><?php echo $order->fname." ".$order->lname;?></td></tr>
							<tr><td><strong>Müşteri E-Posta</strong></td><td><?php echo $order->email;?></td></tr>
							<tr><td><strong>Başlık</strong></td><td><?php echo $order->title;?></td></tr>
							<tr><td><strong>Kısa Bilgi</strong></td><td><?php echo $order->short_info;?></td></tr>
							<tr><td><strong>Teslimat Süresi</strong></td><td><?php echo $order->finish_day;?> Gün</td></tr>
							<tr><td><strong>Ücret</strong></td><td><?php echo $order->price;?> TL</td></tr>
							<tr><td><strong>Ödeme Türü</strong></td>
								<td><?php if($order->payment_type=="paypal"){?>
										PayPal
									<?php }else if($order->payment_type=="garanti"){?>
										Garanti Bankası
									<?php }?>
								</td>
							</tr>
							<tr><td><strong>Durum</strong></td>
								<td>
									<?php if($order->status=="passive"){?>
										<span class="label label-warning">Onay Bekliyor</span>
									<?php }
									else if($order->status=="onprogress"){
									?>
										<span class="label label-default">Devam Ediyor ( <?php echo $remaining;?> Gün Kaldı )</span>
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
							</tr>
							<?php if($order->status=="active"){?>
							<tr><td><strong>Çalışmayı İndir</strong></td>
								<td>
										<a class="btn btn-xs btn-primary" target="_blank" href="<?php echo $order->document;?>">İndir</a>
								</td>
							</tr>
							<?php }
							?>
						</tbody>
					</table>
					<div class="col-md-12" style="padding-left:0;">
						{{ Form::open(array('url' => 'admin/updateOrder','class'=>'form-horizontal',)) }}
							<h3>Sipariş Düzenle</h3>
							<div class="form-group">
								<label for="order_update" class="col-sm-1 control-label">Durum:</label>
								<div class="col-sm-11">
									<select id="order_update" class="form-control" name="status">
										<option <?php if($order->status=='active'){echo "selected";}?> value="active">Tamamlandı</option>
										<option <?php if($order->status=='passive'){echo "selected";}?> value="passive">Onay Bekliyor</option>
										<option <?php if($order->status=='onprogress'){echo "selected";}?> value="onprogress">Devam Ediyor</option>
										<option <?php if($order->status=='payment'){echo "selected";}?> value="payment">Ödeme Bekliyor</option>
										<option <?php if($order->status=='cancel'){echo "selected";}?> value="cancel">İptal Edildi</option>
									</select>
								</div>
							</div>
							<?php if($order->status=='active'){?>
								<div class="form-group">
									<label for="url_update" class="col-sm-1 control-label">Link:</label>
									<div class="col-sm-11">
										<input id="url_update" class="form-control" type="text" name="url" value="<?php echo $order->document;?>"/>
									</div>
								</div>
							<?php }?>
							<div class="form-group">
								<div class="col-sm-12">
									<button class="btn btn-primary" type="submit">Güncelle</button>
								</div>
							</div>
							<input type="hidden" name="order_id" value="<?php echo Crypt::encrypt($order->id);?>" />
						</form>
					</div>
            	</div>
            </div>
        </div>
        <!-- /#page-wrapper -->
@include('common/footer')
