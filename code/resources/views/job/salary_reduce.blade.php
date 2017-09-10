@extends('layouts.nav')
@section('content')
<section class="vbox">
                    <section class="scrollable padder">
                      <marquee direction=left class="headerMarquee">欢迎使用xxx房产记账结算管理系统！</marquee>
                      <ul class="breadcrumb no-border no-radius b-b b-light pull-in">
                        <li><i class="fa fa-home"></i> 主页</li>
                        <li class="active">扣除工资记录</li>
                      </ul>
                      <section class="panel panel-default">
                        <div class="table-responsive" >
                          <table class="headerStyle">
                            <tr>
                                <th class="headertitle" data-toggle="class">
                                工资扣除管理表
                                </th>
                                <th>
                                @if(in_array(session::get('level_code'), ['cw', 'dz', 'zl']))
                                <button  id="count" class="btn btn-sm btn-default addNew" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';" data-toggle="modal" data-target="#myModal" onclick="addReduceSalary();">添加扣除条目</button>
                                 <button  id="addExcel" class="btn btn-sm btn-default" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';" data-toggle="modal" data-target="#myModalExcel" onclick="addReduceSalary();">导入扣除条目</button>
                                @endif
                                </th>
                            </tr>
                          </table>
                        <table class="table table-striped b-t b-light text-sm headerStyle2">
                              <tr>
                                <th>
                                  <label class="labelStyle">查找店铺&nbsp;&nbsp;</label>
                                  <select class="input-sm form-control input-s-sm inline" id="searchstore">
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
                                    <label class="labelStyle reduceTimeStyle">年 / 月&nbsp;&nbsp;</label>  
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
                          <table class="table table-striped b-t b-light text-sm" id="table">
                            <thead>
                              <tr>
                                <th>所属店铺</th>
                                <th>员工姓名</th>
                                <th>年</th>
                                <th>月</th>
                                <th>扣除费用总额</th>
                                <th>扣除费用详情</th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach($reduce as $list)
                                    <tr>
                                        <td>{{ $list->store->name }}</td>
                                        <td>{{ $list->employee->name }}</td>
                                        <td>{{ $list->year }}</td>
                                        <td>{{ $list->month }}</td>
                                        <td>{{ $list->sum_all }}</td>
                                        <td><button class="btn btn-sm btn-default operate" onclick="checkDetails('{{ $list->employee_code }}')" data-toggle="modal" data-target="#checkDetails">查看详情</button></td>
                                    </tr>
                                @endforeach
                            </tbody>
                          </table>
                        </div>
                        <!---->
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="label_model">添加扣除费用</h4>
                              </div>
                              <div class="modal-body">
                                <div class="table-responsive">
                                <table class="table table-striped b-t b-light text-sm" id="table">
                                    <tr>
                                        <td>所属店铺</td>
                                        <input type="hidden" value="" id="store_code">
                                        <input type="hidden" value="add" id="set_id">
                                        <option value="" style="display: none;" id="clone_class"></option>
                                        <td id="store_code_text"></td>
                                    </tr>
                                    <tr>
                                        <td>条目</td>
                                        <td><input type="text" value="" id="category"></td>
                                    </tr>      
                                    <tr>                      
                                        <td>选择员工</td>
                                        <td>
                                            <select class="input-sm form-control input-s-sm inline" id="employee_code">
                                            
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>                      
                                        <td>费用</td>
                                        <td><input type="number" min="0" value="" id="amount"></td>
                                    </tr>
                                    <tr>                      
                                        <td>扣除月份</td>
                                        <td><input type="date" value="" id="sign_date"></td>
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
                        <!-- 显示详情弹框 -->
                         <div class="modal fade" id="checkDetails" tabindex="-1" role="dialog" aria-labelledby="mycheckDetils">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">查看详情</h4>
                              </div>
                                 <table class="table" id="table_list">
                                    <thead>
                                        <tr>  
                                            <th>年/月</th>
                                            <th>类目</th>
                                            <th>金额</th>
                                            <th>扣除时间</th>
                                            @if(in_array(session::get('level_code'), ['cw']))
                                            <th>操作</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="clone_tr" style="display: none;">                     
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            @if(in_array(session::get('level_code'), ['cw']))
                                            <td><button class="btn btn-sm btn-default operate deleteColor" onmouseout="this.style.backgroundColor = '#fb6b5b';this.style.color = 'white';">删除</button></td>
                                            @endif
                                        </tr>
                                        
                                    </tbody>
                                </table>
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
                                     {{ $reduce->links() }}
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
                   <!--excel导入-->
                        <div class="modal fade" id="myModalExcel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="label_model">导入扣除费用</h4>
                              </div>
                              <div class="modal-body">
                                <div class="table-responsive">
                                <form id="subForm" method="post" enctype="multipart/form-data">
                                <table class="table table-striped b-t b-light text-sm" id="table">
                                    
                                    <tr>
                                        <td>选择文件</td>
                                        <td> <input type="file" name="excel" id="subExcel"></td>
                                    </tr> 
                                    <tr>
                                        <td>下载模版</td>
                                        <td><button type="button" class="btn btn-sm btn-default operate" onclick="modelDownload();">点击下载</button></td>
                                    </tr>     
                                    
                                </table>
                                </form>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <div class="info_error" style="text-align:left;color:red;font-size:16px"></div>
                                <button type="button" class="btn btn-default" data-dismiss="modal" id="cancel">
                                    关闭
                                </button>
                                <button type="button" class="btn btn-default" id="subBtnExcel">
                                    保存
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- 显示详情弹框 -->
<script type="text/javascript">
    /*导入扣除费用*/
    $('#addExcel').click(function(){
        $('.info_error').text('');
    })
    /*模版下载*/
    function modelDownload(){
        //把excel发送出来
        var url = "{{url('reducesalary/download')}}";
        window.open(url);
    }
    $('#subBtnExcel').click(function(){
         var formData = new FormData($('#subForm')[0]);
         var file = $('#subExcel').val();
         if(file == ''){
            $('.info_error').text('请选择文件');
         }else{
            $.ajax({
                url: "{{url('/reducesalary/import')}}",
                type: 'POST',
                cache: false,
                data: formData,
                processData: false,
                contentType: false
            }).done(function(res) {
                if(res.status == 1){
                    alert(res.msg);
                    window.location.reload(true);
                }else{
                    $('.info_error').text(res.msg);
                }
            }).fail(function(res) {

            });
         }
    })
    /*添加端口*/
    function addReduceSalary(){
        $('#employee_code option[id=clone_class]').remove(); //克隆前把之前的清除掉
        var store_code = $('#searchstore').val();
        var store_name = $('#searchstore option[value='+store_code+']').text(); //找到select对应的text
        $('#store_code_text').text(store_name);
        $('#store_code').val(store_code);
        $.get("/getallemployee/"+store_code,
            function(data) {
                if(data.status == 1){
                    var clone_class = $('#clone_class');
                    var cl = clone_class.clone(true);
                    $(cl).attr('value', 0);
                    $(cl).text('请输入');
                    $(cl).show();
                    $('#employee_code').append(cl);
                    $.each(data.data, function(key, val) {
                        /*alert(val.month);*/
                        var clo = clone_class.clone(true);
                        var code = val.employee_code;
                        $(clo).attr('value', code);
                        $(clo).text(val.employee.name);
                        $(clo).show();
                        $('#employee_code').append(clo);

                    });
                }
        });
    }

    
    function del(id, category) {
        if(confirm("确定删除类目为["+category+"]该记录？")){
            $.get('/del/reduce/'+id, function(data) {
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

    function checkDetails(employee_code) {
        var year = $('#year').val();
        var month = $('#month').val();
        $.get('/reducesalary/getdetails/'+employee_code+'-'+year+'-'+month, function(data) {
             if(data.status == 1){
                    var d_length = data.data.length;
                    $("#table_list tbody #clone_tr").remove();
                    var clone_tr = $('.clone_tr');
                    $.each(data.data, function(index, val) {
                        
                        var tr = clone_tr.clone(true);
                        var msg = val.year+'-'+val.month;
                        var date = val.year+'-'+val.month+'-'+val.day;
                        $(tr).attr('id', 'clone_tr');
                        $(tr).find('td').eq(0).text(msg);
                        $(tr).find('td').eq(1).text(val.category);
                        $(tr).find('td').eq(2).text(val.amount);
                        $(tr).find('td').eq(3).text(date);
                        //$(tr).find('td').eq(4).find('button').attr('id', val.id);
                        $(tr).find('td').eq(4).find('button').click(function(){
                            del(val.id, val.category);
                        })
                        
                        $(tr).show();
                        if(index < d_length){
                            tr.appendTo('#table_list tbody');
                        }
                        //$("#table_list tbody").append(clo);
                    });
                }
        });
    }

    $(document).ready(function(){
        /*提交*/
        $('#sub_Btn').click(function(event) {

            
            var store_code = $('#store_code').val();
            var sign_date = $('#sign_date').val();
            var category = $('#category').val();
            var employee_code = $('#employee_code').val();
            var amount = $('#amount').val();
            
            var id = $('#set_id').val();
            if(!amount || !category || !sign_date) {
                $('#info_error').text('信息不全！');
            }else if (employee_code == 0) {
                $('#info_error').text('请选择使用者');
            }else if (amount < 0) {
                $('#info_error').text('偿还费用不得小于0');
            }else{
                $.post('/reducesalary/sub', 
                    {
                        id: id,
                        category: category,
                        store_code: store_code,
                        sign_date: sign_date,
                        employee_code: employee_code,
                        amount: amount,
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

        $('#searchstore').change(function(event) {
            var month = $('#month').val();
            var year = $('#year').val();
            var store_code = $('#searchstore').val();
            window.location.href = '/search/reducesalary/'+store_code+'-'+year+'-'+month;
        });
        $('#year').change(function(event) {
            var month = $('#month').val();
            var year = $('#year').val();
            var store_code = $('#searchstore').val();
            window.location.href = '/search/reducesalary/'+store_code+'-'+year+'-'+month;
            
        });
        $('#month').change(function(event) {
            var month = $('#month').val();
            var year = $('#year').val();
            var store_code = $('#searchstore').val();
            window.location.href = '/search/reducesalary/'+store_code+'-'+year+'-'+month;
        });
         
    });
</script>
@endsection