@extends('layouts.nav')
@section('content')
<section class="vbox">
    <section class="scrollable padder">
        <marquee direction=left class="headerMarquee">欢迎使用xxx房产记账结算管理系统！
        </marquee>
        <ul class="breadcrumb no-border no-radius b-b b-light pull-in">
            <li><i class="fa fa-home"></i> 主页</li>
        </ul>
        <div class="table-responsive" >
          <table class="table table-striped b-t b-light text-sm">
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
        <div class="m-b-md">
            <h4 class="m-b-none">成本记录(单位：元)</h4>
        </div>
        <section class="panel panel-default">
            <div class="row m-l-none m-r-none bg-light lter " id="cost_block">
              <div class="col-sm-6 col-md-3 padder-v b-r b-light panel" style="display: none;" id="cost_details">
                <span class="fa-stack fa-2x pull-left m-r-sm">
                  <i class="fa fa-circle fa-stack-2x text-info"></i>
                  <i class="fa fa-group fa-stack-1x text-white"></i>
                </span>
                  <span class="h3 block m-t-xs"> <strong class="strongColor" id="amonut"></strong>
                  </span>
                  <small class="text-muted text-uc" id="categories"></small>
              </div>
            </div>
        </section>
        <div class="table-responsive" style="background-color:rgb(247,247,247)">
        
          <table class="table table-striped text-sm" id="two-charts" style="background-color:rgb(247,247,247)">
            <tr>
              <th style="background-color:rgb(247,247,247)">
                <div id="ichart-render1" class="ichartStyle"></div>
              </th>
              <th style="background-color:rgb(247,247,247)">
                <div id="ichart-render" class="ichartRenderstyle"></div>  
              </th>
            </tr>
          </table>
        
        </div>
        <div class="table-responsive">
        <div id="container" class="chartStyle"></div>
        <div class="saleStyle">
            <table class="table table-striped b-t b-light text-sm" style="overflow:auto;height:286px">
            <header class="panel-heading bg-primary dker no-border" style="background-color:#17c5cb">
              <strong>最佳销售前八名</strong>
            </header>
            <thead>
              <tr>
                <th>名次</th>
                <th>店铺</th>
                <th>姓名</th>
                <th>销售额</th>
              </tr>
            </thead>
            <tbody>
            @for($i = 0; $i < count($best_seller); $i++)
            <tr>
                <td><span class="badge bg-success" style="background-color:#17c5cb">第{{ $i+1 }}名</span></td>
                <td>{{ $best_seller[$i]['store_name'] }}</td>
                <td>{{ $best_seller[$i]['name'] }}</td>
                <td>{{ $best_seller[$i]['sum']}}元</td>               
            </tr>
            @endfor

            
            </tbody>
          </table>
        </div>
        <div class="footerDiv">
          <table class="table table-striped b-t b-light text-sm" style="overflow:auto;height:286px">
            <header class="panel-heading bg-primary dker no-border" style="text-align:center;background-color:#17c5cb">
              <strong>最佳销售店铺前八名</strong>
            </header>
            <thead>
              <tr>
                <th>名次</th>
                <th>店铺</th>
                <th>销售额</th>
              </tr>
            </thead>
            <tbody>
            @for($i = 0; $i < count($best_store); $i++)
            <tr>
                <td><span class="badge bg-success" style="background-color:#17c5cb">第{{ $i+1 }}名</span></td>
                <td>{{ $best_store[$i]['name'] }}</td>
                <td>{{ $best_store[$i]['sum'] }}元</td>               
            </tr>
            @endfor
            </tbody>
          </table>
        </div> 
        <div class="row note">
              <div>
                <header class="panel-heading bg-primary dker no-border" style="background-color:#17c5cb">
                    <strong>重要通知
                        <a href="#" style="margin-left:70%" onclick="addNote();">
                            <i class="fa fa-plus"></i>
                        </a>
                    </strong>
                </header>
                  
              
                <ul class="list-group gutter list-group-lg list-group-sp sortable ul_class" style="overflow:auto;height:286px">
                @foreach($note as $list)
                  <li class="list-group-item box-shadow li_del_hidden{{ $list->id }}" style="display:block">
                    <a href="#" class="pull-right delNote"  style="line-height:25px" >
                        <input type="hidden" class="cDelNote" value="{{ $list->id }}">
                        <i class="fa fa-times "></i>  
                    </a> 
                  <div class="clear">
                  <input type="text" value="{{ $list->text }}" style="width:80%;height:25px" readonly="readonly">
                  </div>
                  </li>
                @endforeach
                    <li class="list-group-item box-shadow clone_class" style="display:none">
                    <a href="#" class="pull-right" data-dismiss="alert" style="line-height:25px" >
                        <input type="hidden" class="cDelNote">
                        <i class="fa fa-times "></i>  
                    </a> 
                  <div class="clear">
                  <input type="text" class="note_text" placeholder="字数最多不超过20"  style="width:80%;height:25px">
                  <button class="btn_save" style="width:50px;height:25px;font-size:12px;line-height:15px;text-align: center;padding: 0;background-color: #17c5cb;color: white;">保存</button>
                  
                  </div>
                  </li>
                </ul>

                
                  

              </div>
        </div>
        </div>
    </section>
     <div class="copyRight">
          <div >版权所有: locqj
            </div>
            </div>
  </section>
   <script src='http://www.ichartjs.com/ichart.latest.min.js'></script>
<script>
    function addNote(){
            var clone_class = $('.clone_class');
            var clo = clone_class.clone(true);
            $(clo).removeClass("clone_class");
            $(clo).show();
            $('.ul_class').append(clo);
    }
    $(function() {

        $('.btn_save').click(function(){
            var texts = $(this).prev('input').val();
            var this_val = $(this);
            if(!texts) {
                alert('内容不得为空');
            } else {
                
                $.post('/note/sub', {
                    text: texts
                }, function(data) {
                    if(data.status) {
                        alert('添加成功');
                        this_val.hide();
                        this_val.prev('input').removeClass('note_text');
                    } else {
                        alert('网络错误，稍后重试！');
                    }
                });
            }
        });
        $('.delNote').click(function(){
            var id = $(this).children('.cDelNote').val();
            if(confirm('确定删除？')) {
                $.get('/note/del/'+id, function(data) {
                    
                    if(data.status == 1) {
                        //window.location.reload();
                        $('.li_del_hidden'+id).hide();
                    }
                }) 
            }
        });
    });

</script>
<script type='text/javascript'>
$(function(){
    var month = $('#month').val();
    var year = $('#year').val();
    var store_code = $('#searchstore').val();
    loadCharts(store_code, year, month)
    $(document).ready(function(){
        /*搜索公司员工*/
        $('#searchstore').change(function(event) {
            var month = $('#month').val();
            var year = $('#year').val();
            var store_code = $('#searchstore').val();
            loadCharts(store_code, year, month);
           });
            $('#year').change(function(event) {
            var month = $('#month').val();
            var year = $('#year').val();
            var store_code = $('#searchstore').val();
            loadCharts(store_code, year, month);
            
           });
        $('#month').change(function(event) {
            var month = $('#month').val();
            var year = $('#year').val();
            var store_code = $('#searchstore').val();
            loadCharts(store_code, year, month);
        });
    });
});
function loadCharts(store_code, year, month)
{
    $.get('/api/charts/'+store_code+'-'+year+'-'+month, function(data) {
      
      var chart2 = iChart.create({
            render:"ichart-render1",
            width:600,
            height:400,
            background_color:"rgb(247,247,247)",
            gradient:false,
            color_factor:0.2,
            border:{
                  color:"#e8e8e8",
                  width:0
            },
            align:"center",
            offsetx:0,
            offsety:0,
            sub_option:{
                  border:{
                        color:"#BCBCBC",
                        width:1
                  },
                  label:{
                        fontweight:600,
                        fontsize:12,
                        color:"#4572a7",
                        sign:"square",
                        sign_size:12,
                        border:{
                              color:"#BCBCBC",
                              width:1
                        },
                        background_color:"#fefefe"
                  }
            },
            shadow:true,
            shadow_color:"#666666",
            shadow_blur:2,
            showpercent:true,
            column_width:"70%",
            bar_height:"70%",
            radius:"70%",
            title:{
                  text:"成本明细",
                  color:"#111111",
                  fontsize:20,
                  font:"微软雅黑",
                  textAlign:"center",
                  height:30,
                  offsetx:0,
                  offsety:0
            },
            subtitle:{
                  text:"成本总额："+data.outcome+"元",
                  color:"#111111",
                  fontsize:16,
                  font:"微软雅黑",
                  textAlign:"right",
                  height:20,
                  offsetx:0,
                  offsety:0
            },
            footnote:{
                  text:"",
                  color:"#111111",
                  fontsize:12,
                  font:"微软雅黑",
                  textAlign:"right",
                  height:20,
                  offsetx:0,
                  offsety:0
            },
            legend:{
                  enable:false,
                  background_color:"#fefefe",
                  color:"#333333",
                  fontsize:12,
                  border:{
                        color:"#BCBCBC",
                        width:1
                  },
                  column:1,
                  align:"right",
                  valign:"bottom",
                  offsetx:0,
                  offsety:0
            },
            coordinate:{
                  width:"80%",
                  height:"84%",
                  background_color:"#ffffff",
                  axis:{
                        color:"#a5acb8",
                        width:[1,"",1,""]
                  },
                  grid_color:"#d9d9d9",
                  label:{
                        fontweight:500,
                        color:"#666666",
                        fontsize:11
                  }
            },
            label:{
                  fontweight:500,
                  color:"#666666",
                  fontsize:11
            },
            type:"pie2d",
            data:data.cost
      });
      


      var chart = iChart.create({
            render:"ichart-render",
            width:475,
            height:400,
            background_color:"rgb(247,247,247)",
            gradient:false,
            color_factor:0.2,
            border:{
                  color:"#e8e8e8",
                  width:0
            },  
            align:"center",
            offsetx:0,
            offsety:0,
            sub_option:{
                  border:{
                        color:"#e4e4e4",
                        width:1
                  },
                  label:{
                        fontweight:500,
                        fontsize:11,
                        color:"#4572a7",
                        sign:"square",
                        sign_size:12,
                        border:{
                              color:"#e4e4e4",
                              width:1
                        },
                        background_color:"#fefefe"
                  }
            },
            shadow:true,
            shadow_color:"#666666",
            shadow_blur:2,
            showpercent:false,
            column_width:"70%",
            bar_height:"70%",
            radius:"90%",
            title:{
                  text:"收入-成本-利润",
                  color:"#111111",
                  fontsize:20,
                  font:"微软雅黑",
                  textAlign:"center",
                  height:30,
                  offsetx:0,
                  offsety:0
            },
            subtitle:{
                  text:"收入总额："+data.bouns_count+"元",
                  color:"#111111",
                  fontsize:16,
                  font:"微软雅黑",
                  textAlign:"right",
                  height:20,
                  offsetx:0,
                  offsety:0
            },
            footnote:{
                  text:"",
                  color:"#111111",
                  fontsize:12,
                  font:"微软雅黑",
                  textAlign:"right",
                  height:20,
                  offsetx:0,
                  offsety:0
            },
            legend:{
                  enable:false,
                  background_color: "#fefefe",
                  color:"#333333",
                  fontsize:12,
                  border:{
                        color:"#BCBCBC",
                        width:1
                  },
                  column:1,
                  align:"right",
                  valign:"bottom",
                  offsetx:0,
                  offsety:0
            },
            coordinate:{
                  width:"80%",
                  height:"84%",
                  background_color:"#ffffff",
                  axis:{
                        color:"#a5acb8",
                        width:[1,"",1,""]
                  },
                  grid_color:"#d9d9d9",
                  label:{
                        fontweight:500,
                        color:"#666666",
                        fontsize:11
                  }
            },
            label:{
                  fontweight:500,
                  color:"#666666",
                  fontsize:11
            },
            type:"pie2d",
            data:[
                  {
                  name:"成本",
                  value:data.outcome,
                  color:"#4545a8"
            },{
                  name:"利润",
                  value:data.profit,
                  color:"#45ada6"
            }
            ]
      });

    
    if(data.status == 0){
        $('#two-charts').hide();
    }else{
      if(data.outcome == null){
        $('#two-charts').hide();
      }else{
        $('#two-charts').show();
        chart.draw();chart2.draw();
      }
        
    }
  

    /*克隆成本相关*/
    var cost_details = $('#cost_details');
    $('.clone_cost').remove();
    if(data.cost != null){
        $.each(data.cost, function(index, val) {
            var clo = cost_details.clone(true);
            if(index%2 != 0){
                $(clo).addClass('lt');
            }
            $(clo).addClass('clone_cost');
            $(clo).find('#amonut').text(val.value);
            $(clo).find('#categories').text(val.name);
            $(clo).show();
            $('#cost_block').append(clo);     
        });

    }
    });
    $.get('/api/charts_all_conunt/'+store_code, function(data) {
        /*营业额和利润*/
        
        $('#container').highcharts({
            chart: {
                type: 'line'
            },
            title: {
                text: '营业额及利润'
            },
            subtitle: {
                text: '单位：元'
            },
            xAxis: {
                categories: data.index_list
            },
            yAxis: {
                title: {
                    text: '营业额及利润'
                }
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true          // 开启数据标签
                    },
                    enableMouseTracking: false // 关闭鼠标跟踪，对应的提示框、点击事件会失效
                }
            },
            series: [{
                name: '营业额',
                data: data.income
            },{
                name: '利润',
                data: data.profit
            }]
        });
  });
}
</script>
    <link rel="icon" type="text/css" href="https://static.jianshukeji.com/highcharts/images/favicon.ico">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <script src="https://img.hcharts.cn/jquery/jquery-1.8.3.min.js"></script>
    <script src="https://img.hcharts.cn/highcharts/highcharts.js"></script>
    <script src="https://img.hcharts.cn/highcharts/modules/data.js"></script>
    <script src="https://img.hcharts.cn/highcharts/modules/drilldown.js"></script>
    <script src="https://img.hcharts.cn/highcharts/modules/exporting.js"></script>
    <script src="https://img.hcharts.cn/highcharts/highcharts.js"></script>
    <script src="https://img.hcharts.cn/highcharts-plugins/highcharts-zh_CN.js"></script>
@endsection