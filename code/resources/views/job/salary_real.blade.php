@extends('layouts.nav')

@section('content')
<section class="vbox">
<section class="scrollable padder">
  <ul class="breadcrumb no-border no-radius b-b b-light pull-in">
    <li><i class="fa fa-home"></i> 主页</li>
    <li class="active">工资发放记录</li>
  </ul>
  <section class="panel panel-default">
   <div class="table-responsive" >
        <table class="headerStyle">
            <tr>
                <th class="headertitle" data-toggle="class">
                    工资发放记录表
                </th>
            </tr>
        </table>
        <table class="table table-striped b-t b-light text-sm headerStyle2">
                  <tr>
                    <th>
                    <label class="labelStyle">查找店铺&nbsp;&nbsp;</label>
                        <select class="input-sm form-control input-s-sm inline" id="searchstore" disabled>
                            @foreach($store as $s)
                                @if ($store_code == $s->code)
                                    <option value="{{ $s->code }}" selected>{{ $s->name }}</option>
                                @else
                                    <option value="{{ $s->code }}" >{{ $s->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </th>
                    <th>
                    <label class="labelStyle realTimeStyle">查找员工&nbsp;&nbsp;</label>
                    <select class="input-sm form-control input-s-sm inline" id="searchemployee">
                        @if(Session('level_code') == 'xs' || Session('level_code') == 'dz' || Session('level_code') == 'zl'))
                            <option value="{{ $employee_code }}" selected>{{ Session::get('username') }}</option>
                        @else
                            @foreach($get_employee as $employee)
                                @if($employee_code == $employee->employee->code)
                                    <option value="{{ $employee->employee->code }}" selected>{{ $employee->employee->name }}</option>
                                @else
                                    <option value="{{ $employee->employee->code }}">{{ $employee->employee->name }}</option>
                                @endif
                            @endforeach
                            @if($employee_code == 'all')
                                <option value="all" selected>所有</option>
                            @else
                                <option value="all">所有</option>
                            @endif
                        @endif
                    </select>
                    </th>
                    <th>
                        <label class="labelStyle realTimeStyle">年 / 月&nbsp;&nbsp;</label>
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
                  </tr>
        </table>
    </div>
    <div class="table-responsive">
      <table class="table table-striped b-t b-light text-sm">
        <thead>
          <tr>
            <th>所属店铺</th>
            <th>姓名</th>
            <th>职位</th>
            <th>年/月</th>
            <th>基本工资</th>
            <th>扣除工资</th>
            <th>利润分红</th>
            @if($store_code != 'hj001')
            <th>销售提成</th>
            @else
            <th>过户提成</th>
            @endif
            <th>规则详情</th>
            <th>总计</th>
            <th>实发工资</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
          @foreach($salary_list as $list)
          <tr>
            <td class="store_name">{{ $list['store_name'] }}</td>
            <td class="employee_name">{{ $list['employee_name'] }}</td>
            <td class="position_name">{{ $list['position_name'] }}【{{ $list['position_tag'] }}】</td>
            <td class="date">{{ $list['year'] }}-{{ $list['month'] }}</td>
            <td class="salary">{{ $list['salary'] }}</td>
            <td class="reduce_salary">{{ $list['reduce_salary'] }}</td>
            <td class="dividend">{{ $list['dividend'] }}</td>
            @if($store_code != 'hj001')
            <td class="bonus">{{ $list['bonus'] }}</td>
            @else
            <td class="bouns_details">{{ $list['transfer'] }}</td>
            @endif
            <td><button class="btn btn-sm btn-default operate" @if(in_array(substr($list['position_code'], 0, 2), ['xs', 'dz', 'zl', 'jl', 'qy']))
                onclick="rules_details('{{ $list['employee_name'] }}','{{ $list['employee_code'] }}','{{ $list['position_code'] }}')"  onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';" data-toggle="modal" data-target="#rulesModal"
                @else onclick="return alert('该职位无规则!')" @endif)>规则详情</button></td>
            <td class="">{{ $list['amount'] }}</td>
            <td class="real_salary">{{ $list['real_salary'] }}</td>
            <td>
                <button class="btn btn-sm btn-default operate" data-toggle="modal" data-target="#releaseRecord" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';" onclick="checkRealSalary('{{ $list['employee_code'] }}', '{{ $list['employee_name'] }}')">发放记录</button>
                @if(Session::get('level_code') == 'cw')
                <button class="btn btn-sm btn-default operate" data-toggle="modal" data-target="#releaseWage" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';" onclick="addRealSalary('{{ $list['employee_code'] }}', '{{ $list['employee_name'] }}')">发放工资</button>
                @endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <footer class="panel-footer">
    <!--克隆用的-->
    <option value="" id="clone_class" style="display: none;"></option>
    <div class="row">  
        <div class="pagination pagination-sm m-t-none m-b-none linkStyle">
             {{ $paginator->links() }}
        </div>
    </div>
</footer>   
    
    <!-- 发放记录弹出框 -->
    <div class="modal fade" id="releaseRecord" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">发放记录</h4>
            </div>
            <div class="modal-body">
                
              <div style="font-size:16px">&nbsp;&nbsp;&nbsp;姓名:<span id="check_name"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              工号&nbsp;&nbsp;<span id="check_code"></span></div>
              <div class="table-responsive">
                <table class="table" id="table_list">
                    <thead>
                        <tr>  
                            <th>年/月</th>
                            <th>金额</th>
                            <th>状态</th>
                            <th>发放时间</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="clone_tr" style="display: none;">                     
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                @if(Session::get('level_code') == 'cw')
                                    <button class="sub_del btn btn-sm btn-default operate deleteColor">删除</button>
                                @endif
                            </td>
                        </tr>
                        
                    </tbody>
                </table>
              </div>
            </div>
            <div class="modal-footer">
                <div id="err_Msg" class="modalFooterstyle"></div>
              <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
          </div>
        </div>
      </div>
      <!-- end发放记录弹出框 -->
      <!-- 签单详情弹出框 -->
        <div class="modal fade" id="rulesModal" tabindex="-1" role="dialog" aria-labelledby="rulesModal">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">规则详情</h4>
                </div>
                <div class="modal-body">

                  <div style="font-size:16px">&nbsp;&nbsp;&nbsp;姓名:<span id="check_name_rules"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  工号&nbsp;&nbsp;<span id="check_code_rules"></span></div>
                  <div class="table-responsive">
                    <table class="table" id="table_list_rules">
                        <thead>
                            <tr>
                                <th>规则</th>
                                <th>规则比例</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="rule_clone_tr" style="display: none;">                     
                                <td></td>
                                <td></td>
                            </tr>
                            
                        </tbody>
                    </table>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                </div>
              </div>
            </div>
          </div>
      <!-- end签单详情弹出框 -->

      <!-- 发放工资 -->
      <div class="modal fade" id="releaseWage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="addLabel"></h4>
              </div>
              <div class="modal-body">
                <div class="table-responsive">
                <table class="table table-striped b-t b-light text-sm">      
                <tr>                      
                    <td>姓名</td>
                    <td>
                        <label id="employee_name"></label>
                    </td>
                </tr>

                <tr>                      
                    <td>工号</td>
                    <td>
                        <label id="employee_code"></label>
                    </td>
                </tr>
                <tr>                      
                    <td>年/月</td>
                    <td>
                        <input value="" id="date" type="text" disabled="">
                    </td>           
                </tr>
                <tr>                      
                    <td>金额</td>
                    <td><input value="" id="amount" type="number"></td>
                </tr>
                </table>
                </div>
              </div>
              <div class="modal-footer">
                <div id="info_error" class="modalFooterstyle"></div>
                <button type="button" class="btn btn-default" data-dismiss="modal" id="cancel">
                    关闭
                </button>
                <button type="button" class="btn btn-default" id="sub_btn" name="">
                    保存
                </button>
              </div>
            </div>
          </div>
        </div>
        <!-- end发放工资 -->
        
  </section>
</section>
<div class="copyRight">
    <div >版权所有: © locqj
    </div>
</div>
</section>
<script>
    $(document).ready(function(){
        $('#searchstore').change(function(event) {
            var month = $('#month').val();
            var year = $('#year').val();
            //var employee_code = $('#searchemployee').val();
            var store_code = $('#searchstore').val();
            window.location.href = '/search/salary_real/'+store_code+'-'+year+'-'+month+'-all';
        });
        $('#year').change(function(event) {
            var month = $('#month').val();
            var year = $('#year').val();
            var store_code = $('#searchstore').val();
            var employee_code = $('#searchemployee').val();
            window.location.href = '/search/salary_real/'+store_code+'-'+year+'-'+month+'-'+employee_code;
            
        });
        $('#month').change(function(event) {
            var month = $('#month').val();
            var year = $('#year').val();
            var store_code = $('#searchstore').val();
            var employee_code = $('#searchemployee').val();
            window.location.href = '/search/salary_real/'+store_code+'-'+year+'-'+month+'-'+employee_code;
        });
        $('#searchemployee').change(function(event) {
            var store_code = $('#searchstore').val();
            var month = $('#month').val();
            var year = $('#year').val();
            var employee_code = $('#searchemployee').val();
            if(employee == 0){
                var employee = 'all';
            }else{
                window.location.href = '/search/salary_real/'+store_code+'-'+year+'-'+month+'-'+employee_code;
            }
        });
        $('#sub_btn').click(function(event) {
            var month = $('#month').val();
            var year = $('#year').val();
            var employee_code = $('#employee_code').text();
            var amount = parseFloat($('#amount').val());

            if(!amount){
                $('#info_error').text('请输入金额');
            }else if(amount < 0){
                $('#info_error').text('金额格式错误');
            }else{
                $.post("{{ route('realsalary.store') }}", 
                    {
                        month: month,
                        year: year,
                        employee_code: employee_code,
                        amount: amount,
                        reduce_amount: 0
                    }, function(data, textStatus, xhr) {
                        if(data.status == 1){
                            alert('添加成功');
                            window.location.reload();
                        }else{
                            alert('添加错误，请重新添加');
                            window.location.reload();
                        }
                });
            }
            
        });
        $('.sub_del').click(function(event) {
            var get_id = $(this).parents('td').attr('class');
            get_id = get_id.substr(2);
            if(confirm('是否删除该条记录')){
                $.get('/realsalary/'+get_id+'/edit', function(data) {
                     if(data.status == 1){
                        alert('删除成功');
                        window.location.reload();
                     }
                 }); 
            }
        });
        $('#amount').click(function(event) {
           $('#info_error').text("");
        });
    });
    /*确认薪水发放*/
   function salaryConfirm(id, amount){
        var employee_code = $('#check_code').text();
        var info = '确认您已收到'+amount+'元？';
        if(confirm(info)){
            $.post("{{url('/realsalary/salaryconfirm')}}", {id:id, employee_code:employee_code}, function(result){
                if(result.status == 1){
                    window.location.reload(true);
                }else{
                    $('#err_Msg').text(result.msg);
                }
            })
        }
    }
    /*查看实际薪水*/
    function checkRealSalary(employee_code, employee_name){
        $('#err_Msg').text('');
        $('#check_code').text(employee_code);
        $('#check_name').text(employee_name);
        var month = $('#month').val();
        var year = $('#year').val();
        $.post('/realsalary/details',
            {
                year: year,
                month: month,
                employee_code: employee_code
            }, function(data) {
                if(data.status == 1){
                    var d_length = data.data.length;
                    $("#table_list tbody #clone_tr").remove();
                    var clone_tr = $('.clone_tr');
                    $.each(data.data, function(index, val) {
                        
                        var tr = clone_tr.clone(true);
                        var msg = val.year+'-'+val.month;
                        $(tr).attr('id', 'clone_tr');
                        $(tr).find('td').eq(0).text(msg);
                        // $(tr).find('td').eq(1).text("发放");
                        $(tr).find('td').eq(1).text(val.amount);
                        if(val.is_confirm){
                             tr.find('td').eq(2).append('<span>已确认</span>');
                        }else if(!val.confirm){
                            tr.find('td').eq(2).append('<span>未确认</span>');
                        }
                        $(tr).find('td').eq(3).text(val.created_at);
                        $(tr).find('td').eq(4).attr('class', 'cc'+val.id);
                        var salaryConfirm = '<button class="btn btn-sm btn-default operate" onclick="salaryConfirm(' + val.id +','+ val.amount+');">已收到</button>';
                        if(employee_code == "{{session('employee_code')}}" && !val.is_confirm){
                            tr.find('td').eq(4).append(salaryConfirm);
                        }
                        $(tr).show();
                        if(index < d_length){
                            tr.appendTo('#table_list tbody');
                        }
                        //$("#table_list tbody").append(clo);
                    });
                }
        });
    }
    /*添加实际薪水*/
    function addRealSalary(employee_code, employee_name){
        $('#amount').val("");
        $('#info_error').text("");
        $('#employee_name').text(employee_name);
        $('#employee_code').text(employee_code);
        $('#addLabel').text('发放添加');
        var month = $('#month').val();
        var year = $('#year').val();
        var msg = year+'-'+month;
        $('#date').val(msg);

    }

    function rules_details(employee_name, employee_code, position_code){
        $('#check_name_rules').text(employee_name);
        $('#check_code_rules').text(employee_code);
        $.ajax({
            type: "get",
            url: "/realsalary/getrules/"+position_code,
            success: function (response) {
                $('#table_list_rules tbody #clone_tr').remove();
                
                var d_length = response['data']['get_bonus_rule'].length;
                
                if(response['status'] == 1){
                    if(response['data']['get_position_key'] != 'xs'){
                        var clone_tr = $('.rule_clone_tr');
                        var tr = clone_tr.clone(true);
                        $(tr).attr('id', 'clone_tr');
                        $(tr).find('td').eq(0).text("分红规则");
                        $(tr).find('td').eq(1).text(response['data']['get_bonus_rule'][0]['percentage']);
                        $(tr).show();
                        tr.appendTo('#table_list_rules tbody');
                    }else{
                        $.each(response['data']['get_bonus_rule'], function(index, val) {
                            var clone_tr = $('.rule_clone_tr');

                            var tr = clone_tr.clone(true);
                            $(tr).attr('id', 'clone_tr');
                            $(tr).removeAttr('class');
                            var msg = "下线："+val.bottom+", 上线："+val.top;
                            $(tr).find('td').eq(0).text(msg);
                            $(tr).find('td').eq(1).text(val.percentage);
                            $(tr).show();
                            if(index < d_length){
                                tr.appendTo('#table_list_rules tbody');
                            }
                        
                        });
                    }
                }
            }
        });
    }
</script>
@endsection