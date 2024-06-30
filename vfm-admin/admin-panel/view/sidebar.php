<?php
/**
 * VFM - veno file manager administration sidebar
 *
 * PHP version >= 5.3
 *
 * @category  PHP
 * @package   VenoFileManager
 * @author    Nicola Franchini <support@veno.it>
 * @copyright 2013 Nicola Franchini
 * @license   Exclusively sold on CodeCanyon
 * @link      http://filemanager.veno.it/
 */
$adminurl = $setUp->getConfig('script_url')."vfm-admin";
if (!$activesec || $activesec == 'home') {
    $open = ' active';
} else {
    $open = '';
} ?>
<div id="sidebar-nav" class="navbar text-white flex-column align-items-stretch text-white pt-0 pb-5 fixed-top" style="height: 100%; overflow: scroll; z-index: 10;background-color:#0000ff;">
    <style>
                .nav-link:active,
                a:active,
                span:active
                {
                    background:#ccc!important;
                    color:white;
                }

                .nav-link{
                    background:#0000ff!important;

                }

                a:hover{
                    color:white!important;
                    background:#ccc!important;

                }
            </style>  <div class="pt-5">    
        <nav class="nav nav-pills flex-column pt-3">
            <div class="nav-item text-white  text-uppercase text-dark small py-3 ps-3"><?php echo $setUp->getString("administration"); ?></div>
    <?php
    if ($gateKeeper->canSuperAdmin('superadmin_can_preferences')) {
        if (!$activesec || $activesec == 'home') { ?>
            <a class="d-flex nav-link  text-white " href="#view-preferences">
                <span class="text-white"><i class="bi bi-sliders"></i> <?php echo $setUp->getString("preferences"); ?></span> 
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
          
            <nav class="nav nav-pills flex-column small" style="background-color:#0000ff;">
                <a class="nav-link  text-white ps-4" href="#view-general"><i class="bi bi-gear-wide-connected"></i> 
                    <span><?php echo $setUp->getString("general_settings"); ?></span></a>
                <a class="nav-link  text-white ps-4" href="#view-uploads"><i class="bi bi-cloud-arrow-up"></i> 
                    <span><?php echo $setUp->getString('upload'); ?></span></a>
                <a class="nav-link  text-white ps-4" href="#view-lists"><i class="bi bi-list-task"></i> 
                    <span><?php echo $setUp->getString('lists'); ?></span></a>
                <a class="nav-link  text-white ps-4" href="#view-permissions"><i class="bi bi-stoplights"></i> 
                    <span><?php echo $setUp->getString('permissions'); ?></span></a>
                <a class="nav-link  text-white ps-4" href="#view-registration"><i class="bi bi-person-plus"></i> 
                    <span><?php echo $setUp->getString('registration'); ?></span></a>
                <a class="nav-link  text-white ps-4" href="#view-share"><i class="bi bi-send"></i> 
                    <span><?php echo $setUp->getString('share_files'); ?></span></a>
                <a class="nav-link  text-white ps-4" href="#view-email"><i class="bi bi-envelope"></i> 
                    <span><?php echo $setUp->getString('email'); ?></span></a>
                <a class="nav-link  text-white ps-4" href="#view-security"><i class="bi bi-shield-check"></i> 
                    <span><?php echo $setUp->getString("security"); ?></span></a>
                <a class="nav-link  text-white ps-4" href="#view-activities"><i class="bi bi-bar-chart-line"></i> 
                    <span><?php echo $setUp->getString("activity_register"); ?></span></a>
            </nav>
            <?php
        } else { ?>
        <a href="index.php" class="d-flex nav-link">
            <span class="text-white"><i class="bi bi-sliders"></i> <?php echo $setUp->getString("preferences"); ?></span> 
            <i class="bi bi-chevron-left ms-auto"></i>
        </a>
            <?php
        }
    }

    if ($gateKeeper->canSuperAdmin('superadmin_can_users')) {
        $activeitem = $activesec == 'users' ? ' active' : '';
        ?>
        <a href="?section=users" class=" text-white nav-link<?php echo $activeitem; ?>"><i class="bi bi-people"></i> 
            <span class="text-white"><?php echo $setUp->getString("users"); ?></span>
        </a>
        <?php
    }

    if ($gateKeeper->canSuperAdmin('superadmin_can_appearance')) {
        $activeitem = $activesec == 'appearance' ? ' active' : '';
        ?>
        <a href="?section=appearance" class=" text-white nav-link<?php echo $activeitem; ?>"><i class="bi bi-brush"></i> 
            <span class="text-white"><?php echo $setUp->getString("appearance"); ?></span>
        </a>
        <?php
    }

    if ($gateKeeper->canSuperAdmin('superadmin_can_translations')) {
        $activeitem = $activesec == 'lang' ? ' active' : '';
        ?>
        <a href="?section=translations" class=" text-white nav-link<?php echo $activeitem; ?>"><i class="bi bi-translate"></i> 
            <span class="text-white"><?php echo $setUp->getString("translations"); ?></span>
        </a>
        <?php
    }
    if ($setUp->getConfig('log_file') == true && $gateKeeper->canSuperAdmin('superadmin_can_statistics')) {
        $activeitem = $activesec == 'log' ? ' active' : '';
        ?>
        <a href="?section=logs" class=" text-white nav-link<?php echo $activeitem; ?>"><i class="bi bi-graph-up-arrow"></i> 
            <span class="text-white"><?php echo $setUp->getString("statistics"); ?></span>
        </a>
        <?php
    }
    if ($gateKeeper->canSuperAdmin('superadmin_can_preferences')) {
        $activeitem = $activesec == 'updates' ? ' active' : '';
        ?>
        <a href="?section=updates" class=" text-white nav-link<?php echo $activeitem; ?>"><i class="bi bi-arrow-repeat"></i> 
            <span class="text-white"><?php echo $setUp->getString("updates"); ?></span>
        </a>
        <?php
    }
    ?>
        </nav>
    </div>
</div>