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
            		$remaining = $user_info["remaining"];
            		$percentage = $user_info["percentage"];
            		?>
            		<table class="table table-bordered table-hover">
						<tbody>
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

                            <?php
                            if($order->status=="payment"){?>
							<tr><td><strong>Ödeme Bildirimi</strong></td>
							<td>
                            <?php if($order->payment_type=="paypal"){?>
                                {{ Form::open(array('route' => 'payment','method'=>'post')) }}
                                <input type="hidden" name="id" value="<?php echo Crypt::encrypt($order->id);?>"/>
                                <input type="hidden" name="price" value="<?php echo Crypt::encrypt($order->price);?>"/>
                                <input type="hidden" name="title" value="<?php echo Crypt::encrypt($order->title);?>"/>
                                <input type="image" src="https://www.paypal.com/tr_TR/i/btn/btn_xpressCheckout.gif"/>
                                {{ Form::close() }}
                            <?php }
                            ?>
							</td>
							</tr>

							<?php
							}
							if($order->status=="active"){?>
							<tr><td><strong>Çalışmayı İndir</strong></td>
								<td>
										<a class="btn btn-xs btn-primary" href="<?php echo $order->document;?>">İndir</a>
								</td>
							</tr>
							<?php }
							?>
						</tbody>
					</table>
            	</div>
            </div>
        </div>
        <!-- /#page-wrapper -->
@include('common/footer')
