@extends('layouts.nav')
@section('content')
<section class="vbox">
<section class="scrollable padder">
<ul class="breadcrumb no-border no-radius b-b b-light pull-in">
    <marquee direction=left class="headerMarquee">欢迎使用xxx房产记账结算管理系统！</marquee>
    <li><a href="index.html"><i class="fa fa-home"></i> 主页</a></li>
    <li class="active">员工管理</li>
</ul>

<section class="panel panel-default">
    <div class="table-responsive">
        <table class="headerStyle">
            <tr>
                <th class="headertitle" data-toggle="class">
                    员工管理表
                </th>
                @if(session::get('level_code') == 'cw')
                <th>
                    <option id="clone_class" value="" style="display: none;"></option>
                    <button class="btn btn-sm btn-default addNew" onclick="addEmployee('{{ $store_code }}')" data-toggle="modal" data-target="#myModal" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';">添加新员工</button>
                </th>
                @endif
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
                    <div data-toggle="buttons">
                        <label class="btn btn-sm btn-default timeStyle">
                            <input type="radio" name="options" id="option1">
                            公司总人数
                        </label>
                        <label class="btn btn-sm btn-default">
                            <input type="radio" name="options" id="option2" >
                            <span id="conunt_num">{{ $employee_count }}</span>
                        </label>
                      </div>
                </th>
            </tr>
        </table>
        </div>
        <div class="table-responsive">
            <table class="table table-striped b-t b-light text-sm" >
                <thead>
                    <tr>
                        <th>所属店铺</th>
                        <th>姓名</th>
                        <th>性别</th>
                        <th>员工编号</th>
                        <th>职位</th>
                        <!-- <th style="width:200px">职位编号</th> -->
                        <th>查看具体信息</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lists as $list)
                        <tr id="{{ $list->employee_code }}">                     
                            <td>{{ $list->store_name }}</td>
                            <td>{{ $list->employee->name }}</td>
                            <td>{{ $list->employee->sex }}</td>
                            <td>{{ $list->employee->code }}</td>
                            <td> {{ $list->position->name }}【{{ $list->position->position_tag }}】</td>
                            <td>
                            <button class="btn btn-sm btn-default operate" data-toggle="modal" data-target="#myModal" onclick="checkDetail('{{ $list->id }}')" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';">查看</button>
                            @if(Session::get('level_code') == 'cw')
                            <button type="button" class="btn btn-sm btn-default operate" data-toggle="modal" data-target="#myModal" onclick="changeEmployee('{{ $list->id }}', '{{ $list->store_code }}')" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';">
                                修改
                            </button>
                            <button class="btn btn-sm btn-default operate deleteColor" onclick="del('{{ $list->employee_code }}')" onmouseover="this.style.backgroundColor='#fb6b5b'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#fb6b5b';this.style.color = 'white';">删除</button>
                            @endif
                          </td>                    
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>

    <!--Modal员工弹出框-->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="label_model">员工修改</h4>
          </div>
          <div class="modal-body">
            <div class="table-responsive">
            <table class="table table-striped b-t b-light text-sm" id="table">
            <!-- <tr>
                      <td class="td4">店铺</td>
                      <td id="store_name" style="font-size: 16px;font-weight: bold;"></td>
                  </tr> -->      
            <tr>                      
                <td class="td4">员工姓名</td>
                <td><input type="text" value="" class="i3" id="employee_name"></td>
            </tr>

            <tr id="selectPosition_tr">                      
                <td class="td4">职位</td>
                <td id="sel_position">
                    <select class="input-sm form-control input-s-sm inline" id="selectPosition">
                        <option value="0">请选择</option>
                    </select>
                </td>
                <td style="display: none;" id="detail_position">
                    <input text="text" value="" class="i3">
                </td>
            </tr>

            <tr>                      
                <td class="td4">性别</td>
                <td>
                    <select class="input-sm form-control input-s-sm inline" id="selectSex" autocomplete="off">
                        <option>请选择</option>
                        <option value="0">男</option>
                        <option value="1">女</option>
                    </select>
                </td>           
            </tr>
            <tr>                      
                <td class="td4">手机号</td>
                <td><input type="text" class="i3" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" 
                maxlength="11" id="phone"/></td>
            </tr>
            <tr>                      
                <td class="td4">身份证号</td>
                <td><input value="" class="i3" maxlength="18"  type="text" 
                onkeyup="value=value.replace(/^[a-zA-Z]+\D*|^\d{0,16}[a-zA-Z]+|[^0-9Xx]/g,'') " onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" id="id_card"></td>
            </tr>
            <tr>                      
                <td class="td4">出生年月</td>
                <td><input type="date" value="" class="i3" id="birth"></td>
            </tr>
            <tr>                      
                <td class="td4">地址</td>
                <td><input type="text" value="" class="i3" id="addr"></td>
            </tr>
            <tr>                      
                <td class="td4">入职时间</td>
                <td><input type="date" value="" class="i3" id="entry_time"></td>
            </tr>
<!--             <tr>                      
    <td class="td4">员工编号</td>
    <td><input type="text" value="" class="i3" id="code"></td>
</tr> -->
            <input type="hidden" id="dis_add_update" value="">
            <input type="hidden"  class="i3" id="get_id" value="">
            <input type="hidden"  class="i3" id="store_code" value="">
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
<!-- end Modal职位调整弹出框 -->
    <footer class="panel-footer">
        <div class="row">
            <div class="pagination pagination-sm m-t-none m-b-none" style="float: right;margin-left:73%; margin-top:0px">
                 {!! $lists->links() !!}
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
<script>
    $(document).ready(function(){
        $('#searchstore').change(function(event) {
            var month = $('#month').val();
            var year = $('#year').val();
            var store_code = $('#searchstore').val();
            window.location.href = '/search/employee/'+store_code+'-0-0';
        });
        /*提交信息*/
        $('#sub_Btn').click(function(event) {
            console.log('test sub');
            //$('#info_error').text('姓名不得为空');
            var name = $('#employee_name').val();
            var sex = $('#selectSex').val();
            var phone = $('#phone').val();
            var id_card = $('#id_card').val();
            var store_code = $('#store_code').val();
            var selectPosition = $('#selectPosition').val();
            var entry_time = $('#entry_time').val();
            var birth = $('#birth').val();
            var addr = $('#addr').val();
            
            if (name == "") {
                $('#info_error').text('姓名不得为空！');
            }else if (!phone){
                $('#info_error').text('电话号码不得为空！');
            }else if (phone.length != 11) {
                $('#info_error').text('电话号码位数不足！');
            }else if (!id_card) {
                $('#info_error').text('身份证不得为空！');
            }else if (id_card.length != 18) {
                $('#info_error').text('身份证位数不足！');
            }else if (!entry_time) {
                $('#info_error').text('入职时间不得为空！');
            }else{
                if($('#dis_add_update').val() == 1){
                    if (selectPosition == 0){
                        $('#info_error').text('请选择职位');
                    }else{
                        /*添加员工提交*/
                        $.post("{{ route('employee.store') }}", 
                            {
                                name: name,
                                sex: sex,
                                phone: phone,
                                id_card: id_card,
                                entry_time: entry_time,
                                birth: birth,
                                addr: addr,
                                store_code: store_code,
                                position_code: selectPosition,

                            }, 
                            function(data, textStatus, xhr) {
                                if (data.status == 1){
                                    console.log(data.data);
                                    var msg = '你的用户名为：【'+data.data.username+'】, 密码为:【'+data.data.pwd+'】请牢记！';
                                    alert(msg);
                                    window.location.reload();
                                }else{
                                    $('#info_error').text(data.msg);
                                }
                        });
                    }
                }else{
                    var id = $("#get_id").val();
                    /*修改员工提交*/
                    $.get("/employee/"+id+"/edit", 
                            {
                                name: name,
                                sex: sex,
                                phone: phone,
                                id_card: id_card,
                                entry_time: entry_time,
                                birth: birth,
                                addr: addr,
                                store_code: store_code,

                            }, 
                            function(data, textStatus, xhr) {
                                if (data.status == 1){
                                    alert(data.msg);
                                    window.location.reload();
                                }else{
                                    $('#info_error').text(data.msg);
                                }
                        });
                }
            }


        });

        /*消除info_error*/
        $('table tr td input').click(function(event) {
            $('#info_error').text("");
        });
        $('#selectPosition').change(function(event) {
            $('#info_error').text("");
        });
        $('#selectSex').change(function(event) {
            $('#info_error').text("");
        });

    });

    /*添加新员工*/
    function addEmployee(store_code) {
        /*信息清空*/
        var store_name = $('#searchstore option[selected]').text();
        $('#store_name').text(store_name);
        $('#info_error').text("");
        $('#detail_position').hide();
        $('#table tr td input').val("");
        $('#selectSex option').removeAttr('selected');

        $('.modal-footer #sub_Btn').show();
        $('#table tbody tr td input').removeAttr("disabled");
        $('#selectSex').removeAttr("disabled");
        $('#sel_position').show();
        $('#selectPosition_tr').show();
        $('#dis_add_update').val('1'); //该标签值为1 添加
        $('#label_model').text('添加员工');
        $('#store_code').val(store_code);
        eachPosition(store_code);
    }

    function eachPosition(store_code){
        
        $.get('/getposition/'+store_code, function(data) {
            if(data.status == 1){
                var clone_class = $('#clone_class');
                $('#selectPosition #clone_class').remove(); //清除克隆标签
                $.each(data.data, function(key, val) {
                    var clo = clone_class.clone(true);
                    var code = val.code;
                    $(clo).attr('value', code);
                    var name = val.name+"【"+val.position_tag+"】";
                    $(clo).text(name);
                    $(clo).show();
                    $('#selectPosition').append(clo);
                });
            }
        })
    }

    /*查看新员工*/
    function checkDetail(id) {
        $.get('/employee/'+id, function(data) {
            
            var store_name = $('#searchstore option[selected]').text();
            $('#store_name').text(store_name);
            $('#label_model').text('详细信息');
            $('#info_error').text("");
            $('.modal-footer #sub_Btn').hide();
            $('#table tbody tr td input').attr("disabled","disabled");
            $('#selectSex').attr("disabled","disabled");
            $('#selectPosition_tr').show();
            $('#sel_position').hide();
            
            $('#employee_name').val(data.data.employee.name);
            
            $('#detail_position').show();
            $('#detail_position input').val(data.data.position.name);
            $('#phone').val(data.data.employee.phone);
            $('#selectSex').val(data.data.employee.sex);
            $('#id_card').val(data.data.employee.id_card);
            $('#birth').val(data.data.employee.birth);
            $('#entry_time').val(data.data.employee.entry_time);
            $('#addr').val(data.data.employee.addr);
            $('#code').val(data.data.employee.code);

        });

    }

    /*调整员工*/
    function changeEmployee(id, store_code){
        var store_name = $('#searchstore option[selected]').text();
        $('#store_name').text(store_name);
        $('#label_model').text('修改员工');
        $('.modal-footer #sub_Btn').show();
        $('#sel_position').hide();
        $('#detail_position').hide();
        $('#table tbody tr td input').removeAttr("disabled");
        $('#selectSex').removeAttr("disabled");
        $('#info_error').text("");
        $('#dis_add_update').val('2'); //该标签值为2 修改
        $('#selectPosition_tr').hide(); //隐藏职位
        $('#get_id').val(id);
        eachPosition(store_code);
        $.get('/employee/'+id, function(data) {
            if(data.status === 1){
                $('#employee_name').val(data.data.employee.name);
                /*选中性别*/
                $('#selectSex').val(data.data.employee.sex);
                $('#phone').val(data.data.employee.phone);
                $('#id_card').val(data.data.employee.id_card);
                $('#birth').val(data.data.employee.birth);
                $('#addr').val(data.data.employee.addr);
                $('#entry_time').val(data.data.employee.entry_time);
                $('#code').val(data.data.employee.code);


            }
        })
    }

    /*员工删除*/
    function del(code){
        if(confirm('确定要删除此信息吗？')){
            $.get("/del/employee/"+code,
                function(data, textStatus, xhr) {
                    if(data.status == '1'){
                        $('#'+code).css('display','none');
                        $('#conunt_num').text($('#conunt_num').text()-1);
                    }
                    else{
                        alert('网络错误，请重试！');
                    }
            });
            // alert('删除成功！');
            return true;
        }
        return false;
    }
</script>
@endsection