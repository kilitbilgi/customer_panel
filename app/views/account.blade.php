@include('common/header')
    <div id="wrapper">

        @include('common/navbar')

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><?php echo Lang::get("site_lang.account_head");?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="panel panel-paypal">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                   	{{HTML::image('images/paypal.png','PayPal Logo' , array('class' => 'paypal-logo'))}}
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"></div>
                                    <div><span class="account_text"><u>PayPal Hesabı</u></span></div>
                                    <div><span class="account_about">Burak ÇOLAK</span></div>
                                    <div><span class="account_about">kilitbilgi@gmail.com</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="panel panel-garanti">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    {{HTML::image('images/garanti.jpg','Garanti Logo' , array('class' => 'garanti-logo'))}}
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"></div>
                                    <div><span class="account_text"><u>Garanti Hesabı</u></span></div>
                                    <div><span class="account_about">Burak ÇOLAK</span></div>
                                    <div><span class="account_about">TR46 0006 2000 5680 0006 6860 76</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
@include('common/footer')
