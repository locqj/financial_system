@extends('layouts.nav')

@section('content')
          <section class="vbox">
            <section class="scrollable padder">
            <marquee direction=left class="headerMarquee">欢迎使用xxx房产记账结算管理系统！</marquee>
            <ul class="breadcrumb no-border no-radius b-b b-light pull-in">
              <li><i class="fa fa-home"></i> 主页</li>
              <li class="active">提成规则</li>
            </ul>
            <section class="panel panel-default">
              
             <!-- 
                <div style="float:left;font-size:22px;margin-left:3%;margin-top:10px">销售提成规则</div>
                <button type="button" class="btn btn-sm btn-default operate" data-toggle="modal" data-target="#myModal" style="float:left;margin-left:70%;margin-top:10px">添加规则</button> -->
            <!-- 一手手房提成规则 -->
           @for($j=11; $j < 13; $j++)
             <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped b-t b-light text-sm">
                        <tr>
                            <th style="width:50%">
                                @if($j== 11)
                                <div style="font-size:18px;margin-top:10px">一手房提比例</div>
                                @elseif($j == 12)
                                <div style="font-size:18px;margin-top:10px">租售提成比例</div>
                                @endif
                            </th>
                            <th>
                            @if(session('level_code') == 'cw')
                             <button type="button" class="btn btn-sm btn-default operate editFirstAndRentSale"  style="margin-top:10px;margin-left:70%;" 
                             onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" 
                             onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';" value="{{$j}}">编辑</button>
        
                            <button type="button" class="btn btn-sm btn-default operate saveFirstAndRentSale" style="display: none;margin-top:10px;margin-left:70%;" 
                            onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" 
                            onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';" value="{{$j}}">保存</button>
                          </th>
                          @endif
                        </tr>
                    </table>
                </div>

                <div class="table-responsive">
                  <table class="table table-striped b-t b-light text-sm">                
                      
                        @if(isset($firstAndRentRule[$j]))
                         <tr>
                            <td>
                                <input type="number" value="{{$firstAndRentRule[$j]}}" min="0" disabled="disabled" style="width: 50px;" class="firstAndRentPercentage">%&nbsp;&nbsp;&nbsp;&nbsp;<span class="errmsgFirstAndRentSale" style="color: red;"></span>
                            </td>
                            <td>
                            </td>
                        </tr>
                        @else
                      <tr>
                            <td>
                                <input type="number" style="width: 50px;" disabled="disabled" min="0"  class="firstAndRentPercentage">%&nbsp;&nbsp;&nbsp;&nbsp;<span class="errmsgFirstAndRentSale" style="color: red;"></span>
                            </td>
                            <td>
                              
                            </td>
                        </tr>
                        @endif

                  </table>
                </div>
              </div>
              @endfor
           <!-- 二手房提成规则 -->
              <div class="modal-body">
                <div class="table-responsive">
                  <table class="table table-striped b-t b-light text-sm">                
                    <tr>                      
                        <th style="width:50%">
                            <div style="font-size:18px;margin-top:10px">二手房提成规则</div>
                        </th>
                        @if(session('level_code') == 'cw')
                        <th>
                            <button type="button" class="btn btn-sm btn-default operate"  style="margin-top:10px;margin-left:70%;" id="editSale" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';">编辑</button>
                            <button type="button" class="btn btn-sm btn-default operate" style="display: none;margin-top:10px;margin-left:70%;" id="saveSale" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';">保存</button>
                        </th>
                        @endif
                    </tr>
                  </table>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped b-t b-light text-sm" id="tb"> 
	                    <tr>                      
	                        <th style="width:20%">下限</th>
	                        <th style="width:20%">上限</th>
	                        <th style="width:20%">提成比例&nbsp&nbsp&nbsp&nbsp<span id="errmsgSale" style="color: red;"></span></th>
	                        <th style="width:20%">
	                            <i class="fa fa-plus icon" id="addLine" style="display: none;">
	                                <b class="bg-primary indexColor"></b>
	                            </i>
	                        </th>
	                    </tr>
      						<!-- 克隆的tr -->
      						    <tr style="display: none;">
      				            <td>
      				                <input class="bottomLimit" disabled="disabled" type="number">
      				            </td>
      				            <td>
      				                <input class="topLimit" onkeyup="value=value.replace(/[^\d]/g,'')" type="text">
      				            </td>
      				            <td>
      				                <input class="percentage" min="0" style="width: 50px;" type="number">%
      				            </td>
      				            <td>
      				                <i class="fa fa-times icon minusLine">
      				                    <b class="bg-primary indexColor"></b>
      				                </i>
      				            </td>
      				        </tr>
      						<!-- end -->
      						<!-- 遍历现有的 -->
      						@foreach($show as $list)
      								    <tr>
      						            <td>
      						                	<input class="bottomLimit" value="{{$list->bottom}}" disabled="disabled" type="number">
      						            </td>
      						            <td>
      						                <input class="topLimit" value="{{$list->top}}" onkeyup="value=value.replace(/[^\d]/g,'')" disabled="disabled" type="text">
      						            </td>
      						            <td>
      						                <input class="percentage" value="{{$list->percentage}}"  min="0" disabled="disabled" style="width: 50px;" type="number">%
      						            </td>
      						            <td>
                                @if($list->bottom != 0)
      						                <i class="fa fa-times icon minusLine" style="display: none;">
      						                    <b class="bg-primary indexColor"></b>
      						                </i>
      						               @endif
      						            </td>
      						        </tr>
      					    @endforeach
      				        <!-- end -->
               </table>
                </div>
              </div>
                <!-- end  二手房提成规则 -->
                <!-- 分红提成 -->
              @for($i=2; $i < 10; $i++)
              <div class="modal-body" @if($i == 7)style="display:none;" @endif>
                <div class="table-responsive">
                    <table class="table table-striped b-t b-light text-sm">
                        <tr>
                            <th style="width:50%">
                                @if($i== 2)
                                <div style="font-size:18px;margin-top:10px">店长助理分红比例</div>
                                @elseif($i == 3)
                                <div style="font-size:18px;margin-top:10px">店长分红比例</div>
                                @elseif($i == 4)
                                <div style="font-size:18px;margin-top:10px">区域经理分红比例</div>
                                @elseif($i == 5)
                                <div style="font-size:18px;margin-top:10px">总经理分红比例</div>
                                @elseif($i == 6)
                                <div style="font-size:18px;margin-top:10px">二级店铺分红比例</div>
                                @elseif($i == 7)
                                <div style="font-size:18px;margin-top:10px">税金</div>
                                @elseif($i == 8)
                                <div style="font-size:18px;margin-top:10px">二手房房源分成比例</div>
                                @elseif($i == 9)
                                <div style="font-size:18px;margin-top:10px">租房房源分成比例</div>
                                @endif
                            </th>
                            <th>
                            @if(session('level_code') == 'cw')
                             <button type="button" class="btn btn-sm btn-default operate editBonus"  style="margin-top:10px;margin-left:70%;" 
                             onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" 
                             onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';" value="{{$i}}">编辑</button>
        
                            <button type="button" class="btn btn-sm btn-default operate saveBonus" style="display: none;margin-top:10px;margin-left:70%;" 
                            onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" 
                            onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';" value="{{$i}}">保存</button>
                          </th>
                          @endif
                        </tr>
                    </table>
                </div>

                <div class="table-responsive">
                  <table class="table table-striped b-t b-light text-sm">                
                    
                      
                        @if(isset($bonusRule[$i]))
		                     <tr>
		                        <td>
                            <!-- 二手和租房时有业务员和提供者 -->
		                            @if($i == 8 || $i == 9)<span>业务员：</span>@endif
                                <!-- 二级店铺时有比例和有效期 -->
                                @if($i == 6)<span>比例：</span>@endif
                                <input type="number" value="@if($i == 6){{$bonusRule[$i]['percentage']}}@else{{$bonusRule[$i]}}@endif" min="0" disabled="disabled" style="width: 50px;" class="bonusPercentage">%
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                @if($i == 6)<span>有效期：</span>
                                <input type="number" value="{{$bonusRule[$i]['parent_store_limit']}}" min="0" disabled="disabled" style="width: 50px;" id="parentStoreLimit">&nbsp;&nbsp;个月@endif
                                @if($i == 8 || $i == 9)房源提供者：【<span class="sourceSalePercentage">{{100 - $bonusRule[$i]}}</span>%】@endif
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <span class="errmsgBonus" style="color: red;"></span>
		                        </td>
		                        <td>
		                        </td>
		                    </tr>
                        @else
		                	<tr>
		                        <td>
                               @if($i == 8 || $i == 9)<span>业务员：</span>@endif
		                            <input type="number" style="width: 50px;" disabled="disabled" min="0"  class="bonusPercentage">%
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                @if($i == 8 || $i == 9)房源提供者：【&nbsp;&nbsp;】@endif
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <span class="errmsgBonus" style="color: red;"></span>
		                        </td>
		                        <td>
		                        	
		                        </td>
		                    </tr>
                        @endif

                  </table>
                </div>
              </div>
              @endfor
              <!-- end分红提成 -->

              <!-- 级职待遇 -->
              <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped b-t b-light text-sm">
                        <tr>                      
                            <th style="width:50%">
                                <div style="font-size:18px;margin-top:10px">级职待遇</div>
                            </th>
                            @if(session('level_code') == 'cw')
                            <th>
                            <button type="button" class="btn btn-sm btn-default operate"  style="margin-left:70%;margin-top:10px" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';" id="editTreat">编辑</button>
        
                        <button type="button" class="btn btn-sm btn-default operate" style="display: none;margin-left:70%;margin-top:10px" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';" id="saveTreat">保存</button>
                            </th>
                            @endif
                             
                        </tr>
                    </table>
                </div>

                <div class="table-responsive">
                  <table class="table table-striped b-t b-light text-sm">                
                    <tr>                      
                      <th>职位</th>
                      <th>晋升要求&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span id="errmsgTreat" style="color: red;"></span></th>
                    </tr>
                      <tr>
                          <td>
                          见习置业顾问
                          </td>
                          <td>
                              满&nbsp&nbsp<input type="number" style="width: 100px;" disabled="disabled" value="0" class="treatAmount">&nbsp元
                          </td>
                      </tr>
                      <tr>
                          <td>
                          置业顾问
                          </td>
                          <td>
                              连续三月业绩累计满&nbsp&nbsp<input type="number" style="width: 100px;" min="0" onkeyup="value=value.replace(/[^\d]/g,'')" disabled="disabled" class="treatAmount">&nbsp元／满三个月
                          </td>
                      </tr>
                      <tr>
                          <td>
                          高级置业顾问
                          </td>
                          <td>
                              连续三月业绩累计满&nbsp&nbsp<input type="number" style="width: 100px;" min="0" onkeyup="value=value.replace(/[^\d]/g,'')" disabled="disabled" class="treatAmount">&nbsp元
                          </td>
                      </tr>
                      <tr>
                          <td>
                          主任置业顾问
                          </td>
                          <td>
                              连续三月业绩累计满&nbsp&nbsp<input type="number" style="width: 100px;" min="0" onkeyup="value=value.replace(/[^\d]/g,'')" disabled="disabled" class="treatAmount">&nbsp元
                          </td>
                      </tr>
                      <tr>
                          <td>
                          金牌置业顾问
                          </td>
                          <td>
                              连续三月业绩累计满&nbsp&nbsp<input type="number" style="width: 100px;" min="0" onkeyup="value=value.replace(/[^\d]/g,'')" disabled="disabled" class="treatAmount">&nbsp元
                          </td>
                      </tr>
                      
                  </table>
                </div>
              </div>
              <!-- end级职待遇-->
      
            <!-- 端口费分摊规则 -->
              <div class="modal-body">
                <div class="table-responsive">
                  <table class="table table-striped b-t b-light text-sm">                
                    <tr>                      
                        <th style="width:50%">
                            <div style="font-size:18px;margin-top:10px">端口费分档规则</div>
                        </th>
                        @if(session('level_code') == 'cw')
                        <th>
                            <button type="button" class="btn btn-sm btn-default operate"  style="margin-top:10px;margin-left:70%;" id="editPort" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';">编辑</button>
                            <button type="button" class="btn btn-sm btn-default operate" style="display: none;margin-top:10px;margin-left:70%;" id="savePort" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';">保存</button>
                        </th>
                        @endif
                    </tr>
                  </table>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped b-t b-light text-sm" id="tbPort"> 
                      <tr>                      
                          <th style="width:25%">分挡线</th>
                          <th style="width:25%">报销比例&nbsp&nbsp&nbsp&nbsp<span id="errmsgPort" style="color: red;"></span></th>
                          <th style="width:25%">
                              <i class="fa fa-plus icon" id="addLinePort" style="display: none;">
                                  <b class="bg-primary indexColor"></b>
                              </i>
                          </th>
                      </tr>
                  <!-- 克隆的tr -->
                      <tr style="display: none;">
                          <td>
                              <input class="portLimit" onkeyup="value=value.replace(/[^\d]/g,'')" type="text">
                          </td>
                          <td>
                              <input class="portPercentage" min="0" style="width: 50px;" type="number">%
                          </td>
                          <td>
                              <i class="fa fa-times icon minusLinePort">
                                  <b class="bg-primary indexColor"></b>
                              </i>
                          </td>
                      </tr>
                  <!-- end -->
                  <!-- 遍历现有的 -->
                  @foreach($port as $list)
                          <tr>
                              <td>
                                  <input class="portLimit" value="{{$list->bottom}}" onkeyup="value=value.replace(/[^\d]/g,'')" disabled="disabled" type="text">
                              </td>
                              <td>
                                  <input class="portPercentage" value="{{$list->percentage}}"  min="0" disabled="disabled" style="width: 50px;" type="number">%
                              </td>
                              <td>
                                  <i class="fa fa-times icon minusLinePort" style="display: none;">
                                      <b class="bg-primary indexColor"></b>
                                  </i>
                              </td>
                          </tr>
                    @endforeach
                      <!-- end -->
               </table>
                </div>
              </div>
                <!-- end  二手房提成规则 -->

            </section>
          </section>
           <div class="copyRight">
          <div >版权所有: © locqj
            </div>
            </div>
          </section>
          <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
          <script type="text/javascript">
          	$(document).ready(function(){
              /**/
              $('input').click(function(){
                /*去除提示*/
                $('#errmsgSale').html('');
                $('.errmsgBonus').html('');
                $('#errmsgTreat').html('');
                $('#errmsgFirstAndRentSale').html('');
                $('#errmsgPort').html('');
              })
              var treat = "{{$treat}}";
              treat = JSON.parse(treat)
              if(treat != ""){
                for (var i = 0; i < $('.treatAmount').length; i++) {
                  $('.treatAmount').eq(i).val(treat[i]);
                }
              }
              /*编辑提成规则*/
              $('#editSale').click(function(){
                /*去除提示*/
                $('#errmsgPort').html('');
                $('#errmsgSale').html('');
                $('.errmsgBonus').html('');
                $('#errmsgTreat').html('');
                $('.errmsgFirstAndRentSale').html('');
                $('#editSale').hide();
                $('#saveSale').show();
                $('#addLine').show();
                $('.minusLine').show();
                if($('.topLimit').length > 2){
                  for (var i = $('.topLimit').length - 2; i >= 0; i--) {
                    $('.topLimit').eq(i).removeAttr('disabled');
                  }
                }

                for (var i = $('.percentage').length - 1; i >= 0; i--) {
                    $('.percentage').eq(i).removeAttr('disabled');
                  }

              })
          		/*加一行*/
          		$('#addLine').click(function(){
                /*去除提示*/
                $('#errmsgPort').html('');
                $('#errmsgSale').html('');
                $('.errmsgBonus').html('');
                $('#errmsgTreat').html('');
                $('.errmsgFirstAndRentSale').html('');
          			/*克隆前长度*/
          			var length = $('.topLimit').length - 1;
  	     				$('.topLimit').eq(length).removeAttr('disabled');
  	     				$('.topLimit').eq(length).val("");
  	     				/*遍历看是否为空*/

  	          	var tr = $("#tb tr").eq(1).clone(true);
  	          	tr.show();   
  	     				tr.appendTo("#tb");

  	     				length = length +1;
  	     				$('.topLimit').eq(length).val("+00");
  	     				$('.topLimit').eq(length).attr('disabled','disabled');
          		});
          		/*减一行【删除】*/
          		$('.minusLine').click(function(){
                /*去除提示*/
                $('#errmsgPort').html('');
                $('#errmsgSale').html('');
                $('.errmsgBonus').html('');
                $('#errmsgTreat').html('');
                $('.errmsgFirstAndRentSale').html('');
                var index = parseInt($(this).index('.minusLine'));
                if(index == ($('.topLimit').length - 2)){
                  $('.topLimit').eq(index).val("+00");
                  $('.topLimit').eq(index).attr('disabled','disabled');
                }else{
                  $('.topLimit').eq(index).val($('.topLimit').eq(index+1).val());
                }
                $(this).parent().parent('tr').remove();
          		})
          		/*实时输入限制*/
          		$('.topLimit').bind('input propertychange', function() {
          			var index = parseInt($(this).index('.topLimit'));
          			var bottomLimit = parseInt($(this).val()) + 1;
          			$('.bottomLimit').eq(index + 1).val(bottomLimit);
          		})
          		/*修改提成规则*/
          		$('#saveSale').click(function(){
                /*去除提示*/
                $('#errmsgPort').html('');
                $('#errmsgSale').html('');
                $('.errmsgBonus').html('');
                $('#errmsgTreat').html('');
                $('.errmsgFirstAndRentSale').html('');
                var rule_key = 1;
                var ruleLimit = new Array();
                for (var i = 1; i <= $('.topLimit').length - 1; i++) {
                  var topLimit = $('.topLimit').eq(i).val();
                  var bottomLimit = $('.bottomLimit').eq(i).val();
                  var percentage = $('.percentage').eq(i).val();
                  if(topLimit == ""){
                    console.log('topLimit is null');
                    $('#errmsgSale').html('不能为空');
                    break;
                  }
                  if(!(percentage > 0) || percentage > 100){
                    console.log('percentage is null');
                     $('#errmsgSale').html('提成比例有误');
                    break;
                  }
                  if(topLimit != '+00' && !(parseInt(topLimit) > parseInt(bottomLimit))){
                    console.log('topLimit is err. top:'+topLimit+'bottom'+bottomLimit);
                     $('#errmsgSale').html('填写有误');
                    break;
                  }
                  ruleLimit[i-1] = [bottomLimit,topLimit,percentage];
                }
                if(i == ($('.topLimit').length)){
            			$.post("{{url('/bonusrule')}}",
      	    				{ruleLimit:ruleLimit,rule_key:rule_key},function(data){
      	    					if(data['status']){
      	    						$('#editSale').show();
                        $('#saveSale').hide();
                        $('#addLine').hide();
                        $('.minusLine').hide();
                        $('.percentage').attr('disabled','disabled');
                        $('.topLimit').attr('disabled','disabled');
                        $('#errmsgSale').html('');
      	    					}else{
      	    						$('#errmsgSale').html(data['msg']);
      	    					}
      	    				});
                }

          		})

              /*编辑端口分档线*/
              $('#editPort').click(function(){
                /*去除提示*/
                $('#errmsgPort').html('');
                $('#errmsgSale').html('');
                $('.errmsgBonus').html('');
                $('#errmsgTreat').html('');
                $('.errmsgFirstAndRentSale').html('');
                $('#editPort').hide();
                $('#savePort').show();
                $('#addLinePort').show();
                $('.minusLinePort').show();
                  // for (var i = $('.topLimit').length - 1; i >= 0; i--) {
                  //   $('.topLimit').eq(i).removeAttr('disabled');
                  // }

                for (var i = $('.percentage').length - 1; i >= 0; i--) {
                    $('.portPercentage').eq(i).removeAttr('disabled');
                    $('.portLimit').eq(i).removeAttr('disabled');
                  }

              })

              /*分档线加一行*/
              $('#addLinePort').click(function(){
                /*去除提示*/
                $('#errmsgPort').html('');
                $('#errmsgSale').html('');
                $('.errmsgBonus').html('');
                $('#errmsgTreat').html('');
                $('.errmsgFirstAndRentSale').html('');

                var tr = $("#tbPort tr").eq(1).clone(true);
                tr.show();   
                tr.appendTo("#tbPort");
              });
              /*分档线减一行*/
              $('.minusLinePort').click(function(){
                /*去除提示*/
                $('#errmsgPort').html('');
                $('#errmsgSale').html('');
                $('.errmsgBonus').html('');
                $('#errmsgTreat').html('');
                $('.errmsgFirstAndRentSale').html('');
                $(this).parent().parent('tr').remove();
              })
              /*保存分档规则*/
              $('#savePort').click(function(){
                /*去除提示*/
                $('#errmsgPort').html('');
                $('#errmsgSale').html('');
                $('.errmsgBonus').html('');
                $('#errmsgTreat').html('');
                $('.errmsgFirstAndRentSale').html('');
                var rule_key = 13;
                var ruleLimit = new Array();
                for (var i = 1; i <= $('.portLimit').length - 1; i++) {
                  var portLimit = $('.portLimit').eq(i).val();
                  var percentage = $('.portPercentage').eq(i).val();
                  if(portLimit == "" || parseInt(portLimit) < 0){
                    console.log('portLimit is null');
                    $('#errmsgPort').html('填写有误');
                    break;
                  }else if(!(percentage > 0) || percentage > 100){
                    console.log('percentage is null');
                     $('#errmsgPort').html('提成比例有误');
                    break;
                  }else if(i > 1 && !(parseInt(portLimit) > parseInt($('.portLimit').eq(i-1).val()))){
                    console.log('portLimit is err');
                     $('#errmsgPort').html('填写有误');
                    break;
                  }
                  ruleLimit[i-1] = [portLimit,percentage];
                }
                if(i == ($('.portLimit').length)){
                  $.post("{{url('/bonusrule')}}",
                    {ruleLimit:ruleLimit,rule_key:rule_key},function(data){
                      if(data['status']){
                        $('#editPort').show();
                        $('#savePort').hide();
                        $('#addLinePort').hide();
                        $('.minusLinePort').hide();
                        $('.portPercentage').attr('disabled','disabled');
                        $('.portLimit').attr('disabled','disabled');
                        $('#errmsgPort').html('');
                      }else{
                        $('#errmsgPort').html(data['msg']);
                      }
                    });
                }

              });
              /*分红规则*/
          		$('.saveBonus').click(function(){
                /*去除提示*/
                $('#errmsgSale').html('');
                $('.errmsgBonus').html('');
                $('#errmsgTreat').html('');
                $('.errmsgFirstAndRentSale').html('');
                var index = parseInt($(this).val()) - 2;
          			var percentage = $('.bonusPercentage').eq(index).val();
          			var rule_key = index + 2;
                var parent_store_limit = "";
                if(rule_key == 6){
                  parent_store_limit = $('#parentStoreLimit').val();
                }
          			if(percentage < 0 || !percentage || percentage > 100){
          				$('.errmsgBonus').eq(index).html('提成比例有误');
          			}else if(rule_key == 6 && (!parent_store_limit || parent_store_limit < 0)){
                  $('.errmsgBonus').eq(index).html('有效期有误');
                }else{
	          			$.post("{{url('/bonusrule')}}",
		    				{rule_key:rule_key,percentage:percentage,parent_store_limit:parent_store_limit},function(data){
		    					if(data['status']){
		    						$('.saveBonus').eq(index).hide();
                    $('.editBonus').eq(index).show();
                    $('.bonusPercentage').eq(index).attr('disabled','disabled');
                    $('.errmsgBonus').eq(index).html('');
                    if(rule_key == 6){
                      $('#parentStoreLimit').attr('disabled', 'disabled');
                    }
                    if(rule_key == 8 || rule_key == 9){
                      $('.sourceSalePercentage').eq(rule_key-8).text(100 - percentage);
                    }		    					}else{
		    						$('.errmsgBonus').eq(index).html(data['msg']);
		    					}
		    				});
	          		}
          		})

          		$('.editBonus').click(function(){
                /*去除提示*/
                $('#errmsgSale').html('');
                $('.errmsgBonus').html('');
                $('#errmsgTreat').html('');
                $('.errmsgFirstAndRentSale').html('');
                var index = parseInt($(this).val()) - 2;
                $(this).hide();
                $(this).parent().children('.saveBonus').show();
                $('.bonusPercentage').eq(index).removeAttr('disabled');
                if(index == 4){
                  $('#parentStoreLimit').removeAttr('disabled');
                }
          		})

              /*编辑一手房和租售规则*/
              $('.editFirstAndRentSale').click(function(){
                /*去除提示*/
                $('#errmsgSale').html('');
                $('.errmsgBonus').html('');
                $('#errmsgTreat').html('');
                $('#errmsgFirstAndRentSale').html('');
                var index = $(this).index('.editFirstAndRentSale');
                $(this).hide();
                $(this).parent().children('.saveFirstAndRentSale').show();
                $('.firstAndRentPercentage').eq(index).removeAttr('disabled');
              })  
              /*一手房和租售*/
              $('.saveFirstAndRentSale').click(function(){
                /*去除提示*/
                $('#errmsgSale').html('');
                $('.errmsgBonus').html('');
                $('#errmsgTreat').html('');
                $('#errmsgFirstAndRentSale').html('');
                var index = $(this).index('.saveFirstAndRentSale');
                var percentage = $('.firstAndRentPercentage').eq(index).val();
                var rule_key = $(this).val();
                if(percentage < 0 || !percentage || percentage > 100){
                  $('.errmsgFirstAndRentSale').eq(index).html('提成比例有误');
                }else{
                  $.post("{{url('/bonusrule')}}",
                {rule_key:rule_key,percentage:percentage},function(data){
                  if(data['status']){
                    $('.saveFirstAndRentSale').eq(index).hide();
                    $('.editFirstAndRentSale').eq(index).show();
                    $('.firstAndRentPercentage').eq(index).attr('disabled','disabled');
                    $('.errmsgFirstAndRentSale').html('');
                  }else{
                    $('.errmsgFirstAndRentSale').eq(index).html(data['msg']);
                  }
                });
                }
              });

              /*级之待遇*/
              $('#editTreat').click(function(){
                /*去除提示*/
                $('#errmsgSale').html('');
                $('.errmsgBonus').html('');
                $('#errmsgTreat').html('');
                $('.errmsgFirstAndRentSale').html('');
                $(this).hide();
                $('#saveTreat').show();
                $('.treatAmount').removeAttr('disabled');
                $('.treatAmount').eq(0).attr('disabled','disabled');
              })
              $('#saveTreat').click(function(){
                /*去除提示*/
                $('#errmsgSale').html('');
                $('.errmsgBonus').html('');
                $('#errmsgTreat').html('');
                $('.errmsgFirstAndRentSale').html('');
                var treatRule = new Array();
                var rule_key = 10;
                for (var i = 0; i <= $('.treatAmount').length - 1; i++) {
                  var amount = $('.treatAmount').eq(i).val();
                  if(amount == ""){
                    console.log('not null');
                    $('#errmsgTreat').html('不能为空');
                    break;
                  }
                  if(i <  ($('.treatAmount').length - 1) && parseInt(amount) >=  parseInt($('.treatAmount').eq(i+1).val())){
                    console.log('limit err');
                    $('#errmsgTreat').html('输入有误');
                    break;
                  }

                  treatRule[i] = amount;
                }
                if(i == $('.treatAmount').length){
                  $.post("{{url('/bonusrule')}}",
                    {treatRule:treatRule,rule_key:rule_key},function(data){
                      if(data['status']){
                        $('#saveTreat').hide();
                        $('#editTreat').show();
                        $('.treatAmount').attr('disabled','disabled');
                      }else{
                        $('#errmsgTreat').html(data['msg']);
                      }
                    });
                }
              })   		

      });
          </script>
@endsection