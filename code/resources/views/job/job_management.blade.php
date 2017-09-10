@extends('layouts.nav')

@section('content')
<section class="vbox">
<section class="scrollable padder">
<marquee direction=left class="headerMarquee">欢迎使用xxx房产记账结算管理系统！</marquee>
<ul class="breadcrumb no-border no-radius b-b b-light pull-in">
  <li><i class="fa fa-home"></i> 主页</li>
  <li class="active">职位管理</li>
</ul>
<section class="panel panel-default">
    <div class="table-responsive" >
       <!--  <div class="tips">
            <div class="tipsDiv">
                <div>说明：1.可以通过点击下拉菜单进行店铺查找以及切换。
                </div>
                <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2.点击销售薪水标准按钮可以制定薪水标准。</div>
                <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3.点击修改工资按钮可以修改职位对应的基本工资。</div>
                <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4.点击提成规则按钮可以查看、修改以及制定提成规则。</div>
            </div>
            <img src="{{ asset('static/images/position.gif') }}">
        </div> -->
    <table class="headerStyle">
      <tr>
        <th class="headertitle" data-toggle="class">
            职位管理表
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
            <div data-toggle="buttons">
            <label class="btn btn-sm btn-default timeStyle">
              <input type="radio" name="options" id="option1">
              公司职位分类数
            </label>
            <label class="btn btn-sm btn-default">
              <input type="radio" name="options" id="option2">
              <span id="conunt_num">{{ $position_code }}</span>
            </label>
            </div>
        </th>
      </tr>
  </table>
  </div>
  <div class="table-responsive">
            <table class="table table-striped b-t b-light text-sm ">
              <thead>
                <tr>
                    <th>所属店铺</th>
                    <th>职位</th>
                    <th>基本工资</th>
                    @if(session::get('level_code') == 'cw')
                    <th>操作</th>
                    @endif
                </tr>
              </thead>
              <tbody>
                @foreach($positions as $position)
                <tr id='{{ $position->code }}'>                      
                    <td>{{ $position->store->name }}</td>
                    <td>{{$position->name}}【{{ $position->position_tag }}】</td>
                    <td class="salary">{{ $position->salary }}</td>
                    @if(session::get('level_code') == 'cw')
                    <td>
                        <input type="hidden" id="salary_update_id" value="">
                        <input type="hidden" id="salary_update_salary" value="">
                        <button class="btn btn-sm btn-default operate" data-toggle="modal" data-target="#update_salary" onclick="updateSalary('{{ $position->id }}', '{{ $position->salary }}')" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';">修改工资</button>
                        <!-- <button class="btn btn-sm btn-default" style="width:65px;height:25px;font-size:12px;line-height:15px"  onclick="del('{{ $position->code }}')">删除职位</button> -->
                    </td> 
                    @endif

                    
                </tr>
                @endforeach
              </tbody>
            </table>
        </div>
        <footer class="panel-footer">
            <div class="row">  
                <div class="pagination pagination-sm m-t-none m-b-none linkStyle">
                     {!! $positions->links() !!}
                </div>
            </div>
        </footer>
        <!-- Modal过户单修改弹出框 -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">修改</h4>
              </div>
              <div class="modal-body">
                <div class="table-responsive">
                        <table class="table table-striped b-t b-light text-sm" id="table">                
                            <tr>                      
                              <td class="td4">职位名称</td>
                              <td>  
                                    <select class="input-sm form-control input-s-sm inline" id="name">
                                        <option value="0">请选择</option>
                                        <option value="dz">店长</option>
                                        <option value="zl">店长助理</option>
                                        <option value="xs">销售</option>
                                        <option value="gh">过户</option>
                                        <option value="qy">区域经理</option>
                                        <option value="other">其他</option>
                                    </select>
                              </td>
                            </tr>  
                            <tr class="other_name" style="display: none;">
                                <td>自定义职位名称</td>
                                <td>
                                    <input type="text" value="" id="other_name">
                                </td>
                            </tr>               
<!--                             <tr>                     
  <td class="td4">职位编号</td>
  <td><input type="text" value="" id="code" class="i3"></td>
</tr> -->
                            <tr>                     
                            <td>职位级别</td> 
                              <td>
                                  <input  type="text"  id="level" maxlength="1" onkeyup="this.value=this.value.replace(/\D/g,'')" />
                              </td>
                            </tr>
                            <tr>                      
                              <td >基本工资</td>
                              <td><input type="number" value="" id="salary"></td>
                            </tr>
                            <tr style="display: none;">                      
                              <td><input type="" value="" id="position_id"></td>
                            </tr>
                            <tr style="display: none;">                      
                              <td><input type="" value="" id="store_code"></td>
                            </tr>
                        </table>
                      </div>
              </div>
              <div class="modal-footer">
                <div id="info" class="modalFooterstyle"></div>
                <button type="button" class="btn btn-default" data-dismiss="modal" >关闭</button>
                <button type="button" class="btn btn-default" id="sub">保存</button>
              </div>
            </div>
          </div>
        </div>
        <!--end modal-->

      <!-- Modal薪资标准修改弹框 -->
        <div class="modal fade" id="myModal_postionLevel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">销售薪资标准</h4>
              </div>
              <div class="modal-body">
                <div class="table-responsive">
                        <table class="table table-striped b-t b-light text-sm" id="table_level" >
                          <tr id="clone_class" style="display: none;">
                            <td class="employeeid" ></td>
                            <td><button class="btn btn-sm btn-default">下线</button>
                                  <input id="" type="text"  value="" style="width: 80px;" ><span style="margin-right: 6%; margin-left: 1%")>元</span>
                            </td>
                            <td><button class="btn btn-sm btn-default">上线</button>
                               
                                    <input id="" type="text" style="width: 80px;"  value=""><span style="margin-left: 1%">元</span>
                            </td>
                          </tr>
                        </table>
                  </div>
              </div>
              <div class="modal-footer">
                <div  class="info_pl modalFooterstyle "></div>
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-default" id="sub_position_level">保存</button>
              </div>
            </div>
          </div>
        </div>
        <!--end modal-->
        <!-- Modal修改基本工资弹框 -->
        <div class="modal fade" id="update_salary" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">修改基本工资</h4>
              </div>
              <div class="modal-body">
                <table class="table table-striped b-t b-light text-sm" id="table_salary">
                    <tr>                      
                        <td class="td4">基本工资</td>
                        <td><input type="number" value="" id="up_salary" min='0' class="i3"></td>
                    </tr>
                </table>
              </div>
              <div class="modal-footer">
                <div class="info_pl modalFooterstyle"></div>
                <button type="button" class="btn btn-default" data-dismiss="modal" >关闭</button>
                <button type="button" class="btn btn-default" id="sub_position_salary">保存</button>
              </div>
            </div>
          </div>
        </div>
        <!--end modal-->
</section>
   <!--  <div class="copyRight">版权所有: © locqj
    </div> -->
</section>
<div class="copyRight">
    <div >版权所有: © locqj
    </div>
</div>
</section>
<script type="text/javascript">
    $(document).ready(function(){
        /*搜索公司员工*/
        $('#searchstore').change(function(event) {
            var month = $('#month').val();
            var year = $('#year').val();
            var store_code = $('#searchstore').val();
            window.location.href = '/search/position/'+store_code+'-0-0';
        });

        /*选择职位*/
/*        $('#name').change(function(event) {
            $('#info').text("");
           var name = $('#name').val();
           if(name == 'other'){
                $('.other_name').show();
           }else{
                $('.other_name').hide();
           }
        });*/

        
        $('#up_salary').click(function(event) {
            $('.info_pl').text("");
        });
        /*提交表单*/
        $('#sub').click(function(event) {
            var name = $('#name').val();
            var name2 = $("#name").find("option:selected").text();
            var level = $('#level').val();
            var code = $('#code').val();
            var salary = $('#salary').val();
            var id = $('#position_id').val();
            var store_code = $('#store_code').val();
            if(name == '0'){
                $('#info').text('请选择职位');
            }else if(store_code != ""){
                if(name == 'other'){
                    var other_name = $('#other_name').val();
                    if(other_name == ""){
                        $('#info').text('请填写职位');
                    }
                    name2 = other_name;
                    name = "ot";
                }
                
                /*创建职位*/
                $.post("{{ route('position.store') }}", 
                {
                    name: name2,
                    s_code: name,
                    level: level,
                    salary: salary,
                    store_code: store_code

                }, function(data, textStatus, xhr) {
                    if(data.status == 1){
                        alert('添加成功');
                        window.location.reload();
                    }else{
                        $('#info').text(data.msg);
                    }
                });
            }else{
                if(name == 'other'){
                    name2 = other_name;
                    name = "ot";
                }
                /*修改职位*/
                $.get("/position/"+id+"/edit", 
                {
                    name: name,
                    level: level,
                    salary: salary
                }, function(data, textStatus, xhr) {
                    if(data.status == 1){
                        alert('修改成功');
                        window.location.reload();
                    }else{
                        $('#info').text(data.msg);
                    }
                });
            }
        });
        /*提交销售薪水规则*/
        $('#sub_position_level').click(function(event) {
            var top1 = parseInt($('#top1').val());
            var bottom1 = parseInt($('#bottom1').val());
            var top2 = parseInt($('#top2').val());
            var bottom2 = parseInt($('#bottom2').val());
            var top3 = parseInt($('#top3').val());
            var bottom3 = parseInt($('#bottom3').val());
            if(!top1){
                $('.info_pl').text('[一级]上线不得为空');
            }else if (top1 <= 0) {
                $('.info_pl').text('[一级]上线不得为负');
            }else if(bottom2 <= top1){
                $('.info_pl').text('[二级]下线与[一级]上线有交集');
            }else if(!top2){
                $('.info_pl').text('[二级]上线不得为空');
            }else if(!bottom2){
                $('.info_pl').text('[二级]下线不得为空');
            }else if(top2 <= 0){
                $('.info_pl').text('[二级]上线不得为负');
            }else if(bottom2 <= 0){
                $('.info_pl').text('[二级]下线不得为负');
            }else if(bottom3 <= top2){
                $('.info_pl').text('[三级]下线与[二级]上线有交集');
            }else if (bottom3 <= 0) {
                $('.info_pl').text('[三级]下线不得为负');
            }else if(top2 <= bottom2){
                $('.info_pl').text('[二级]下线大于上线');
            }else if(!bottom3){
                $('.info_pl').text('[三级]下线不得为空');
            }else{
                $.post('/position/positionlevelsub', 
                    {
                        top1: top1,
                        bottom1: bottom1,
                        top2: top2,
                        bottom2: bottom2,
                        top3: top3,
                        bottom3: bottom3
                    }, function(data, textStatus, xhr) {
                        if(data.status == 1){
                            alert('插入成功');
                            window.location.reload();
                        }
                });
            }

        });
        $('top1').click(function(event) {
            $('.info_pl').text("");
        });
        /*提交修改薪水*/
        $('#sub_position_salary').click(function(event) {
            var salary = parseFloat($('#up_salary').val());
            var id = $('#salary_update_id').val();
            var table_salary = parseFloat($('#salary_update_salary').val());
            if(!salary) {
                $('.info_pl').text('工资不能为空');
            }else if(salary < 0){
                $('.info_pl').text('工资不能为负数');
            }else if(salary == table_salary){
                window.location.reload();
            }else{
                if(confirm('确定将工资修改为:'+salary+'元')){
                    $.post('/position/positionsalarysub', {salary: salary, id: id}, 
                        function(data, textStatus, xhr) {
                        if(data.status == 1){
                            alert('修改成功');
                            window.location.reload();
                        }else{
                            alert('修改失败');
                            window.location.reload();
                        }
                    });
                }
            }
        });

        /*消除info*/
  /*      $('input').click(function(event) {
            $('#info').text("");
            $('.info_pl').text("");
        });*/
    /*    $('#top1').bind('input propertychange', function() {
            var bottom2 = $('#top1').val();
            $('#bottom2').val();
        });
        $('#top2').bind('input propertychange', function() {
            var bottom3 = $('#top2').val();
            $('#bottom3').val(bottom3);
        });*/


    });
    /*添加职位*/
   /* function addPosition(store_code){
        var store_code = $('#store_code').val(store_code);
    }*/
    /*修改工资*/
    function updateSalary(id, salary){
        $('.info_pl').text("");
        $('#salary_update_id').val(id);
        $('#salary_update_salary').val(salary);
        $.get('/position/'+id, function(data) {
            $('#up_salary').val(data.data.salary);
        });
    }

    /*删除职位*/
/*    function del(code){
        if(confirm('确定要删除此信息吗？')){
            $.get("/del/position/"+code,
                function(data, textStatus, xhr) {
                    if(data.status == '1'){
                        $('#'+code).css('display','none');
                        $('#conunt_num').text($('#conunt_num').text()-1);
                    }
                    else{
                        alert('网络错误，请重试！');
                    }
            });
            
            return true;
        }
        return false;
    }*/
    /*修改职位*/
/*    function update(id){
        $('#info').text("");
        $('#position_id').val(id);
        $.get("/position/"+id, function(data) {
            if(data.status == 1){
                $('#name').val(data.data.name);
                $('#name option').each(function(index, el) {
                    var this_text = $(this).text();
                    if(this_text == data.data.name){
                        $(this).attr("selected", true);
                    }
                });
                $('#level').val(data.data.level);
                $('#salary').val(data.data.salary);
            }else{
                alert('网络错误，请重试！');
            }
        });
    }*/
    /*修改职位薪水标准*/
    function positionLevel() {
        $('.info_pl').text("");

        $.get('position/positionlevel', function(data) {
            $('.cl_class').remove();
            $.each(data.data, function(index, val) {
                var ind = parseFloat(index)+1;
                
                var clo = $('#clone_class').clone();
                clo.addClass('cl_class');
                clo.children('td').eq(0).text(val.name);
                if(ind == 1){
                    clo.children('td').eq(1).children('input').attr("disabled","disabled");
                }
                if(ind == 3){
                    clo.children('td').eq(2).children('input').attr("disabled","disabled");   
                }
                clo.children('td').eq(1).children('input').val(val.bottom);
                clo.children('td').eq(1).children('input').attr('id', 'bottom'+ind);
                clo.children('td').eq(2).children('input').val(val.top);
                clo.children('td').eq(2).children('input').attr('id', 'top'+ind);
                clo.appendTo('#table_level');
                clo.show();
            });
        });
    }




</script>
@endsection