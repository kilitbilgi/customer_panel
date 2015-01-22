@include('common/header')
    <div id="wrapper">

        @include('common/navbar')

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><?php echo Lang::get("site_lang.dashboard_head");?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $user_info["active_order"];?></div>
                                    <div>Aktif Siparişleriniz</div>
                                </div>
                            </div>
                        </div>
                        <a href="<?php 
                        if(Auth::user()->type=='customer'){
                        	echo url('orders');
						}else{
							echo url('admin/orders');
						}
						?>">
                            <div class="panel-footer">
                                <span class="pull-left">Detayları Görüntüleyin</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-shopping-cart fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $user_info["all_order"];?></div>
                                    <div>Tüm Siparişleriniz</div>
                                </div>
                            </div>
                        </div>
                        <a href="<?php 
                        if(Auth::user()->type=='customer'){
                        	echo url('orders');
						}else{
							echo url('admin/orders');
						}
						?>">
                            <div class="panel-footer">
                                <span class="pull-left">Detayları İnceleyin</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-support fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $user_info["all_ticket"];?></div>
                                    <div>Destek Talepleriniz</div>
                                </div>
                            </div>
                        </div>
                        <a href="<?php 
                        if(Auth::user()->type=='customer'){
                        	echo url('tickets');
						}else{
							echo url('admin/tickets');
						}
						?>">
                            <div class="panel-footer">
                                <span class="pull-left">Detayları İnceleyin</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
@include('common/footer')
