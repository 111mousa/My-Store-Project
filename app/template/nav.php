<nav class="main_navigation <?= (isset($_COOKIE['menu_opened']) && $_COOKIE['menu_opened'] == 'true') ? 'opened no_animation' : '' ?>">
    <div class="employee_info">
        <div class="profile_picture">
            <img src="/PhpProject2/img/user.png" alt="User Profile Picture">
        </div>
        <span class="name"><?=$this->session->user->Profile->FirstName?> <?=$this->session->user->Profile->LastName?></span>
        <span class="privilege"><?=$this->session->user->GroupName?></span>
    </div>
    <ul class="app_navigation">
        <li class="<?=$this->matchUrl('/MVCProject/public/')===true?'selected':''?>"><a href="/MVCProject/public/"><i class="fa fa-dashboard"></i><?=$text_general_statistics?></a></li>
        <li class="submenu">
            <a href="javascript:;"><i class="fa fa-credit-card"></i> <?= $text_transactions ?></a>
            <ul>
                <li><a href="/MVCProject/public/purchases"><i class="fa fa-gift"></i> <?= $text_transactions_purchases ?></a></li>
                <li><a href="/MVCProject/public/sales"><i class="fa fa-shopping-bag"></i> <?= $text_transactions_sales ?></a></li>
            </ul>
        </li>
        <li class="submenu">
            <a href="javascript:;"><i class="fa fa-money"></i> <?= $text_expenses ?></a>
            <ul>
                <li><a href="/MVCProject/public/expensescategories"><i class="fa fa-list-ul"></i> <?= $text_expenses_categories ?></a></li>
                <li><a href="/MVCProject/public/dailyexpenses"><i class="fa fa-dollar"></i> <?= $text_expenses_daily_expenses ?></a></li>
            </ul>
        </li>
        <li class="submenu">
            <a href="javascript:;"><i class="material-icons">store</i> <?= $text_store ?></a>
            <ul>
                <li><a href="/MVCProject/public/productcategories"><i class="fa fa-archive"></i> <?= $text_store_categories ?></a></li>
                <li><a href="/MVCProject/public/productslist"><i class="fa fa-tag"></i> <?= $text_store_products ?></a></li>
            </ul>
        </li>
        <li><a href="/MVCProject/public/clients"><i class="material-icons">contacts</i><?=$text_clients?></a></li>
        <li class="<?=$this->matchUrl('/MVCProject/public/suppliers')===true?'selected':''?>"><a href="/MVCProject/public/suppliers"><i class="material-icons">group</i><?=$text_suppliers?></a></li> 
        <li class="submenu">
            <a href="javascript:;"><i class="fa fa-user"></i> <?= $text_users ?></a>
            <ul>
                <li><a href="/MVCProject/public/users"><i class="fa fa-user-circle"></i> <?= $text_users_list ?></a></li>
                <li><a href="/MVCProject/public/usersgroups"><i class="fa fa-group"></i> <?= $text_users_groups ?></a></li>
                <li><a href="/MVCProject/public/privileges"><i class="fa fa-key"></i> <?= $text_users_privileges ?></a></li>
            </ul>
        </li>
        <li><a href="/MVCProject/public/reports"><i class="fa fa-bar-chart"></i><?=$text_reports?></a></li>
        <li><a href="/MVCProject/public/notifications"><i class="fa fa-bell"></i><?=$text_notifications?></a></li>
        <li><a href="/MVCProject/public/auth/logout"><i class="fa fa-sign-out"></i><?=$text_log_out?></a></li>
    </ul>
</nav>
<div class="action_view <?= (isset($_COOKIE['menu_opened']) && $_COOKIE['menu_opened'] == 'true') ? 'collapsed no_animation' : '' ?>" >
<?php $messages = $this->messenger->getMessages(); if(!empty($messages)):foreach($messages as $message):?>
    <p class="message t<?=$message[1]?>"> <?= $message[0] ?><a href="" class="closeBtn"><i class="fa fa-times"></i></a></p>
<?php endforeach; endif; ?>