@extends('layouts.nav')

@section('content')
<section class="vbox">
<section class="scrollable padder">
<marquee direction=left class="headerMarquee">欢迎使用xxx房产记账结算管理系统！</marquee>
<ul class="breadcrumb no-border no-radius b-b b-light pull-in">
  <li><i class="fa fa-home"></i> 主页</li>
  <li class="active">员工职位调整</li>
</ul>

<section class="panel panel-default">
    <div class="table-responsive">
        <table class="headerStyle">
            <tr>
                <th class="headertitle" data-toggle="class">
                    店铺职位调整表
                </th>
            </tr>
        </table>
        <table class="table table-striped b-t b-light text-sm headerStyle2">
            <tr>
              <th class="th-sortable" data-toggle="class">
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
                    <th>调整</th>
                </tr>
                </thead>
                <tbody>
                @foreach($employee_position_store as $list)
                <tr>
                    <input type="hidden" id="store{{$list->id}}" value="{{$list->store_code}}">
                    <input type="hidden" id="position{{$list->id}}" value="{{$list->position_code}}">
                    <td >{{ $list->store->name }}</td>
                    <td >{{ $list->employee->name }}</td>
                    <td >{{ $list->position->name }}【{{ $list->position->position_tag }}】</td> 
                    <td>
                    <button type="button" class="btn btn-sm btn-default operate" data-toggle="modal" data-target="#myModal" onclick="changePosition('{{ $list->id }}', '{{ $list->store->code }}')" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';">调整</button>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
          </div>

          <div class="table-responsive">
            <table class="headerStyle">
                <tr>
                    <th class="headertitle" data-toggle="class">
                        区域职位调整表
                    </th>
                </tr>
            </table>
            <div class="table-responsive">
                <table class="table table-striped b-t b-light text-sm">
                    <thead>
                    <tr>
                        <th>所属区域</th>
                        <th>姓名</th>
                        <th>职位</th>
                        <th>调整</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($employee_position_zone as $list)
                    <tr>
                        <input type="hidden" id="store{{$list->id}}" value="{{$list->store_code}}">
                        <input type="hidden" id="position{{$list->id}}" value="{{$list->position_code}}">
                        <td >{{ $list->zone->name }}</td>
                        <td >{{ $list->employee->name }}</td>
                        <td >{{ $list->position->name }}【{{ $list->position->position_tag }}】</td> 
                        <td>
                        <button type="button" class="btn btn-sm btn-default operate" data-toggle="modal" data-target="#myModal" onclick="changePosition('{{ $list->id }}', '{{ $list->zone->code }}')" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';">调整</button>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
              </div>
        </div>
<!--Modal职位调整弹出框-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">职位调整</h4>
      </div>
      <div class="modal-body modal-bodyHeight">

      <button class="btn btn-sm btn-default modal-bodySearch">查找店铺/区域</button>
            <div style="float: left;">
            <input type="hidden" id="old_store_code">
            <select class="input-sm form-control input-s-sm inline" id="searchStore">
                @foreach($select_all['store'] as $list)
                    <option value="{{ $list->code }}" class="searchstore">{{ $list->name }}[店铺]</option>
                @endforeach
                @foreach($select_all['zone_all'] as $list)
                    <option value="{{ $list->code }}" class="searchstore">{{ $list->name }}[区域]</option>
                @endforeach
            </select>
            </div>
        <button class="btn btn-sm btn-default" style="margin-left:10%; float: left;">职位选择</button>
            <div id="cSearchPosition">
            <select class="input-sm form-control input-s-sm inline" id="searchPosition">
            </select>
            </div>
      </div>
      <div class="modal-footer">
        <div id="errMsg" style="color: red;float: left;"></div>
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button type="button" class="btn btn-default" id="sub_btn" name="">保存</button>
      </div>
    </div>
  </div>
</div>
<!-- end Modal职位调整弹出框 -->
<footer class="panel-footer">
    <!--克隆用的-->
    <option value="" id="clone_class" style="display: none;"></option>
    <div class="row">  
        <div class="pagination pagination-sm m-t-none m-b-none linkStyle">
             {!! $employee_position_store->links() !!}
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
<script type="text/javascript">
    /*调整职位赋初始值*/
    function changePosition(id, old_store_code){
        $('#errMsg').text('');
        $('#old_store_code').val(old_store_code);
        $('#searchPosition option').remove();
        $('#sub_btn').attr('name', id);
        $.get("{{ url('position/adjustmentajax') }}",{
            'id': id
        }, function(data) {
            if(data.status == 1){
                $('#searchStore').val(data.data.store_code);
                var clone_class = $('#clone_class');
                $.each(data.data.positions, function(index, val) {
                    var clo = clone_class.clone(true);
                    var code = val.code;
                    $(clo).attr('value', code);
                    var name = val.name + "【"+val.position_tag+"】";
                    $(clo).text(name);
                    $(clo).show();
                    $('#searchPosition').append(clo);
                });
                $.each($('#searchPosition option'), function(index, val) {
                    if($(this).val() != data.data.position_code && data.data.position_code == 'dz01'){
                        var clone_class = $('#clone_class');
                        var first_clone = clone_class.clone(true);
                        $(first_clone).attr('value', data.data.position_code);
                        $(first_clone).text(data.data.position.name);
                        $(first_clone).show();
                        $('#searchPosition').append(first_clone);
                        return false;
                    }
                });
                $('#searchPosition').val(data.data.position_code);
            }
        });
    }
    function searchEmployee(){
        var name = $('#searchEmployee').val();
        window.location.href = '/searchemployee/adjustment/'+name;
    }
    $(document).ready(function(){
        /*店铺查找*/
        $('#searchstore').change(function(event) {
            
            var store_code = $('#searchstore').val();
            var store_z_code = $('#searchZone').val();
            window.location.href = '/search/position_adjument/'+store_code+'-0-0';
        });
        


        /*职位调整，选择店铺*/
        $("#searchStore").change(function(){
            $("#searchPosition option").remove(); //请求前删除clone标签
            var store_code = $('#searchStore').val();
            if(store_code != 0){
                $.get("/getposition/"+store_code,
                function(data) {
                    if(data.status == 1){
                        var clone_class = $('#clone_class');
                        /*职位联动*/
                        var cl = clone_class.clone(true);
                        $(cl).attr('value', 0);
                        $(cl).text('请输入');
                        $(cl).show();
                        $('#searchPosition').append(cl);
                        $.each(data.data, function(key, val) {
                            /*alert(val.month);*/
                            var clo = clone_class.clone(true);
                            var code = val.code;
                            $(clo).attr('value', code);
                            var name = val.position_tag;
                            $(clo).text(name);
                            $(clo).show();
                            $('#searchPosition').append(clo);

                        });
                    }
                });
            }else{
                
            }
        });

        /*提交修改*/
        $('#sub_btn').click(function(event) {
            var store_code = $('#searchStore').val();
            var position_code = $('#searchPosition').val();
            var id = $('#sub_btn').attr('name');
            //alert($('#position'+id).val());
            var old_store_code = $('#old_store_code').val();
            var store_name = $('#searchStore option[value='+store_code+']').text();
            var position_name = $('#searchPosition option[value='+position_code+']').text();
            

            if($('#position'+id).val() == position_code && $('#store'+id).val() == store_code){
                window.location.reload();
            }else{

                
                if(position_code == 0){
                    alert('请选择职位');
                }else{
                    var msg = '确定要将职位修改成['+store_name+']的['+position_name+']吗?';
                    if(confirm(msg)){
                        $.get("{{ url('position/adjustmentsub') }}",
                        {
                            id: id,
                            store_code: store_code,
                            old_store_code: old_store_code,
                            position_code: position_code
                        }, function(data) {
                            if(data.status == 1){
                                alert('修改成功');
                                window.location.reload();
                                
                            }else{
                                
                                $('#errMsg').text(data.msg);
                                // window.location.reload();
                                
                            }
                        });
                    }  
                }
                
            }
        });
    });
</script>
@endsection