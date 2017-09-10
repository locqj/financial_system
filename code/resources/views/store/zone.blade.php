@extends('layouts.nav')
@section('content')
              <section class="vbox">
            <section class="scrollable padder">
            <marquee direction=left class="headerMarquee">欢迎使用xxx房产记账结算管理系统！</marquee>
            <ul class="breadcrumb no-border no-radius b-b b-light pull-in">
              <li><i class="fa fa-home"></i> 主页</li>
              <li class="active">店铺管理</li>
            </ul>
            <section class="panel panel-default">
              <div class="table-responsive">
                <!-- <div class="tips">
                  <div class="tipsDiv">
                    <div>说明：1.可以通过点击下拉菜单进行店铺查找以及切换。
                    </div>
                    <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2.点击添加新店铺按钮可以添加新店铺信息。</div>
                    <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3.点击编辑按钮可以查看以及修改店铺信息。</div>
                  </div>
                  <div>
                  <img src="{{ asset('static/images/store.gif') }}">
                  </div>
                </div> -->
                <table class="headerStyle">
                    <tr>
                      <th class="headertitle" data-toggle="class">
                        区域管理表
                      </th>
                      <th>
                      @if(in_array(session::get('level_code'), ['cw']))
                        <button class="btn btn-sm btn-default addNew" data-toggle="modal" id="storeAdd" data-target="#modifyStore" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';" onclick="cAdd();">添加区域</button>
                      @endif
                      </th>
                    </tr>
                </table>
                </div>
                <div class="table-responsive">
                <table class="table table-striped b-t b-light text-sm">
                  <thead>
                    <tr>
                      <th>区域号</th>
                      <th>区域名称</th>
                      <th>地址</th>
                      <th>创建时间</th>
                      @if(in_array(session::get('level_code'), ['cw']))
                      <th>操作</th>
                      @endif
                    </tr>
                  </thead>
                  <tbody>
                         @foreach($store as $list)
                    <tr>
                      <td class="editId" style="display: none;">{{$list->id}}</td>       
                      <td class="editCode">{{$list->code}}</td>
                      <td class="editName">{{$list->name}}</td>
                      <td class="editAddr">{{$list->addr}}</td>
                      <td>{{$list->created_at}}</td>
                      @if(in_array(session::get('level_code'), ['cw']))
                      <td>
                     <button class="btn btn-sm btn-default storeEdit operate" value="{{$list->id}}" data-toggle="modal" data-target="#modifyStore"  onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';" onclick="cUpdate(' {{$list->id}} ')">编辑</button>
                      <button class="btn btn-sm btn-default storeDel operate deleteColor" value="{{$list->id}}" onmouseover="this.style.backgroundColor='#fb6b5b'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#fb6b5b';this.style.color = 'white';" onclick="cDel('{{ $list->id }}')">删除</button>
                      </td> 
                      @endif                  
                    </tr>
                 @endforeach
                  </tbody>
                </table>
              </div>
              <footer class="panel-footer headerStyle2">
                <div class="row">  
                  <div class="col-sm-4 text-right text-center-xs" style="margin-left:-24%">
                    {!! $store->links() !!}
                  </div>
                </div>
              </footer>
            </section>
            <!-- <div class="copyRight">版权所有: © locqj
            </div> -->
          </section>
          <div class="copyRight">
          <div >版权所有: © locqj
            </div>
            </div>
          </section>
          <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>

          <!-- 添加弹框 -->
          <div class="modal fade" id="modifyStore" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                  <div class="table-responsive">
                    <table class="table" id="edittable">                
                              <tr>
                                <input type="text" id="storeId" style="display: none;">
                                <input type="text" id="status_add_up" value="" style="display: none;">
                              <tr id="storeCodeTr">                     
                                <td class="modalTd">区域编码</td>
                                <td id="storeCode"></td>
                              </tr>
                                <td class="modalTd">区域名称</td>
                                <td><input type="text" class="modalInput" id="storeName"></td>   
                              </tr>                 
                             
                              <tr>               
                                <td class="modalTd">地址</td>
                                <td><input type="text" class="modalInput" id="storeAddr"></td>
                              </tr>
                              <tr>               
                                <td class="modalTd">备注</td>
                                <td>
                                  <textarea id="remark" style="width:172px;resize: none;">
                                  </textarea>
                                </td>
                              </tr>
                    </table>
                  </div>
                </div>
                <div class="modal-footer">
                  <span id="errsmg" style="color: red;float: left;"></span>
                  <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                  <button type="button" class="btn btn-default" id="subBtn">保存</button>
                </div>
              </div>
            </div>
          </div>
          <script type="text/javascript">

            /*提交*/
            $('#subBtn').click(function(){
              var id = $('#storeId').val();
              var name = $('#storeName').val();
              var addr = $('#storeAddr').val();
              var remark = $('#remark').val();
              var city_code = "{{$cityCode}}";
              var status_add_up = $('#status_add_up').val();
             if(!name){
                $('#errsmg').text('店铺名称不能为空');
              }else if(!addr){
                $('#errsmg').text('店铺地址不能为空');
              }else{
                if(status_add_up == 1){
                    $.post('/zone/addsub', {
                        'name': name,
                        'addr': addr,
                        'remark': remark,
                        'city_code': city_code
                        }, function(data, textStatus, xhr) {
                        if(data.status == 1){
                            alert('添加成功!');
                            window.location.reload();
                        }
                    });
                }else{

                    $.post('/zone/updatesub/'+id, {
                        'name': name,
                        'addr': addr,
                        'remark': remark
                        }, function(data, textStatus, xhr) {
                        if(data.status == 1){
                            alert('修改成功!');
                            window.location.reload();
                        }
                    });
                }
              }
            });
            $('#edittable input').click(function(){
                $('#errsmg').text("");
            })
          </script>
          <script type="text/javascript">
            /*更新操作*/
            function cUpdate(id){
                $('#errsmg').text('');
                $('#status_add_up').val('2');
                $('#storeCodeTr').show();
                $('#storeId').val(id);
                $('.modal-title').text("更新区域");
                console.log($('#status_add_up').val());
                $.get('/zone/find/'+id, function(data) {
                    $('#storeCode').text(data.data.code);
                    $('#storeName').val(data.data.name);
                    $('#storeAddr').val(data.data.addr);
                    $('#remark').val(data.data.remark);
                });
            }
            /*删除*/
            function cDel(id){
                if(confirm('确定删除？'))
                $.get('/zone/del/'+id, function(data) {
                    if(data.status == 1){
                        window.location.reload();
                    }
              });
            }
            /*添加*/
            function cAdd(){
                $('#errsmg').text('');
                $('#storeId').val('');
                $('#storeName').val('');
                $('#storeCode').val('');
                $('#storeCodeTr').hide();
                $('#storeAddr').val('');
                $('#remark').val('');
                $('#status_add_up').val('1');
                $('.modal-title').text("添加区域");
                console.log($('#status_add_up').val());
            }
          </script>
 @endsection