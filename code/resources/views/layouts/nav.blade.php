<!DOCTYPE html>
<html lang="en" class="app">

<head>
    <meta charset="utf-8" />
    <title>xxx房产记账结算系统</title>
    <meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link rel="stylesheet" href="{{ asset('static/css/index.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('static/css/index2.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('static/css/hengju.css') }}" type="text/css" />
    <link rel="icon" type="text/css" href="https://static.jianshukeji.com/highcharts/images/favicon.ico">
   <!--  <link rel="stylesheet" href="{{ asset('static/css/font.css') }}" type="text/css" cache="false" /> -->
    <script src="{{ asset('static/js/employee_information.js') }}" type="text/javascript" charset="utf-8"></script>
    <script src="http://qrcode.565tech.com/static/admin/js/app.v2.js"></script>
    <script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>
</head>

<body>
    <section class="vbox">
        <header class="bg-dark dk header navbar navbar-fixed-top-xs headerHeight">
            <div class="navbar-header aside-md" style="width:50em">
                <a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen" data-target="#nav"> <i class="fa fa-bars"></i>
                </a>
              
                <img src="{{ asset('static/images/fclogo.png') }}" width="35" height="35" class="imgStyle">
                <span class="navbar-brand headerTitle">xxx房产管理系统</span>
                <a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".nav-user"> <i class="fa fa-cog"></i>
        </a>
            </div>
            <ul class="nav navbar-nav navbar-right hidden-xs nav-user">
                <li class="dropdown ">
                   <a href=" " class="dropdown-toggle" data-toggle="dropdown">
                        <span class="thumb-sm avatar pull-left">
                            <img src="{{ asset('static/images/user.jpg') }}">
                        </span>
                        {{ Session::get('username') }}[{{ Session::get('position_tag') }}]<b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight">
                        <span class="arrow top"></span>
                        <li>
                            <a href="{{url('/logout')}}">退出系统</a>
                        </li>
                        <li>
                            <a data-toggle="modal" data-target="#modifyPwd" id="passChange">修改密码</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </header>
        <section>
            <section class="hbox stretch">
                 <!-- .aside -->
        <aside class="bg-dark lter aside-md hidden-print" id="nav">
          <section class="vbox">
            <section class="w-f scrollable">
              <div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="5px" data-color="#333333">
                <!-- nav -->
                <nav class="nav-primary hidden-xs">
                <!-- 店长 -->

                  <ul class="nav">
                  <li class="@if($_SERVER['REQUEST_URI'] == '/tree') active @endif">
                      <a href="/tree" >
                        <i class="fa fa-sitemap icon">
                            <b class="bg-primary storeCostcolor"></b>
                        </i>
                        <span>公司组织架构</span>
                      </a>
                  </li>
                  @if(session('level_code') == 'dz' || session('level_code') == 'jl' ||session('level_code') == 'cw' || session('level_code') == 'zl' || session('level_code') == 'qy')
                    <li class="@if($_SERVER['REQUEST_URI'] == '/index') active @endif">
                      <a href="{{url('/index')}}" >
                        <i class="fa fa-home icon"><b class="bg-danger"></b></i> 
                        <span>首页</span>
                      </a>
                    </li>

                  <li class="@if($_SERVER['REQUEST_URI'] == '/bonusrule') active @endif">
                    <a href="{{route('bonusrule.index')}}" >
                      <i class="fa fa-arrows-alt icon">
                          <b class="bg-primary bonusruleColor"></b>
                      </i>
                      <span>提成规则</span>
                    </a>
                  </li>

                  <li class="<?php $url = $_SERVER['REQUEST_URI'];  $url = explode('/', $url);
                      if($url[1] == 'commission'){
                          echo 'active';
                      }else if ($url[1] == 'find'){
                          $url = $url[1].'/'.$url[2]; 
                          if($url == 'find/commission_details'){
                              echo 'active';}
                      }?>">
                    <a href="{{route('commission.index')}}" >
                      <i class="fa fa-strikethrough icon">
                          <b class="bg-primary salaryColor"></b>
                      </i>
                      <span>佣金明细</span>
                    </a>
                  </li>
      
                  <li class="<?php $url = $_SERVER['REQUEST_URI'];  $url = explode('/', $url);
                      if($url[1] == 'bonus'){
                          echo 'active';
                      }else if ($url[1] == 'find'){
                          $url = $url[1].'/'.$url[2]; 
                          if($url == 'find/bonus_details'){
                              echo 'active';}
                      }?>">
                    <a href="{{route('bonus.index')}}" >
                      <i class="fa fa-list icon">
                          <b class="bg-primary commissionColor"></b>
                      </i>
                      <span>提成明细</span>
                    </a>
                  </li>
                 <li class="<?php $url = $_SERVER['REQUEST_URI'];  $url = explode('/', $url);
                        if($url[1] == 'reducesalary'){
                            echo 'active';
                        }else if ($url[1] == 'search'){
                            $url = $url[1].'/'.$url[2]; 
                            if($url == 'search/reducesalary'){
                                echo 'active';}
                        }?>">
                      <a href="/reducesalary" >
                        <i class="fa fa-times-circle icon">
                            <b class="bg-primary reducesalaryColor"></b>
                        </i>
                        <span>扣除工资记录</span>
                      </a>
                    </li>
                  @endif
                  <!-- 全部 -->
                    
                     <li class="<?php $url = $_SERVER['REQUEST_URI'];  $url = explode('/', $url);
                          if($url[1] == 'contract'){
                              echo 'active';
                          }else if ($url[1] == 'search'){
                              $url = $url[1].'/'.$url[2]; 
                              if($url == 'search/contract'){
                                  echo 'active';}
                          }?>">
                        <a href="{{ url('contract') }}" >
                          <i class="fa fa-list-alt icon">
                              <b class="bg-primary contractColor"></b>
                          </i>
                          <span>签单管理</span>
                        </a>
                      </li>
                    <!-- end 全部 -->
                    <!--总店人员-->
                    <!-- 财务和过户 -->
                    @if(session('level_code') == 'cw' || session('level_code') == 'gh' || session('level_code') == 'jl')
                        <li class="<?php $url = $_SERVER['REQUEST_URI'];  $url = explode('/', $url);
                            if($url[1] == 'transfer'){
                                echo 'active';
                            }else if ($url[1] == 'search'){
                                $url = $url[1].'/'.$url[2]; 
                                if($url == 'search/transfer'){
                                    echo 'active';}
                            }?>">
                          <a href="{{route('transfer.index')}}" >
                            <i class="fa fa-link icon">
                                <b class="bg-primary transferColor"></b>
                            </i>
                            <span>过户记录</span>
                          </a>
                        </li>
                    @endif
                    <!-- end财务和过户 -->
                    <!-- 财务和经理 -->
                  @if(session('level_code') == 'cw' || session('level_code') == 'jl')
                        <li class="<?php $url = $_SERVER['REQUEST_URI'];  $url = explode('/', $url);
                            if($url[1] == 'position'){
                                echo 'active';
                            }else if ($url[1] == 'search'){
                                $url = $url[1].'/'.$url[2]; 
                                if($url == 'search/position_adjument'){
                                    echo 'active';}
                            }?>">
                          <a href="{{ url('position/adjustment') }}" >
                            <i class="fa fa-exchange icon">
                                <b class="bg-primary dker"></b>
                            </i>
                            <span>员工职位调整</span>
                          </a>
                        </li>
                        <li class="<?php $url = $_SERVER['REQUEST_URI'];  $url = explode('/', $url);
                            if($url[1] == 'count'){
                                echo 'active';
                            }else if ($url[1] == 'search'){
                                $url = $url[1].'/'.$url[2]; 
                                if($url == 'search/count_all'){
                                    echo 'active';}
                            }?>">
                          <a href="{{ url('/count') }}" >
                            <i class="fa fa-table icon">
                                <b class="bg-primary countColor"></b>
                            </i>
                            <span>财务结算</span>
                          </a>
                        </li>
                    @endif
                    <!--end-->
                  </ul>
                </nav>
                <!-- / nav --> </div>
                <div class="modal fade" id="modifyPwd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="color:black">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">修改密码</h4>
                      </div>
                      <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table" >      
                                <tr>                      
                                    <td>原密码</td>
                                    <td><input type="password" id="passBefore"></td>
                                </tr>
                                <tr>                      
                                    <td>新密码</td>
                                    <td><input type="password" id="passNow"></td>
                                </tr>
                                <tr>                      
                                    <td>确认密码</td>
                                    <td><input type="password" id="passNowConfirm"></td>
                                </tr>
                            </table>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <span id="errMsgNav" style="color: red;float: left;"></span>
                        <div id="info" class="modalFooterstyle"></div>
                        <button type="button" class="btn btn-default" data-dismiss="modal" id="cancel">
                            取消
                        </button>
                        <button type="button" class="btn btn-default" id="passSub" name="">
                            确认
                        </button>
                      </div>
                    </div>
                  </div>
            </div>
            </section>
            <footer class="footer lt hidden-xs b-t b-dark">
              <a href="#nav" data-toggle="class:nav-xs" class="pull-right btn btn-sm btn-dark btn-icon">
                <i class="fa fa-angle-left text"></i>
                <i class="fa fa-angle-right text-active"></i>
              </a>
            </footer>
          </section>
        </aside>
        <!-- /.aside -->
                <section id="content">
                    @yield('content')      
                </section>
            </section>
        </section>
    </section>
<script type="text/javascript">
  /*修改密码初始化*/
  $('#passChange').click(function(){
    $('#passBefore').val('');
    $('#passNow').val('');
    $('#passNowConfirm').val('');
    $('#errMsgNav').html('');
  })
  $('#passBefore').click(function(){
    $('#errMsgNav').html('');
  })
  $('#passNow').click(function(){
    $('#errMsgNav').html('');
  })
  $('#passNowConfirm').click(function(){
    $('#errMsgNav').html('');
  })
  /*修改密码*/
  $('#passSub').click(function(){
    var passBefore = $('#passBefore').val();
    var passNow = $('#passNow').val();
    var passNowConfirm = $('#passNowConfirm').val();
    if(passBefore == ""){
         $('#errMsgNav').html('原密码不能为空');
    }else if(passNow == ""){
         $('#errMsgNav').html('新密码不能为空');
    }else if(passNowConfirm == ""){
       $('#errMsgNav').html('确认密码不能为空');
    }else if(passNow != passNowConfirm){
       $('#errMsgNav').html('确认密码不一致');
    }else{
      $.post("{{url('/user/passedit')}}",
        {passBefore:passBefore,passNow:passNow,passNowConfirm:passNowConfirm},function(result){
          if(result['status']){
            alert(result['msg']);
            window.location.href = "{{url('/logout')}}";
          }else{
             $('#errMsgNav').html(result['msg']);
          }
        });
    }
  })
</script>
</body>

</html>
