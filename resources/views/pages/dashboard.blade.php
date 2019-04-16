@extends('layouts.main')
@section('content')
<!-- BEGIN PAGE HEAD-->
<div class="page-head">
    <!-- BEGIN PAGE TITLE -->
    <div class="page-title">
        <h1>Member Koperasi Dashboard
            <small>statistics, charts and reports</small>
        </h1>
    </div>
    <!-- END PAGE TITLE -->
</div>
<!-- END PAGE HEAD-->
<!-- BEGIN PAGE BREADCRUMB -->
<ul class="page-breadcrumb breadcrumb">
    <li>
        <a href="javascript:;">Home</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <span class="active">Dashboard</span>
    </li>
</ul>
<!-- END PAGE BREADCRUMB -->
<!-- BEGIN PAGE BASE CONTENT -->
<div class="row widget-row">
    @foreach ($peminjaman as $peminjaman)
    <div class="col-md-4">
        <!-- BEGIN WIDGET THUMB -->
        <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
            <h4 class="widget-thumb-heading">Pinjaman - 
            <?php if (!is_null($peminjaman)) {
                echo $peminjaman->keperluan;
            ?>
            </h4>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-green icon-bulb"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle"><?php 
                        if ($peminjaman->status == 0) {
                            echo "Menunggu persetujuan";
                        }
                        elseif ($peminjaman->status == 1) {
                            echo "Telah disetujui";
                        }
                        elseif ($peminjaman->status == 2) {
                            echo "Telah ditolak";
                        }
                    ?></span>
                    <span class="widget-thumb-body-stat" data-counter="counterup" data-value="
                    <?php
                    // if (!is_null($peminjaman)) {
                        echo "IDR ".$peminjaman->jumlah;
                    };
                    // }
                    // else{
                    //     echo 0;
                    // }
                        
                    ?>">0</span>
                </div>
            </div>
        </div>
        <!-- END WIDGET THUMB -->
    </div>
    @endforeach
</div>
<!-- <div class="row">
    <div class="col-lg-6 col-xs-12 col-sm-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-cursor font-dark hide"></i>
                    <span class="caption-subject font-dark bold uppercase">General Stats</span>
                </div>
                <div class="actions">
                    <a href="javascript:;" class="btn btn-sm btn-circle red easy-pie-chart-reload">
                        <i class="fa fa-repeat"></i> Reload </a>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="easy-pie-chart">
                            <div class="number transactions" data-percent="55">
                                <span>+55</span>% </div>
                            <a class="title" href="javascript:;"> Transactions
                                <i class="icon-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="margin-bottom-10 visible-sm"> </div>
                    <div class="col-md-4">
                        <div class="easy-pie-chart">
                            <div class="number visits" data-percent="85">
                                <span>+85</span>% </div>
                            <a class="title" href="javascript:;"> New Visits
                                <i class="icon-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="margin-bottom-10 visible-sm"> </div>
                    <div class="col-md-4">
                        <div class="easy-pie-chart">
                            <div class="number bounce" data-percent="46">
                                <span>-46</span>% </div>
                            <a class="title" href="javascript:;"> Bounce
                                <i class="icon-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-xs-12 col-sm-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-equalizer font-dark hide"></i>
                    <span class="caption-subject font-dark bold uppercase">Server Stats</span>
                    <span class="caption-helper">monthly stats...</span>
                </div>
                <div class="tools">
                    <a href="" class="collapse"> </a>
                    <a href="#portlet-config" data-toggle="modal" class="config"> </a>
                    <a href="" class="reload"> </a>
                    <a href="" class="remove"> </a>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="sparkline-chart">
                            <div class="number" id="sparkline_bar5"></div>
                            <a class="title" href="javascript:;"> Network
                                <i class="icon-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="margin-bottom-10 visible-sm"> </div>
                    <div class="col-md-4">
                        <div class="sparkline-chart">
                            <div class="number" id="sparkline_bar6"></div>
                            <a class="title" href="javascript:;"> CPU Load
                                <i class="icon-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="margin-bottom-10 visible-sm"> </div>
                    <div class="col-md-4">
                        <div class="sparkline-chart">
                            <div class="number" id="sparkline_line"></div>
                            <a class="title" href="javascript:;"> Load Rate
                                <i class="icon-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
  <div class="col-lg-12 col-xs-12 col-sm-12">
        <div class="portlet light portlet-fit bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-directions font-green hide"></i>
                    <span class="caption-subject bold font-dark uppercase "> Activities</span>
                    <span class="caption-helper">Horizontal Timeline</span>
                </div>
                <div class="actions">
                    <div class="btn-group">
                        <a class="btn blue btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Actions
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li>
                                <a href="javascript:;"> Action 1</a>
                            </li>
                            <li class="divider"> </li>
                            <li>
                                <a href="javascript:;">Action 2</a>
                            </li>
                            <li>
                                <a href="javascript:;">Action 3</a>
                            </li>
                            <li>
                                <a href="javascript:;">Action 4</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="portlet-body">
                <div class="cd-horizontal-timeline mt-timeline-horizontal loaded" data-spacing="60">
                    <div class="timeline">
                        <div class="events-wrapper">
                            <div class="events" style="width: 1800px;">
                                <ol>
                                    <li>
                                        <a href="#0" data-date="16/01/2014" class="border-after-red bg-after-red selected" style="left: 120px;">16 Jan</a>
                                    </li>
                                    <li>
                                        <a href="#0" data-date="28/02/2014" class="border-after-red bg-after-red" style="left: 300px;">28 Feb</a>
                                    </li>
                                    <li>
                                        <a href="#0" data-date="20/04/2014" class="border-after-red bg-after-red" style="left: 480px;">20 Mar</a>
                                    </li>
                                    <li>
                                        <a href="#0" data-date="20/05/2014" class="border-after-red bg-after-red" style="left: 600px;">20 May</a>
                                    </li>
                                    <li>
                                        <a href="#0" data-date="09/07/2014" class="border-after-red bg-after-red" style="left: 780px;">09 Jul</a>
                                    </li>
                                    <li>
                                        <a href="#0" data-date="30/08/2014" class="border-after-red bg-after-red" style="left: 960px;">30 Aug</a>
                                    </li>
                                    <li>
                                        <a href="#0" data-date="15/09/2014" class="border-after-red bg-after-red" style="left: 1020px;">15 Sep</a>
                                    </li>
                                    <li>
                                        <a href="#0" data-date="01/11/2014" class="border-after-red bg-after-red" style="left: 1200px;">01 Nov</a>
                                    </li>
                                    <li>
                                        <a href="#0" data-date="10/12/2014" class="border-after-red bg-after-red" style="left: 1380px;">10 Dec</a>
                                    </li>
                                    <li>
                                        <a href="#0" data-date="19/01/2015" class="border-after-red bg-after-red" style="left: 1500px;">29 Jan</a>
                                    </li>
                                    <li>
                                        <a href="#0" data-date="03/03/2015" class="border-after-red bg-after-red" style="left: 1680px;">3 Mar</a>
                                    </li>
                                </ol>
                                <span class="filling-line bg-red" aria-hidden="true" style="transform: scaleX(0.0763889);"></span>
                            </div>
                            .events
                        </div>
                        .events-wrapper
                        <ul class="cd-timeline-navigation mt-ht-nav-icon">
                            <li>
                                <a href="#0" class="prev inactive btn btn-outline red md-skip">
                                    <i class="fa fa-chevron-left"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#0" class="next btn btn-outline red md-skip">
                                    <i class="fa fa-chevron-right"></i>
                                </a>
                            </li>
                        </ul>
                        .cd-timeline-navigation
                    </div>
                    .timeline
                    <div class="events-content">
                        <ol>
                            <li class="selected" data-date="16/01/2014">
                                <div class="mt-title">
                                    <h2 class="mt-content-title">New User</h2>
                                </div>
                                <div class="mt-author">
                                    <div class="mt-avatar">
                                        <img src="../assets/pages/media/users/avatar80_3.jpg">
                                    </div>
                                    <div class="mt-author-name">
                                        <a href="javascript:;" class="font-blue-madison">Andres Iniesta</a>
                                    </div>
                                    <div class="mt-author-datetime font-grey-mint">16 January 2014 : 7:45 PM</div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="mt-content border-grey-steel">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam euismod eleifend ipsum, at posuere augue. Pellentesque mi felis, aliquam at iaculis eu, mi felis, aliquam at iaculis mi felis, aliquam
                                        at iaculis finibus eu ex. Integer efficitur tincidunt malesuada. Sed sit amet molestie elit, vel placerat ipsum. Ut consectetur odio non est rhoncus volutpat.</p>
                                    <a href="javascript:;" class="btn btn-circle red btn-outline">Read More</a>
                                    <a href="javascript:;" class="btn btn-circle btn-icon-only blue">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                    <a href="javascript:;" class="btn btn-circle btn-icon-only green pull-right">
                                        <i class="fa fa-twitter"></i>
                                    </a>
                                </div>
                            </li>
                            <li data-date="28/02/2014">
                                <div class="mt-title">
                                    <h2 class="mt-content-title">Sending Shipment</h2>
                                </div>
                                <div class="mt-author">
                                    <div class="mt-avatar">
                                        <img src="../assets/pages/media/users/avatar80_3.jpg">
                                    </div>
                                    <div class="mt-author-name">
                                        <a href="javascript:;" class="font-blue-madison">Hugh Grant</a>
                                    </div>
                                    <div class="mt-author-datetime font-grey-mint">28 February 2014 : 10:15 AM</div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="mt-content border-grey-steel">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam euismod eleifend ipsum, at posuere augue. Pellentesque mi felis, aliquam at iaculis eu, finibus eu ex. Integer efficitur leo eget dolor
                                        tincidunt, et dignissim risus lacinia. Nam in egestas nunc. Suspendisse potenti. Cras ullamcorper tincidunt malesuada. Sed sit amet molestie elit, vel placerat ipsum. Ut consectetur odio non
                                        est rhoncus volutpat. Nullam interdum, neque quis vehicula ornare, lacus elit dignissim purus, quis ultrices erat tortor eget felis. Cras commodo id massa at condimentum. Praesent dignissim luctus
                                        risus sed sodales.</p>
                                    <a href="javascript:;" class="btn btn-circle btn-outline green-jungle">Download Shipment List</a>
                                    <div class="btn-group dropup pull-right">
                                        <button class="btn btn-circle blue-steel dropdown-toggle" type="button" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false"> Actions
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu pull-right" role="menu">
                                            <li>
                                                <a href="javascript:;">Action </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">Another action </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">Something else here </a>
                                            </li>
                                            <li class="divider"> </li>
                                            <li>
                                                <a href="javascript:;">Separated link </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <li data-date="20/04/2014">
                                <div class="mt-title">
                                    <h2 class="mt-content-title">Blue Chambray</h2>
                                </div>
                                <div class="mt-author">
                                    <div class="mt-avatar">
                                        <img src="../assets/pages/media/users/avatar80_1.jpg">
                                    </div>
                                    <div class="mt-author-name">
                                        <a href="javascript:;" class="font-blue">Rory Matthew</a>
                                    </div>
                                    <div class="mt-author-datetime font-grey-mint">20 April 2014 : 10:45 PM</div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="mt-content border-grey-steel">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam euismod eleifend ipsum, at posuere augue. Pellentesque mi felis, aliquam at iaculis eu, finibus eu ex. Integer efficitur leo eget dolor
                                        tincidunt, et dignissim risus lacinia. Nam in egestas nunc. Suspendisse potenti. Cras ullamcorper tincidunt malesuada. Sed sit amet molestie elit, vel placerat ipsum. Ut consectetur odio non
                                        est rhoncus volutpat. Nullam interdum, neque quis vehicula ornare, lacus elit dignissim purus, quis ultrices erat tortor eget felis. Cras commodo id massa at condimentum. Praesent dignissim luctus
                                        risus sed sodales.</p>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto, optio, dolorum provident rerum aut hic quasi placeat iure tempora laudantium ipsa ad debitis unde? Iste voluptatibus minus veritatis
                                        qui ut. laudantium ipsa ad debitis unde? Iste voluptatibus minus veritatis qui ut. </p>
                                    <a href="javascript:;" class="btn btn-circle red">Read More</a>
                                </div>
                            </li>
                            <li data-date="20/05/2014">
                                <div class="mt-title">
                                    <h2 class="mt-content-title">Timeline Received</h2>
                                </div>
                                <div class="mt-author">
                                    <div class="mt-avatar">
                                        <img src="../assets/pages/media/users/avatar80_2.jpg">
                                    </div>
                                    <div class="mt-author-name">
                                        <a href="javascript:;" class="font-blue-madison">Andres Iniesta</a>
                                    </div>
                                    <div class="mt-author-datetime font-grey-mint">20 May 2014 : 12:20 PM</div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="mt-content border-grey-steel">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam euismod eleifend ipsum, at posuere augue. Pellentesque mi felis, aliquam at iaculis eu, finibus eu ex. Integer efficitur leo eget dolor
                                        tincidunt, et dignissim risus lacinia. Nam in egestas nunc. Suspendisse potenti. Cras ullamcorper tincidunt malesuada. Sed sit amet molestie elit, vel placerat ipsum. Ut consectetur odio non
                                        est rhoncus volutpat. Nullam interdum, neque quis vehicula ornare, lacus elit dignissim purus, quis ultrices erat tortor eget felis. Cras commodo id massa at condimentum. Praesent dignissim luctus
                                        risus sed sodales.</p>
                                    <a href="javascript:;" class="btn btn-circle green-turquoise">Read More</a>
                                </div>
                            </li>
                            <li data-date="09/07/2014">
                                <div class="mt-title">
                                    <h2 class="mt-content-title">Event Success</h2>
                                </div>
                                <div class="mt-author">
                                    <div class="mt-avatar">
                                        <img src="../assets/pages/media/users/avatar80_1.jpg">
                                    </div>
                                    <div class="mt-author-name">
                                        <a href="javascript:;" class="font-blue-madison">Matt Goldman</a>
                                    </div>
                                    <div class="mt-author-datetime font-grey-mint">9 July 2014 : 8:15 PM</div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="mt-content border-grey-steel">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto, optio, dolorum provident rerum aut hic quasi placeat iure tempora laudantium ipsa ad debitis unde.</p>
                                    <a href="javascript:;" class="btn btn-circle btn-outline purple-medium">View Summary</a>
                                    <div class="btn-group dropup pull-right">
                                        <button class="btn btn-circle green dropdown-toggle" type="button" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false"> Actions
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu pull-right" role="menu">
                                            <li>
                                                <a href="javascript:;">Action </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">Another action </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">Something else here </a>
                                            </li>
                                            <li class="divider"> </li>
                                            <li>
                                                <a href="javascript:;">Separated link </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <li data-date="30/08/2014">
                                <div class="mt-title">
                                    <h2 class="mt-content-title">Conference Call</h2>
                                </div>
                                <div class="mt-author">
                                    <div class="mt-avatar">
                                        <img src="../assets/pages/media/users/avatar80_1.jpg">
                                    </div>
                                    <div class="mt-author-name">
                                        <a href="javascript:;" class="font-blue-madison">Rory Matthew</a>
                                    </div>
                                    <div class="mt-author-datetime font-grey-mint">30 August 2014 : 5:45 PM</div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="mt-content border-grey-steel">
                                    <img class="timeline-body-img pull-left" src="../assets/pages/media/blog/5.jpg" alt="">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto, optio, dolorum provident rerum aut hic quasi placeat iure tempora laudantium ipsa ad debitis unde? Iste voluptatibus minus veritatis
                                        qui ut. laudantium ipsa ad debitis unde? Iste voluptatibus minus veritatis qui ut. </p>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto, optio, dolorum provident rerum aut hic quasi placeat iure tempora laudantium ipsa ad debitis unde? Iste voluptatibus minus veritatis
                                        qui ut. laudantium ipsa ad debitis unde? Iste voluptatibus minus veritatis qui ut. </p>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto, optio, dolorum provident rerum aut hic quasi placeat iure tempora laudantium ipsa ad debitis unde? Iste voluptatibus minus veritatis
                                        qui ut. laudantium ipsa ad debitis unde? Iste voluptatibus minus veritatis qui ut. </p>
                                    <a href="javascript:;" class="btn btn-circle red">Read More</a>
                                </div>
                            </li>
                            <li data-date="15/09/2014">
                                <div class="mt-title">
                                    <h2 class="mt-content-title">Conference Decision</h2>
                                </div>
                                <div class="mt-author">
                                    <div class="mt-avatar">
                                        <img src="../assets/pages/media/users/avatar80_5.jpg">
                                    </div>
                                    <div class="mt-author-name">
                                        <a href="javascript:;" class="font-blue-madison">Jessica Wolf</a>
                                    </div>
                                    <div class="mt-author-datetime font-grey-mint">15 September 2014 : 8:30 PM</div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="mt-content border-grey-steel">
                                    <img class="timeline-body-img pull-right" src="../assets/pages/media/blog/6.jpg" alt="">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto, optio, dolorum provident rerum aut hic quasi placeat iure tempora laudantium ipsa ad debitis unde? Iste voluptatibus minus veritatis
                                        qui ut.</p>
                                    <a href="javascript:;" class="btn btn-circle green-sharp">Read More</a>
                                </div>
                            </li>
                            <li data-date="01/11/2014">
                                <div class="mt-title">
                                    <h2 class="mt-content-title">Timeline Received</h2>
                                </div>
                                <div class="mt-author">
                                    <div class="mt-avatar">
                                        <img src="../assets/pages/media/users/avatar80_2.jpg">
                                    </div>
                                    <div class="mt-author-name">
                                        <a href="javascript:;" class="font-blue-madison">Andres Iniesta</a>
                                    </div>
                                    <div class="mt-author-datetime font-grey-mint">1 November 2014 : 12:20 PM</div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="mt-content border-grey-steel">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam euismod eleifend ipsum, at posuere augue. Pellentesque mi felis, aliquam at iaculis eu, finibus eu ex. Integer efficitur leo eget dolor
                                        tincidunt, et dignissim risus lacinia. Nam in egestas nunc. Suspendisse potenti. Cras ullamcorper tincidunt malesuada. Sed sit amet molestie elit, vel placerat ipsum. Ut consectetur odio non
                                        est rhoncus volutpat. Nullam interdum, neque quis vehicula ornare, lacus elit dignissim purus, quis ultrices erat tortor eget felis. Cras commodo id massa at condimentum. Praesent dignissim luctus
                                        risus sed sodales.</p>
                                    <a href="javascript:;" class="btn btn-circle green-turquoise">Read More</a>
                                </div>
                            </li>
                            <li data-date="10/12/2014">
                                <div class="mt-title">
                                    <h2 class="mt-content-title">Timeline Received</h2>
                                </div>
                                <div class="mt-author">
                                    <div class="mt-avatar">
                                        <img src="../assets/pages/media/users/avatar80_2.jpg">
                                    </div>
                                    <div class="mt-author-name">
                                        <a href="javascript:;" class="font-blue-madison">Andres Iniesta</a>
                                    </div>
                                    <div class="mt-author-datetime font-grey-mint">10 December 2015 : 12:20 PM</div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="mt-content border-grey-steel">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam euismod eleifend ipsum, at posuere augue. Pellentesque mi felis, aliquam at iaculis eu, finibus eu ex. Integer efficitur leo eget dolor
                                        tincidunt, et dignissim risus lacinia. Nam in egestas nunc. Suspendisse potenti. Cras ullamcorper tincidunt malesuada. Sed sit amet molestie elit, vel placerat ipsum. Ut consectetur odio non
                                        est rhoncus volutpat. Nullam interdum, neque quis vehicula ornare, lacus elit dignissim purus, quis ultrices erat tortor eget felis. Cras commodo id massa at condimentum. Praesent dignissim luctus
                                        risus sed sodales.</p>
                                    <a href="javascript:;" class="btn btn-circle green-turquoise">Read More</a>
                                </div>
                            </li>
                            <li data-date="19/01/2015">
                                <div class="mt-title">
                                    <h2 class="mt-content-title">Timeline Received</h2>
                                </div>
                                <div class="mt-author">
                                    <div class="mt-avatar">
                                        <img src="../assets/pages/media/users/avatar80_2.jpg">
                                    </div>
                                    <div class="mt-author-name">
                                        <a href="javascript:;" class="font-blue-madison">Andres Iniesta</a>
                                    </div>
                                    <div class="mt-author-datetime font-grey-mint">19 January 2015 : 12:20 PM</div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="mt-content border-grey-steel">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam euismod eleifend ipsum, at posuere augue. Pellentesque mi felis, aliquam at iaculis eu, finibus eu ex. Integer efficitur leo eget dolor
                                        tincidunt, et dignissim risus lacinia. Nam in egestas nunc. Suspendisse potenti. Cras ullamcorper tincidunt malesuada. Sed sit amet molestie elit, vel placerat ipsum. Ut consectetur odio non
                                        est rhoncus volutpat. Nullam interdum, neque quis vehicula ornare, lacus elit dignissim purus, quis ultrices erat tortor eget felis. Cras commodo id massa at condimentum. Praesent dignissim luctus
                                        risus sed sodales.</p>
                                    <a href="javascript:;" class="btn btn-circle green-turquoise">Read More</a>
                                </div>
                            </li>
                            <li data-date="03/03/2015">
                                <div class="mt-title">
                                    <h2 class="mt-content-title">Timeline Received</h2>
                                </div>
                                <div class="mt-author">
                                    <div class="mt-avatar">
                                        <img src="../assets/pages/media/users/avatar80_2.jpg">
                                    </div>
                                    <div class="mt-author-name">
                                        <a href="javascript:;" class="font-blue-madison">Andres Iniesta</a>
                                    </div>
                                    <div class="mt-author-datetime font-grey-mint">3 March 2015 : 12:20 PM</div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="mt-content border-grey-steel">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam euismod eleifend ipsum, at posuere augue. Pellentesque mi felis, aliquam at iaculis eu, finibus eu ex. Integer efficitur leo eget dolor
                                        tincidunt, et dignissim risus lacinia. Nam in egestas nunc. Suspendisse potenti. Cras ullamcorper tincidunt malesuada. Sed sit amet molestie elit, vel placerat ipsum. Ut consectetur odio non
                                        est rhoncus volutpat. Nullam interdum, neque quis vehicula ornare, lacus elit dignissim purus, quis ultrices erat tortor eget felis. Cras commodo id massa at condimentum. Praesent dignissim luctus
                                        risus sed sodales.</p>
                                    <a href="javascript:;" class="btn btn-circle green-turquoise">Read More</a>
                                </div>
                            </li>
                        </ol>
                    </div>
                    .events-content
                </div>
            </div>
        </div>
    </div>
</div> -->
<!-- END PAGE BASE CONTENT -->

@endsection
