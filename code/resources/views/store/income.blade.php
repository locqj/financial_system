@extends('layouts.nav')
@section('content')
<section class="vbox">
            <section class="scrollable padder">
            <marquee direction=left class="headerMarquee">欢迎使用xxx房产记账结算管理系统！</marquee>
            <ul class="breadcrumb no-border no-radius b-b b-light pull-in">
              <li><i class="fa fa-home"></i> 主页</li>
              <li class="active">店铺收入</li>
            </ul>
            <section class="panel panel-default">
              <div class="table-responsive" >
                <table class="headerStyle">
                  <tr>
                    <th class="headertitle" data-toggle="class">
                        店铺收入表
                    </th>
                    <th>
                    @if(in_array(session::get('level_code'), ['cw', 'dz','zl']))
                    <button class="btn btn-sm btn-default addNew" data-toggle="modal" data-target="#modifyStore" id="costAdd" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';">添加新收入</button>
                    @endif
                    </th>
                  </tr>
                </table>
                <table class="table table-striped b-t b-light text-sm headerStyle2">
                  <tr>
                    <th>
                      <label class="labelStyle">查找店铺&nbsp;&nbsp;</label>
                      <select class="input-sm form-control input-s-sm inline" id="store_code" disabled>
                        <option value="{{$store->code}}">{{$store->name}}</option>
                        @foreach($income->store as $list)
                          @if($list->code != $store->code)
                          <option value="{{$list->code}}">{{$list->name}}</option>
                          @endif
                        @endforeach
                      </select>
                    </th>
                    <th>
                      <label class="labelStyle timeStyle">年 / 月&nbsp;&nbsp;</label> 
                      <select class="input-sm form-control input-s-sm inline" id="year">
                        <option value="{{$year}}">{{$year}}</option>
                            @foreach($years as $list)
                            @if($list->year != $year)
                              <option value="{{$list->year}}">{{$list->year}}</option>
                            @endif
                            @endforeach
                      </select>   
                      <select class="input-sm form-control input-s-sm inline" id="month">
                        <option value="{{$month}}">{{$month}}</option>
                          @for($i = 1; $i < 13 ; $i++)
                            @if($i != $month)
                             <option value="{{$i}}">{{$i}}</option>
                             @endif
                             @endfor
                      </select>
                    </th>
                  </tr>
              </table>
            </div>
              <div class="table-responsive">
                <table class="table table-striped b-t b-light text-sm" id="table1">
                  <thead>
                    <tr>
                      <th>类目</th>
                      <th>店铺</th>
                      <th>年</th>
                      <th>月</th>
                      <th>总额</th>
                      <th>备注</th>
                      @if(session('level_code') == 'cw')
                      <th>操作</th>
                      @endif
                    </tr>
                  </thead>
                  <tbody>
                   @foreach($income as $list)
                    <tr>
                      <td class="editId" style="display: none;">{{$list->id}}</td>                     
          					  <td>{{$list->category}}</td>
                      <td>{{$list->store->name}}</td>
                      <td>{{$list->year}}</td>
                      <td>{{$list->month}}</td>
                      <td>{{$list->total}}</td>
                      <td>{{$list->remark}}</td>
                      @if(session('level_code') == 'cw')
                      <td>                   
                      	 <button class="btn btn-sm btn-default costEdit operate" data-toggle="modal" data-target="#modifyStore" value="{{$list->id}}" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';">修改</button>
                         <button class="btn btn-sm btn-default costDel operate deleteColor" value="{{$list->id}}" onmouseover="this.style.backgroundColor='#fb6b5b'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#fb6b5b';this.style.color = 'white';">删除</button>
                      </td>
                      @endif               
                    </tr>
				  @endforeach
				  	<tr>
				  		<td>{!! $income->links() !!}</td>
				  	</tr>
                  </tbody>
                </table>
              </div>
     <!--          <footer class="panel-footer">
       <div class="row">
       <div class="col-sm-4 text-right text-center-xs" style="margin-left:65%">
         <button class="btn btn-sm btn-default" onclick="calculate();">结算</button>
       </div>
       </div>
     </footer> -->
            </section>
          </section>
          <div class="copyRight">
              <div >版权所有: © locqj
                </div>
          </div>
          </section>
          <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
           <!-- 显示详情弹框 -->
 <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">查看详情</h4>
      </div>
      <div>
        <span id="detail" style="margin-left: 10px;margin-top: 10px;"></span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
      </div>
      </div>
      
    </div>
  </div>
</div>
 <!-- 添加弹框 -->
          <div class="modal fade" id="modifyStore" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="editHead">收入录入</h4>
                </div>
                <div class="modal-body">
                  <div class="table-responsive">
                    <table class="table">                
                              <tr>
                                <input type="text" id="costId" disabled="disabled" style="display: none;">
                                <td class="modalTd">类目</td>
                                <td><input type="text" class="modalInput" id="category"></td>   
                              </tr>                 
                              <tr>                     
                                <td class="modalTd">总额</td>
                                <td><input type="number" class="modalInput" id="total"></td>
                              </tr>
                              <tr>               
                                <td class="modalTd">店铺</td>
                                <td>
                                  <select class="input-sm form-control input-s-sm inline" disabled="disabled" id="owner_store_code">
                                    <
                                    @foreach($income->store as $list)
                                      <option value="{{$list->code}}" class="ownerStoreOpt" id="{{$list->code}}">{{$list->name}}</span>
                                      </option>
                                    @endforeach
                                  </select>  
                                </td>
                           </tr>
                           <tr>                     
                                <td class="modalTd">录入时间</td>
                                <td>
                                  <input type="month" value="{{$year}}-{{$month}}" id="start_time">
                                </td>
                          </tr>
                           <tr>                     
                                <td class="modalTd">备注</td>
                                <td>
                                  <textarea id="remark" style="resize:none"></textarea>
                                </td>
                          </tr>
                             
                    </table>
                  </div>
                </div>
                <div class="modal-footer">
                   <span id="errMsg" style="color: red;float: left;"></span>
                  <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                  <button type="button" class="btn btn-default" id="subBtn">保存</button>
                </div>
              </div>
            </div>
          </div>

          <script type="text/javascript">
            $('#start_time').click(function(){
              /*去除错误提示*/
              $('#errMsg').html('');
            })
            $('#category').click(function(){
              /*去除错误提示*/
              $('#errMsg').html('');
            })
            $('#total').click(function(){
              /*去除错误提示*/
              $('#errMsg').html('');
            })
            /*添加成本*/
            $('#costAdd').click(function(){
               $('#editHead').text('收入录入');
               /*去除错误提示*/
              $('#errMsg').html('');
              $('#costId').val('');
              $('#category').val('');
              $('#remark').val('');
              $('#total').val('');
              var store_code = $('#store_code').val();
              $('#'+store_code).attr('selected','selected');
            })
            /*编辑*/
            $('.costEdit').click(function(){
               $('#editHead').text('收入修改');
               /*去除错误提示*/
              $('#errMsg').html('');
              var costId = $(this).val();
              $('#costId').val(costId);
             $.ajax({
                    url: "{{URL::action('StoreIncomeController@index')}}"+"/"+costId,
                    type: 'GET',
                    success: function(result) {
                      if(result['status']){
                            var editCost = result['data'];
                            $('#category').val(editCost['category']);
                            $('#total').val(editCost['total']);
                            $('#'+editCost['store_code']).attr('selected','selected');
                            $('#remark').val(editCost['remark']);
                            // $('#year'+editCost['year']).attr('selected','selected');
                            // $('#month'+editCost['month']).attr('selected','selected');
                        }else{
                          $('#errMsg').html(result['msg']);
                        }                        
                      }
                });    
            });
            /*提交*/
            $('#subBtn').click(function(){
              var id = $('#costId').val();
              var category = $('#category').val();
              var remark = $('#remark').val()
              var total = $('#total').val();
              var owner_store_code = $('#owner_store_code').val();
              var start_time = $('#start_time').val();
              var month = start_time.substr(5, 2);
              var year = start_time.substr(0, 4);
              if(month.substr(0, 1) == 0){
                month = month.substr(1, 1);
              }
              if(!category){
                $('#errMsg').html('请填写类目');
              }else if(total < 0 || !total){
                $('#errMsg').html('请正确填写总额');
              }else if(!start_time){
                $('#errMsg').html('请填写录入时间');
              }else{
                $.post("{{URL::action('StoreIncomeController@store')}}",{
                    id:id,
                    category:category,
                    remark:remark,
                    total:total,
                    owner_store_code:owner_store_code,
                    year:year,
                    month:month
                  },function(data){
                    if(data['status']){
                       // window.location.reload(true);
                       
                      window.location.href = "/income/time_key/"+owner_store_code+"-"+year+"-"+start_time.substr(5, 2);
                    }else{
                      $('#errMsg').html(data['msg']);
                    }
                  });
              }
            })
            /*查看月份详情*/
            $(".detailShow").click(function(){
              $("#detail").html($(this).val());
            }) 
            /*选年份查找*/
            $('#year').change(function(){
              keyFind();
            })
            /*选月份查看*/ 
            $('#month').change(function(){
              keyFind();
            })
            /*选店铺查找*/
          	$('#store_code').change(function(){
          		keyFind();
          	});

          /*查找函数*/
            function keyFind(){
              var store_code = $('#store_code').val();
              var year = $('#year').val();
              var month = $('#month').val();
              window.location.href = "{{url('/income/time_key')}}"+"/"+store_code+"-"+year+"-"+month;
            }
            /*删除*/
            $('.costDel').click(function(){
              var key = $(this).val();
              var content = '确定删除？';
              if(confirm(content)){
                $.ajax({
                          url: "{{url('/income')}}"+"/"+key,
                          type: 'DELETE',
                          success: function(result) {
                            if(result['status']){
                              window.location.reload(true);
                              }                      
                            }
                      });
              }

            });
            /*结算按钮*/
            function calculate(){

            }
          </script>
@endsection