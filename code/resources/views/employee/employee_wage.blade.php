@extends('layouts.nav')
@section('content')
      <section class="vbox">
        <section class="scrollable padder">
          <ul class="breadcrumb no-border no-radius b-b b-light pull-in">
            <li><i class="fa fa-home"></i> 主页</li>
            <li class="active">员工工资查看</li>
          </ul>
          <section class="panel panel-default">
            <header class="panel-heading head">员工工资明细表 </header>
            <div class="table-responsive">
            <table class="headerStyle">
                  <tr>
                    <th class="th-sortable" data-toggle="class">
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
                    <th class="th-sortable" data-toggle="class">
                        <label>年 / 月</label>  
                        <select class="input-sm form-control input-s-sm inline selectTh" id="year">
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
            <table class="table table-striped b-t b-light text-sm">
            <thead>
              <tr>
                <th>所属店铺</th>
                <th>姓名</th>
                <th>职位</th>
                <th>基本工资</th>
                <th>销售提成</th>
                <th>分红提成</th>
                <th>总计</th>
              </tr>
            </thead>
            <tbody>
            @foreach($grant_log as $list)
              <tr>
                <td>{{ $list->store->name }}</td>                      
                <td>{{ $list->employee->name }}</td>
                <td>{{ $list->position->name }}</td>        
                <td>{{ $list->salary }}</td> 
                <td>{{ $list->bonus }}</td> 
                <td>{{ $list->dividend }}</td>   
                <td>{{ $list->amount }}</td>        
              </tr>
            @endforeach
            </tbody>
            </table>
            </div>
          </section>
        </section>
         <div class="copyRight">
          <div >版权所有: © locqj
            </div>
            </div>
      </section>

<script>
    $(document).ready(function(){
        /*搜索公司员工*/
        $('#searchstore').change(function(event) {
            var month = $('#month').val();
            var year = $('#year').val();
            var store_code = $('#searchstore').val();
            window.location.href = '/search/employeewage/'+store_code+'-'+year+'-'+month;
           });
            $('#year').change(function(event) {
            var month = $('#month').val();
            var year = $('#year').val();
            var store_code = $('#searchstore').val();
            window.location.href = '/search/employeewage/'+store_code+'-'+year+'-'+month;
            
           });
        $('#month').change(function(event) {
            var month = $('#month').val();
            var year = $('#year').val();
            var store_code = $('#searchstore').val();
            window.location.href = '/search/employeewage/'+store_code+'-'+year+'-'+month;
        });
    });
</script>
@endsection