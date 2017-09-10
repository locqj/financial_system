var row = 0 ; //定义全局行数用于修改
var reg_email = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/; //用于判断邮箱格式
var reg_name = /^((\w*\d\w*[a-z]\w*)|(\w*[a-z]\w*\d\w*))$/i; //用于判断用户名格式
var reg_chinese = /^[\u0391-\uFFE5]+$/ ; //用于判断姓名格式
var reg_pass = /^((\w*\d\w*[a-z]\w*)|(\w*[a-z]\w*\d\w*))$/i;//用于判断密码格式
//----获取行号-----
// function getRow(r){
//  var i=r.parentNode.parentNode.rowIndex; 
//  return i ;
// }
//----获取行号-----
 
//----删除某一行-----
// function delRow(r){ 
//  document.getElementById('table').deleteRow(getRow(r));
// }
//----删除某一行-----
 
//----清除添加信息框的内容-----
function cleanAddInput(){
 document.getElementById('name').value = "";
 document.getElementById('sex').value = "";
 document.getElementById('age').value = "";
 document.getElementById('phone').value = "";
 document.getElementById('IDnumber').value = "";
 document.getElementById('qq').value = "";
 document.getElementById('email').value = "";
 document.getElementById('address').value = "";
}
//----清除添加信息框的内容-----
 
//----显示添加信息框-----
// function showAddInput(){
//  document.getElementById('addinfo').style="display:block-inline" ;
//  document.getElementById('btn_add').style="display:block-inline" ;
//  document.getElementById('btn_update').style="display:none" ;
//  cleanAddInput(); 
// }
//----显示添加信息框-----
 

 
//----判断输入框的信息是否符合要求-----
function judge(){
 //根据id获取表单信息
 var name = document.getElementById('name').value;
 var sex = document.getElementById('sex').value; 
 var age = document.getElementById('age').value;
 var phone = document.getElementById('phone').value;
 var IDnumber = document.getElementById('IDnumber').value;
 var qq = document.getElementById('qq').value;
 var email = document.getElementById('email').value;
 var address = document.getElementById('address').value;
 var judge = true ; //用于判断表单信息是否符合
 if(name==''){
  judge = false ;
  alert('请输入姓名');
 }else if(sex==''){
  judge = false ;
  alert('请输入性别');
 }else if(age==''){
  judge = false ;
  alert('请输入年龄');
 }else if(phone==''){
  judge = false ;
  alert('请输入手机号码');
 }else if(IDnumber==''){
  judge = false ;
  alert('请输入身份证号码');
 }else if(IDnumber.length!=18){
  judge = false ;
  alert('身份证应为18位，请正确填写');
 }else if(qq==''){
  judge = false ;
  alert('请输入qq');
 }else if(qq.length<=5 &&qq.length>=13){
  judge = false ;
  alert('请正确输入qq号码');
 }else if(phone.length<3&&qq.length>12){
  judge = false ;
  alert('请正确输入电话');
 }else if(!reg_email.test(email)){
  judge = false ;
  alert('邮箱格式不正确');
 }else if(!reg_chinese.test(name)){
  judge = false ;
  alert('姓名格式不正确');
 }
  
 return judge ;
}
//----判断输入框的信息是否符合要求-----
 
//----新增信息的插入方法-----
function insertInfo(){
 //根据id获取表单信息
 var arr = new Array();
 arr[0] = document.getElementById('name').value;
 arr[1] = document.getElementById('sex').value; 
 arr[2] = document.getElementById('age').value;
 arr[3] = document.getElementById('phone').value;
 arr[4] = document.getElementById('IDnumber').value;
 arr[5] = document.getElementById('qq').value;
 arr[6] = document.getElementById('email').value;
 arr[7] = document.getElementById('address').value;
 var x = document.getElementById('table').insertRow(1); //获取第一行对象
  
 for(var i=0;i<arr.length;i++){
  x.insertCell(i).innerHTML = arr[i] ; //用循环把每个数据插入第一行的每一列
 }
  
}
//----新增信息的插入方法-----
 
//----新增信息-----
function addInfo(){
  
 if(judge()==true){
  alert('添加成功');
  insertInfo(); //执行插入
  hideAddInput(); //隐藏添加信息框
   
 }else{
  alert('添加失败');
 }
}
//----新增信息-----
 
 
//----根据行号修改信息-----
function updateRow(r){
 row = getRow(r); //把该行号赋值给全局变量
 showAddInput(); //显示修改表单
 //提交按钮替换

 document.getElementById('btn_update').style="display:block-inline" ;
 insertInputFromQuery(queryInfoByRow(row));
  
}
//----根据行号修改信息-----
 
 
//----根据行号查信息----
function queryInfoByRow(r){
  
 var arr = new Array();
 for(var m=0 ; m<7;m++){
  arr[m] = document.getElementById('table').rows[row].cells[m].innerText;
 }
 return arr ; //返回该行数据
  
}
//----根据行号查信息----
 
//----把查询到的信息放入修改的表单里----
function insertInputFromQuery(arr){
 document.getElementById('name').value = arr[0];
 document.getElementById('sex').value = arr[1];
 document.getElementById('age').value = arr[2];
 document.getElementById('phone').value = arr[3];
 document.getElementById('IDnumber').value = arr[4];
 document.getElementById('qq').value = arr[5];
 document.getElementById('email').value = arr[6];
 document.getElementById('address').value = arr[7];
  
}
//----把查询到的信息放入修改的表单里----
 
 
function updateInfo(){
 if(judge()==true){
  alert('修改成功');
  document.getElementById('table').deleteRow(row);//删除原来那行  
  insertInfo(); //插入修改后的值
  hideAddInput(); //隐藏添加模块
 }else{
  alert('修改失败');
  hideAddInput();
 }
}