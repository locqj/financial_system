<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*请求参数*/
function rq($key=null,$default=null){
    if(!$key){
        return Request::all();
    }
    return Request::get($key,$default);
}

/*返回api信息*/
function arrayChange($status,$msg,$data=array()){
    return ['status'=>$status,'msg'=>$msg,'data'=>$data];
}

/*返回失败api*/
function err($msg = null){
    return ['status' => 0, 'msg' => $msg];
}

/*返回成功api*/
function suc($data_to_add = []){
    $data = ['status' => 1, 'data' => []];
    if($data_to_add)
        $data['data'] = $data_to_add;
    return $data;
}

/*返回成功api*/
function succ($msg = null){
    return ['status' => 1, 'msg' => $msg];
}

/*实例化StaffEmployee*/
function employee_ins(){
    return new App\StaffEmployee;
}
/*用户model*/
function user_ins(){
    return new App\User;   
}


/*实例化店铺*/
function store_new(){
    return new App\StoreStore;
}

/*实例化职位*/
function position_ins(){
    return new App\StaffPosition;

}
/*实例化店铺成本详情*/
function cost_details_ins(){
    return new App\CostDetails;
}
/*实例化基本工资详情表*/
function salary_details_ins(){
    return new App\SalaryDetails;
}

/*实例化员工工资记录*/
function grant_log_ins(){
    return new App\EmployeeWage;
}
/*实例化update_code记录*/
function calculate_log_ins(){
    return new App\CalculateLog;
}

/*实例化staff_port*/
function staff_port_ins(){
    return new App\StaffPort;   
}

/*实例化奖金规则表*/
function bonus_rule_ins(){
    return new App\StaffBonusRule;
}

/*实例化合同*/
function contract_ins(){
    return new App\StaffContract;
}

/*实例化过户记录*/
function transfer_ins(){
    return new App\StaffTransferRecord;
}

/*实例化区域*/
function store_zone_ins(){
    return new App\StoreZone;   
}

/*实例化扣除工资*/
function salary_reduce_ins(){
    return new App\SalaryReduce;
}

/*实例化店铺成本表*/
function cost_new(){
    return new App\StoreCost;
}

/*实例化城市区域表*/
function city_new(){
    return new App\StoreCity;
}

/*实例化公司表*/
function company_new(){
    return new App\StoreCompany;
}

/*实例化员工职位关联表*/
function employee_position(){
    return new App\EmployeePosition;
}

/*实例化分红表*/
function bonus_details_new(){
    return new App\BonusDetails;
}

/*实例化佣金表*/
function commission_details_new(){
    return new App\CommissionDetails;
}

/*实例化店铺金额计算表*/
function calculate_store_new(){
    return new App\CalculateStore;
}

/*实例化店铺收入管理表*/
function store_income_new(){
    return new App\StoreIncome;
}

/*实例化签单动态表*/
function contract_process_new(){
    return new App\ContractProcess;
}

/*实例化常用关键词表*/
function using_words_new(){
    return new App\UsingWords;
}



/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|

*/

Route::group(['middleware' => 'web'], function () {
    // 登陆中间件
    Route::group(['middleware'=> 'checkLogin'], function(){
            /*财务||总部*/
        Route::group(['middleware' => 'CW'], function(){
            /*----------------------------------StaffPositionController------------------------------*/
            Route::post('position/positionsalarysub', 'StaffPositionController@cUpdateSalary'); //修改工资
            Route::get('position/positionlevel', 'StaffPositionController@cPositionLevel'); //获取薪水规则
            Route::post('position/positionlevelsub', 'StaffPositionController@cPositionLevelSub'); //薪水规则修改提交
            Route::get('position/adjustmentajax', 'StaffPositionController@cJobAdjustmentAjax'); //调整员工职位界面ajax遍历员工信息
            Route::get('position/adjustment', 'StaffPositionController@cJobAdjustment'); //员工职位调整页面
            Route::get('position/adjustmentsub', 'StaffPositionController@cJobAdjustmentSub'); //员工职位调整提交
            Route::get('position/adjustment/form/{code}', 'StaffPositionController@cJobForm'); //职位新增，修改表单
            Route::resource('position', 'StaffPositionController');
            /*-----------------------------StoreStoreController---------------------------------*/
            /*店铺*/
            /*以公司关键词查找*/
            Route::get('/store/company_key/{company_code}','StoreStoreController@company_key');
            /*以店铺关键词查找*/
            Route::get('store/name_key/{name}','StoreStoreController@name_key');
            /*以城市为关键词查找*/
            Route::get('store/city_key/{city_zone}','StoreStoreController@city_key');

            /*-----------------------------StoreCityController---------------------------------*/
            /*城市*/
            // Route::resource('city','StoreCityController');

            /*-----------------------------StoreCompanyController---------------------------------*/
            /*公司*/
            Route::resource('company','StoreCompanyController');


            
            /*----------------------------------总计算------------------------*/
            Route::get('count', 'CountController@index');
            Route::get('count/sub/{year}-{month}', 'CalculateController@cFinalCount');
            Route::get('count/sub_season/{year}-{season}','CalculateController@cFinalCountSeason');


            /*------------------------------------storecity------------------------------------*/
            Route::get('/city', 'StoreCityController@index'); //展示
            Route::post('/city/addsub', 'StoreCityController@cAddSub'); //添加区域提交
            Route::post('/city/updatesub/{id}', 'StoreCityController@cUpdateSub'); //更新区域提交
            Route::get('/city/find/{id}', 'StoreCityController@cFindCity'); //找该数据
            Route::get('/city/del/{id}', 'StoreCityController@cDel'); //删除区域（暂时不考虑）

             /*----------------------------------StaffContractController------------------------------*/
            Route::post('contract/updaterealamount/{id}', 'StaffContractController@cUpdateRealAmount'); //更新结佣金额
            Route::post('contract/updaterecevicedamount/{id}', 'StaffContractController@cRecevicedAmount'); //更新实收金额
            Route::post('contract/updateissign/{id}', 'StaffContractController@cUpdateisSign'); //更新结佣状态
            /*------------------------------------note------------------------------------*/
            /*首页备忘录的路由*/
            Route::post('/note/sub', 'IndexController@cAddNote');
            Route::get('/note/del/{id}', 'IndexController@cDelNote');
            /*------------------------------------note------------------------------------*/
            /*------------------------------------签单动态------------------------------------*/
            Route::post('/process/del', 'ContractProcessController@cDel');//删
            Route::post('/process/edit', 'ContractProcessController@cEdit');//改

            /*------------------------------------区域------------------------------------*/
            Route::post('/zone/addsub', 'StoreZoneController@cAddSub'); //添加区域提交
            Route::post('/zone/updatesub/{id}', 'StoreZoneController@cUpdateSub'); //更新区域提交
            Route::get('/zone/del/{id}', 'StoreZoneController@cDel'); //删除区域（暂时不考虑）
             /*------------------------------------删除------------------------------------*/
            Route::get('del/{status}/{id}', 'StaffController@cDel'); //删除api

            Route::resource('contract', 'StaffContractController', ['only' => ['edit', 'destroy']]);

            /*-----------------------------StoreStoreController---------------------------------*/
            /*店铺*/
            Route::resource('store','StoreStoreController', ['except' => ['index', 'show']]); 

            /*----------------------------------StoreIncomeController------------------------*/
            Route::resource('income','StoreIncomeController', ['only' => ['destroy']]);
             /*-----------------------------StoreCostController---------------------------------*/
            /*店铺支出*/
            Route::resource('cost','StoreCostController', ['only' => ['destroy']]);
            Route::post('/using_words', 'Controller@cUsingWords');

            /*------------------------------------调整端口------------------------------------*/
            Route::post('/port/change', 'StaffPortController@cPortChange');
            // Route::get('/port/count/{store_code}-{employee_code}-{year}-{month}', 'StaffPortController@cPortCount');
        });

        /*财务||过户*/
        Route::group(['middleware' => 'CWorGH'], function(){
            /*----------------------------------过户费用记录------------------------*/
            Route::resource('transfer', 'StaffTransferRecordController');
            Route::post('/transfer/process_edit','StaffTransferRecordController@cEdit');//签单动态编辑过户
        });

        /*店长||财务||经理||助理*/
        Route::group(['middleware' => 'DZorCW'], function(){
            /*-----------------------------StoreCostController---------------------------------*/
            /*店铺支出*/
            Route::resource('cost','StoreCostController', ['except' => ['destroy']]);
            /*返回店铺类型*/
            Route::post('/cost/storetype','StoreCostController@cGetStoreType');
            /*以店铺搜索*/
            Route::get('/cost/store_key/{store_code}','StoreCostController@cStoreKey');
            /*添加图片*/
            Route::post('/cost/images/{id}', 'StoreCostController@cStoreImages');
            Route::get('/cost/image/del/{id}', 'StoreCostController@cDelImage'); //删除图片

            /*-----------------------------BonusController---------------------------------*/
            /*分红记录*/
            Route::resource('bonus', 'BonusDetailsController');
            Route::get('bonus/search/{year}/{month}', 'BonusDetailsController@searchBonus');
            Route::post('/bonus/bonus_detail','BonusDetailsController@cGetBonusDetail');
            /*-----------------------------CommissinDetailsController---------------------------------*/
            /*佣金记录*/
            Route::resource('commission','CommissionDetailsController');
            Route::post('/commission/contract_detail','CommissionDetailsController@cGetContractDetail');
            /*-----------------------------IndexController---------------------------------*/
            /*主页*/
            Route::get('/index','IndexController@index');
            Route::get('/api/charts_all_conunt/{store_code}', 'IndexController@cChartYearIncomeData');
            Route::get('/api/charts/{store_code}-{year}-{month}', 'IndexController@getCalculateStore');
            /*----------------------------------StaffEmployeeController------------------------------*/
            Route::get('employee/searchemployee/{name}', 'StaffEmployeeController@cSearchEmployee');   //查找员工信息
            Route::resource('employee', 'StaffEmployeeController');    

            /*----------------------------------StaffTransferRecordController------------------------*/
            Route::get('transfer/contractnum/{store_code}', 'StaffTransferRecordController@cGetContract');
           
             /*----------------------------------签单动态------------------------*/
            Route::post('/process/store', 'ContractProcessController@cStore');//增
            Route::post('/process/show', 'ContractProcessController@cShow');//查
           
            /*----------------------------------店铺成本记录------------------------*/
            Route::resource('costdetails', 'StoreCostDetailsController');

            /*----------------------------------StoreIncomeController------------------------*/
            Route::resource('income','StoreIncomeController', ['except' => ['destroy']]);
             /*-----------------------------StoreStoreController---------------------------------*/
            /*店铺*/
            Route::resource('store','StoreStoreController', ['only' => ['index', 'show']]); 

             /*------------------------------------storezone------------------------------------*/
            Route::get('/zone/{city_code}', 'StoreZoneController@index'); //展示
            Route::get('/zone/find/{id}', 'StoreZoneController@cFindZone'); //找该数据


            /*------------------------------------port------------------------------------*/
            Route::get('/port', 'StaffPortController@index');
            Route::post('/port/sub', 'StaffPortController@cSub'); //端口提交
            Route::get('/port/getDetails/{id}', 'StaffPortController@cGetDetails'); 

            /*------------------------------------reduce------------------------------------*/
            Route::get('/reducesalary', 'SalaryReduceController@index'); //扣除工资页面
            Route::post('/reducesalary/sub', 'SalaryReduceController@store'); //扣除工资提交
            Route::get('/reducesalary/getdetails/{employee_code}-{year}-{month}', 'SalaryReduceController@cGetDetails'); //获取详情
            Route::post('/reducesalary/import', 'SalaryReduceController@cImport');  //导入excel
            Route::get('/reducesalary/download',function(){
                // return response()->download(public_path().'/download/salary_reduce_model.xls', '衡居扣除工资明细模版.xls');
                $filename=realpath(public_path().'/download/salary_reduce_model.xls'); //文件名
                Header( "Content-type:  application/octet-stream "); 
                Header( "Accept-Ranges:  bytes "); 
                Header( "Accept-Length: " .filesize($filename));
                header( "Content-Disposition:  attachment;  filename= 衡居扣除工资明细模版.xls"); 
                echo file_get_contents($filename);
                readfile($filename); 
            });

            /*-----------------------------StaffBonusRuleController---------------------------------*/
            /*提成规则*/
            Route::resource('bonusrule', 'StaffBonusRuleController');

           /*-----------------------------StaffContractController---------------------------------*/
            Route::get('contract/get_store_employee/{store_code}', 'StaffContractController@cGetStoreEmployee'); //获取当前店铺员工
            Route::resource('contract', 'StaffContractController', ['except' => ['edit', 'destroy']]);
            Route::post('/contract/image/{contract_id}', 'StaffContractController@cStoreImages');//添加图片
            Route::get('/contract/image/del/{id}', 'StaffContractController@cDelImage'); //删除图片
        
        });

        /*----------------------------------基本工资记录------------------------*/
        Route::resource('salarydetails', 'SalaryDetailsController');
        
        /*----------------------------------StaffController--------------------------------------*/
        Route::get('/search/{status}/{season}/{store_code}/{year}', 'StaffController@cSearchSeason'); //按季度搜索
        Route::get('getposition/{store_code}', 'StaffController@cGetPosition'); //职位修改，获取店铺职位
        Route::get('getemployee/{store_code}-{employee_code}', 'StaffController@cGetEmployee');  //签单，获取店铺员工
        Route::get('getemployee/{store_code}', 'StaffController@cGetPortEmployee');  //获取店铺员工 端口处用到
        Route::get('getallemployee/{store_code}', 'StaffController@cGetStoreAllEmployee'); //扣钱，获取店铺所有员工信息




        Route::group(['middleware' => 'cAuth'], function(){
            Route::get('search/{stauts}/{store_code}-{year}-{month}-{employee_code?}-{end_month?}', 'StaffController@cSearch'); //搜索
            Route::get('search/{stauts}/{store_code}-{year}-{month}-{employee_code}-{end_month}', 'StaffController@cSearch'); //搜索
            Route::get('getmonth/{stauts}/{store_code}/{year}', 'StaffController@cReturnMonth'); //返回搜索月份
             /*以时间搜索*/
            Route::get('/cost/time_key/{store_code}-{year}-{month?}','StoreCostController@cTimeKey');
             /*以时间搜索*/
            Route::get('/income/time_key/{store_code}-{year}-{month}','StoreIncomeController@cTimeKey');
            /*-----------------------------KeyFindController---------------------------------*/
            /*佣金和提成查找合并*/
            Route::get('find/{key}/{store_code}-{year}-{month}-{employee_code?}','KeyFindController@cKeyFind'); 
            
            Route::get('find/{key}/{store_code}/{year}/{season}','KeyFindController@cKeyFindSeason');
        });

         


         /*----------------------------------StaffContractController------------------------------*/
         Route::get('/contract', 'StaffContractController@index');
         Route::get('/contract/{year}/{month}/{end_month}', 'StaffContractController@searchContract');

        /*----------------------------------基本工资详情------------------------*/
        //Route::resource('employeewage', 'StaffEmployeeWageController');
        /*---------------------------------------------------------------------------------*/

         /*-----------------------------员工工资查询-------------------------------------------*/
        Route::post('/realsalary/details', 'SalaryRealController@cEmployeeRealSalary');
        Route::get('/realsalary/getrules/{position_code}', 'SalaryRealController@cGetBonusRules');
        Route::resource('realsalary','SalaryRealController');
        Route::post('/realsalary/salaryconfirm', 'SalaryRealController@cSalaryConfirm');
        /*---------------------------------------------------------------------------------*/


        /*------------------------------------修改密码--------------------------------------*/
        Route::post('/user/passedit','UserController@cPassWordEdit');

        /*------------------------------------Tree------------------------------------*/
        Route::get('/tree', 'TreeController@cTreeData');

        

    });
    
    
    /*------------------------------登陆相关--------------------------------*/
    Route::get('/login', ['as' => 'login', 'uses' => 'LoginController@index']); //登陆页面
    Route::post('/login/sub', 'LoginController@cIndexSub'); //登陆提交
    Route::get('/logout', 'LoginController@cLogout'); //登出
    /*---------------------------------------------------------------------------------*/

    /*-------------------------------------定时任务--------------------------------------------*/
    Route::get('/crontab/{u}/{p}', 'AutoPositionAdjController@cCronTab'); //定时任务!!!!!!!!!!!!!crontab//除见习以外每季度执行一次
    Route::get('/crontab/jx/{u}/{p}', 'AutoPositionAdjController@cCronTabJianxi'); //定时任务!!!!!!!!!!!!!crontab见习每月执行一次


    /*fc.iperson.cn 重定向到 fc.iperson.cn/login */
    Route::get('/', function(){
        return Redirect::to('login');
    });

    


});


