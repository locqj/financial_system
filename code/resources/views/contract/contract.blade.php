@extends('layouts.nav')
@section('content')
<script src="/static/js/jquery.lighter.js" type="text/javascript"></script>
<link href="/static/css/jquery.lighter.css" rel="stylesheet" type="text/css" />   
<style type="text/css">
        .image_container {
            display: inline-block;
            float: left;
        }

            #tdRoomPicture a, .image_container a,.image_containerEdit a {
                text-align: center;
                vertical-align: middle;
                text-decoration: none;
            }

        a.addImg {
            width: 100px;
            height: 100px;
            line-height: 100px;
            display: inline-block;
            font-size: 50px;
            background-color: #dae6f3;
        }

        .image_container a.previewBox {
            background-color: #dae6f3;
            margin: 0 3px 0 0;
            display: none;
            /*display: inline-block;*/
        }

        .image_container .delImg {
            position: absolute;
            color: #f00;
            margin: 0 0 0 84px;
            font-size: 16px;
            width: 16px;
            height: 16px;
            line-height: 16px;
            text-align: center;
            vertical-align: middle;
            background-color: #c3c3c3;
        }

        
    </style>
<section class="vbox">
<section class="scrollable padder">
<marquee direction=left class="headerMarquee">欢迎使用xxx房产记账结算管理系统！</marquee>
<ul class="breadcrumb no-border no-radius b-b b-light pull-in">
  <li><i class="fa fa-home"></i> 主页</li>
  <li class="active">签单管理</li>
</ul>

<section class=" panel panel-default">
    <div class="table-responsive" >
        <table class="headerStyle">
            <tr>
                <input type="hidden" value="" id="contract_id">
                <input type="hidden" value="" id="add_or_update">
                <th class="headertitle" data-toggle="class">
                  签单管理表
                </th>
                <input type="hidden" value="{{ $store_code }}" id="store_code">
                @if(in_array(session::get('level_code'), ['cw', 'dz', 'zl']))
                @if($store_code != 'all')
                <th>
                <button class="btn btn-sm btn-default contractStyle" data-toggle="modal" data-target="#myModal" onclick="addContract1('{{ $store_code }}')" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';">添加新签单(一手)</button>
                <button class="btn btn-sm btn-default contractStyle" data-toggle="modal" data-target="#myModal" onclick="addContract2('{{ $store_code }}')" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';">添加新签单(二手)</button>
                <button class="btn btn-sm btn-default contractStyle" data-toggle="modal" data-target="#myModal" onclick="addContractz('{{ $store_code }}')" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';">添加新签单(租单)</button>
                </th>
                @endif
                @endif

            </tr>
        </table>
        <table class="table table-striped b-t b-light text-sm headerStyle2">
              <tr>
                <th>
                    <label class="labelStyle">查找店铺&nbsp;&nbsp;</label>
                    <select class="input-sm form-control input-s-sm inline" id="searchstore">
                            @foreach($store as $k => $s)
                                @if ($store_code == $s->code)
                                    @if(in_array(Session::get('level_code'), ['xs', 'dz', 'zl']))
                                    
                                    @else 
                                        @if($k == 0)
                                        <option value="all">所有</option>
                                        @endif
                                    @endif
                                    <option value="{{ $s->code }}" selected>{{ $s->name }}</option>
                                @else
                                    @if($k == 0)
                                    <option value="all">所有</option>
                                    @endif
                                    <option value="{{ $s->code }}" >{{ $s->name }}</option>
                                @endif
                            @endforeach
                    </select>
                </th>
                <th>
                    <label class="labelStyle">查找员工&nbsp;&nbsp;</label>
                    <select class="input-sm form-control input-s-sm inline" id="searchemployee">
                            <option value="all">所有</option>
                            @foreach($sign_employee as $e)
                                @if ($employee_code == $e->employee->code)
                                    <option value="{{ $e->employee->code }}" selected>{{ $e->employee->name}}</option>
                                @else
                                    <option value="{{ $e->employee->code }}" >{{ $e->employee->name }}</option>
                                @endif
                            @endforeach
                    </select>
                </th>
                <th>
                        <label class="labelStyle">年 / 月&nbsp;&nbsp;</label>  
                        <select class="input-sm form-control input-s-sm inline" id="year" style="width: 80px;">
                        @if(count($years) > 0)
                            @foreach($years as $y)
                                @if($year == $y->year)
                                    <option value="{{ $y->year }}" selected>{{ $y->year }}</option>
                                @else 
                                    <option value="{{ $y->year }}">{{ $y->year }}</option>
                                @endif
                            @endforeach
                        @else
                            <option value="{{ $year }}" selected>{{ $year }}</option>
                        @endif
                        </select>
                        <select class="input-sm form-control input-s-sm inline" id="month" style="width: 60px;">
                            @for($i = 1; $i < 13 ; $i++)
                                @if($month == $i)
                                    <option value="{{ $i }}" selected>{{ $i }}</option>
                                @else
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endif
                            @endfor
                        </select>
                        至
                        <select class="input-sm form-control input-s-sm inline" id="end_month" style="width: 60px;">
                             @if(isset($end_month))
                                    <option value="{{ $end_month }}">{{ $end_month }}</option>
                            @endif
                            @for($i = $month; $i < 13 ; $i++)
                                @if(isset($end_month))
                                    @if($i != $end_month)
                                    <option value="{{ $i + 0 }}">{{ $i + 0 }}</option>
                                    @endif
                                @else
                                    <option value="{{ $i + 0 }}">{{ $i + 0 }}</option>
                                @endif
                            @endfor
                        </select>
                    </th>
                    <th>
                    <div data-toggle="buttons">
                        <label class="btn btn-sm btn-default">
                            <input type="radio" name="options" id="option1">
                            共计
                        </label>
                        <label class="btn btn-sm btn-default">
                            <input type="radio" name="options" id="option2" >
                            <span id="conunt_num">{{ count($allContracts) }}单</span>
                            <span id="conunt_num" style="margin-left: 10px;">{{ $received_amount_all }}元</span>
                        </label>
                    </div>
                </th>
              </tr>
        </table>
    </div>
    <!--签单表-->
    <div class="table-responsive" >
    <table class="table table-striped b-t b-light text-sm">
        <thead>
        <tr>
            <th>所属店铺</th>
            <th>姓名</th>
            <th>签单类型</th>
            <th>签单日期</th>
            <th>房源地址(签单号)</th>
            <th>签佣额度</th>
            @if(session('level_code') == 'cw')
            <th>是否结佣</th>
            <th>结佣额度</th>
            <th>实收金额</th>
            @endif
            @if($sign_employee !=null)
            <th>操作</th>
            @endif
        </tr>
        </thead>
        <tbody>
            @foreach($contracts as $contract)
            <tr id="cc{{ $contract->id }}">
                <td style="display: none;" class="code{{ $contract->id }}">{{ $contract->store->code }}</td>
                <td>{{ $contract->store->name }}</td>
                <td class="employee_name{{ $contract->id }}" abbr="{{ $contract->employee->code }}">{{ $contract->employee->name }}</td>
                <td>{{ $contract->type_name }}</td>
                <td>
                    {{ $contract->year }}-{{ $contract->month }}-{{ $contract->day }}
                </td>
                <td>{{ $contract->contract_addr }}({{ $contract->number }})</td>
                <td>{{ $contract->sign_amount }}</td>
                @if(session('level_code') == 'cw')
                <td>
                    @if($contract->is_signed == 0)

                        <button class="btn btn-sm btn-default operate2" onclick="changeSign({{ $contract->id }});"  onmouseover="this.style.backgroundColor='#ed9c28'; 
                        this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#ffb70a';this.style.color = 'white';" data-target="#isSignedShow" data-toggle="modal" >未结佣</button>

                    @else
                        已结佣
                    @endif
                </td>
                <td class="real{{ $contract->id }}">
                    @if($contract->is_signed == 0)
                    <input readonly="readonly" type="button" class="btn btn-sm btn-default operate"  
                    onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" 
                    onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';" 
                    value="@if($contract->real_amount == 0)结佣金额@else{{ $contract->real_amount }}@endif" 
                    @if(session::get('level_code') == 'cw')  onclick="changerealamount('{{ $contract->id }}', '{{ $contract->is_signed }}');" 
                    @if($contract->is_signed == 0)data-toggle="modal" data-target="#realSigned" @endif @endif></input>
                    @else
                    {{ $contract->real_amount }}
                    @endif

                </td>
                <td class="received{{ $contract->id }}">
                    @if($contract->is_signed == 0)
                    <input readonly="readonly" class="btn btn-sm btn-default operate1"    
                    onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" 
                    onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';" 
                    value="@if($contract->received_amount == 0)实收金额@else{{ $contract->received_amount }}@endif"  
                    @if(session::get('level_code') == 'cw')  onclick="updaterec('{{ $contract->id }}', '{{ $contract->is_signed }}')"  
                    @if($contract->is_signed == 0) data-toggle="modal" data-target="#received_amount_label" @endif @endif></input>
                    @else
                    {{ $contract->received_amount }}
                    @endif
                </td>
                @endif
                @if($sign_employee != null)
                <td>
                <button class="btn btn-sm btn-default operate" data-toggle="modal" data-target="#details" onclick="cDetails('{{ $contract->id }}')" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';">详情</button>
                    @if(session('level_code') == 'cw')
                    @if($store_code != 'all')
                            <button class="btn btn-sm btn-default operate" data-toggle="modal" data-target="#myModal" onclick="updateContract('{{ $contract->id }}')" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';"
                            >修改</button>
                        <button class="btn btn-sm btn-default operate deleteColor"  onclick="del('{{ $contract->id }}', '{{ $contract->number }}')" onmouseover="this.style.backgroundColor='#fb6b5b'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#fb6b5b';this.style.color = 'white';">删除</button>
                    @endif
                    @endif
                <!-- 只有二手房有 -->
                    @if($contract->type == 2 && session::get('level_code') != 'xs')
                    @if($store_code != 'all')
                        <button class="btn btn-sm btn-default operate showProcess" data-toggle="modal" data-target="#contractProcess" value="{{ $contract->number }}" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';">动态</button>
                    @endif
                    @endif
                </td>
                @endif

            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
    <!--签单表结束-->
    <footer class="panel-footer">
 
    <option value="" id="clone_class" style="display: none;"></option>
    <div class="pagination pagination-sm m-t-none m-b-none linkStyle ">
             {!! $contracts->links() !!}
    </div>    
    </footer>
</section>
</section>
<div class="copyRight">
    <div >版权所有: © locqj
    </div>
</div>
</section>
<!-- 签单流程弹框 -->
     <div class="modal fade" id="contractProcess" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="processTitle">签单动态</h4>
                </div>
                <div class="modal-body">
                  <div class="table-responsive">
                @if(in_array(session('level_code'), ['cw', 'dz', 'gh', 'zl']))
                    <div id="processAdd">
                        <div style="float:left">
                        动&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;态：<select class="input-sm form-control input-s-sm inline" id="processType" style="margin-left:2px">
                            @if(in_array(session('level_code'), ['cw', 'dz', 'zl']))
                               <option value="1">网签</option>
                               <option value="2">贷款</option>
                            @endif
                            <!-- 如果是过户 -->
                            @if(in_array(session('level_code'), ['cw', 'gh']))
                               <option value="3">交税</option>
                               <option value="trans">过户</option>
                        </select>
                        </div>
                        <div class="isTrans"  hidden="hidden" style="float:left;margin-left:20%">
                            过户专员：<select class="input-sm form-control input-s-sm inline" id="processTransferEmployeeCode">
                            @foreach($transferEmployee as $guohu)
                                    <option value="{{ $guohu->employee_code }}">
                                        {{ $guohu->employee->name }}
                                    </option>
                            @endforeach         
                        </select>
                        </div>
                        <br><br>
                        <div style="clear:both" hidden="hidden" class="isTrans">
                            过户费用：<input type="number" class="input-sm form-control input-s-sm inline" style="margin-right: 103px;" id="transferAmount">
                            过户时间：<input type="date" class="input-sm form-control input-s-sm inline" id="transferTime">
                        </div>
                        @endif
                        <!-- end 如果是过户 -->
                        <br>
                        <div>
                            备&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;注：<textarea id="processRemark" class="input-sm form-control input-s-sm inline" style="resize:none;margin-left:2px;width:76.6%"></textarea>
                        <button id="processSub" class="operate btn btn-sm btn-default" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';" style="margin-top:20px">提交</button>
                        </div>

                    </div>
                    @endif
                    <table  id="showTb" border="1" style="margin-top:20px" cellpadding="10">                
                        <tr>
                          <th width="50">动态</th>
                          <th>详情</th>
                          <th>备注</th>
                          @if(session('level_code') == 'cw')
                          <th width="80">操作</th> 
                          @endif 
                        </tr> 
                        <tr class="showTr" style="display: none;">
                          <td class="showProcessId" style="display: none;"></td>
                          <td class="showProcessContent"></td>
                          <td>
                              <div class="showProcessTime"></div>
                              <ul style="display: none;list-style: none;padding: 0;margin:0" class="showTransferConet">
                                  <li>
                                        过户专员：<select class="input-sm form-control inline showProcessTransferEmployee" disabled="disabled" style="width:65%">
                                                    @foreach($transferEmployee as $guohu)
                                                            <option value="{{ $guohu->employee_code }}" class="showEmployeeCode{{ $guohu->employee_code }}">
                                                                {{ $guohu->employee->name }}
                                                            </option>
                                                    @endforeach         
                                                </select>
                                  </li>
                                  <li>过户时间：<input type="date" class="showProcessTransferTime input-sm form-control inline" disabled="disabled" style="width:65%"></li>
                                  <li>过户费用：<input type="number" class="showProcessTransferAmount form-control input-s-sm inline" disabled="disabled" style="width:65%"></li>
                              </ul>
                          </td>
                          <td><input type="text" class="showProcessRemark" disabled="disabled"></td>
                          @if(session('level_code') == 'cw')
                          <td class="processDelTr">
                            <i class="fa fa-times icon processDel">
                            <!-- 删除 -->
                                <b class="bg-primary indexColor"></b>
                            </i><span class="processEditGang">／</span>
                            <i class="fa fa-pencil icon processEdit">
                            <!-- 编辑 -->
                                <b class="bg-primary indexColor"></b>
                            </i>
                            <i class="fa fa-check icon processCheck" style="display: none;">
                            <!-- 删除 -->
                                <b class="bg-primary indexColor"></b>
                            </i>
                          </td>
                          @endif
                        </tr>                   
                    </table>
                  </div>
                </div>
                <div class="modal-footer">
                    <div class="modalFooterstyle info_error"></div>
                  <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                </div>
              </div>
            </div>
          </div>
<!--  ／签单流程弹框终止-->
    <!-- Modal薪资标准修改弹框 -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="h4label">添加签单 
                </h4>
              </div>
              <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped b-t b-light text-sm" id="table">
                        <tr>                      
                            <td>签单类型</td>
                            <input type="hidden" id="sign_type_input" value="">
                            <td id="sign_type">
                            </td>
                        </tr>
                        <tr>                      
                            <td>签单员工</td>
                            <td>
                                <select class="input-sm form-control input-s-sm inline" id="employee_code">
                                    @if($sign_employee != null)
                                        @foreach($sign_employee as $list)
                                        <option value="{{ $list->employee_code }}">
                                            {{ $list->employee->name }}【{{ $list->position->position_tag }}】
                                            
                                        </option>
                                        @endforeach
                                    @endif
                                </select>
                            </td>   
                        </tr>  
        
                        <tr class="source_employee">                      
                            <td>选择提供方所在店铺</td>
                            <td>
                                <select class="input-sm form-control input-s-sm inline" id="source_store">
                                    <option value="all">请选择</option>
                                    @foreach($store_list as $list)
                                        <option value="{{ $list->code }}" class="searchstore">{{ $list->name }}</option>
                                    @endforeach    
                                </select>
                            </td>
                        </tr>
                        <tr class="source_store" style="display: none;">
                            <td>选择提供方</td>
                            <td>
                                <select class="input-sm form-control input-s-sm inline" id="source_employee">
                                    
                                </select>
                            </td>
                        </tr>              
                        <tr>                      
                            <td>签单日期</td>
                            <td>
                                <input type="date" value="" id="sign_date">
                            </td>
                        </tr>
                        <tr id="contractNumberTr">                      
                           <td>签单号</td>
                           <td><input type="text" value="" id="number" onkeyup="value=value.replace(/[^\w\.\/]/ig,'')"></td>
                        </tr>
                        <tr class="tax" style="display: none;">                      
                           <td>是否交税(税额为：{{ $get_tax }}%)</td>
                           <td>
                               <select class="input-sm form-control input-s-sm inline" id="is_tax">
                                   <option value="0">否</option>
                                   <option value="1">是</option>
                               </select>
                           </td>
                        </tr>
                        <tr class="sign_amount">                      
                            <td>签佣额度</td>
                            <td><input type="number" value="" min="0" id="sign_amount"></td>
                        </tr>
                        <tr id="real_amount_tr" style="display: none;">                      
                            <td>结佣额度</td>
                            <td><input type="number" value="" min="0" id="real_amount"></td>
                        </tr>
                        <tr>                      
                            <td>房源地址</td>
                            <td><input type="text" value="" min="0" id="contract_addr"></td>
                        </tr>
                        <tr>                      
                            <td>备注</td>
                            <td>
                            <textarea id="remark" style="width:172px;resize:none"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>添加图片</td>
                            <td> 
                               <form id="Form1" method="post" enctype="multipart/form-data">
                                    <div id="tdRoomPicture">
                                        <a href="javascript:;" class="addImg" data-picid="0">+</a>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    </table>
                   </div>
              </div>
              <div class="modal-footer">
                <div  class="modalFooterstyle info_error"></div>
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-default" id="sub_btn">保存</button>
                <option value="" style="display: none;" id="clone_class"></option>
              </div>
            </div>
          </div>
        </div>
        <!--end modal-->
        <!-- Modal结佣修改弹框 -->
        <div class="modal fade" id="realSigned" tabindex="-1" role="dialog" aria-labelledby="realSignedLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <input type="hidden" id="real_amount_id" value="">
                <h4 class="modal-title" id="realSignedLabel">结佣额度 
                </h4>
              </div>
              <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped b-t b-light text-sm" id="table">
                        <tr id="real_amount_label">                      
                            <td class="td4">已录入额度</td>
                            <td id="real_label_input"></td>
                        </tr>
                        <tr id="real_amount_tr">                      
                            <td class="td4">添加额度</td>
                            <td><input type="number" value="" class="i3" id="real_amount_add"></td>
                        </tr>
                    </table>
                   </div>
              </div>
              <div class="modal-footer">
                <div class="modalFooterstyle info_error"></div>
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-default" id="realSignedSub_btn">保存</button>
                <option value="" style="display: none;" id="clone_class"></option>
              </div>
            </div>
          </div>
        </div>
        <!--end modal-->
        
        <!-- Modal实际金额修改弹框 -->
        <div class="modal fade" id="received_amount_label" tabindex="-1" role="dialog" aria-labelledby="receivedLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <input type="hidden" id="res_amount_id" value="">
                <h4 class="modal-title" >实收额度 
                </h4>
              </div>
              <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped b-t b-light text-sm" id="table">
                        <tr id="real_amount_label">                      
                            <td class="td4">当前结用额度</td>
                            <td id="received_real_label"></td>
                        </tr>
                        <tr id="real_amount_label">                      
                            <td class="td4">已录入额度</td>
                            <td id="received_label_input"></td>
                        </tr>
                        <tr id="real_amount_tr">                      
                            <td class="td4">添加额度</td>
                            <td><input type="number" value="" class="i3" id="received_amount"></td>
                        </tr>
                    </table>
                   </div>
              </div>
              <div class="modal-footer">
                <div class="modalFooterstyle info_error"></div>
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-default" id="recSignedSub_btn">保存</button>
              </div>
            </div>
          </div>
        </div>
        <!--end modal-->

        <!-- Modal详情弹框 -->
        <div class="modal fade" id="details" tabindex="-1" role="dialog" aria-labelledby="detailsLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" >签单详情 
                </h4>
              </div>
              <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped b-t b-light text-sm" id="table">
                        <tr>                      
                            <td class="td4">单号</td>
                            <td class="td4 detail_number"></td>
                        </tr>
                        <tr>                      
                            <td class="td4">签单日期</td>
                            <td class="td4 detail_source_sign_date"></td>
                        </tr>
                        <tr>                      
                            <td class="td4">房源地址</td>
                            <td class="td4 detail_addr"></td>
                        </tr>
                        <tr>                      
                            <td class="td4">员工姓名</td>
                            <td class="td4 detail_employee_name"></td>
                        </tr>
                        <tr>                      
                            <td class="td4">签佣金额</td>
                            <td class="td4 detail_sign_amount"></td>
                        </tr>
                        <tr>                      
                            <td class="td4">结佣金额</td>
                            <td class="td4 detail_real_amount"></td>
                        </tr>
                        <tr>                      
                            <td class="td4">实收金额</td>
                            <td class="td4 detail_received_amount"></td>
                        </tr>
                        <tr>                      
                            <td class="td4">房源提供员工</td>
                            <td class="td4 detail_source_employee"></td>
                        </tr>
                        <tr>                      
                            <td class="td4">备注</td>
                            <td class="td4 detail_remark"></td>
                        </tr>
                        <tr>
                            <td>添加图片</td>
                            <td> 
                                    <div >
                                        <a href="javascript:;" class="addImgDetails"></a>
                                    </div>
                            </td>
                        </tr>
                    </table>
                   </div>
              </div>
              <div class="modal-footer">
                <div class="modalFooterstyle info_error"></div>
                <button type="button" class="btn btn-default" data-dismiss="modal" >关闭</button>
              </div>
            </div>
          </div>
        </div>
        <!--end modal-->
        <!-- 结佣备注框 -->

        <!-- Modal实际金额修改弹框 -->
        <div class="modal fade" id="isSignedShow" tabindex="-1" role="dialog" aria-labelledby="receivedLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <input type="hidden" id="isSignedContractId">
                <h4 class="modal-title" >结佣 
                </h4>
              </div>
              <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped b-t b-light text-sm" id="table">
                        <tr id="real_amount_tr">                      
                            <td class="td4">备注：</td>
                            <td><input type="text" id="isSignedSubRemark"></td>
                        </tr>
                    </table>
                   </div>
              </div>
              <div class="modal-footer">
                <div class="modalFooterstyle info_error"></div>
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-default" id="isSignedSub">保存</button>
              </div>
            </div>
          </div>
        </div>
        <!--end 结佣备注框-->

<script type="text/javascript">
    /*添加图片*/
   $(function () {
            var picId = 0;
            var pictureUploading = false;
            $("#Form1").delegate(".addImg", "click", function () {
                if (!!pictureUploading) return;
                pictureUploading = true;

                picId = parseInt($(this).attr("data-picId"));
                picId++;
                $(this).attr("data-picId", picId);

                $(this).before("<div class=\"image_container\" data-picId=\"" + picId + "\">"
                                + "<input class=\"uploadImages\" id=\"RoomInfo1_RoomPicture" + picId + "\" name=\"RoomInfo1_RoomPicture" + picId + "\" type=\"file\" accept=\"image/jpeg,image/png,image/gif\" style=\"display: none;\" />"
                                + "<input id=\"RoomInfo1_RoomPictureHidDefault" + picId + "\" name=\"RoomInfo1_RoomPictureHidDefault" + picId + "\" type=\"hidden\" value=\"0\" />"
                                + "<a href=\"javascript:;\" id=\"previewBox" + picId + "\" class=\"previewBox\">"
                                    + "<div class=\"delImg\">&times;</div>"
                                    + "<img id=\"preview" + picId + "\" style=\"height:100px;width:100px;border-width:0px;\" />"
                                + "</a>"
                            + "</div>");

                $("#RoomInfo1_RoomPicture" + picId).change(function () {
                    var $file = $(this);
                    var fileObj = $file[0];
                    var windowURL = window.URL || window.webkitURL;
                    var dataURL;

                    $("#previewBox" + picId).css("display", "inline-block");
                    var $img = $("#preview" + picId);
                    //var $img = $("#preview1");

                    if (fileObj && fileObj.files && fileObj.files[0]) {
                        dataURL = windowURL.createObjectURL(fileObj.files[0]);
                        $img.attr('src', dataURL);
                    } else {
                        dataURL = $file.val();
                        var imgObj = $img; //document.getElementById("preview");
                        // 两个坑:
                        // 1、在设置filter属性时，元素必须已经存在在DOM树中，动态创建的Node，也需要在设置属性前加入到DOM中，先设置属性在加入，无效；
                        // 2、src属性需要像下面的方式添加，上面的两种方式添加，无效；
                        imgObj.style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale)";
                        imgObj.filters.item("DXImageTransform.Microsoft.AlphaImageLoader").src = dataURL;
                    }

                    if (1 === picId) {
                        defaultImg(picId, true);
                    }
                    pictureUploading = false;

                });
                $("#RoomInfo1_RoomPicture" + picId).click();

                //设置默认图片
                // $(".previewBox").click(function () {
                //     var _picId = parseInt($(this).parent(".image_container").attr("data-picId"));
                //     $(".image_container").each(function () {
                //         var i = parseInt($(this).attr("data-picId"));
                //         if (i === _picId)
                //             defaultImg(i, true);
                //         else
                //             defaultImg(i, false);
                //     });
                // });

                //删除上传的图片
                $(".delImg").click(function () {
                    var _picId = parseInt($(this).parent().parent(".image_container").attr("data-picId"));
                    $(".image_container[data-picid='" + _picId + "']").remove();
                    if ($(".image_container").length > 0 && $(".defaultImg").length < 1) {
                        $(".image_container").each(function () {
                            var i = parseInt($(this).attr("data-picId"));
                            defaultImg(i, true);
                            return false;
                        });
                    }

                });

            });

            function defaultImg(picId, selected) {
                if (!picId) return;
                if (!!selected) {
                    $("#RoomInfo1_RoomPictureHidDefault" + picId).val(1);
                    $("#previewBox" + picId).addClass("defaultImg");
                }
                else {
                    $("#RoomInfo1_RoomPictureHidDefault" + picId).val(0);
                    $("#previewBox" + picId).removeClass("defaultImg");
                }
            }
        });

    /*签单动态*/
    $('.showProcess').click(function(){
        $('.info_error').text("");
        $('.showTr').hide();
        var contract_number = $(this).val();
        $('#processSub').val(contract_number);
        $.post('/process/show', {contract_number:contract_number},function(result){
            if(result['status'] == 1){
                var content = result['data'];
                for (var i = 0; i < content.length; i++) {
                    var tr = $("#showTb tr").eq(1).clone(true);
                    tr.show();
                    tr.appendTo("#showTb");
                    tr.children('.showProcessContent').html(content[i].type_name);
                    tr.children().find('.showProcessRemark').val(content[i].remark);
                    tr.children().find('.showProcessTime').text("时间："+content[i].created_at);
                    tr.children('.showProcessId').html(content[i].id);
                    if(content[i].type == 'trans'){
                        tr.children().find('.showTransferConet').show();
                        //过户时间
                        var month = content[i].month;
                        var day = content[i].day;
                        if(month < 10)
                            month = '0'+ month;
                        if(day < 10)
                            day = '0' + day;
                        tr.children().find('.showProcessTransferTime').val(content[i].year+'-'+month+'-'+day);
                        //过户专员
                        tr.children().find('.showEmployeeCode'+content[i].employee_code).attr('selected', 'selected');
                        tr.children().find('.showProcessTransferAmount').val(content[i].amount);
                    }
                }
            }
        })

    })
    $('#processType').change(function(){
        $('.info_error').text("");
        if($(this).val() === 'trans'){
            $('.isTrans').show();
        }else{
            $('.isTrans').hide();
        }
    })

    /*签单动态提交*/
    $('#processSub').click(function(){
        $('.info_error').text("");
        var type = $('#processType').val();
        var remark = $('#processRemark').val();
        var contract_number = $(this).val();
        if(type === 'trans'){
            var amount = $('#transferAmount').val();
            var transfer_date = $('#transferTime').val();
            var store_code = $('#searchstore').val();
            var employee_code = $('#processTransferEmployeeCode').val();
            if(employee_code == 0){
                $('.info_error').text('请选择过户专员');
            }else if(!amount){
                $('.info_error').text('请填写过户费用');
            }else if(amount < 0){
                $('.info_error').text('过户费用不得为负数');
            }else if(!transfer_date){
                $('.info_error').text('请选择过户日期');
            }else{
                $.post("{{ route('transfer.store') }}", 
                    {
                        employee_code: employee_code,
                        store_code: store_code,
                        contract_number: contract_number,
                        amount: amount,
                        transfer_date: transfer_date,
                        remark:remark
                    }, function(result) {
                        if(result['status'] == 1){
                            var content = result['data'];
                            var tr = $("#showTb tr").eq(1).clone(true);
                            tr.show();
                            tr.appendTo("#showTb");
                            tr.children('.showProcessContent').html(content.type_name);
                            tr.children().find('.showProcessRemark').val(content.remark);
                            tr.children().find('.showProcessTime').html(content.created_at);
                            tr.children('.showProcessId').html(content.id);

                            tr.children().find('.showTransferConet').show();
                            //过户时间
                            var month = content.month;
                            var day = content.day;
                            if(month < 10)
                                month = '0'+ month;
                            if(day < 10)
                                day = '0' + day;
                            tr.children().find('.showProcessTransferTime').val(content.year+'-'+month+'-'+day);
                            //过户专员
                            tr.children().find('.showEmployeeCode'+content.employee_code).attr('selected', 'selected');
                            tr.children().find('.showProcessTransferAmount').val(content.amount);
                        }else{
                            $('.info_error').text(result['msg']);
                        }
                });
            }
        }else{
            $.post('/process/store',{contract_number:contract_number,type:type,remark:remark},function(result){
                if(result['status'] == 1){
                    var content = result['data'];
                    var tr = $("#showTb tr").eq(1).clone(true);
                    tr.show();
                    tr.appendTo("#showTb");
                    tr.children('.showProcessContent').html(content.type_name);
                    tr.children().find('.showProcessRemark').val(content.remark);
                    tr.children().find('.showProcessTime').html(content.created_at);
                    tr.children('.showProcessId').html(content.id);
                }else{
                    $('.info_error').text(result['msg']);
                }
            })
        }
    })

    /*编辑签单动态*/
    $('.processEdit').click(function(){
        $('.info_error').text("");
        var index = $(this).index('.processEdit');
        var type_name = $('.showProcessContent').eq(index).text();
        $('.processDel').eq(index).hide();
        $(this).hide();
        $('.processEditGang').eq(index).hide();
        $('.processCheck').eq(index).show();
        $('.showProcessRemark').eq(index).removeAttr('disabled');
        if(type_name == '过户'){
            $('.showProcessTransferTime').eq(index).removeAttr('disabled');
            $('.showProcessTransferEmployee').eq(index).removeAttr('disabled');
            $('.showProcessTransferAmount').eq(index).removeAttr('disabled');
        }
    })
    /*编辑签单保存*/
    $('.processCheck').click(function(){
        $('.info_error').text("");
        var index = $(this).index('.processCheck');
        var id = $('.showProcessId').eq(index).text();
        var type_name = $('.showProcessContent').eq(index).text();
        var remark = $('.showProcessRemark').eq(index).val();
        if(type_name == '过户'){
            var employee_code = $('.showProcessTransferEmployee').eq(index).val();
            var amount = $('.showProcessTransferAmount').eq(index).val();
            var transfer_date = $('.showProcessTransferTime').eq(index).val();
            if(!amount){
                $('.info_error').text('请填写过户费用');
            }else if(amount < 0){
                $('.info_error').text('过户费用不得为负数');
            }else if(!transfer_date){
                $('.info_error').text('请选择过户日期');
            }else{
                $.post('/transfer/process_edit',{id:id,employee_code:employee_code,amount:amount,transfer_date:transfer_date,remark:remark},function(result){
                    if(result['status'] == 1){
                        $('.showProcessTransferTime').eq(index).attr('disabled','disabled');
                        $('.showProcessTransferEmployee').eq(index).attr('disabled','disabled');
                        $('.showProcessTransferAmount').eq(index).attr('disabled','disabled');
                        $('.showProcessRemark').eq(index).attr('disabled', 'disabled');
                        $('.processEditGang').eq(index).show();
                        $('.processCheck').eq(index).hide();
                        $('.processEdit').eq(index).show();
                        $('.processDel').eq(index).show();
                    }
                });
            }
        }else{
            $.post('/process/edit',{id:id,remark:remark},function(result){
                if(result['status'] == 1){
                    $('.showProcessRemark').eq(index).attr('disabled', 'disabled');
                    $('.processEditGang').eq(index).show();
                    $('.processCheck').eq(index).hide();
                    $('.processEdit').eq(index).show();
                    $('.processDel').eq(index).show();
                }
            })
        }
    })
    /*签单动态删除*/
    $('.processDel').click(function(){
        $('.info_error').text("");
        var index = $(this).index('.processDel');
        var type_name = $('.showProcessContent').eq(index).text();
        var id = $('.showProcessId').eq(index).text();
        var tips = "确认删除此动态？";
        if(confirm(tips)){
            if(type_name == '过户'){
                 $.get("/del/transfer/"+id,
                        function(result) {
                            if(result['status'] == 1){
                                $('.showTr').eq(index).hide();
                            }else{
                               $('.info_error').text(result['msg']);
                            }
                    });
            }else{
                $.post('/process/del', {id:id}, function(result){
                    if(result['status'] == 1){
                        $('.showTr').eq(index).hide();
                    }else{
                        $('.info_error').text(result['msg']);
                    }
                })
            }
        }
    })
    /*签单删除*/
    function del(id, number){
        var msg = '确定要单号为['+number+']删除此信息吗？';
        if(confirm(msg)){
            $.get("/del/contract/"+id,
                function(data, textStatus, xhr) {
                    if(data.status == '1')
                        $('#cc'+id).css('display','none');
                    else
                        alert('网络错误，请重试！');
            });
            // alert('删除成功！');
            return true;
        }
        return false;
    }

    /*添加一手签单*/
    function addContract1(store_code) {
        $('.image_container').remove();
        $('.previewBoxEdit').remove(); //去除之前图片
        $('#contractNumberTr').hide(); //一手房自动生成签单号
        $('#sign_type_input').val('1');
        $('#sign_type').text('一手房');

        $('.source_employee').hide(); //一手房将选择房源店铺关掉
        $('.source_employee').hide();
        $('.source_store').hide();
        $('.sign_amount').show();
        $('#real_amount_tr').hide();
        // $('.tax').show(); //展示税收
        $('.info_error').text("");
        $('#employee_code #clone_class').remove();
        $('#h4label').text('添加一手签单');
        $('#employee_code').removeAttr("disabled"); //解除锁定员工input
        $('#table tr td input').val("");
        $('#add_or_update').val('1'); //赋值为1 表示为add
        //selelctEmployee(store_code);
    }
    /*添加二手签单*/
    function addContract2(store_code){
        $('.image_container').remove();
        $('.previewBoxEdit').remove(); //去除之前图片
        $('#contractNumberTr').show();//展示签单号
        $('#sign_type_input').val('2');
        $('#sign_type').text('二手房');

        $('.source_employee').show();
        $('#real_amount_tr').hide();
        $('.sign_amount').show();
        // $('.tax').show(); //展示税收

        $('.info_error').text("");
        $('#employee_code #clone_class').remove();
        $('#h4label').text('添加二手签单');
        $('#employee_code').removeAttr("disabled"); //解除锁定员工input
        $('#table tr td input').val("");
        $('#add_or_update').val('1'); //赋值为1 表示为add
        //selelctEmployee(store_code);
    }
    /*添加租单签单*/
    function addContractz(store_code){
        $('.image_container').remove();
        $('.previewBoxEdit').remove(); //去除之前图片
        $('#contractNumberTr').show(); //展示签单号
        $('#sign_type_input').val('3');
        $('#sign_type').text('租单');
        $('.info_error').text("");

        $('.source_employee').show();
        $('#real_amount_tr').hide();
        $('.sign_amount').show();
        // $('.tax').show(); //展示税收

        $('#employee_code #clone_class').remove();
        $('#h4label').text('添加租单');
        $('#employee_code').removeAttr("disabled"); //解除锁定员工input
        $('#table tr td input').val("");
        $('#add_or_update').val('1'); //赋值为1 表示为add
        //selelctEmployee(store_code);
    }
    /*签单详情*/
    function cDetails(id) {
        $('.imageDetailschild').remove();//移除图片
        $('.info_error').text("");
        $.get('/contract/'+id, function(data) {
            if(data.status == 1){
                var real_amount = "";
                var received_amount = "";
                $('.detail_addr').text(data.data.contract_addr);
                $('.detail_remark').text(data.data.remark);
                $('.detail_number').text(data.data.number);
                $('.detail_source_sign_date').text(data.data.year+'-'+data.data.month+'-'+data.data.day);
                $('.detail_addr').text(data.data.contract_addr);
                $('.detail_employee_name').text(data.data.employee.name);
                $('.detail_sign_amount').text(data.data.sign_amount);
                if(data.data.real_amount != 0) {
                    real_amount = data.data.real_amount;
                }
                $('.detail_real_amount').text(real_amount);
                if(data.data.received_amount != 0) {
                    received_amount = data.data.received_amount;
                }
                $('.detail_received_amount').text(received_amount);
                if(data.data.source_employee){
                    $('.detail_source_employee').text(data.data.source_employee.name);
                }else{
                    $('.detail_source_employee').text('无');
                    
                }
                $('.detail_remark').text(data.data.remark);
                var images = data.data.images;
                for (var i = 0; i < images.length; i++) {
                    var imageAppend = "<a  data-lighter href=\""+images[i].url+"\"><img class=\"imageDetailschild\" src=\"" + images[i].url + "\" style=\"height:100px;width:100px;border-width:0px;float:left;margin-right:3px;\" /></a>";
                    $('.addImgDetails').before(imageAppend);
                }
            }
        });
    }


    /*更新签单*/
    function updateContract(id) {
        $('.image_container').remove();
        $('.previewBoxEdit').remove(); //去除之前图片
        $('.info_error').text("");
        $('#employee_code #clone_class').remove();
        $('#h4label').text('更新签单');
        $('#employee_code').attr("disabled","disabled"); //锁定员工input
        $('.tax').hide(); //隐藏税收
        $('.sign_amount').hide();
        $('.source_employee').hide();
        $('.contract_addr').hide();

        var store_code = $('.code'+id).text(); //获取所在店铺
        $('#contract_id').val(id);
        $('#add_or_update').val('0'); //赋值为1 表示为add
        $.get('/contract/'+id, function(data) {
            if(data.status == 1){
                $.each($('#employee_code option'), function(index, val) {
                    if(data.data.employee.status == 0){
                        if($(this).val() != data.data.employee.code && $(this).val() != 0){
                        var clone_class = $('#clone_class');
                        var first_clone = clone_class.clone(true);
                        $(first_clone).attr('value', data.data.employee.code);
                        $(first_clone).text(data.data.employee.name);
                        $(first_clone).show();
                        $('#employee_code').append(first_clone);
                        return false;
                        }
                    }else{
                        return false;
                    }
                });
                $('#sign_type').text(data.data.type_name);
                $('#employee_code').val(data.data.employee.code);
                $('#sign_date').val(data.data.sign_date);
                $('#number').val(data.data.number);
                $('#sign_amount').val(data.data.sign_amount);
                $('#real_amount').val(data.data.real_amount);
                $('#contract_addr').val(data.data.contract_addr);
                $('#remark').val(data.data.remark);
                 var images = data.data.images;
                for (var i = 0; i < images.length; i++) {
                    var imageAppend = "<a style=\"height:100px;display:inline-block;width:100px\" href=\"javascript:;\" id=\"previewBoxEdit" + i + "\" class=\"previewBoxEdit\">"
                                    + "<div class=\"delImgEdit\" style=\"position: absolute;color: #f00;margin: 0 0 0 84px;font-size: 16px;width: 16px;height: 16px;line-height: 16px;text-align: center;vertical-align: middle;background-color: #c3c3c3;\" onclick=\"delImageEditById("+images[i].id+", this)\">&times;</div>"
                                    + "<img class=\"imageDetailschild\" src=\"" + images[i].url + "\" style=\"height:100px;width:100px;border-width:0px;\" />"
                                + "</a>";
                    $('.addImg').before(imageAppend);
                }
            }
        });
    }
    /*删除已上传图片*/
    function delImageEditById(id, delThis){
        var info = "此图片已上传，确定删除？";
        if(confirm(info)){
            $.get("{{url('/contract/image/del')}}/"+id, function(result){
                if(result.status == 1){
                    $(delThis).parent().empty();
                }
            })
        }        
    }
    /*修改结佣状态*/
    function changeSign(id){
        $('.info_error').text("");
        $('#isSignedSubRemark').val("");
        $('#isSignedContractId').val(id);
    }

    //结佣备注
    $('#isSignedSub').click(function(){
        var id = $('#isSignedContractId').val();
        var real_amount = parseFloat($('.real'+id).children('input').val());
        var received_amount = parseFloat($('.received'+id).children('input').val());
        var msg = '请确定结佣金额为'+received_amount+'元';
        var remark = $('#isSignedSubRemark').val();
        if(isNaN(real_amount)) {
            $('.info_error').text("结用额度未填，不得结佣！");
        }else if(isNaN(received_amount)) {
            $('.info_error').text("实收额度未填，不得结佣！");
        }else if(remark == ""){
            $('.info_error').text("备注不得为空，可填写“无“！");
        }else {
            if(confirm(msg)){
                $.post('/contract/updateissign/'+id, {remark:remark},function(data) {
                    if(data.status == 1){
                        alert('结佣成功');
                        window.location.reload();
                    }else{
                        $('.info_error').text(data['msg'])
                    }
                });
            }
        }
    })

    /*更新结佣*/
    function changerealamount(id, is_signed){
        $.get('/contract/'+id, function(data){
            $('#real_label_input').text(data.data.real_amount);
        });
        $('.info_error').text("");
        $('#real_amount_add').val("");
        $('#real_amount_id').val(id);
        if(is_signed == 1){
            alert('已结佣不得修改');
        }
    }

    /*更新实收金额*/
    function updaterec(id, is_signed) {
        $.get('/contract/'+id, function(data){
            $('#received_label_input').text(data.data.received_amount);
            $('#received_real_label').text(data.data.real_amount)
        });
        $('.info_error').text("");
        $('#res_amount_id').val(id);
        $('#received_amount').val("");
        if(is_signed == 1){
            alert('已结佣不得修改');
        }
    }
    /*图片ajax*/
   function uploadImagesAjax($contract_number){
        var formData = new FormData($('#Form1')[0]);
        $.ajax({
            url: "{{url('/contract/image')}}/"+$contract_number,
            type: 'POST',
            cache: false,
            data: formData,
            processData: false,
            contentType: false
        }).done(function(res) {
            if(res.status == 1){
                alert('添加成功');
                window.location.reload(true);
            }else{
                $('.info_error').text(res.msg);
            }
        }).fail(function(res) {

        });
   }

    $(document).ready(function(){
        /*提交form*/
        $('#sub_btn').click(function(event) {
            var status_up_or_add = $('#add_or_update').val();
            var sign_type = $('#sign_type_input').val(); //获取单子类型
            var employee_code = $('#employee_code').val();
            var sign_date = $('#sign_date').val();
            var source_store = $('#source_store').val();
            if(source_store == 'all'){
                var is_divide = 0;
            }else{
                var is_divide = 1;
            }
            var source_employee = $('#source_employee').val();
            var number = $('#number').val();
            
            var real_amount = parseFloat($('#real_amount').val());
            var remark = $('#remark').val();
            var contract_addr = $('#contract_addr').val();
            var store_code = $('#store_code').val();
            var is_tax = $('#is_tax').val();
            // if(is_tax == 1) {
            //     var sign_amount = parseFloat($('#sign_amount').val()) * (100 - {{ $get_tax }}) / 100;
            // } else {
                var sign_amount = parseFloat($('#sign_amount').val());
            // }
            if (!sign_date){
                $('.info_error').text('签单日期不得为空');
            }else if (!number && sign_type != 1){
                $('.info_error').text('签单号不得为空');
            }else if (!sign_amount){
                $('.info_error').text('签佣额度不得为空');
            }else if (sign_amount < 0){
                $('.info_error').text('签佣额度不得为负数');
            }else if (real_amount < 0){
                $('.info_error').text('结佣额度不得为负数');
            }else {
                if(status_up_or_add == 1){
                    /*如何选择了房源提供就判断他有没选择员工*/
                    if(is_divide == 1){
                        if(source_employee == 0){
                            $('.info_error').text('请添加房源员工！');
                        }else{
                            if(confirm('请你确定你的签单金额为'+sign_amount+'元')) {
                                $.post("{{ route('contract.store') }}",
                                {
                                    employee_code: employee_code,
                                    sign_date: sign_date,
                                    number: number,
                                    sign_amount: sign_amount,
                                    store_code: store_code,
                                    sign_type: sign_type,
                                    is_divide: is_divide,
                                    source_store: source_store,
                                    source_employee: source_employee,
                                    remark: remark,
                                    contract_addr: contract_addr,
                                    
                                }, 
                                function(data, textStatus, xhr) {
                                    if(data.status == 1){
                                        uploadImagesAjax(data.data);
                                        // alert('添加成功');
                                        // window.location.reload();
                                    }else{
                                        $('.info_error').text(data.msg);
                                    }
                                });
                            }
                        } 
                    }else{
                        if(confirm('请你确定你的签单金额为'+sign_amount+'元')) {
                            $.post("{{ route('contract.store') }}",
                                {
                                    employee_code: employee_code,
                                    sign_date: sign_date,
                                    number: number,
                                    sign_amount: sign_amount,
                                    store_code: store_code,
                                    sign_type: sign_type,
                                    is_divide: is_divide,
                                    source_store: source_store,
                                    source_employee: source_employee,
                                    remark: remark,
                                    contract_addr: contract_addr,
                                    
                                }, 
                                function(data, textStatus, xhr) {
                                    if(data.status == 1){
                                        uploadImagesAjax(data.data);
                                        // alert('添加成功');
                                        // window.location.reload();
                                    }else{
                                        $('.info_error').text(data.msg);
                                    }
                            });
                        }
                    }
                           
                }else{
                    /*修改签单*/
                    var contract_id = $('#contract_id').val();
                    var is_signed = 1;
                    $.get("/contract/"+contract_id+"/edit",
                    {   
                        employee_code: employee_code,
                        sign_date: sign_date,
                        number: number,
                        remark: remark,
                        contract_addr: contract_addr

                    }, function(data, textStatus, xhr) {
                        if(data.status == 1){
                            uploadImagesAjax(contract_id);
                            // window.location.reload();
                        }else{
                            $('.info_error').text(data.msg);
                        }
                    });
                    
                }
            }

        });



          /*房源选择店铺触发*/
        $("#source_store").change(function(){
            $(".source_store").show();
            $("#source_employee option").remove(); //请求前删除clone标签
            var store_code = $('#source_store').val();
            var contract_employee = $('#employee_code').val();
            if(store_code != 'all'){
                /*请求员工*/
                $.get("/getemployee/"+store_code+'-'+contract_employee,
                function(data) {
                    if(data.status == 1){
                        var clone_class = $('#clone_class');
                        
                        var cl = clone_class.clone(true);
                        $(cl).attr('value', 0);
                        $(cl).text('请输入');
                        $(cl).show();
                        $('#source_employee').append(cl);
                        $.each(data.data, function(key, val) {
                            /*alert(val.month);*/
                            var clo = clone_class.clone(true);
                            var code = val.employee_code;
                            $(clo).attr('value', code);
                            $(clo).text(val.employee.name);
                            $(clo).show();
                            $('#source_employee').append(clo);

                        });
                    }
                });
            } else {
                $('.source_store').hide();
                $("#source_employee option").remove(); //请求前删除clone标签
            }
        });


        /*更新结佣金额提交*/
        $('#realSignedSub_btn').click(function(event) {
            var id = $('#real_amount_id').val();
            var this_amount = parseFloat($('#real_amount_add').val());
            var last_amount = parseFloat($('#real_label_input').text());
            var real_amount = this_amount + last_amount;
            if(!this_amount){
                $('.info_error').text('添加不得为空');
            }else{
                if(confirm('请确认当前修改结用金额为：'+real_amount+'元！')) {
                    $.post('/contract/updaterealamount/'+id, 
                        {real_amount: real_amount}, 
                    function(data, textStatus, xhr) {
                        if(data.status == 1){
                            alert('添加成功');
                            window.location.reload();
                        }
                    });
                }
            }
        });


        /*实收金额提交*/
        $('#recSignedSub_btn').click(function(event) {
            var id = $('#res_amount_id').val();
            var this_amount = parseFloat($('#received_amount').val());
            var last_amount = parseFloat($('#received_label_input').text());
            var real_amount = parseFloat($('.real'+id).children('input').val());
            var received_amount = this_amount + last_amount;
            if(received_amount > real_amount){
                $('.info_error').text('实收金额不得大于结佣金额，当前结用金额为：'+real_amount+'元！');
            }else if(!this_amount){
                $('.info_error').text('添加金额不得为空');
            }else{
                if(confirm('请确认当前修改结用金额为：'+received_amount+'元！')) {
                    $.post('/contract/updaterecevicedamount/'+id, 
                    {received_amount: received_amount}, 
                    function(data, textStatus, xhr) {
                        if(data.status == 1){
                            alert('添加成功');
                            window.location.reload();
                        }
                    });
                }
            }
        });

        $('#searchstore').change(function(event) {
           selectSearch();
        });
        $('#year').change(function(event) {
            selectSearch();            
           });
        $('#month').change(function(event) {
            selectSearch();
        });
        $('#searchemployee').change(function(event) {
            selectSearch();
        });
        $('#end_month').change(function(event) {
            selectSearch();
        });

        function selectSearch(){
            var month = $('#month').val();
            var year = $('#year').val();
            var store_code = $('#searchstore').val();
            var employee_code = $('#searchemployee').val();
            var end_month = $('#end_month').val();
            if(store_code == 'all')
            {
                window.location.href = '/contract/'+year+'/'+month+'/'+end_month;
            }else{
                
                window.location.href = '/search/contract/'+store_code+'-'+year+'-'+month+'-'+employee_code+'-'+end_month;
            }
            
        }
        

        /*消除info*/
        $('table tr td input').click(function(event) {
            $('.info_error').text("");
        });
        $('#employee_code').change(function(event) {
            $('.info_error').text("");
        });
        $('#is_signed').change(function(event) {
            $('.info_error').text("");
        });
        $('input').click(function(){
            $('.info_error').text("");
        })
    });
</script>

@endsection