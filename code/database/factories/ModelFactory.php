<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'username' => $faker->name,
        'pwd' => bcrypt(str_random(10)),
        'employee_code' => str_random(10),
        'status' => 1,
    ];
});

//收入工厂定义
$factory->define(App\StoreIncome::class, function(Faker\Generator $faker){
	return [
		'total' => rand(1000,10000).'.'.rand(0,9),
		'category' => $faker->name,
		'month' => rand(1, 12),
		'year' => 2017,
		'store_code' => 'hjs0000'.rand(2 ,5),
		'created_at' => $faker->dateTimeThisYear()
	];
});

//签单工厂定义
$factory->define(App\StaffContract::class, function(Faker\Generator $faker){
	$store_employee = array(['employee_code'=>'hjs00002T3','store_code'=>'hjs00002'],['employee_code'=>'hjs00003T6','store_code'=>'hjs00003'],['employee_code'=>'hjs00004T8','store_code'=>'hjs00004'],['employee_code'=>'hjs00005T10','store_code'=>'hjs00005']);
	$key_rand = rand(0, 3);
	$month = rand(1, 12);
	$day = rand(1, 28);
	$key_devide = rand(0, 1);
	$source_employee = array(['employee_code'=>'','store_code'=>''],['employee_code'=>'hjs00003T6','store_code'=>'hjs00003']);
	$real_amount = rand(1000, 100000).'.'.rand(1, 9);
	return [
	'number' => rand(100,10000),
	'employee_code' => $store_employee[$key_rand]['employee_code'],
	'sign_amount' => rand(1000, 100000).'.'.rand(1, 9),
	'real_amount' => $real_amount,
	'is_signed' => 1,
	'year' => 2017,
	'month' => $month,
	'store_code' => $store_employee[$key_rand]['store_code'],
	'updated_at' => '2017-'.$month.$day.$faker->time($format = 'H:i:s', $max = 'now'),
	'created_at' => '2017-'.$month.$day.$faker->time($format = 'H:i:s', $max = 'now'),
	'day' => $day,
	'status_del' => 0,
	'type' => rand(1,3),
	'is_divide'=> $key_devide,
	'source_employee' => $source_employee[$key_devide]['employee_code'],
	'received_amount' => $real_amount,
	'source_store' => $source_employee[$key_devide]['store_code'],
	];
});

//支出工厂定义
$factory->define(App\StoreCost::class, function(Faker\Generator $faker){
	$total = rand(100, 10000).'.'.rand(1, 9);
	$start_month = rand(1, 12);
	$start_year = 2017;
	$length = rand(1, 12);
	$owner_store_code = array(['store_code'=>'hj001','pay_stores'=>'["hjs00002","hjs00003","hjs00004","hjs00005"]'],['store_code'=>'hjs00002','pay_stores'=>'["hjs00002"]'],['store_code'=>'hjs00003','pay_stores'=>'["hjs00003"]'],['store_code'=>'hjs00004','pay_stores'=>'["hjs00004"]'],['store_code'=>'hjs00005','pay_stores'=>'["hjs00005"]']);
	$key_store = rand(0, 4);
	$pay_month = cCountMonth($start_year, $start_month, $length);
	return [
		'total' => $total,
		'category' => $faker->name,
		'month' => $start_month,
		'length' => $length,
		'owner_store_code' => $owner_store_code[$key_store]['store_code'],
		'pay_stores' => $owner_store_code[$key_store]['pay_stores'],
		'unit' => round($total / $length ,1),
		'pay_month' => json_encode($pay_month),
		'created_at' => date('Y-m-d H:i:s'),
		'year' => $start_year
	];
});

function cCountMonth($start_year, $start_month, $length){
	//超过所在年份
    if($start_month + $length > 12){  //先计算当年剩余月份
        for ($i=0; $i <= 12 - $start_month ; $i++) { 
            $pay_month[$i] = array(
                'year'=>(int)$start_year,
                'month'=>(int)($start_month+$i)
                );
        }
                                      //剩余依次自增
        $leng_left = ($length + $start_month) -13 ;
        $count_year = 1;
        while($leng_left > 0 ){
                $count = 1;
                while ( $count <= 12 && $leng_left > 0 ) {
                    $pay_month[$i]['year'] = (int)($start_year + $count_year);
                    $pay_month[$i]['month'] = (int)$count++;
                    $i++;
                    $leng_left--;
                }
                $count_year++;
            }

    }else{                             //未超过所在年份的自增
        $i = 0;
        while ($length > 0) {
            $pay_month[$i] = array(
                'year' => (int)$start_year,
                'month' => (int)$start_month ++
                );
            $length--;
            $i++;
        }
    }

    return $pay_month;
}
