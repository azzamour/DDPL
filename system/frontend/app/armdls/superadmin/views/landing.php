<?php
	if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
		$uri = 'https://';
	} else {
		$uri = 'http://';
	}
	$uri .= $_SERVER['HTTP_HOST'];
	header('Location: '.$uri.'/frontend/superadmin/managerial');
	exit;
?>
<!-- /*
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">
            <!-- Page-Title -->
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="page-title">Dashboard</h4>
                    <p class="text-muted page-title-alt">Informasi Pendapatan</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="portlet">
                        <!-- /primary heading -->
                        <div class="portlet-heading">
                            <h3 class="portlet-title text-dark text-uppercase">
                                Projects
                            </h3>
                            <div class="portlet-widgets">
                                <a href="javascript:;" data-toggle="reload"><i class="ion-refresh"></i></a>
                                <span class="divider"></span>
                                <a data-toggle="collapse" data-parent="#accordion1" href="#portlet2"><i class="ion-minus-round"></i></a>
                                <span class="divider"></span>
                                <a href="#" data-toggle="remove"><i class="ion-close-round"></i></a>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div id="portlet2" class="panel-collapse collapse in">
                            <div class="portlet-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Lapangan</th>
                                                <th>QTY</th>
                                                <th>Total Cost</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Lapangan A Mangga Dua</td>
                                                <td>2187</td>
                                                <td>IDR 15.000.000</td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Lapangan B Mangga Dua</td>
                                                <td>2187</td>
                                                <td>IDR 15.000.000</td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>Lapangan C Mangga Dua</td>
                                                <td>2187</td>
                                                <td>IDR 15.000.000</td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td>Lapangan D Mangga Dua</td>
                                                <td>2187</td>
                                                <td>IDR 15.000.000</td>
                                            </tr>
                                            <tr>
                                                <td>5</td>
                                                <td>Lapangan E Mangga Dua</td>
                                                <td>2187</td>
                                                <td>IDR 15.000.000</td>
                                            </tr>
                                            <tr>
                                                <td>6</td>
                                                <td>Lapangan A Untag</td>
                                                <td>2187</td>
                                                <td>IDR 15.000.000</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- container -->
    </div>
    <!-- content -->
    <footer class="footer text-right">
        Copyright © 2016 Gool Futsal. Powered by Zonacode.
    </footer>
</div>
<!-- ============================================================== -->
<!-- End Right content here -->
<!-- ============================================================== -->
*/ -->