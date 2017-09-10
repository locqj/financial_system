@extends('layouts.nav')

@section('content')
<section class="vbox">
<section class="scrollable padder">
<marquee direction=left class="headerMarquee">欢迎使用xxx房产记账结算管理系统！</marquee>
<ul class="breadcrumb no-border no-radius b-b b-light pull-in">
  <li><i class="fa fa-home"></i> 主页</li>
  <li class="active">过户记录</li>
</ul>
<section class="panel panel-default"> 
     <div class="table-responsive" >
        <table class="headerStyle">
            <tr>
                <th class="headertitle" data-toggle="class">
                过户记录
                </th>
                <!-- @if ($contract_count != 0)
                <th>
                  <button class="btn btn-sm btn-default addNew" data-toggle="modal" data-target="#myModal" onclick="addTransfer('{{ $store_code }}')" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';">添加过户单
                  </button>
                </th>
                @else
                <th>
                  <button class="btn btn-sm btn-default addNew" id="no_contract" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';">无可过户签单
                  </button>
                </th>
                @endif -->
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
                <label class="labelStyle">季度查询&nbsp;&nbsp;</label>
                <select class="input-sm form-control input-s-sm inline" id="season_year">
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
                <select class="input-sm form-control input-s-sm inline" id="searchseason">
                    <option value="0">请选择</option>
                    <option value="1">第一季度</option>
                    <option value="2">第二季度</option>
                    <option value="3">第三季度</option>
                    <option value="4">第四季度</option>
                    
                </select>
            </th>
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
          </tr>
        </table> 
        </div>
        <div class="table-responsive">   
        <table class="table table-striped b-t b-light text-sm">
            <thead>
                <tr>
                    <th>过户店铺</th>
                    <th>过户人员</th>
                    <th>年</th>
                    <th>月</th>
                    <th>过户单号</th>
                    <th>过户费用</th>
                    <th>过户日期</th>
                    <!-- <th>操作</th> -->
                </tr>
            </thead>
            <tbody>
                @foreach($transfer as $list)
                <tr id="t{{ $list->id }}">                      
                  <td class="store_code">{{ $list->store->name }}</td> 
                  <td class="employee_name">{{ $list->employee->name }}</td> 
                  <td>{{ $list->year }}</td>
                  <td>{{ $list->month }}</td>
                  <td class="contract_number">{{ $list->contract_number }}</td>  
                  <td class="amount">{{ $list->amount }}</td> 
                  <td class="date">{{ $list->year}}-{{ $list->month }}-{{ $list->day }}</td> 
                 <!--  <td>
                    <button type="button" class="btn btn-sm btn-default operate" data-toggle="modal" data-target="#myModal" onclick="update('{{ $list->id }}');" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';">修改</button>
                    <button class="btn btn-sm btn-default operate deleteColor"   onclick="del('{{ $list->id }}', '{{ $list->contract_number }}')" onmouseover="this.style.backgroundColor='#fb6b5b'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#fb6b5b';this.style.color = 'white';">删除</button>
                  </td>    -->               
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <footer class="panel-footer headerStyle2">
        <option value="" id="clone_class" style="display: none;"></option>
        <div class="pagination pagination-sm m-t-none m-b-none linkStyle ">
                 {!! $transfer->links() !!}
        </div>    
    
    </footer>
</section>
</section>
<div class="copyRight">
    <div >版权所有: © locqj
    </div>
</div>
</section>
            <!-- Modal添加新过户单弹出框 -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" >
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">添加新过户单</h4>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
                <table class="table table-striped b-t b-light text-sm" id="table">                
                    <tr>                      
                      <td>过户专员</td>
                      <td>
                        <select class="input-sm form-control input-s-sm inline" id="employee_code">
                                <!-- <option value="0">请选择</option> -->
                                @foreach($guohus as $guohu)
                                    <option value="{{ $guohu->employee_code }}">
                                        {{ $guohu->employee->name }}
                                    </option>
                                @endforeach                                            
                        </select>
                      </td>   
                    </tr>                 
                    <!-- <tr>                     
                      <td class="td4">员工编号</td>
                      <td><input type="text" value="" class="i3" id="employee_code"></td>
                    </tr> -->
                    <tr>                      
                      <td>过户店铺</td>
                      <td>
                        <select class="input-sm form-control input-s-sm inline" id="store_code">
                            <option value="0">请选择</option>
                            @foreach($store as $list)
                                <option value="{{ $list->code }}">
                                    {{ $list->name }}
                                </option>
                            @endforeach                                            
                        </select>
                      </td>
                    </tr>
                    <tr>                      
                      <td>过户单号[即为签单号]</td>
                      <td>
                        <select class="input-sm form-control input-s-sm inline" id="contract_number">
                             <option value="0" id="contract_0">请选择</option>                   
                        </select>
                      </td>
                    </tr>
                    <tr>                      
                      <td>过户费用</td>
                      <td><input type="number" value="" id="amount"></td>
                    </tr>
                   <tr>                      
                      <td>过户日期</td>
                      <td><input type="date" value="" id="transfer_date"></td>
                    </tr>
                    <input type="hidden" value="" id="get_id"> 
                </table>
              </div>
      </div>
      <div class="modal-footer">
        <div id="info_error" class="modalFooterstyle"></div>
        <!--select clone-->

        <!--select clone-->
        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="cancel();">关闭</button>
        <button type="button" class="btn btn-default" onclick="sub();"  id="sub">保存</button>

      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
    /*修改过户记录*/
    function update(id){
        $('#info_error').text("");
        $('#employee_code #clone_class').remove();
        $('#myModalLabel').text('修改过户记录');
        $('#contract_number').attr('disabled', 'disabled');
        $.get(" /transfer/"+id, function(data) {
            if(data.status == 1){
                getContractNum(1, data.data.store_code);
                var clone_class = $('#clone_class');
                var first_clone = clone_class.clone(true);
                $(first_clone).attr('value', data.data.contract_number);
                $(first_clone).text(data.data.contract_number);
                $(first_clone).show();
                $('#contract_number').append(first_clone);
                $.each($('#employee_code option'), function(index, val) {
                     if($(this).val() != data.data.employee.code){
                        var clone_class = $('#clone_class');
                        var first_clone = clone_class.clone(true);
                        $(first_clone).attr('value', data.data.employee.code);
                        $(first_clone).text(data.data.employee.name);
                        $(first_clone).show();
                        $('#employee_code').append(first_clone);
                        return false;
                     }
                });
                $('#employee_code').val(data.data.employee.code);
                $('#store_code').val(data.data.store_code);
                $('#contract_number').val(data.data.contract_number);
                /*$.each($('#employee_code option'), function(index, val) {
                    if($(this).val() == data.data.employee.code){
                        $(this).attr('selected', true);
                    }
                });*/
                /*$.each($('#store_code option'), function(index, val) {
                    if($(this).val() == data.data.store_code){
                        $(this).attr('selected', true);
                    }
                });*/
                /*$.each($('#contract_number option'), function(index, val) {
                    if($(this).val() == 0){
                        $(this).attr('selected', true);
                        $(this).val(data.data.contract_number);
                        $(this).text(data.data.contract_number+"[当前单号]");
                    }
                });*/
                $("#store_code").attr("disabled","disabled");//禁用店铺选项
                //$('#contract_number').val(data.data.contract_number);
                $('#amount').val(data.data.amount);
                $('#transfer_date').val(data.data.date);
                $('#sub').text('修改');
                $('#get_id').val(id);
            }
        });
    }
    /*找指定店铺的订单号*/
    function getContractNum(status, store_code){
        if(status == 1){    
        $('#contract_number #clone_class').remove();
        $.get("{{ url('transfer/contractnum') }}/"+store_code, function(data) {
            if(data.status == 1){
                var clone_class = $('#clone_class');
                $.each(data.data, function(index, val) {
                    var clo = clone_class.clone(true);
                    var code = val;
                    $(clo).attr('value', code);
                    var name = val;
                    $(clo).text(name);
                    $(clo).show();
                    $('#contract_number').append(clo);
                });
            }
            
        });
        }
    }

    /*提交信息*/
    function sub(){
        var sub = $('#sub').text();
        var id = $('#get_id').val();
        var employee_code = $('#employee_code').val();
        var store_code = $('#store_code').val();
        var contract_number = $('#contract_number').val();
        var amount = $('#amount').val();
        var transfer_date = $('#transfer_date').val();
        if(employee_code == 0){
            $('#info_error').text('请选择过户专员');
        }
        else if(store_code == 0){
            $('#info_error').text('请选择店铺');
        }
        else if(contract_number == 0){
            $('#info_error').text('请选择过户签单');
        }
        else if(!amount){
            $('#info_error').text('请填写过户费用');
        }
        else if(amount < 0){
            $('#info_error').text('过户费用不得为负数');
        }
        else if(!transfer_date){
            $('#info_error').text('请选择过户日期');
        }
        else if(sub == '修改'){
            $.get('/transfer/'+id+'/edit', {
                employee_code: employee_code,
                contract_number: contract_number,
                amount: amount,
                transfer_date: transfer_date
            }, function(data) {
                if(data.status == 1){
                    alert('修改成功');
                    window.location.reload();//再议

                }else{
                    $('#info_error').text(data.msg);
                }
            });
        }else{
            $.post("{{ route('transfer.store') }}", 
                {
                    employee_code: employee_code,
                    store_code: store_code,
                    contract_number: contract_number,
                    amount: amount,
                    transfer_date: transfer_date
                }, function(data, textStatus, xhr) {
                    if(data.status == 1){
                        alert('添加成功');
                        window.location.reload();//再议                        
                    }else{
                        $('#info_error').text(data.msg);
                    }
            });
        }
    }

    /*点击添加过户单*/
    function addTransfer(store_code){
        /*遍历该店铺下面的未过户签单*/
        $('#info_error').text("");
        $('#contract_number').removeAttr('disabled');
        getContractNum(1, store_code);
        $('#employee_code #clone_class').remove();
        $("#employee_code option").removeAttr("selected"); //移除属性selected
        $("#contract_0").text('请选择'); //重置contract_number的value 0
        $("#contract_0").val(0);
        $.each($('#store_code option'), function(index, val) {
            if($(this).val() == store_code){
                $(this).attr('selected', true);
            }
        });
        //$("#store_code option:checked").attr("selected", "");
        //$("#store_code option").removeSelected();//禁用店铺选项
        $('#store_code').attr("disabled",true); //store_code的disbaled，锁定store_code
        $('#amount').val(""); 
        $('#transfer_date').val("");
    }
    /*过户删除*/
    function del(id, contract_number){
        if(confirm('确定要删除单号为['+contract_number+']的信息吗？')){
            $.get("/del/transfer/"+id,
                function(data, textStatus, xhr) {
                    if(data.status == '1'){
                        window.location.reload();
                    }
                    else{
                        alert('网络错误，请重试！');
                    }
            });
            return true;
        }
        return false;
    }

    $(document).ready(function(){
        $('#table tr td input').click(function(event) {
            $('#info_error').text("");
        });
        $('#table tr td select').change(function(event) {
            $('#info_error').text("");
        });
        /*搜索公司员工*/
        $('#searchstore').change(function(event) {
            var code = $('#searchstore').val(); //公司id
            if (code == 0)
                window.location.href = "/transfer";
            else
                window.location.href = "{{ url('searchstore') }}"+"/"+code+"/transfer";
        });

        $('#no_contract').click(function(event) {
            alert('请确认该店铺过户完成或无相应签单！');
        });
        
        $("#searchYear").change(function(){
            $("#searchMonth option").remove(); //请求前删除clone标签
            var year = $('#searchYear').val();
            if(year != 0){

                $.get("{{ url('searchmonth/transfer') }}", {
                    year: year
                },
                function(data) {
                    if(data.status == 1){
                        var clone_class = $('#clone_class');
                        /*月份联动*/
                        var cl = clone_class.clone(true);
                        $(cl).attr('value', 0);
                        $(cl).text('请输入');
                        $(cl).show();
                        $('#searchMonth').append(cl);
                        $.each(data.data, function(key, val) {
                            var clo = clone_class.clone(true);
                            var code = val.month;
                            var name = val.month;
                            $(clo).attr('value', code);
                            $(clo).text(name);
                            $(clo).show();
                            $('#searchMonth').append(clo);
                        });
                        $('#cSearchMonth').show();
                    }
                });
            }else{
                $('#cSearchMonth').hide();
            }
        });
        
        $('#searchstore').change(function(event) {
            var month = $('#month').val();
            var year = $('#year').val();
            var store_code = $('#searchstore').val();
            if(store_code == 'all'){
                window.location.href = '/transfer';
            }else{
                window.location.href = '/search/transfer/'+store_code+'-'+year+'-'+month;
            }
        });
        $('#year').change(function(event) {
            var month = $('#month').val();
            var year = $('#year').val();
            var store_code = $('#searchstore').val();
            window.location.href = '/search/transfer/'+store_code+'-'+year+'-'+month;
            
        });
        $('#month').change(function(event) {
            var month = $('#month').val();
            var year = $('#year').val();
            var store_code = $('#searchstore').val();
            window.location.href = '/search/transfer/'+store_code+'-'+year+'-'+month;
        });
        /*季度搜索*/
        $('#searchseason').change(function(event) {
            var season =$('#searchseason').val();
            var store_code = $('#searchstore').val();
            var season_year = $('#season_year').val();
            window.location.href = '/search/transfer/'+season+'/'+store_code+'/'+season_year;
        });
    });
</script>
@endsection

