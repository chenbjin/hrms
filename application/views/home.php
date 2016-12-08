<?php 
$hrms = $this->session->userdata('hrms');
?>
<h2> 你好 <?=$hrms['name']?>, 欢迎使用薪酬管理系统！</h2>
<hr />

<div class='door'>
    <div class='box' onclick="location='/user/personal'">工资</div>
    <div class='box' onclick="location='/user/security'">设置</div>
    <div class='box' onclick="location='/contacts'">通讯录</div>
</div>

<!--
<div>
    <ul>
        <li><a href="/contacts">Contacts</a></li>
        <li><a href="/user/security">Security</a></li>
        <li><a href="/user/personal">Personal</a></li>
    </ul>
</div>
-->
