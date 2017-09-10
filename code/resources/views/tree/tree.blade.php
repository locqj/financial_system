@extends('layouts.nav')
@section('content')
<meta name="viewport" content="width=device-width, initial-scale=1" />  
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script>
        $(function(){
            var liWidth = $("#li1").width();
            var width1 = screen.availWidth + liWidth;
            width1 = width1 + "px";
            $("#div1").css('width',width1);
            var liWidth2 = $("#li1").width();
            var width3 = liWidth2 + 100;
              width2 = width3 + "px";
            $("#div1").css('width',width2);
        })
    </script>
    <style type="text/css">
    

    * {margin: 0; padding: 0;}
    .tree{
        margin-top: 1%;
    }

    .tree ul {
        padding-top: 40px; position: relative;
        
        transition: all 0.5s;
        -webkit-transition: all 0.5s;
        -moz-transition: all 0.5s;
    }

    .tree li {
        float: left; text-align: center;
        list-style-type: none;
        position: relative;
        padding: 40px 1px 0 1px;
        
        transition: all 0.5s;
        -webkit-transition: all 0.5s;
        -moz-transition: all 0.5s;
    }

    /*We will use ::before and ::after to draw the connectors*/

    .tree li::before, .tree li::after{
        content: '';
        position: absolute; top: 0; right: 50%;
        border-top: 2px solid #ccc;
        width: 50%; height: 40px;
    }
    .tree li::after{
        right: auto; left: 50%;
        border-left: 2px solid #ccc;
    }

    /*We need to remove left-right connectors from elements without 
    any siblings*/
    .tree li:only-child::after, .tree li:only-child::before {
        display: none;
    }

    /*Remove space from the top of single children*/
    .tree li:only-child{ padding-top: 0;}

    /*Remove left connector from first child and 
    right connector from last child*/
    .tree li:first-child::before, .tree li:last-child::after{
        border: 0 none;
    }
    /*Adding back the vertical connector to the last nodes*/
    .tree li:last-child::before{
        border-right: 2px solid #ccc;
        border-radius: 0 5px 0 0;
        -webkit-border-radius: 0 5px 0 0;
        -moz-border-radius: 0 5px 0 0;
    }
    .tree li:first-child::after{ 
        border-radius: 5px 0 0 0;
        -webkit-border-radius: 5px 0 0 0;
        -moz-border-radius: 5px 0 0 0;
    }

    /*Time to add downward connectors from parents*/
    .tree ul ul::before{
        content: '';
        position: absolute; top: 0; left: 50.5%;
        border-left: 2px solid #ccc;
        width: 0; height: 40px;
    }

    .tree li a{
        margin-top:1px;
        width: 160px;
        border: 1px solid #ccc;
        padding: 5px 10px;
        text-decoration: none;
        background-color:#17c5cb;
        color: white;
        font-family: arial, verdana, tahoma;
        font-size: 1.5em;

        display: inline-block;
        
        
        
        transition: all 0.5s;
        -webkit-transition: all 0.5s;
        -moz-transition: all 0.5s;
    }

    /*Time for some hover effects*/
    /*We will apply the hover effect the the lineage of the element also*/
    .tree li a:hover, .tree li a:hover+ul li a {
        background: #c8e4f8; color: #000; border: 1px solid #94a0b4;
    }
    /*Connector styles on hover*/
    .tree li a:hover+ul li::after, 
    .tree li a:hover+ul li::before, 
    .tree li a:hover+ul::before, 
    .tree li a:hover+ul ul::before{
        border-color:  #94a0b4;
    }

    .btnChange{
        
        width: 100px;
        border: 1px solid #ccc;
        text-decoration: none;
        padding:5px 10px;
        background-color:#01b468;
        color: white;
        font-family: arial, verdana, tahoma;
        font-size: 1.3em;
        text-overflow: ellipsis;
            overflow: hidden;
            white-space: nowrap;

        border-radius: 5px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        
        transition: all 0.5s;
        -webkit-transition: all 0.5s;
        -moz-transition: all 0.5s;
    }

    .btnChange:hover{
        background: #02df82; color: #000; border: 1px solid #94a0b4;
    }

    .btn{
        border: 1px solid #ccc;
        padding: 5px 10px;
        text-decoration: none;
        /*background-color:#17c5cb;*/
        color: #666;
        font-family: arial, verdana, tahoma;
        font-size: 1.5em;

        border-radius: 5px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        
        transition: all 0.5s;
        -webkit-transition: all 0.5s;
        -moz-transition: all 0.5s;
    }

</style>

<section class="vbox">
<section class="scrollable padder">
<marquee direction=left class="headerMarquee">欢迎使用xxx房产记账结算管理系统！</marquee>
<ul class="breadcrumb no-border no-radius b-b b-light pull-in">
  <li><i class="fa fa-home"></i> 主页</li>
  <li class="active">公司组织架构</li>
</ul>
<div class="table-responsive-tree">
<div id="div1" style="display:table;margin:0 auto"> 
<h2 style="text-align:center">公司组织架构图</h2>
<div class="tree" style="">
    <ul>
    @foreach($data as $list_zong)
        <li id="li1">
            <div class="menu_list">  
                <button title="{{ $list_zong['name'] }}" class="dropdown-toggle @if(in_array(session('level_code'), ['cw', 'jl', 'gh'])) btnChange @else btn @endif" 
                @if(in_array(session::get('level_code'), ['cw', 'jl'])) data-toggle="dropdown" @endif>{{ $list_zong['name'] }}
                </button>
                <table class="dropdown-menu animated fadeInRight" style="position: absolute;left:40%;border:1px solid white"> 
                <tr>
                    <td>
                        <span class="arrow top"></span>
                    </td>
                </tr>
                <!-- <tr>
                    <td>
                        <a href="/port/count/all-all-{{$year}}-{{$month}}"  onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';">端口统计</a> 
                    </td>
                </tr> -->
                <tr>
                    <td>
                        <a href="/city"  onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';">地域管理</a> 
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="/search/employee/{{ $list_zong['value'] }}-0-0" target="_blank" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';">员工管理</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="/search/position/{{ $list_zong['value'] }}-0-0" target="_blank" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';">基本工资</a> 
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="/cost/time_key/{{$list_zong['value']}}-{{$year}}-{{$month}}" target="_blank" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';">成本录入</a> 
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="/search/salary_real/{{$list_zong['value']}}-{{$year}}-{{$month}}-all" target="_blank" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';">工资发放记录</a> 
                    </td>
                </tr>
                </table>
            </div>
                @if(array_key_exists('children', $list_zong))
                <ul>
                    @foreach($list_zong['children'] as $list_city)
                        <li>
                            <div  class="menu_list">  
                                <button title="{{ $list_city['name'] }}" class="dropdown-toggle @if(in_array(session('level_code'), ['cw', 'jl', 'gh'])) btnChange @else btn @endif" 
                                @if(in_array(session::get('level_code'), ['cw', 'jl'])) data-toggle="dropdown" @endif>{{ $list_city['name'] }}
                                </button>
                                <table class="dropdown-menu animated fadeInRight" style="position: absolute;left:40%;border:1px solid white"> 
                                    <tr>
                                        <td>
                                            <span class="arrow top"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="/zone/{{$list_city['value']}}"  onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';">区域管理</a> 
                                        </td>
                                    </tr>
                                 </table>
                            </div>
                    @if(array_key_exists('children', $list_city))
                    <ul>
                        @foreach($list_city['children'] as $list_zone)
                            <li>
                                <div  class="menu_list">  
                                    <button title="{{ $list_zone['name'] }}" class="dropdown-toggle @if(in_array(session('level_code'), ['cw', 'jl'])) btnChange @elseif(session::get('store_code') == $list_zone['value']) btnChange @else btn @endif" 
                                    @if(in_array(session::get('level_code'), ['cw', 'jl']) || session::get('store_code') == $list_zone['value']) data-toggle="dropdown" @endif>{{ $list_zone['name'] }}
                                    </button>
                                    <table class="dropdown-menu animated fadeInRight " style="position: absolute;left:32%;border:1px solid white"> 
                                    <tr>
                                        <td>
                                            <span class="arrow top"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="/search/store/{{ $list_zone['value'] }}-0-0"  onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';">店铺管理</a> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="/search/employee/{{ $list_zone['value'] }}-0-0" target="_blank" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';">员工管理</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="/search/position/{{ $list_zone['value'] }}-0-0" target="_blank" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';">基本工资</a> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="/cost/time_key/{{$list_zone['value']}}-{{$year}}-{{$month}}" target="_blank" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';">成本录入</a> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="/search/salary_real/{{$list_zone['value']}}-{{$year}}-{{$month}}-all" target="_blank" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';">工资发放记录</a> 
                                        </td>
                                    </tr>

                                    </table> 
                                </div>
                                @if(array_key_exists('children', $list_zone))
                                <ul>
                                    @foreach($list_zone['children'] as $list_store)
                                        <li>
                                            <div class="menu_list">  
                                                <button title="{{ $list_store['name'] }}" class="dropdown-toggle @if(in_array(session::get('level_code'), ['cw', 'jl']))btnChange  
                                                @elseif(session::get('store_code') == $list_store['value'] || session::get('store_code') == $list_store['zone']) btnChange @else btn @endif" 
                                                @if(in_array(session::get('level_code'), ['cw', 'jl']) || session::get('store_code') == $list_store['zone']) data-toggle="dropdown" 
                                                @elseif(session::get('store_code') == $list_store['value']) data-toggle="dropdown" @endif>{{ $list_store['name'] }}
                                                </button>
                                                <table class="dropdown-menu animated fadeInRight " style="border:1px solid white">

                                                <tr>
                                                    <td>
                                                        <span class="arrow top"></span>
                                                    </td>
                                                </tr>
                                                @if(session::get('level_code') != 'xs')
                                                <tr>
                                                    <td>
                                                        <a href="/search/store/{{ $list_store['value'] }}-0-0" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';">本店操作</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a href="/search/employee/{{ $list_store['value'] }}-0-0" target="_blank" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';">员工管理</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td> 
                                                        <a href="/search/position/{{ $list_store['value'] }}-0-0" target="_blank" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';">基本工资</a> 
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a href="/cost/time_key/{{$list_store['value']}}-{{$year}}-{{$month}}" target="_blank" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';">成本录入</a> 
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a href="/income/time_key/{{$list_store['value']}}-{{$year}}-{{$month}}" target="_blank" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';">店铺收入</a> 
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a href="/search/costdetails/{{$list_store['value']}}-{{$year}}-{{$month}}" target="_blank" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';">成本明细</a> 
                                                    </td>
                                                </tr>
                                                 <tr>
                                                    <td>
                                                        <a href="/search/port/{{$list_store['value']}}-{{$year}}-{{$month}}-all" target="_blank" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';">端口管理</a> 
                                                    </td>
                                                </tr>
                                                @endif
                                                @if(session::get('level_code') == 'xs')
                                                <tr>
                                                    <td>
                                                        <a href="/search/salary_real/{{$list_store['value']}}-{{$year}}-{{$month}}-{{session::get('employee_code')}}" target="_blank" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';">工资发放记录</a> 
                                                    </td>
                                                </tr>
                                                @else
                                                <tr>
                                                    <td>
                                                        <a href="/search/salary_real/{{$list_store['value']}}-{{$year}}-{{$month}}-all" target="_blank" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';">工资发放记录</a> 
                                                    </td>
                                                </tr>
                                                @endif
                                                </table> 
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                    @endif
                </li>
                @endforeach
            </ul>
            @endif
        </li>
    @endforeach
    </ul>
</div>
</div>
</div>
</section>
<div class="copyRight">
    <div >版权所有: © locqj
    </div>
</div>
</section>


@endsection