<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">

        <link rel="shortcut icon" href="<?php echo base_url(''); ?>assets/images/favicon_1.ico">

        <title>Gool Futsal - Real Futsal Court</title>

        <link href="<?php echo base_url(''); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(''); ?>assets/css/core.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(''); ?>assets/css/components.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(''); ?>assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(''); ?>assets/css/pages.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(''); ?>assets/css/responsive.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <script src="<?php echo base_url(''); ?>assets/js/modernizr.min.js"></script>
        <script>(function (i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                        m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

            ga('create', 'UA-69506598-1', 'auto');
            ga('send', 'pageview');
        </script>

    </head>
    <body>

        <div class="account-pages"></div>
        <div class="clearfix"></div>

        <!-- HOME -->
        <section class="home bg-dark" id="home">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <div class="home-wrapper">
                            <h1 class="icon-main text-custom"><i class="md md-album"></i></h1>
                            <h1 class="home-text"><span>Terima Kasih Telah Memesan</span></h1>
                            <p class="m-t-30 text-muted cd-text">
                                Pembayaran anda akan segera kami proses secepatnya
                                <br/>
                                Apabila dalam waktu 5 jam belum dikonfirmasi via email, harap hubungi call center
                            </p>

                            <!-- COUNTDOWN -->
                            <p>You will be redirected in <span id="counter">10</span> second(s).</p>
                            <script type="text/javascript">
                                function countdown() {
                                    var i = document.getElementById('counter');
                                    if (parseInt(i.innerHTML) <= 0) {
                                        location.href = 'home/landing';
                                    }
                                    i.innerHTML = parseInt(i.innerHTML) - 1;
                                }
                                setInterval(function () {
                                    countdown();
                                }, 1000);
                            </script>
                            <!-- /COUNTDOWN -->

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- END HOME -->

        <script>
            var resizefunc = [];
        </script>

        <!-- jQuery  -->
        <script src="<?php echo base_url(''); ?>assets/js/jquery.min.js"></script>
        <script src="<?php echo base_url(''); ?>assets/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(''); ?>assets/js/detect.js"></script>
        <script src="<?php echo base_url(''); ?>assets/js/fastclick.js"></script>
        <script src="<?php echo base_url(''); ?>assets/js/jquery.slimscroll.js"></script>
        <script src="<?php echo base_url(''); ?>assets/js/jquery.blockUI.js"></script>
        <script src="<?php echo base_url(''); ?>assets/js/waves.js"></script>
        <script src="<?php echo base_url(''); ?>assets/js/wow.min.js"></script>
        <script src="<?php echo base_url(''); ?>assets/js/jquery.nicescroll.js"></script>
        <script src="<?php echo base_url(''); ?><?php echo base_url(''); ?>assets/js/jquery.scrollTo.min.js"></script>


        <script src="<?php echo base_url(''); ?>assets/js/jquery.core.js"></script>
        <script src="<?php echo base_url(''); ?>assets/js/jquery.app.js"></script>

        <!-- Countdown -->
        <script src="<?php echo base_url(''); ?>assets/plugins/countdown/dest/jquery.countdown.min.js"></script>
        <script src="<?php echo base_url(''); ?>assets/plugins/simple-text-rotator/jquery.simple-text-rotator.min.js"></script>

        <script type="text/javascript">
            $(document).ready(function () {

                // Countdown
                // To change date, simply edit: var endDate = "September 16, 2016 18:16:00";
                $(function () {
                    var endDate = "January 17, 2018 11:59:59";
                    $('.u-countdown .row').countdown({
                        date: endDate,
                        render: function (data) {
                            $(this.el).html('<div><div><span class="text-custom">' + (parseInt(this.leadingZeros(data.years, 2) * 365) + parseInt(this.leadingZeros(data.days, 2))) + '</span><span><b>Days</b></span></div><div><span class="text-primary">' + this.leadingZeros(data.hours, 2) + '</span><span><b>Hours</b></span></div></div><div class="lj-countdown-ms"><div><span class="text-pink">' + this.leadingZeros(data.min, 2) + '</span><span><b>Minutes</b></span></div><div><span class="text-info">' + this.leadingZeros(data.sec, 2) + '</span><span><b>Seconds</b></span></div></div>');
                        }
                    });
                });

                // Text rotate
                $(".home-text .rotate").textrotator({
                    animation: "fade",
                    speed: 3000
                });
            });

        </script>

    </body>
</html>
