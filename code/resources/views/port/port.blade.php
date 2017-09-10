@extends('layouts.nav')
@section('content')
<section class="vbox">
                    <section class="scrollable padder">
                      <marquee direction=left class="headerMarquee">欢迎使用xxx房产记账结算管理系统！</marquee>
                      <ul class="breadcrumb no-border no-radius b-b b-light pull-in">
                        <li><i class="fa fa-home"></i> 主页</li>
                        <li class="active">端口管理</li>
                      </ul>
                      <section class="panel panel-default">
                        <div class="table-responsive" >
                          <table class="headerStyle">
                            <tr>
                                <th class="headertitle" data-toggle="class">
                                端口管理表
                                </th>
                                <th>
                                    <div data-toggle="buttons">
                                        <label class="btn btn-sm btn-default timeStyle">
                                            <input type="radio" name="options" id="option1">
                                            共计
                                        </label>
                                        <label class="btn btn-sm btn-default">
                                            <input type="radio" name="options" id="option2" >
                                            <span id="conunt_num">{{ count($ports) }}个端口</span>
                                        </label>
                                    </div>
                                </th>
                                <th>
                                @if(in_array(session::get('level_code'), ['cw', 'dz','zl']))
                                  <button  id="count" class="btn btn-sm btn-default addNew" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';" data-toggle="modal" data-target="#myModal" onclick="addPort();">添加端口</button>
                                @endif
                                </th>
                            </tr>
                          </table>

                        <table class="table table-striped b-t b-light text-sm headerStyle2">         
                              <tr>
                                <th>
                                  <label class="labelStyle">查找店铺&nbsp;&nbsp;</label>
                                  <select class="input-sm form-control input-s-sm inline" id="searchstore" disabled="disabled">
                                    <option value="all">所有</option>
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
                                    <label class="labelStyle">查找员工&nbsp;&nbsp;</label>
                                    <select class="input-sm form-control input-s-sm inline" id="searchemployee">
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
                                    <label class="labelStyle portTimeStyle">年 / 月&nbsp;&nbsp;</label>  
                                    <select class="input-sm form-control input-s-sm inline" id="year">
                                        <option value="{{$year}}">{{$year}}</option>
                                          @for($i = $pay_year_start; $i <= $pay_year_end; $i++)
                                            @if($i != $year)
                                              <option value="{{$i}}">{{$i}}</option>
                                           @endif
                                          @endfor
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
                          <table class="table table-striped b-t b-light text-sm" id="table">
                            <thead>
                              <tr>
                                <th>所属店铺</th>
                                <th>端口号</th>
                                <th>使用者</th>
                                <th>平台</th>
                                <th>偿还费用</th>
                                <th>偿还月份</th>
                                <th>偿还期限</th>
                                <th>每期费用</th>
                                <th>是否算入工资</th>
                                <th>操作</th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach($ports as $list)
                                <tr>
                                    <td>{{ $list->store->name }}</td>
                                    <td>{{ $list->port_number }}</td>
                                    <td>@if(isset($list->employee->name)) {{ $list->employee->name }} @else 未绑定@endif</td>                      
                                    <td>{{ $list->port_place }}</td> 
                                    <td>{{ $list->amount }}</td>
                                    <td><button class="btn btn-sm btn-default detailShow operate" value="{{$list->pay_month}}"  data-toggle="modal" data-target="#payDetils" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';">查看详情</button></td>
                                    <td>{{ $list->length }}</td>
                                    <td>{{ $list->unit }}</td>
                                    <td>@if($list->is_personal) 是 @else 否 @endif</td>
                                    @if(in_array(session::get('level_code'), ['cw']))
                                    <td>
                                        <button class="btn btn-sm btn-default operate" id="editPort" data-toggle="modal" data-target="#editChange" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';" onclick="editPortFunction('{{$list->employee_code}}', '{{$list->id}}', '{{$list->is_personal}}')">调整端口</button>
                                        <button class="btn btn-sm btn-default operate deleteColor" onclick="del('{{ $list->id }}', '{{ $list->port_number }}')" onmouseover="this.style.backgroundColor='#fb6b5b'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#fb6b5b';this.style.color = 'white';">删除</button>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                          </table>
                        </div>
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="label_model">端口管理</h4>
                              </div>
                              <div class="modal-body">
                                <div class="table-responsive">
                                <table class="table table-striped b-t b-light text-sm" id="table">
                                    <tr>
                                        <td>所属店铺</td>
                                        <input type="hidden" value="" id="store_code">
                                        <input type="hidden" value="add" id="set_id">
                                        <td id="store_code_text"></td>
                                    </tr>
                                    <tr>
                                        <td>端口号</td>
                                        <td><input type="text" value="" id="port_number"></td>
                                    </tr>      
                                    <tr>                      
                                        <td>平台</td>
                                        <td>
                                           <input type="text" value="" id="port_place">
                                        </td>
                                    </tr>
                                   <!--  <tr>                      
                                        <td>使用者</td>
                                        <td>
                                            <select class="input-sm form-control input-s-sm inline" id="employee_code">
                                            
                                            </select>
                                        </td>
                                    </tr> -->
                                    <tr>                      
                                        <td>偿还费用</td>
                                        <td><input type="number" min="0" value="" id="amount"></td>
                                    </tr>
                                    <tr>                      
                                        <td>开始偿还年月</td>
                                        <td><input type="month" value="" id="sign_date"></td>
                                    </tr>
                                    <tr>                      
                                        <td>偿还期数</td>
                                        <td><input type="number" min="0" value="" id="period"></td>
                                    </tr>
                                    <tr>                      
                                        <td>备注</td>
                                        <td>
                                            <textarea id="remark" style="resize:none"></textarea>
                                        </td>
                                    </tr>
                                </table>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <div id="info_error" style="text-align:left;color:red;font-size:16px"></div>
                                <button type="button" class="btn btn-default" data-dismiss="modal" id="cancel">
                                    关闭
                                </button>
                                <button type="button" class="btn btn-default" id="sub_Btn" name="">
                                    保存
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>
                        
                        <!-- 调整端口 -->
                        <div class="modal fade" id="editChange" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="label_model">端口调整</h4>
                              </div>
                              <div class="modal-body">
                                <div class="table-responsive">
                                <table class="table table-striped b-t b-light text-sm" id="table">
                                    <tr>
                                        <td>所属店铺</td>
                                        <td>
                                        <input type="hidden" id="editId">
                                        <option value="" style="display: none;" id="clone_class"></option>
                                            <select class="input-sm form-control input-s-sm inline" id="editStoreBelong">
                                                 @foreach($store as $s)
                                                    @if ($store_code == $s->code)
                                                        <option value="{{ $s->code }}" selected>{{ $s->name }}</option>
                                                    @else
                                                        <option value="{{ $s->code }}" >{{ $s->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>                      
                                        <td>使用者</td>
                                        <td>
                                            <select class="input-sm form-control input-s-sm inline" id="editEmployeeBelong">
                                            
                                            </select>
                                        </td>
                                    </tr>
                                    <tr id="isPersonalTr" style="display: none;">                      
                                        <td>是否算入工资</td>
                                        <td>
                                            <select class="input-sm form-control input-s-sm inline" id="editIsPersonal">
                                                <option value="0" id="personal0" class="isPersonalOpt">否</option>
                                                <option value="1" id="personal1" class="isPersonalOpt">是</option>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <div id="err_Msg" style="text-align:left;color:red;font-size:16px"></div>
                                <button type="button" class="btn btn-default" data-dismiss="modal" id="cancel">
                                    关闭
                                </button>
                                <button type="button" class="btn btn-default" id="editSub">
                                    保存
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- 调整端口 -->
                        <!-- 显示详情弹框 -->
                         <div class="modal fade" id="payDetils" tabindex="-1" role="dialog" aria-labelledby="mypayDetils">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">查看详情</h4>
                              </div>
                                 <div>
                                    <table class="table" id="detailTable">                
                                      
                                    </table>  
                                  </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                              </div>
                              </div>
                              
                            </div>
                          </div>
                        <!-- 显示详情弹框 -->
                        <footer class="panel-footer">
                            <div class="row">
                                <div class="pagination pagination-sm m-t-none m-b-none linkStyle">
                                     {{$ports->links()}}
                                </div>
                            </div>
                       </footer>
                      </section>
                    </section>
                     <div class="copyRight">
                        <div>版权所有: © locqj
                        </div>
                      </div>
                  </section>
                  
<script type="text/javascript">
    /*添加端口*/
    function addPort(){
        var store_code = $('#searchstore').val();
        var store_name = $('#searchstore option[value='+store_code+']').text(); //找到select对应的text
        $('#store_code_text').text(store_name);
        $('#store_code').val(store_code);
    }

    /*端口调整*/
    function editPortFunction(employee_code, id, is_personal){
        if(employee_code){
            $('#isPersonalTr').show();
        }
        $('.isPersonalOpt').removeAttr('selected');
        $('#personal'+is_personal).prop('selected', 'selected');
        $('#editId').val(id);
        diffEmployee(employee_code);
    }
    /*选择店铺*/
    $('#editStoreBelong').change(function(){
        diffEmployee();
    })
    $('#editEmployeeBelong').change(function(){
        if($(this).val() != 0){
            $('#isPersonalTr').show();
        }else{
            $('#isPersonalTr').hide();
        }
    })
    function diffEmployee(employee_code = null){
        $('#editEmployeeBelong option[id=clone_class]').remove(); //克隆前把之前的清除掉
        var store_code = $('#editStoreBelong').val();
        $.get("/getemployee/"+store_code,
            function(data) {
                if(data.status == 1){
                    var clone_class = $('#clone_class');
                    var cl = clone_class.clone(true);
                    $(cl).attr('value', 0);
                    $(cl).text('请选择');
                    $(cl).show();
                    $('#editEmployeeBelong').append(cl);
                    $.each(data.data, function(key, val) {
                        /*alert(val.month);*/
                        var clo = clone_class.clone(true);
                        var code = val.employee_code;
                        $(clo).attr('value', code);
                        $(clo).text(val.employee.name);
                        if(code == employee_code){
                            $(clo).attr('selected', 'selected');
                            $('#isPersonalTr').show();
                            $('.isPersonalOpt').removeAttr('selected');
                        }else{
                            $('#isPersonalTr').hide();
                            $('.isPersonalOpt').removeAttr('selected');
                        }
                        $(clo).show();
                        $('#editEmployeeBelong').append(clo);

                    });
                }
        });
    }
    /*编辑提交*/
    $('#editSub').click(function(){
        var is_personal = $('#editIsPersonal').val();
        var store_code = $('#editStoreBelong').val();
        var employee_code = $('#editEmployeeBelong').val();
        var id = $('#editId').val();
        $.post('/port/change', {id:id, store_code:store_code, employee_code:employee_code, is_personal:is_personal}, function(result){
            if(result.status == 1){
                window.location.reload(true);
            }else{
                $('#err_Msg').text(result.msg);
            }
        })
    })

    $(".detailShow").click(function(){
        $('.detailTr').hide();
        var content = $(this).val();
        $("#detailTable").append(content);
    }) 
    
    function del(id, port_number){
        if(confirm("确定删除端口号为["+port_number+"]的端口吗？")){
            $.get('/del/port/'+id, function(data) {
                if(data.status == 1){
                    alert('删除成功');
                    window.location.reload();
                }else{
                    alret(data.msg);
                    window.location.reload();
                }
            });   
        }
    }

    $(document).ready(function(){
        /*提交*/
        $('#sub_Btn').click(function(event) {

            var port_place = $('#port_place').val();
            var port_number = $('#port_number').val();
            var store_code = $('#store_code').val();
            var sign_date = $('#sign_date').val();
            var period = $('#period').val();
            // var employee_code = $('#employee_code').val();
            var amount = $('#amount').val();
            var remark = $('#remark').val();
            var id = $('#set_id').val();
            if(!port_number || !port_place || !sign_date || !period || !amount) {
                $('#info_error').text('信息不全！');
            }else if (amount < 0) {
                $('#info_error').text('偿还费用不得小于0');
            }else if(period < 0) {
                $('#info_error').text('偿还期数不得小于0');
            }else{
                $.post('/port/sub', 
                    {
                        id: id,
                        port_number: port_number,
                        port_place: port_place,
                        store_code: store_code,
                        sign_date: sign_date,
                        period: period,
                        amount: amount,
                        remark: remark
                    }, 
                    function(data, textStatus, xhr) {
                        if(data.status == 1){
                            alert("添加成功！");
                            window.location.reload();
                        }else{
                            alert(data.msg);
                            window.location.reload();
                        }
                });
            }

        });

        $('input').click(function(event) {
            $('#info_error').text("");
        });

        function selectSearch(){
            var month = $('#month').val();
            var year = $('#year').val();
            var store_code = $('#searchstore').val();
            var employee_code = $('#searchemployee').val();
            var end_month = $('#end_month').val();
            window.location.href = '/search/port/'+store_code+'-'+year+'-'+month+'-'+employee_code;
        }

        $('#searchstore').change(function(event) {
            selectSearch();
        });
        $('#searchemployee').change(function(event) {
            selectSearch();
        });
        $('#year').change(function(event) {
            selectSearch();
            
        });
        $('#month').change(function(event) {
            selectSearch();
        });
         
    });
</script>
@endsection