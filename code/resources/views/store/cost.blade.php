@extends('layouts.nav')
@section('content')
<style type="text/css">
        .image_container {
            display: inline-block;
            float: left;
        }

            #tdRoomPicture a, .image_container a,.image_containerEdit a {
                text-align: center;
                vertical-align: middle;
                text-decoration: none;
            }

        a.addImg {
            width: 100px;
            height: 100px;
            line-height: 100px;
            display: inline-block;
            font-size: 50px;
            background-color: #dae6f3;
        }

        .image_container a.previewBox {
            background-color: #dae6f3;
            margin: 0 3px 0 0;
            display: none;
            /*display: inline-block;*/
        }

        .image_container .delImg {
            position: absolute;
            color: #f00;
            margin: 0 0 0 84px;
            font-size: 16px;
            width: 16px;
            height: 16px;
            line-height: 16px;
            text-align: center;
            vertical-align: middle;
            background-color: #c3c3c3;
        }

        
    </style>
<section class="vbox">
            <section class="scrollable padder">
            <marquee direction=left class="headerMarquee">欢迎使用xxx房产记账结算管理系统！</marquee>
            <ul class="breadcrumb no-border no-radius b-b b-light pull-in">
              <li><i class="fa fa-home"></i> 主页</li>
              <li class="active">成本录入</li>
            </ul>
            
            <section class="panel panel-default">
              <div class="table-responsive" >
                <!-- <div class="tips">
                  <div class="tipsDiv">
                    <div>说明：1.可以通过点击下拉菜单进行店铺查找以及切换。
                    </div>
                    <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2.点击添加新成本按钮可以添加新成本信息。</div>
                    <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3.点击查看按钮可以查看偿还分期以及还款店铺信息。</div>
                    <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4.点击修改按钮可以修改当前成本具体信息。</div>
                  </div>
                  <img src="{{ asset('static/images/cost.gif') }}">
                </div> -->
                <table class="headerStyle">
                  <tr>
                    <th class="headertitle">
                        成本录入表
                    </th>
                    <th>
                    @if(in_array(session::get('level_code'), ['cw', 'dz','zl']))
                    <button class="btn btn-sm btn-default contractStyle" data-toggle="modal" data-target="#modifyStore" id="costAdd" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';">添加新成本</button>
                    @endif
                    @if(in_array(session::get('level_code'), ['cw']))
                    <button class="btn btn-sm btn-default contractStyle" data-toggle="modal" data-target="#categoryConfigShow" id="categoryConfig" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';">类目调整</button>
                    @endif
                    </th>
                  </tr>
                </table>
                <table class="table table-striped b-t b-light text-sm headerStyle2">
                  <tr>
                    <th>
                      <label class="labelStyle">区域／店铺&nbsp;&nbsp;</label>
                      <select class="input-sm form-control input-s-sm inline" id="store_code" disabled>
                        <option value="{{$store->code}}">{{$store->name}}</option>
                        @foreach($cost->store as $list)
                          @if($list->code != $store->code)
                          <option value="{{$list->code}}">{{$list->name}}</option>
                          @endif
                        @endforeach
                      </select>
                    </th>
                    <th>
                      <label class="labelStyle costTimeStyle">年 / 月&nbsp;&nbsp;</label> 
                      <select class="input-sm form-control input-s-sm inline" id="year">
                        <option value="{{$year}}">{{$year}}</option>
                          @for($i = $pay_year_start; $i <= $pay_year_end; $i++)
                            @if($i != $year)
                              <option value="{{$i}}">{{$i}}</option>
                           @endif
                          @endfor
                      </select>   
                      <select class="input-sm form-control input-s-sm inline" id="month">
                        <option value="{{$month}}">{{$month}}</option>
                          @for($i = 1; $i < 13 ; $i++)
                            @if($i != $month)
                             <option value="{{$i}}">{{$i}}</option>
                             @endif
                             @endfor
                      </select>
                    </th>
                  </tr>
              </table>
              </div>
              <div class="table-responsive" >
                <table class="table table-striped b-t b-light text-sm" id="table1">
                  <thead>
                    <tr>
                      <th>类目</th>
                      <th>明细</th>
                      <th>店铺</th>
                      <th>年</th>
                      <th>月</th>
                      <th>总额</th>
                      <th>偿还月份</th>
                      <th>每期还款金额</th>
                      <th>还款店铺</th>
                      @if(session('level_code') == 'cw')
                      <th>操作</th>
                      @endif
                    </tr>
                  </thead>
                  <tbody>
                   @foreach($cost as $list)
                    <tr>
                      <td class="editId" style="display: none;">{{$list->id}}</td>                     
          					  <td>{{$list->category}}</td>
                      <td>{{$list->details}}</td>
                      <td>{{$list->owner_store_name}}</td>
                      <td>{{$list->year}}</td>
                      <td>{{$list->month}}</td>
                      <td>{{$list->total}}</td>
          					  <td>
                        <button class="btn btn-sm btn-default detailShow operate" value="{{$list->pay_month}}" data-toggle="modal" data-target="#myModal" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';">查看详情</button>
                      </td>
          					  <td>{{$list->unit}}</td>
          					  <td>
                        <button class="btn btn-sm btn-default detailShow operate" value="{{$list->pay_stores}}" data-toggle="modal" data-target="#myModal" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';">查看详情</button>
                      </td>
                      @if(session('level_code') == 'cw')
                      <td>                 
                      	 <button class="btn btn-sm btn-default costEdit operate" data-toggle="modal" data-target="#modifyStore" value="{{$list->id}}" onmouseover="this.style.backgroundColor='#33C1A4'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#17c5cb';this.style.color = 'white';">修改</button>
                         <button class="btn btn-sm btn-default costDel operate deleteColor" value="{{$list->id}}" onmouseover="this.style.backgroundColor='#fb6b5b'; this.style.color = 'white';" onmouseout="this.style.backgroundColor = '#fb6b5b';this.style.color = 'white';">删除</button>
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
                  @if(count($cost) > 9)
                    {!! $cost->links() !!}
                  @endif
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
          <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
           <!-- 显示详情弹框 -->
 <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">查看详情</h4>
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
</div>
 <!-- 添加弹框 -->
          <div class="modal fade" id="modifyStore" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="editHead">成本录入</h4>
                </div>
                <div class="modal-body">
                  <div class="table-responsive">
                    <table class="table">                
                              <tr>
                                <input type="text" id="costId" style="display: none;">
                                <td class="modalTd">明细</td>
                                <td><input type="text" class="modalInput" id="details"></td>   
                              </tr>
                               <tr>                     
                                <td class="modalTd">类目</td>
                                <td>
                                  <select id="category" class="input-sm form-control input-s-sm inline">
                                    @foreach($categoryList as $list)
                                      <option value="{{$list->value}}" id="category{{$list->value}}">{{$list->value}}</option>
                                    @endforeach
                                  </select>
                                </td>
                              </tr>             
                              <tr>                     
                                <td class="modalTd">总额</td>
                                <td><input type="number" class="modalInput" id="total"></td>
                              </tr>
                              <tr>               
                                <td class="modalTd">店铺</td>
                                <td>
                                  <select class="input-sm form-control input-s-sm inline" disabled="disabled" id="owner_store_code">
                                    <
                                    @foreach($cost->store as $list)
                                      <option value="{{$list->code}}" class="ownerStoreOpt" id="{{$list->code}}">{{$list->name}}</span>
                                      </option>
                                    @endforeach
                                  </select>  
                                </td>
                              </tr>
                              <tr>               
                                <td class="modalTd">开始偿还时间</td>
                                <td>
                                  <input type="month" value="{{$year}}-{{$month}}" id="start_time">
                                </td>
                              </tr>
                              <tr>               
                                <td class="modalTd">分期数</td>
                                <td><input type="number" class="modalInput" id="length"></td>
                              </tr>
                              <tr>               
                                <td class="modalTd">偿还方式</td>
                                <td>
                                  <select class="input-sm form-control input-s-sm inline" disabled="disabled" id="payType">
                                      <option value="1" id="payTypeOp1">自付</option>
                                      <option value="2" id="payTypeOp2">分摊</option>
                                  </select>   
                                </td>
                              </tr>
                              <tr>
                            <td>添加图片</td>
                            <td> 
                               <form id="Form1" method="post" enctype="multipart/form-data">
                                    <div id="tdRoomPicture">
                                        <a href="javascript:;" class="addImg" data-picid="0">+</a>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    </table>
                  </div>
                </div>
                <div class="modal-footer">
                  <span id="errMsg" style="color: red;float: left;"></span>
                  <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                  <button type="button" class="btn btn-default" id="subBtn">保存</button>
                </div>
              </div>
            </div>
          </div>
          
           <!-- 添加弹框 -->
          <div class="modal fade" id="categoryConfigShow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel">类目配置</h4>
                </div>
                <div class="modal-body">
                  <div class="table-responsive">
                    <table class="table" id="tbCategory"> 
                    <tr>                      
                          <th style="width:75%">类目名称</th>
                          <th style="width:25%">
                              <i class="fa fa-plus icon" id="addLineCategory">
                                  <b class="bg-primary indexColor"></b>
                              </i>
                          </th>
                      </tr>            
                       <!-- 克隆的tr -->
                      <tr style="display: none;">
                          
                          <td>
                              <input class="categoryValue"  type="text">
                          </td>
                          <td>
                              <i class="fa fa-times icon minusLinePort">
                                  <b class="bg-primary indexColor"></b>
                              </i>
                          </td>
                      </tr>
                  <!-- end -->
                  <!-- 遍历现有的 -->
                  @foreach($categoryList as $list)
                          <tr>
                              <td>
                                  <input class="categoryValue" value="{{$list->value}}" type="text">
                              </td>
                              <td>
                                  <i class="fa fa-times icon minusLinePort">
                                      <b class="bg-primary indexColor"></b>
                                  </i>
                              </td>
                          </tr>
                    @endforeach
                      <!-- end -->            
                    </table>
                  </div>
                </div>
                <div class="modal-footer">
                  <span class="errMsg" style="color: red;float: left;"></span>
                  <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                  <button type="button" class="btn btn-default" id="saveCategory">保存</button>
                </div>
              </div>
            </div>
          </div>
          <script type="text/javascript">
          /*类目调整*/
          /*分档线加一行*/
              $('#addLineCategory').click(function(){
                /*去除提示*/
                $('.errMsg').text('');
                var tr = $("#tbCategory tr").eq(1).clone(true);
                tr.show();   
                tr.appendTo("#tbCategory");
              });
              /*类目减一行*/
              $('.minusLinePort').click(function(){
                $('.errMsg').text('');
                $(this).parent().parent('tr').remove();
              })
              /*保存分档规则*/
              $('#saveCategory').click(function(){
                /*去除提示*/
                $('.saveCategory').text('');
                var type = 1;
                var words = new Array();
                for (var i = 1; i <= $('.categoryValue').length - 1; i++) {
                  var categoryValue = $('.categoryValue').eq(i).val();
                  if(categoryValue == ""){
                    $('.errMsg').html('不能为空');
                    break;
                  }
                  words[i-1] = categoryValue;
                }
                if(i == ($('.categoryValue').length)){
                  $.post("{{url('/using_words')}}",
                    {words:words, type:type},function(data){
                      if(data['status']){
                        window.location.reload(true);
                      }else{
                        $('#errmsgPort').html(data['msg']);
                      }
                    });
                }

              });
            /*添加成本*/
            $('#costAdd').click(function(){
              $('.image_container').remove();
              $('.previewBoxEdit').remove(); //去除之前图片
              /*去除错误提示*/
              $('#errMsg').html('');
              /*弹框头部*/
              $('#editHead').text('成本录入');
              $('#costId').val('');
              $('#category').val('');
              $('#total').val('');
              $('#length').val('');
              var store_code = $('#store_code').val();
              $('#'+store_code).attr('selected','selected');
              $.post("{{url('/cost/storetype')}}",
                {store_code:store_code},
                function(result){
                  if(result == "1"){
                    $('#payTypeOp1').val('2');
                    $('#payTypeOp1').html('分摊');
                  }else{
                    $('#payTypeOp1').val('1');
                    $('#payTypeOp1').html('自付');
                  }
              });
            })
            /*编辑*/
            $('.costEdit').click(function(){
              $('.image_container').remove();
              $('.previewBoxEdit').remove(); //去除之前图片
              /*去除错误提示*/
              $('#errMsg').html('');
              /*弹框头部信息*/
              $('#editHead').text('成本修改');
              var costId = $(this).parent().siblings('.editId').text();
              $('#costId').val(costId);
             $.ajax({
                    url: "{{URL::action('StoreCostController@index')}}"+"/"+costId,
                    type: 'GET',
                    success: function(result) {
                      if(result['status']){
                            var editCost = result['data'];
                            $('#details').val(editCost['details']);
                            $('#category'+editCost['category']).prop('selected', 'selected');
                            $('#total').val(editCost['total']);
                            $('#'+editCost['owner_store_code']).prop('selected','selected');
                            var start_month = editCost['start_month'];
                            if(editCost['start_month'] < 10){
                              start_month = '0'+start_month;
                            }
                            $('#start_time').val(editCost['start_year']+'-'+start_month);
                            $('#length').val(editCost['length']);
                            if(editCost['payType'] == "1"){
                              $('#payTypeOp1').val('1');
                              $('#payTypeOp1').html('自付');
                            }else{
                              $('#payTypeOp1').val('2');
                              $('#payTypeOp1').html('分摊');
                            }
                          var images = editCost.images;
                          for (var i = 0; i < images.length; i++) {
                              var imageAppend = "<a href=\"javascript:;\" id=\"previewBoxEdit" + i + "\" class=\"previewBoxEdit\">"
                                              + "<div class=\"delImgEdit\" style=\"position: absolute;color: #f00;margin: 0 0 0 84px;font-size: 16px;width: 16px;height: 16px;line-height: 16px;text-align: center;vertical-align: middle;background-color: #c3c3c3;\" onclick=\"delImageEditById("+images[i].id+", this)\">&times;</div>"
                                              + "<img class=\"imageDetailschild\" src=\"" + images[i].url + "\" style=\"height:100px;width:100px;border-width:0px;\" />"
                                          + "</a>";
                              $('.addImg').before(imageAppend);
                          }
                        }else{
                          $('#errMsg').html(result['msg']);
                        }                        
                      }
                });    
            });
            $('#start_time').click(function(){
              /*去除错误提示*/
              $('#errMsg').html('');
            })
            $('#category').click(function(){
              /*去除错误提示*/
              $('#errMsg').html('');
            })
            $('#total').click(function(){
              /*去除错误提示*/
              $('#errMsg').html('');
            })
            $('#length').click(function(){
              /*去除错误提示*/
              $('#errMsg').html('');
            })
            /*提交*/
            $('#subBtn').click(function(){
              var start_time = $('#start_time').val();
              var start_month = start_time.substr(5, 2);
              var start_year = start_time.substr(0, 4);
              if(start_month.substr(0, 1) == 0){
                start_month = start_month.substr(1, 1);
              }
              var id = $('#costId').val();
              var category = $('#category').val();
              var details = $('#details').val();
              var total = $('#total').val();
              var length = parseInt($('#length').val());
              var owner_store_code = $('#owner_store_code').val();
              var payType = $('#payType').val();
              if(!details){
                $('#errMsg').html('请填写明细');
              }else if(!category){
                $('#errMsg').html('请填写类目');
              }else if(total < 0 || !total){
                $('#errMsg').html('请正确填写总额');
              }else if(!start_time){
                $('#errMsg').html('请填写开始偿还时间');
              }else if(length < 0 || !length){
                $('#errMsg').html('请正确填写分期数');
              }else{
                $.post("{{URL::action('StoreCostController@store')}}",
                  {
                    id:id,
                    details:details,
                    category:category,
                    total:total,
                    owner_store_code:owner_store_code,
                    start_year:start_year,
                    start_month:start_month,
                    length:length,
                    payType:payType
                  },function(data){
                    if(data['status']){
                      uploadImagesAjax(data.data);
                      // window.location.href = "/cost/time_key/"+owner_store_code+"-"+start_year+"-"+start_time.substr(5, 2);
                    }else{
                     $('#errMsg').html(data['msg']);
                    }
                  });
              }
            })
            /*查看月份详情*/
            $(".detailShow").click(function(){
              $('.detailTr').hide();
              var content = $(this).val();
              $("#detailTable").append(content);
            }) 
            /*选年份查找*/
            $('#year').change(function(){
              keyFind();
            })
            /*选月份查看*/ 
            $('#month').change(function(){
              keyFind();
            })
            /*选店铺查找*/
          	$('#store_code').change(function(){
          		keyFind();
          	});

          /*查找函数*/
            function keyFind(){
              var store_code = $('#store_code').val();
              var year = $('#year').val();
              var month = $('#month').val();
              window.location.href = "{{url('/cost/time_key')}}"+"/"+store_code+"-"+year+"-"+month;
            }
            /*删除*/
            $('.costDel').click(function(){
              var key = $(this).val();
              var content = '确定删除？';
              if(confirm(content)){
                $.ajax({
                          url: "{{url('/cost')}}"+"/"+key,
                          type: 'DELETE',
                          success: function(result) {
                            if(result['status']){
                              window.location.reload(true);
                              }                     
                            }
                      });
              }

            });

    /*图片ajax*/
   function uploadImagesAjax($cost_id){
        var formData = new FormData($('#Form1')[0]);
        $.ajax({
            url: "{{url('/cost/images')}}/"+$cost_id,
            type: 'POST',
            cache: false,
            data: formData,
            processData: false,
            contentType: false
        }).done(function(res) {
            if(res.status == 1){
                alert('添加成功');
                window.location.reload(true);
            }else{
                $('#errMsg').text(res.msg);
            }
        }).fail(function(res) {

        });
   }

   /*删除已上传图片*/
    function delImageEditById(id, delThis){
        var info = "此图片已上传，确定删除？";
        if(confirm(info)){
            $.get("{{url('/contract/image/del')}}/"+id, function(result){
                if(result.status == 1){
                    $(delThis).parent().empty();
                }
            })
        }        
    }

  /*添加图片*/
   $(function () {
            var picId = 0;
            var pictureUploading = false;
            $("#Form1").delegate(".addImg", "click", function () {
                if (!!pictureUploading) return;
                pictureUploading = true;

                picId = parseInt($(this).attr("data-picId"));
                picId++;
                $(this).attr("data-picId", picId);

                $(this).before("<div class=\"image_container\" data-picId=\"" + picId + "\">"
                                + "<input class=\"uploadImages\" id=\"RoomInfo1_RoomPicture" + picId + "\" name=\"RoomInfo1_RoomPicture" + picId + "\" type=\"file\" accept=\"image/jpeg,image/png,image/gif\" style=\"display: none;\" />"
                                + "<input id=\"RoomInfo1_RoomPictureHidDefault" + picId + "\" name=\"RoomInfo1_RoomPictureHidDefault" + picId + "\" type=\"hidden\" value=\"0\" />"
                                + "<a href=\"javascript:;\" id=\"previewBox" + picId + "\" class=\"previewBox\">"
                                    + "<div class=\"delImg\">&times;</div>"
                                    + "<img id=\"preview" + picId + "\" style=\"height:100px;width:100px;border-width:0px;\" />"
                                + "</a>"
                            + "</div>");

                $("#RoomInfo1_RoomPicture" + picId).change(function () {
                    var $file = $(this);
                    var fileObj = $file[0];
                    var windowURL = window.URL || window.webkitURL;
                    var dataURL;

                    $("#previewBox" + picId).css("display", "inline-block");
                    var $img = $("#preview" + picId);
                    //var $img = $("#preview1");

                    if (fileObj && fileObj.files && fileObj.files[0]) {
                        dataURL = windowURL.createObjectURL(fileObj.files[0]);
                        $img.attr('src', dataURL);
                    } else {
                        dataURL = $file.val();
                        var imgObj = $img; //document.getElementById("preview");
                        // 两个坑:
                        // 1、在设置filter属性时，元素必须已经存在在DOM树中，动态创建的Node，也需要在设置属性前加入到DOM中，先设置属性在加入，无效；
                        // 2、src属性需要像下面的方式添加，上面的两种方式添加，无效；
                        imgObj.style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale)";
                        imgObj.filters.item("DXImageTransform.Microsoft.AlphaImageLoader").src = dataURL;
                    }

                    if (1 === picId) {
                        defaultImg(picId, true);
                    }
                    pictureUploading = false;

                });
                $("#RoomInfo1_RoomPicture" + picId).click();

                //设置默认图片
                // $(".previewBox").click(function () {
                //     var _picId = parseInt($(this).parent(".image_container").attr("data-picId"));
                //     $(".image_container").each(function () {
                //         var i = parseInt($(this).attr("data-picId"));
                //         if (i === _picId)
                //             defaultImg(i, true);
                //         else
                //             defaultImg(i, false);
                //     });
                // });

                //删除上传的图片
                $(".delImg").click(function () {
                    var _picId = parseInt($(this).parent().parent(".image_container").attr("data-picId"));
                    $(".image_container[data-picid='" + _picId + "']").remove();
                    if ($(".image_container").length > 0 && $(".defaultImg").length < 1) {
                        $(".image_container").each(function () {
                            var i = parseInt($(this).attr("data-picId"));
                            defaultImg(i, true);
                            return false;
                        });
                    }

                });

            });

            function defaultImg(picId, selected) {
                if (!picId) return;
                if (!!selected) {
                    $("#RoomInfo1_RoomPictureHidDefault" + picId).val(1);
                    $("#previewBox" + picId).addClass("defaultImg");
                }
                else {
                    $("#RoomInfo1_RoomPictureHidDefault" + picId).val(0);
                    $("#previewBox" + picId).removeClass("defaultImg");
                }
            }
        });
          </script>
@endsection