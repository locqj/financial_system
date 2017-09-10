@extends('layouts.nav')
@section('content')
<section class="vbox">
                    <section class="scrollable padder">
                      <marquee direction=left class="headerMarquee">欢迎使用xxx房产记账结算管理系统！</marquee>
                      <ul class="breadcrumb no-border no-radius b-b b-light pull-in">
                        <li><i class="fa fa-home"></i> 主页</li>
                        <li class="active">账目结算</li>
                      </ul>
                      <section class="panel panel-default">
                        <div class="table-responsive" >
                          <table class="headerStyle">
                            <tr>
                              <th class="headertitle" data-toggle="class">
                                账目结算表
                              </th>
                            </tr>
                          </table>
                         <!--显示店铺基本信息-->
                        <table class="table table-striped b-t b-light text-sm headerStyle2">
                              <tr>
                                <th>
                                    <label class="labelStyle">年 / 月&nbsp;&nbsp;</label>  
                                    <select class="input-sm form-control input-s-sm inline" id="year">
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
                                    <select class="input-sm form-control input-s-sm inline" id="month">
                                        @for($i = 1; $i < 13 ; $i++)
                                            @if($month == $i)
                                                <option value="{{ $i }}" selected>{{ $i }}</option>
                                            @else
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endif
                                        @endfor
                                    </select>
                                </th>
                                <th>
                                 @if(session('level_code') == 'cw')
                                  <button  id="count" class="btn btn-sm btn-default operate " onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';">按月结算</button>
                                  <button  id="countSeason" class="btn btn-sm btn-default operate " onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';" data-toggle="modal" data-target="#showDetail">按季结算</button>
                                  @endif
                                  <!-- 职位调整， -->
                                  @if(0)
                                   <button  id="autoPositionAdjustment" class="btn btn-sm btn-default operate " onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';">职位调整</button>
                                   @endif
                                </th>
                              </tr>
                        </table>
                        </div>
                         <div class="table-responsive">
                          <table class="table table-striped b-t b-light text-sm" id="table">
                            <thead>
                              <tr>
                                <th>结算码</th>
                                <th>日期</th>
                              </tr>
                            </thead>
                            <tbody>
                            @foreach($update_code as $list)
                              <tr>
                                <td>{{ $list->update_code }}</td>
                                <td>{{ $list->created_at }}</td>                         
                              </tr>
                            @endforeach
                              
                            </tbody>
                          </table>
                        </div>
                        <!-- {!! $update_code->links() !!} -->
                        <footer class="panel-footer">
                            <div class="row">
                                <div class="pagination pagination-sm m-t-none m-b-none linkStyle">
                                     {!! $update_code->links() !!}
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
                          <th>结算季度</th>
                          <th>
                            <select class="input-sm form-control input-s-sm inline" id="yearSeason">
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
                            <select class="input-sm form-control input-s-sm inline" id="season">
                                  <option value="1" >第一季度</option>
                                  <option value="2" >第二季度</option>
                                  <option value="3" >第三季度</option>
                                  <option value="4" >第四季度</option>
                            </select>
                          </th> 
                        </tr> 
                       <!--  <tr style="display: none;" class="showTr">
                          <td class="showBonusType"></td>
                          <td class="showBonusAmount"></td>
                        </tr>   -->                 
                    </table>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                  <button type="button" class="btn btn-default" id="countSeasonSub">结算</button>
                </div>
              </div>
            </div>
          </div>
<script type="text/javascript">

    $(document).ready(function(){
        $('#searchstore').change(function(event) {
            var month = $('#month').val();
            var year = $('#year').val();
            var store_code = $('#searchstore').val();
            window.location.href = '/search/count_all/store_code-'+year+'-'+month;
        });
        $('#year').change(function(event) {
            var month = $('#month').val();
            var year = $('#year').val();
            var store_code = $('#searchstore').val();
            window.location.href = '/search/count_all/store_code-'+year+'-'+month;
            
        });
        $('#month').change(function(event) {
            var month = $('#month').val();
            var year = $('#year').val();
            var store_code = $('#searchstore').val();
            window.location.href = '/search/count_all/store_code-'+year+'-'+month;
        });
        $('#count').click(function(event) {
            var month = $('#month').val();
            var year = $('#year').val();
            var tips = '请确认结算'+year+'年'+month+'月！'
            if(confirm(tips)){
            $.get('/count/sub/'+year+'-'+month, function(data) {
                if(data.status == 1){
                    var msg = '结算成功,结算单号为['+data.data.update_code+']';
                    alert(msg);
                    // window.location.reload();
                    /*var tr = $("#table tbody tr").eq(0).clone(true);
                    $(tr).find('td').eq(0).text(data.data.update_code);
                    $(tr).find('td').eq(1).text(data.data.date);
                    tr.appendTo("#table tbody");*/
                }else{
                    alert("网络问题，结算失败");
                    // window.location.reload();
                }
            });
          }
        }); 
      $('#countSeasonSub').click(function(){
        var year = $('#yearSeason').val();
        var season = $('#season').val();
        var seasonText = $('#season').children('option:selected').text();
        var tips = '请确认结算'+year+'年'+seasonText+'！';
        if(confirm(tips)){
            $.get('/count/sub_season/'+year+'-'+season, function(data) {
                if(data.status == 1){
                    var msg = '结算成功,结算单号为['+data.data.update_code[0]+'],['+data.data.update_code[1]+'],['+data.data.update_code[1]+']';
                    alert(msg);
                    window.location.reload();
                }else{
                    alert("网络问题，结算失败");
                    window.location.reload();
                }
            });
          }
      })
    });
    /*职位调整*/
    $('#autoPositionAdjustment').click(function(){
      $.get("{{url('/crontab')}}/locqj/159753",function(result){
        if(result == "done\nfinish"){
          alert('调整成功');
        }else{
          alert('网络问题，调整失败');
        }
      });
    })
</script>
@endsection