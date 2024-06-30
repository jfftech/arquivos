<?php
/**
 * VFM - veno file manager: include/login.php
 * front-end login card
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
if (!defined('VFM_APP')) {
    return;
}
/**
* Login Area
*/
$disclaimerfile = 'vfm-admin/_content/login-disclaimer.html';

if (!$gateKeeper->isAccessAllowed()) { ?>
<style>
    body{
        background:linear-gradient(to top , #0000ff,white);
    }
</style>
    <section class="col-12 w-100" style="margin-top:15%;height:100%!important;">
        <div class="w-sm-100 " style="width:70%;margin-left:17%;height:400px!important;">
            <div class="card mb-3 shadow "  style="height:400px;">
                <div class="card-header d-none">
                    <h5 class="m-0 text-center"><?php echo $setUp->getString("log_in"); ?>-----</h5>
                </div>
                <div class="mt-4 w-100" >
                 <div class="d-flex row-12 w-100 col-12 col-sm-12 col-xl-12 gap-2" style="margin-top:-3%!important;">
                 <div class="col-6 col-xl-6 col-lg-6 d-sm-none w-50 d-xl-grid d-lg-grid justify-center">
<div class="row-12 w-100 text-center fs-2 mt-0" style="background-color:#0000ff!important;min-height:404px;">
    <div class="d-flex row-12 w-100" style="margin-top:33%;">
        <div class="img-icon d-flex item-center" style="margin-left:23%;margin-top:4%;height:45px;width:65px;">
            <i class="m-0 p-0 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" style="height:60px;width:80px;margin-top:-5%;" class="bi bi-folder-fill"  viewBox="0 0 16 16">
  <path d="M9.828 3h3.982a2 2 0 0 1 1.992 2.181l-.637 7A2 2 0 0 1 13.174 14H2.825a2 2 0 0 1-1.991-1.819l-.637-7a2 2 0 0 1 .342-1.31L.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3m-8.322.12q.322-.119.684-.12h5.396l-.707-.707A1 1 0 0 0 6.172 2H2.5a1 1 0 0 0-1 .981z"/>
</svg>
            </i>
        </div>
        <div class="d-grid item-center text-white px-2" style="margin-left:0.5%;">
            <h2  style="margin-left:-65%;;margin-top:9%;" class="fs-2" >DPQ</h2>
            <h5  style="font-size:14px!important;margin-top:-8%;">
                Direcção de Pessoal e Quadros
            </h5>
         </div>
    </div>
</div>
                </div>
                   <style>
                    @media (max-device-width: 580px){
                        .w-sm-100{
                            width: 100!important;
                        }
                        .d-sm-none{
                            display: none !important;
                        }
                    }
                   </style>
                    <div class="row-12 col-md-6 col-sm-12 w-sm-100 col-xl-6 col-lg-6 w-xl-50 w-lg-50">
                    <form enctype="multipart/form-data" method="post" role="form" action="<?php echo $location->makeLink(false, null, ""); ?>" class="loginform w-auto">
                    <div class="d-flex row-12 justify-center mt-3">
                        <span class="d-xl-flex d-lg-flex d-sm-grid  align-items-center mx-5 mt-4">
                            <div class="img-icon d-sm-flex d-xl-grid d-lg-grid  justify-content-sm-center">
                <img src="./vfm-admin/images/logo.png" style="height:50px;width:45px;margin-top:-5%;"  />

                            </div>
                            <h4 class="fs-6 fw-bolder text-primary">
                                Sistema de Gestão de Arquivos da DQP
                            </h4>
                        </span>
                    </div>
                        <div id="login_bar" class="form-group">
                            <div class="form-group my-3">
                                <label class="visually-hidden" for="user_name">
                                    <?php echo $setUp->getString("username"); ?>
                                </label>
                                <div class="input-group  w-sm-100" style="width:87%; ">

                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" name="user_name" value="" id="user_name" class="form-control "placeholder="<?php echo $setUp->getString("username"); ?>" required>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label class="visually-hidden" for="user_pass">
                                    <?php echo $setUp->getString("password"); ?>
                                </label>
                                <div class="input-group  w-sm-100" style="width:87%; ">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <input type="password" name="user_pass" id="user_pass" class="form-control " placeholder="<?php echo $setUp->getString("password"); ?>" required>
                                </div> 
                            </div>
                            <?php
                            if (file_exists($disclaimerfile)) {
                                $disclaimer = file_get_contents($disclaimerfile);
                                echo $disclaimer; ?>
                                <input type="hidden" id="trans_accept_terms" value="<?php echo $setUp->getString("accept_terms_and_conditions"); ?>">
                                <div class="form-check">
                                    <input class="form-check-input mx-2" type="checkbox" id="agree" name="agree" required> <?php echo $setUp->getString("accept"); ?> 
                                    <label for="agree">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#login-disclaimer">
                                            <u><?php echo $setUp->getString("terms_and_conditions"); ?></u>
                                        </a>
                                    </label>
                                </div>
                                <?php
                            } ?>
                            <div class="form-check mb-3" style="margin-left:3%!important;">
                                <input class="form-check-input" type="checkbox" id="vfm_remember" name="vfm_remember" value="yes">
                                <label for="vfm_remember">
                                    <?php echo $setUp->getString("remember_me"); ?>
                                </label>
                            </div>
                            <?php
                            /* ************************ CAPTCHA ************************* */
                            if ($setUp->getConfig("show_captcha") == true) {
                                $capath = "vfm-admin/";
                                include "vfm-admin/include/captcha.php";
                            }   ?>
                            <div class="d-grid gap-2 mb-3 row" style="margin-left:5%!important;">
                            <button type="submit" class="btn-lg w-sm-100 p-0 text-white" style="border-radius:5px;width:85%;background-color:#0000ff!important;margin-left:0%;border:none;height:40px;" >
                                <i class="bi bi-box-arrow-in-right"></i> 
                                <?php echo $setUp->getString("log_in"); ?>
                            </button>
                            <p class="lostpwd m-2"  style="font-size:13px!important;text-align:right!important;margin-top:1%!important;margin-left:-15%!important"><a href="?rp=req"><?php echo $setUp->getString("lost_password"); ?></a></p>
                            </div>
                        </div>
                    </form>
                    </div>
                 </div>
                </div>
            </div>

    <?php
    if ($setUp->getConfig("registration_enable") == true) { ?>
            <div class="d-grid gap-2">
                <a class="btn btn-outline-primary" href="?reg=1">
                    <i class="bi bi-person-plus"></i> <?php echo $setUp->getString("registration"); ?>
                </a>
            </div>
        <?php
    } ?>

        </div>
    </section>
    <?php
}
// Inline form
if ($gateKeeper->isAccessAllowed() && $gateKeeper->showLoginBox()) { ?>
<style>
        body{
        background:linear-gradient(to top , #0000ff,white)!important;
    }
</style>
<section class="vfmblock" >
    <form enctype="multipart/form-data" method="post" action="<?php echo $location->makeLink(false, null, ""); ?>" class="row row-cols-md-auto mt-3 align-items-center loginform" role="form">
        <div class="col-12 mb-3">
            <label class="visually-hidden" for="user_name">
                <?php echo $setUp->getString("username"); ?>:
            </label>
            <input type="text" required style="border-color:red!important;" class="form-control" placeholder="<?php echo $setUp->getString("username"); ?>" >
        </div>
        <div class="col-12 mb-3">
            <label class="visually-hidden" for="user_pass">
                <?php echo $setUp->getString("password"); ?>: 
            </label>
            <input type="password" name="user_pass" id="user_pass" class="form-control" placeholder="<?php echo $setUp->getString("password"); ?>" required>
        </div>

        <style>
            @import url(https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;600;800;900&display=swap);
            
            .card,form {
              font-family: 'Roboto'!important;
            }
     
        </style>
        <?php
        // style="background:linear-gradient(to top , #0000ff,white);"
        /* ************************ CAPTCHA ************************* */
        if ($setUp->getConfig("show_captcha") == true) { ?>
            <div class="col-12 mb-3">
            <?php
            $capath = "vfm-admin/";
            include "vfm-admin/include/captcha.php";
            ?>
            </div>
            <?php
        }   ?>
        <div class="col-12 mb-3">
            <div class="d-grid gap-2">
                <button type="submit" class="btn " style="background-color:#0000ff!important;">
                    <i class="bi bi-box-arrow-in-right"></i>  <?php echo $setUp->getString("log_in"); ?>
                </button>
            </div>
        </div>
        <?php
        if (file_exists($disclaimerfile)) { ?>
        <div class="col-12 mb-3">
            <?php
            $disclaimer = file_get_contents($disclaimerfile);
            echo $disclaimer; ?>
            <input type="hidden" id="trans_accept_terms" value="<?php echo $setUp->getString("accept_terms_and_conditions"); ?>">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="agree" name="agree" required> <?php echo $setUp->getString("accept"); ?>
                <label>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#login-disclaimer">
                        <u><?php echo $setUp->getString("terms_and_conditions"); ?></u>
                    </a>
                </label>
            </div>
        </div>
            <?php
        }
        if ($setUp->getConfig("registration_enable") == true) { ?>
        <div class="col-12 mb-3">
            <div class="d-grid gap-2">
                <a class="btn btn-outline-primary" href="?reg=1">
                    <i class="bi bi-person-plus"></i> <?php echo $setUp->getString("registration"); ?>
                </a>
            </div>
        </div>
            <?php
        }   ?>
    </form>
    <a class="small lostpwd" href="?rp=req"><?php echo $setUp->getString("lost_password"); ?></a>
</section>
    <?php
}


