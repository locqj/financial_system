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
                      店铺管理表
                    </th>
                    <th>
                    @if(in_array(session::get('level_code'), ['cw']) && $cityCode)
                      <button class="btn btn-sm btn-default addNew" data-toggle="modal" id="storeAdd" data-target="#modifyStore" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';">添加新店铺</button>
                    @endif
                    </th>
                  </tr>
              </table>
              </div>
              @if(0)
               <!--  <div class="col-sm-5 m-b-xs">
                按公司查找：
                  <select class="input-sm form-control input-s-sm inline" id="company">
                    <option value="allCompany">全部</option>
                    @if($companyName['code'])
                      <option value="{{$companyName['code']}}}" selected="selected">{{$companyName['name']}}</option>
                    @endif
                  @foreach($store->company as $list)
                    @if($list->code != $companyName['code'])
                      <option value="{{$list->code}}">{{$list->name}}</option>
                    @endif
                  @endforeach
                  </select>
                </div> -->
                <!-- <div class="col-sm-4 m-b-xs" style="margin-left:-10%">
                  <div class="btn-group" data-toggle="buttons">
                  按城市查找：
                    <select class="input-sm form-control input-s-sm inline" id="city">
                      <option value="allCity">全部</option>
                      @if($cityName['code'])
                      <option value="{{$cityName['code']}}}" selected="selected">{{$cityName['name']}}</option>
                    @endif
                      @foreach($store->city as $list)
                        @if($list->zone != $cityName['code'])
                          <option value="{{$list->zone}}">{{$list->name}}</option>
                          @endif
                      @endforeach
                    </select>  
                  </div>
                </div> -->
                @endif
                <!-- <div class="col-sm-3">
                  <div class="input-group">
                    <input type="text" id="name" class="input-sm form-control" placeholder="请输入店铺名称">
                    <span class="input-group-btn">
                    <button class="btn btn-sm btn-default" id="nameFind" type="button">Go!</button>
                    </span> </div>
                </div>
              </div> -->
              <div class="table-responsive">
                <table class="table table-striped b-t b-light text-sm" id="myTable">
                  <thead>
                    <tr>
                      <th>店铺号</th>
                      <th>店铺名称</th>
                      <th>地址</th>
                      <th>店铺类型</th>
                      <th>父级店铺</th>
                      <!-- <th>所属公司</th> -->
                      <!-- <th>所在城市</th> -->
                      <th>创建时间</th>
                      @if(session('level_code') == 'cw')
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
					            <td class="editType">{{$list->type_name}}</td>
					            <td>{{$list->parent_name}}</td>
                      <!-- <td>{{$list->company_name}}</td> -->
                      <!-- <td>{{$list->city_name}}</td> -->
					            <td>{{$list->created_at}}</td>
                  @if(session('level_code') == 'cw')
                      <td>
                     <button class="btn btn-sm btn-default storeEdit operate" value="{{$list->id}}" data-toggle="modal" data-target="#modifyStore"  onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';">编辑</button>
                      <button class="btn btn-sm btn-default storeDel operate deleteColor" value="{{$list->id}}" onmouseover="this.style.backgroundColor='#fb6b5b'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#fb6b5b';this.style.color = 'white';">删除</button>
                      </td>
                    @endif         
                    </tr>
                 @endforeach
                  </tbody>
              {!! $store->links() !!}
                </table>
              </div>
              <footer class="panel-footer">
                <div class="row">  
                  <div class="col-sm-4 text-right text-center-xs" style="margin-left:-24%">
                    <!-- <a href="{{URL::action('StoreStoreController@create')}}"> -->
                      <!-- <button class="btn btn-sm btn-default" data-toggle="modal" data-target="#modifyStore">添加新店铺</button> -->
                    <!-- </a>  -->
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
                  <h4 class="modal-title" id="editTitle">添加店铺</h4>
                </div>
                <div class="modal-body">
                  <div class="table-responsive">
                    <table class="table">                
                              <tr>
                                <input type="text" id="storeId" style="display: none;">
                              <tr id="storeCodeTr">                     
                                <td class="modalTd">店铺号</td>
                                <td id="storeCode"></td>
                              </tr>
                                <td class="modalTd">店铺名称</td>
                                <td><input type="text" class="modalInput" id="storeName"></td>   
                              </tr>                 
                             <tr id="addZone">               
                                <td class="modalTd">区域</td>
                                <td>
                                  <select type="text" id="storeZone" style="width: 150px" class="form-control">
                                  @foreach($zone as $list)
                                      <option value="{{$list->code}}" id="zone{{$list->code}}" class="zoneOpt">{{$list->name}}</option>
                                  @endforeach
                              </select>
                                </td>
                              </tr>
                              <tr>               
                                <td class="modalTd">地址</td>
                                <td><input type="text" class="modalInput" id="storeAddr"></td>
                              </tr>
                              <!-- <tr id="editParentCode">               
                                <td class="modalTd">父店</td>
                                <td>
                                  <select type="text" id="parent_code"  style="width: 150px" class="form-control">
                                  <option value="" id="noParentCode">无</option>
                                 @foreach($parentStore as $list)
                                  <option value="{{$list->code}}" id="{{$list->code}}" class="editParentCodeOpt">{{$list->name}}</option>
                                 @endforeach
                              </select>
                                </td>
                              </tr> -->
                              <tr>               
                                <td class="modalTd">店铺类型</td>
                                <td>
                                  <select type="text" id="storeType" disabled="disabled" style="width: 150px" class="form-control">
                                  <option value="2" id="typeOp1">分店</option>
                                  <option value="1" id="typeOp2">总店</option>
                              </select>
                                </td>
                              </tr>
                              @if(0)
                              <!-- <tr>               
                                <td class="modalTd">总店</td>
                                <td>
                                  <select type="text" id="parent_code"  style="width: 150px" class="form-control">
                                 @foreach($parentStore as $list)
                                  <option value="{{$list->code}}">{{$list->name}}</option>
                                 @endforeach
                              </select>
                                </td>
                              </tr> -->
                              @endif
                    </table>
                  </div>
                </div>
                <div class="modal-footer">
                  <div id="errMsg" style="color: red;float: left;"></div>
                  <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                  <button type="button" class="btn btn-default" id="subBtn">保存</button>
                </div>
              </div>
            </div>
          </div>
          <script type="text/javascript">
          /*消除错误提示信息*/
          $('#storeName').click(function(){
            $('#errMsg').html('');
          });
          $('#storeAddr').click(function(){
            $('#errMsg').html('');
          })
          // $('#parent_code').change(function(){
          //   $('#errMsg').html('');
          // });
          $('#storeAdd').click(function(){
            $('.zoneOpt').removeAttr('selected');
            $('#zone'+"{{$zoneCode}}").prop('selected', 'selected');
            $('#storeZone').attr('disabled', 'disabled');
            // $('#addZone').hide();
            $('#editTitle').text('添加店铺');
            $('#errMsg').html('');
            $('#storeId').val('');
            $('#storeName').val('');
            $('#storeCode').val('');
            $('#storeCodeTr').hide();
            $('#storeAddr').val('');
            // $('#parent_code').removeAttr('disabled');
            // $('#'+$('#parent_code').val()).removeAttr('selected');
            // $('#noParentCode').attr('selected','selected');
            // $('#editParentCode').hide();
            $('#typeOp1').html('分店');
            $("#typeOp1").val('2');
            $('#typeOp2').html('总店');
            $("#typeOp2").val('1');
          });
          $('.storeEdit').click(function(){
            $('#storeZone').removeAttr('disabled');
            $('.zoneOpt').removeAttr('selected');
            $('#zone'+"{{$zoneCode}}").prop('selected', 'selected');
            $('#addZone').show();
            $('#editTitle').text('修改店铺');
            $('#errMsg').html('');
            var editCode = $(this).parent().siblings('.editCode').text();
            var storeId = $(this).parent().siblings('.editId').text();
            $('#storeId').val(storeId);
           $.ajax({
                  url: "{{URL::action('StoreStoreController@index')}}"+"/"+editCode,
                  type: 'GET',
                  success: function(result) {
                    if(result['status']){
                      var zoneCode = "{{$zoneCode}}";
                      var editStore = result['data'];
                      $('#storeName').val(editStore['name']);
                      $('#storeCode').html(editStore['code']);
                      $('#storeCodeTr').show();
                      // $('#zone'+editStore['zone_code']).prop('selected', 'selected');
                      $('#storeAddr').val(editStore['addr']);
                      // if(zoneCode == ""){
                      //   $('#parent_code').attr('disabled','disabled');
                      // }
                      // $('.editParentCodeOpt').show();
                      // $('#'+editStore['code']).hide();
                      // if(editStore['parent_code'] == ""){
                      //   $('#noParentCode').attr('selected','selected');
                      // }else{
                      //   $('#'+editStore['parent_code']).attr('selected','selected');
                      // }
                      // $('#editParentCode').show();
                      if(editStore['type'] == 2){
                        $('#typeOp1').html('分店');
                        $("#typeOp1").val('2');
                        $('#typeOp2').html('总店');
                        $("#typeOp2").val('1');
                      }else{
                        $('#typeOp1').html('总店');
                        $("#typeOp1").val('1');
                        $('#typeOp2').html('分店');
                        $("#typeOp2").val('2');
                      }
                      }else{
                        $('#errMsg').html(result['msg']);
                      }                        
                    }
              });
            $('#storeId').val($(this).val());
              
          })
            /*添加店铺*/
            $('#subBtn').click(function(){
              var id = $('#storeId').val();
              var code = $('#storeCode').val();
              var name = $('#storeName').val();
              var addr = $('#storeAddr').val();
              var type = $('#storeType').val();
              var zone_code = $('#storeZone').val();
              // var parent_code = $('#parent_code').val();
              // var city_zone = $('#city_zone').val();
              // var company_code = $('#company_code').val();
             if(!name){
                console.log('a');
                $('#errMsg').text('店铺名称不能为空');
              }else if(!addr){
                $('#errMsg').html('店铺地址不能为空');
              }else{
                $.post("{{URL::action('StoreStoreController@store')}}",
                {
                 id:id,
                 code:code,
                 name:name,
                 addr:addr,
                 type:type,
                 // parent_code:parent_code,
                 // city_zone:city_zone,
                 // company_code:company_code,
                 zone_code:zone_code,
                },function(data){
                  if(data['status']){
                    window.location.reload(true);
                  }else{
                    $('#errMsg').html(data['msg']);
                  }

                })
              }
            });
            /*以公司名称查找*/
            $('#company').change(function(){
              var company = $('#company').val();
              window.location.href = "{{url('/store/company_key')}}"+"/"+company;
            });
            /*以城市名称查找*/
            $('#city').change(function(){
              var city = $('#city').val();
              window.location.href = "{{url('/store/city_key')}}"+"/"+city;
            });
            /*以店铺名称查找*/
            $('#nameFind').click(function(){
              var name = $('#name').val();
              if(!name)
                window.location.href = "{{url('/store/name_key')}}"+"/allName";
              else
                window.location.href = "{{url('/store/name_key')}}"+"/"+name;
            });
            /*删除*/
            $('.storeDel').click(function(){
              var key = $(this).val();
              var content = '确定删除？';
              if(confirm(content)){
                $.ajax({
                          url: "{{url('/store')}}"+"/"+key,
                          type: 'DELETE',
                          success: function(result) {
                            if(result['status']){
                              window.location.reload(true);
                              }                     
                            }
                      });
              }

            });
          </script>
 @endsection