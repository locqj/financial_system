 @extends('layouts.nav')
 @section('content')
 <section class="vbox">
            <section class="scrollable padder">
              <marquee direction=left class="headerMarquee">欢迎使用xxx房产记账结算管理系统！</marquee>
              <ul class="breadcrumb no-border no-radius b-b b-light pull-in">
                <li><i class="fa fa-home"></i> 主页</li>
                <li class="active">佣金明细</li>
              </ul>
              <section class="panel panel-default">
                <div class="table-responsive" >
                  <table class="headerStyle">
                    <tr>
                        <th class="headertitle" data-toggle="class">
                          佣金明细
                        </th>
                    </tr>
                  </table>
                 <!--显示店铺基本信息-->
                  <table class="table table-striped b-t b-light text-sm headerStyle2">
                      <tr>
                        <th>
                          <label class="labelStyle">查找店铺&nbsp;&nbsp;</label>
                          <select class="input-sm form-control input-s-sm inline" onchange="keyFind()" id="store_code">
                                <option value="{{$store_rand->code}}">{{$store_rand->name}}</option>
                              @foreach($store as $list)
                                @if($list->code != $store_rand->code)
                                <option value="{{$list->code}}">{{$list->name}}</option>
                                @endif
                              @endforeach
                              </select>
                        </th>
                        <th>
                            <label class="labelStyle">查找员工&nbsp;&nbsp;</label>
                            <select class="input-sm form-control input-s-sm inline" onchange="keyFind()" id="searchemployee">
                                    <option value="all">所有</option>
                                    @foreach($search_employee as $e)
                                        @if ($employee_code == $e->employee->code)
                                            <option value="{{ $e->employee->code }}" selected>{{ $e->employee->name}}</option>
                                        @else
                                            <option value="{{ $e->employee->code }}" >{{ $e->employee->name }}</option>
                                        @endif
                                    @endforeach
                            </select>
                        </th>
                        <!-- <th>
                            <label class="labelStyle">季度查询&nbsp;&nbsp;</label>
                            <select class="input-sm form-control input-s-sm inline" id="yearSeason">
                                <option value="{{$year}}">{{$year}}</option>
                                   @foreach($years as $list)
                                    @if($list->year != $year)
                                      <option value="{{$list->year}}">{{$list->year}}</option>
                                    @endif
                                    @endforeach
                              </select>  
                            <select class="input-sm form-control input-s-sm inline" onchange="keyFindSeason()" id="seasonSeason">
                                <option value="">请选择</option>
                                <option value="1" @if(isset($season) && $season == 1) selected="selected" @endif>第一季度</option>
                                <option value="2" @if(isset($season) && $season == 2) selected="selected" @endif>第二季度</option>
                                <option value="3" @if(isset($season) && $season == 3) selected="selected" @endif>第三季度</option>
                                <option value="4" @if(isset($season) && $season == 4) selected="selected" @endif>第四季度</option>
                            </select>
                        </th> -->
                        <th>
                          <label class="labelStyle timeStyle" style="margin-left:-10%">年 / 月&nbsp;&nbsp;</label>  
                          <select class="input-sm form-control input-s-sm inline" onchange="keyFind()" id="year">
                                <option value="{{$year}}">{{$year}}</option>
                                   @foreach($years as $list)
                                    @if($list->year != $year)
                                      <option value="{{$list->year}}">{{$list->year}}</option>
                                    @endif
                                    @endforeach
                              </select>   
                              <select class="input-sm form-control input-s-sm inline" onchange="keyFind()" id="month">
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
                  <div class="table-responsive" >
                  <table class="table table-striped b-t b-light text-sm">
                    <thead>
                        <tr>               
                          <th>所属店铺</th>
                          <th>姓名</th>
                          <th>年</th>
                          <th>月</th>
                          <th>员工编号</th>
                          <th>签单个数</th>
                          <th>一手房佣金</th>
                          <th>二手房佣金</th>
                          <th>租房佣金</th>                      
                        </tr>
                    </thead>
                    <tbody>
                      @foreach($commission_details as $list)
                      <tr>
                        <td>{{$list->store->name}}</td>                     
                        <td>{{$list->employee->name}}</td>
                        <td class="showYear">{{$list->year}}</td>
                        <td class="showMonth">{{$list->month}}</td>
                        <td class="showEmployeeCode">{{$list->employee->code}}</td>
                        <td>
                        <!-- <a href="contract.html"></a> -->
                        {{$list->contract_number}}
                        </td>
                        <td data-toggle="modal" data-target="#showDetail">
                        <button class="btn btn-sm btn-default operate showAmountDetail" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';" value="{{$list->employee->code}}">
                        {{$list->amount}}
                        </button>
                        </td>
                        <td data-toggle="modal" data-target="#showDetail">
                        <button class="btn btn-sm btn-default operate showSecondAmountDetail" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';" value="{{$list->employee->code}}">
                        {{$list->second_amount}}
                        </button>
                        </td>
                        <td data-toggle="modal" data-target="#showDetail">
                        <button class="btn btn-sm btn-default operate showRentAmountDetail" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';" value="{{$list->employee->code}}">
                        {{$list->rent_amount}}
                        </button>
                        </td>                
                      </tr>
                      @endforeach
                    </tbody>
                    {!! $commission_details->links() !!}
                  </table>
                </div>
                <footer class="panel-footer">
                    <div class="row">
                        <div class="pagination pagination-sm m-t-none m-b-none" style="float: right;margin-left:73%; margin-top:0px">
                             
                        </div>
                    </div>
               </footer>
              </section>
            </section>
            <div class="copyRight">
              <div >版权所有: © locqj
              </div>
            </div>
          </section>
           <!-- 添加弹框 -->
          <div class="modal fade" id="showDetail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel">佣金详情</h4>
                </div>
                <div class="modal-body">
                  <div class="table-responsive">
                    <table class="table" id="showTb">                
                        <tr>
                          <th>日期</th>
                          <th>签单编号</th>
                          <th>结佣金额</th> 
                          <th id="showEmployeeRoleTr">员工角色</th>
                          <th>员工佣金</th> 
                          <th id="searchEmployeeCode" style="display: none;"></th>
                        </tr> 
                        <tr style="display: none;" class="showTr">
                          <td class="showContractDate"></td>
                          <td class="showContractCode"></td>
                          <td class="showContractAmount"></td>
                          <td class="showEmployeeRole"></td>
                          <td class="showEmployeeAmount"></td>
                        </tr>                   
                    </table>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                </div>
              </div>
            </div>
          </div>
          <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
          <script type="text/javascript">
          /**
           * 点签单号跳转
           */
          $('.showContractCode').click(function(){
            var month = $('#month').val();
            var year = $('#year').val();
            var store_code = $('#store_code').val();
            var employee_code = $('#searchEmployeeCode').text();
            var end_month = month;
            window.location.href = '/search/contract/'+store_code+'-'+year+'-'+month+'-'+employee_code+'-'+end_month;
          })
          /*年月搜索*/
            function keyFind(){
              var store_code = $('#store_code').val();
              var year = $('#year').val();
              var month = $('#month').val();
              var employee_code = $('#searchemployee').val();
              window.location.href = "{{url('find')}}"+"/"+"commission_details/"+store_code+"-"+year+"-"+month+'-'+employee_code;
            }
          /*季度搜索*/
          function keyFindSeason(){
            var store_code = $('#store_code').val();
            var year = $('#yearSeason').val();
            var season = $('#seasonSeason').val();
            if(season != "")
              window.location.href = "{{url('find')}}"+"/"+"commission_details/"+store_code+"/"+year+"/"+season;
          }
            //金额来源细节
            //一手房
            $('.showAmountDetail').click(function(){
              $('#searchEmployeeCode').text($(this).val());
              $('.showTr').hide();
              $('#showEmployeeRoleTr').hide();
              var index = $(this).index('.showAmountDetail');
              var employee_code = $('.showEmployeeCode').eq(index).text();
              var year = $('.showYear').eq(index).text();
              var month = $('.showMonth').eq(index).text();
              $.post("{{url('/commission/contract_detail')}}", {year:year,month:month,employee_code:employee_code,type:'amount'},function(result){
                if(result['status'] == 1){
                  var contract = result['data'];
                  for (var i = 0; i < contract.length; i++) {
                    var tr = $("#showTb tr").eq(1).clone(true);
                    tr.show();   
                    tr.appendTo("#showTb");
                    tr.children('.showEmployeeRole').remove();
                    tr.children('.showContractDate').html(contract[i].created_at);
                    tr.children('.showContractCode').html(contract[i].number);
                    tr.children('.showContractAmount').html(contract[i].real_amount);
                    tr.children('.showEmployeeAmount').html(contract[i].real_amount);
                  }
                }
              })
            })
            //二手房
             $('.showSecondAmountDetail').click(function(){
              $('#searchEmployeeCode').text($(this).val());
              $('.showTr').hide();
              $('#showEmployeeRoleTr').show();
              var index = $(this).index('.showSecondAmountDetail');
              var employee_code = $('.showEmployeeCode').eq(index).text();
             var year = $('.showYear').eq(index).text();
              var month = $('.showMonth').eq(index).text();
              $.post("{{url('/commission/contract_detail')}}", {year:year,month:month,employee_code:employee_code,type:'second'},function(result){
                if(result['status'] == 1){
                  var contract = result['data'];
                  for (var i = 0; i < contract.length; i++) {
                    var tr = $("#showTb tr").eq(1).clone(true);
                    tr.show();   
                    tr.appendTo("#showTb");
                    tr.children('.showContractCode').html(contract[i].number);
                    tr.children('.showContractDate').html(contract[i].created_at);
                    tr.children('.showContractAmount').html(contract[i].signed_amount);
                    tr.children('.showEmployeeRole').html(contract[i].employee_role);
                    tr.children('.showEmployeeAmount').html(contract[i].real_amount);
                  }
                }
              })
            })
            //租房
            $('.showRentAmountDetail').click(function(){
              $('#searchEmployeeCode').text($(this).val());
              $('.showTr').hide();
              $('#showEmployeeRoleTr').show();
              var index = $(this).index('.showRentAmountDetail');
              var employee_code = $('.showEmployeeCode').eq(index).text();
              var year = $('.showYear').eq(index).text();
              var month = $('.showMonth').eq(index).text();
              $.post("{{url('/commission/contract_detail')}}", {year:year,month:month,employee_code:employee_code,type:'rent'},function(result){
                if(result['status'] == 1){
                  var contract = result['data'];
                  for (var i = 0; i < contract.length; i++) {
                    var tr = $("#showTb tr").eq(1).clone(true);
                    tr.show();   
                    tr.appendTo("#showTb");
                    tr.children('.showContractCode').html(contract[i].number);
                    tr.children('.showContractDate').html(contract[i].created_at);
                    tr.children('.showContractAmount').html(contract[i].real_amount);
                    tr.children('.showContractIsSource').html(contract[i].is_source);
                    tr.children('.showContractOwnerStore').html(contract[i].owner_store_name);
                  }
                }
              })
            })
          </script>
@endsection