<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">
            <!-- Page-Title -->
            <div class="row">
                    <h4 class="page-title">Data Pemesanan</h4>
                    <ol class="breadcrumb">
                        <li>
                            <a href="">Daftar Pemesanan Lapangan</a>
                        </li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card-box table-responsive">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No. Order</th>
                                    <th>Nama Pemesan</th>
                                    <th>No. Telepon</th>
                                    <th>Tanggal Order</th>
                                    <th>Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // echo json_encode($invoice);
                                foreach ($invoice as $key) {
                                    echo "<tr><td>
											" . $key['i_id'] . "
											</td>";
                                    echo "<td>
											" . $key['i_nama_pemesan'] . "
											</td>";
                                    echo "<td>
											" . $key['i_telp_pemesan'] . "
											</td>";
                                    echo "<td>
											" . $key['i_date'] . "
											</td>";
                                    echo "<td>
											<a href='" . base_url() . "admin/invoice?id=" . $key['i_id'] . "' class='btn btn-default waves-effect waves-light'>" . $key['i_status'] . "</a>
											</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div> <!-- container -->

    </div> <!-- content -->

    <footer class="footer">
        Copyright © 2016 Gool Futsal. Powered by Zonacode.
    </footer>

</div>
<!-- ============================================================== -->
<!-- End Right content here -->
<!-- ============================================================== -->
