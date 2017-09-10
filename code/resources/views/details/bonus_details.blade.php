@extends('layouts.nav')
@section('content')
<section class="vbox">
                <section class="scrollable padder">
                  <marquee direction=left class="headerMarquee">欢迎使用xxx房产记账结算管理系统！</marquee>
                  <ul class="breadcrumb no-border no-radius b-b b-light pull-in">
                    <li><i class="fa fa-home"></i> 主页</li>
                    <li class="active">提成明细</li>
                  </ul>
                  <section class=" panel panel-default">
                    <div class="table-responsive" >
                      <table class="headerStyle">
                        <tr>
                            <th class="headertitle" data-toggle="class">
                              提成明细
                            </th>
                        </tr>
                      </table>
                      <table class="table table-striped b-t b-light text-sm headerStyle2">
                          <tr>
                            <th>
                            <label class="labelStyle">查找店铺&nbsp;&nbsp;</label>
                               <select class="input-sm form-control input-s-sm inline" onchange="keyFind()" id="store_code">
                                @if($store_rand == 'all')
                                  <option value="all">所有</option>
                                  @foreach($store as $list)
                                    <option value="{{$list->code}}">{{$list->name}}</option>
                                  @endforeach
                                @else
                                  <option value="{{$store_rand->code}}">{{$store_rand->name}}</option>
                                  @foreach($store as $list)
                                    @if($list->code != $store_rand->code)
                                    <option value="{{$list->code}}">{{$list->name}}</option>
                                    @endif
                                  @endforeach
                                   <option value="all">所有</option>
                                @endif
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
                            <th>职位</th>
                            <th>销售提成</th>
                            <th>分红金额</th>
                            <th>总额</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($bonus_employee as $list)
                            @foreach($list->bonusAndSale as $list_bonus)
                              <tr>
                                <td>{{$list->store->name}}</td>                      
                                <td>{{$list->employee->name}}</td>
                                <td class="showYear">{{$list_bonus['year']}}</td>
                                <td class="showMonth">{{$list_bonus['month']}}</td>
                                <td class="showEmployeeCode">{{$list->employee_code}}</td> 
                                <td>{{$list->position->name}}</td>       
                                <td><a href="{{url('find')}}/commission_details_personal/{{$list->employee_code}}-{{$list_bonus['year']}}-{{$list_bonus['month']}}">
                                <button class="btn btn-sm btn-default operate" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';">
                                {{$list_bonus['sale']}}
                                </button>
                                </a>
                                </td>       
                                <td class="showBonusDetail" data-toggle="modal" data-target="#showDetail">
                                  <button class="btn btn-sm btn-default operate" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';">
                                  {{$list_bonus['bonus']}}
                                  </button>
                                </td>
                                <td>{{$list_bonus['all']}}</td>           
                              </tr>
                            @endforeach
                          @endforeach
                        </tbody>
                        
                      </table>

                    </div>

                    <footer class="panel-footer">
                        <div class="row">
                            <div class="pagination pagination-sm m-t-none m-b-none" style="float: right;margin-left:73%; margin-top:0px">
                                
                            </div>
                        </div>
                   </footer>

                  </section>
                  <div style="float: right;">
                  @if($store_rand == 'all')
                  {!! $bonus_employee->links() !!}
                  @endif
                  </div> 
                </section>

                <div class="copyRight">
                  <div >版权所有: © locqj
                  </div>
                </div>
                 <!-- 添加弹框 -->
          <div class="modal fade" id="showDetail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel">提成详情</h4>
                </div>
                <div class="modal-body">
                  <div class="table-responsive">
                    <table class="table" id="showTb">                
                        <tr>
                          <th>分红类型</th>
                          <th>金额</th>
                          <th id="bonusSource" style="display: none;">分红来源</th> 
                        </tr> 
                        <tr style="display: none;" class="showTr">
                          <td class="showBonusType"></td>
                          <td class="showBonusAmount"></td>
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
              </section>
              <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
              <script type="text/javascript">
              /*月份搜索*/
            function keyFind(){
              var store_code = $('#store_code').val();
              var year = $('#year').val();
              var month = $('#month').val();
              var employee_code = $('#searchemployee').val();
              if(store_code == 'all')
              {
                  window.location.href = '/bonus/search/' + year +'/' + month;
              }
              else
              {
                window.location.href = "{{url('find')}}"+"/"+"bonus_details/"+store_code+"-"+year+"-"+month+'-'+employee_code;
              }
              
            }
            /*季度搜索*/
            function keyFindSeason(){
              var store_code = $('#store_code').val();
              var year = $('#yearSeason').val();
              var season = $('#seasonSeason').val();
              if(season != "")
                window.location.href = "{{url('find')}}"+"/"+"bonus_details/"+store_code+"/"+year+"/"+season;
            }
            $('.showBonusDetail').click(function(){
              $('#bonusSource').hide();
              $('.showTr').hide();
              var index = $(this).index('.showBonusDetail');
              var employee_code = $('.showEmployeeCode').eq(index).text();
              var year = $('.showYear').eq(index).text();
              var month = $('.showMonth').eq(index).text();
              $.post("{{url('/bonus/bonus_detail')}}", {employee_code:employee_code, year:year, month:month},function(result){
                if(result['status'] == 1){
                  var bonus = result['data'];
                  if(bonus[0].bonus_rule_key == 4 || bonus[0].bonus_rule_key == 5 || bonus[0].bonus_rule_key == 6){
                    $('#bonusSource').show();
                  }
                  for (var i = 0; i < bonus.length; i++) {
                    var tr = $("#showTb tr").eq(1).clone(true);
                    tr.show();   
                    tr.appendTo("#showTb");
                    tr.children('.showBonusType').html(bonus[i].bonus_type);
                    tr.children('.showBonusAmount').html(bonus[i].bonus_amount);
                    if(bonus[0].bonus_rule_key == 4 || bonus[0].bonus_rule_key == 5 || bonus[0].bonus_rule_key == 6){
                      tr.append('<td>'+bonus[i].cstore_name+'</td>');
                    }
                  }
                }
              })
            })
          </script>
@endsection