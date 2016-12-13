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
                    <h4 class="page-title">Pembayaran Pemesanan</h4>
                    <ol class="breadcrumb">
                        <li>
                            <a href="#">Formulir Pembayaran</a>
                        </li>
                    </ol>
                </div>
            </div>
            <!-- Wizard with Validation -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card-box">
                        <h4 class="m-t-0 header-title"><b>Pembayaran</b></h4>
                        <p class="text-muted m-b-30 font-13">
                            Pastikan data terisi dengan lengkap dan benar.
                        </p>
                        <form id="wizard-validation-form" method="post" action="<?php echo base_url() ?>admin/confirm_payment">
                            <div>
                                <h3>Step 1</h3>
                                <section>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table class="table m-t-30">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Item</th>
                                                            <th>Date</th>
                                                            <th>Time</th>
                                                            <th style="text-align: right;">Total</th>
                                                        </tr>
                                                    </thead>
                                                    <?php
                                                    if (!isset($booked) || empty($booked)) {
                                                        echo '<tr>
														<td>
														Reserve field click <a href="' . base_url() . 'admin/landing">here</a>
														</td>
														</tr>';
                                                    } else {
                                                        echo '<tbody>';
                                                        foreach ($booked as $key) {
                                                            echo '<tr>';
                                                            echo "<td>

															</td>";
                                                            echo "<td>
															" . $key['name'] . "-" . $key['location'] . "
															</td>";
                                                            echo "<td>
															" . $key['date'] . "
															</td>";
                                                            echo "<td>
															" . $key['time'] . "
															</td>";
                                                            echo "<td style='text-align: right;'>IDR
															" . number_format($key['price'], 2, ',', '.') . "
															</td>";
                                                            echo '</tr>';
                                                        }

                                                        echo '</tbody>';
                                                    }
                                                    ?>
                                                    <!-- <tbody>
                                                            <tr>
                                                                    <td><button class="demo-delete-row btn btn-danger btn-xs btn-icon fa fa-times"></button></td>
                                                                    <td>Lapangan A</td>
                                                                    <td>1 jam</td>
                                                                    <td>12/12/2012</td>
                                                                    <td>15.00</td>
                                                                    <td>IDR 120.000</td>
                                                                    <td style="text-align: right;">IDR 120.000</td>
                                                            </tr>
                                                            <tr>
                                                                    <td><button class="demo-delete-row btn btn-danger btn-xs btn-icon fa fa-times"></button></td>
                                                                    <td>Lapangan B</td>
                                                                    <td>3 jam</td>
                                                                    <td>12/12/2012</td>
                                                                    <td>15.00</td>
                                                                    <td>IDR 120.000</td>
                                                                    <td style="text-align: right;">IDR 120.000</td>
                                                            </tr>
                                                            <tr>
                                                                    <td><button class="demo-delete-row btn btn-danger btn-xs btn-icon fa fa-times"></button></td>
                                                                    <td>Lapangan D</td>
                                                                    <td>1 jam</td>
                                                                    <td>12/12/2012</td>
                                                                    <td>15.00</td>
                                                                    <td>IDR 120.000</td>
                                                                    <td style="text-align: right;">IDR 120.000</td>
                                                            </tr>
                                                    </tbody> -->
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="border-radius: 0px;">
                                        <div class="col-md-3 col-md-offset-9">
                                                <!-- <p class="text-right"><b>DP amount:</b></p>
                                                <input type="text" class="form-control" id="field-1" placeholder="Masukan dp"> -->
                                                <!-- <p class="text-right">Discout: 12.9%</p> -->
                                            <hr>
                                            <h3 class="text-right"><b>Grand Total</b><br><?php echo "IDR " . number_format($total_biaya, 2, ',', '.'); ?></h3>
                                            <a href="<?php echo base_url() . 'admin/removeBooked' ?>" type="button" class="btn btn-danger waves-effect waves-light">
                                                Reset booked
                                            </a>
                                        </div>
                                    </div>
                                </section>
                                <h3>Step 2</h3>
                                <section>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h4 class="m-t-0 header-title"><b>Data Pemesan</b></h4>
                                            <p class="text-muted m-b-30 font-13">
                                                Inputkan data diri pemesan lapangan dengan benar
                                            </p>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Nama Pemesan</label>
                                                <input required type="text" name="invoice[i_nama_pemesan]" class="form-control" id="exampleInputEmail1" placeholder="Nama pemesan">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Email address</label>
                                                <input required type="email" name="invoice[i_email_pemesan]" class="form-control" id="exampleInputEmail1" placeholder="Email pemesan">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Nomor Telepon</label>
                                                <input required type="number" name="invoice[i_telp_pemesan]" class="form-control" id="exampleInputEmail1" placeholder="Nomor Telepon">
                                            </div>
                                            <h4 class="m-t-0 header-title"><b>Pembayaran via Transfer</b></h4>
                                            <p class="text-muted m-b-30 font-13">
                                                Untuk pembayaran via transfer dapat menggunakan rekening dibawah
                                            </p>
                                            <div class="row" style="border-radius: 0px;">
                                                <div class="col-md-12">
                                                    <h3 class="text-left"><b>Bank BNI</b><br> 01234567890</h3>
                                                    <p class="text-left">a/n Gool Futsal</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <h4 class="m-t-0 header-title"><b>Data Pembayaran</b></h4>
                                            <p class="text-muted m-b-30 font-13">
                                                Inputkan data diri pemesan lapangan dengan benar
                                            </p>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Nama Bank</label>
                                                <input required type="text" name="invoice[i_bank_rekening]" class="form-control" id="exampleInputEmail1" placeholder="Nama bank">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Nama Rekening</label>
                                                <input required type="namarekening" name="invoice[i_no_rekening]" class="form-control" id="exampleInputEmail1" placeholder="Nama rekening">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Jumlah Bayar DP</label>
                                                <input required type="number" name="invoice[i_current_payment]" class="form-control" id="exampleInputEmail1" placeholder="Jumlah DP">
                                            </div>
                                            <div class="row" style="border-radius: 0px;">
                                                <div class="col-md-12">
                                                        <!-- <p class="text-right"><b>DP amount:</b> 2930.00</p>
                                                        <p class="text-right">Discout: 12.9%</p> -->
                                                    <hr>
                                                    <h3 class="text-right"><b>Grand Total</b><br><?php echo "IDR " . number_format($total_biaya, 2, ',', '.'); ?></h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <!--<h3>Step 3</h3>
                                <section>
                                        <div class="row">
                                                <div class="col-md-12">
                                                        <h4 class="m-t-0 header-title"><b>Rekap Pembayaran</b></h4>
                                                        <p class="text-muted m-b-30 font-13">
                                                                Berikut adalah rekap pembayaran persewaan lapangan
                                                        </p>
                                                        <div class="table-responsive">
                                                                <table class="table m-t-30">
                                                                        <thead>
                                                                                <tr>
                                                                                        <th>#</th>
                                                                                        <th>Item</th>
                                                                                        <th>Invoice No</th>
                                                                                        <th style="text-align: right;">Total</th>
                                                                                </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                                <tr>
                                                                                        <td>1</td>
                                                                                        <td>Pembayaran DP</td>
                                                                                        <td><a href="#">73463274</a></td>
                                                                                        <td style="text-align: right;">IDR 120.000</td>
                                                                                </tr>
                                                                        </tbody>
                                                                </table>
                                                        </div>
                                                        <div class="row" style="border-radius: 0px;">
                                                                <div class="col-md-12">
                                                                        <p class="text-right"><b>DP amount:</b> 2930.00</p>
                                                                        <p class="text-right">Discout: 12.9%</p>
                                                                        <hr>
                                                                        <h3 class="text-right"><b>Biaya Sisa </b><br>IDR 1.000.000</h3>
                                                                </div>
                                                        </div>
                                                </div>
                                        </div>
                                </section>
                                <h3>Step Final</h3>
                                <section>
                                        <div class="form-group clearfix">
                                                <div class="col-lg-12">
                                                        <input id="acceptTerms-2" name="acceptTerms2" type="checkbox" class="required">
                                                        <label for="acceptTerms-2">I agree with the Terms and Conditions.</label>
                                                </div>
                                        </div>
                                </section> -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End row -->
        </div>
        <!-- container -->
    </div>


    <!-- MODAL -->
    <div id="dialog" class="modal-block mfp-hide">
        <section class="panel panel-info panel-color">
            <header class="panel-heading">
                <h2 class="panel-title">Are you sure?</h2>
            </header>
            <div class="panel-body">
                <div class="modal-wrapper">
                    <div class="modal-text">
                        <p>Are you sure that you want to delete this row?</p>
                    </div>
                </div>

                <div class="row m-t-20">
                    <div class="col-md-12 text-right">
                        <button id="dialogConfirm" class="btn btn-primary waves-effect waves-light">Confirm</button>
                        <button id="dialogCancel" class="btn btn-default waves-effect">Cancel</button>
                    </div>
                </div>
            </div>

        </section>
    </div>
    <!-- end Modal -->
    <!-- content -->
    <footer class="footer">
        Copyright © 2016 Gool Futsal. Powered by Zonacode.
    </footer>
</div>
<!-- ============================================================== -->
<!-- End Right content here -->
<!-- ============================================================== -->
