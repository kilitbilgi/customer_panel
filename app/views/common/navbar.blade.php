<!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo url('/');?>">Hoşgeldiniz , <?php echo $user_info["fullname"];?></a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
            	<?php 
            	$user_type= Auth::user()->type;
            	if($user_type=="customer"){?>
            	<li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-tasks fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                	<ul class="dropdown-menu dropdown-tasks">
                <?php
            	$order_limited = $user_info["order_limited"];
				$i = 0;
				foreach ($order_limited as $value) {
					$dateCreated = new DateTime($value->created_at);
					$dateNow = new DateTime();
					
					$remaining_day = $dateCreated->diff($dateNow);
					
					$remaining = $value->finish_day - $remaining_day->format("%d");
					
					if($remaining<0){
						$remaining=0;
						$percentage= 100;
					}else{
						$percentage = 100 - round(($remaining * 100) / $value->finish_day);
					}
					$title = $value->title;
				?>
				<li>
                            <a href="<?php echo url('viewOrder/'.$value->id);?>">
                                <div>
                                    <p>
                                        <strong><?php echo mb_substr($title,0,20,'UTF-8');?></strong>
                                        <span class="pull-right text-muted"><?php echo $percentage;?>% Tamamlandı</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-<?php
                                        switch ($i) {
                                            case 0:
                                                echo 'success';
                                                break;
											case 1:
												echo 'info';    
                                                break;
											case 2:
												echo "warning";
												break;
											case 3:
												echo "danger";
												break;
                                        }
										$i++;
                                        ?>" role="progressbar" aria-valuenow="<?php echo $percentage;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percentage;?>%">
                                            <span class="sr-only"><?php echo $percentage;?>% Tamamlandı</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                </li>
                <li class="divider"></li>
				<?php
				}	
            	?>
            	<li>
               		<a class="text-center" href="<?php echo url('orders');?>">
                    	<strong>Tüm Siparişleriniz</strong>
                        <i class="fa fa-angle-right"></i>
                     </a>
                </li>
                    </ul>
                    <!-- /.dropdown-tasks -->
                </li>
                <?php }?>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="<?php echo url('profile');?>"><i class="fa fa-user fa-fw"></i> Profiliniz</a>
                        </li>
                        <li><a href="<?php echo $user_type=="admin"?url('admin/orders'):url('orders');?>"><i class="fa fa-gear fa-fw"></i> Siparişleriniz</a>
                        </li>
                        <li><a href="<?php echo $user_type=="admin"?url('admin/tickets'):url('tickets');?>"><i class="fa fa-support fa-fw"></i> Destek Bildirimleriniz</a>
                        </li>
                        <li class="divider"></li>
                        <li><a id="signoutButton" href="<?php echo url('logout');?>"><i class="fa fa-sign-out fa-fw"></i> Çıkış Yap</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a <?php if(Request::segment(1)=="main"){?>class="active"<?php }?><?php if(!Request::segment(1)){?>class="active"<?php }?> href="<?php echo url('main');?>"><i class="fa fa-dashboard fa-fw"></i> <?php echo Lang::get("site_lang.dashboard_head");?></a>
                        </li>
                        <li>
                            <a <?php if(Request::segment(1)=="profile"){?>class="active"<?php }?> href="<?php echo url('profile')?>"><i class="fa fa-user fa-fw"></i> <?php echo Lang::get("site_lang.profile_head");?></a>
                        </li>
                        
                        <?php if(Auth::user()->type == "admin"){?>
                        <li>
                            <a <?php if(Request::segment(1)=="admin/orders"){?>class="active"<?php }?> href="<?php echo url('admin/orders')?>"><i class="fa fa-shopping-cart fa-fw"></i> <?php echo Lang::get("site_lang.admin_order_head");?></a>
                        </li>
                        <?php }else{?>
                        <li>
                            <a <?php if(Request::segment(1)=="orders"){?>class="active"<?php }?> href="<?php echo url('orders')?>"><i class="fa fa-shopping-cart fa-fw"></i> <?php echo Lang::get("site_lang.order_head");?></a>
                        </li>
                        <?php }?>
                        <?php if(Auth::user()->type == "admin"){?>
                        <li>
                            <a <?php if(Request::segment(1)=="admin/tickets"){?>class="active"<?php }?> href="<?php echo url('admin/tickets')?>"><i class="fa fa-support fa-fw"></i> <?php echo Lang::get("site_lang.admin_ticket_head");?></a>
                        </li>
                        <?php }else{?>
                        <li>
                            <a <?php if(Request::segment(1)=="tickets"){?>class="active"<?php }?> href="<?php echo url('tickets')?>"><i class="fa fa-support fa-fw"></i> <?php echo Lang::get("site_lang.ticket_head");?></a>
                        </li>
                        <?php }?>
                        
                        <li>
                            <a <?php if(Request::segment(1)=="accounts"){?>class="active"<?php }?> href="<?php echo url('accounts')?>"><i class="fa fa-fax fa-fw"></i> <?php echo Lang::get("site_lang.account_head");?></a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>