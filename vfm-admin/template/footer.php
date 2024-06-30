<?php
/**
 * VFM - veno file manager: include/footer.php
 * script footer
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
$privacy_file = 'vfm-admin/_content/privacy-info.html';
$privacy = file_exists($privacy_file) ? file_get_contents($privacy_file) : false;
?>
   <style>
            @import url(https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;600;800;900&display=swap);
            footer {
              font-family: 'Roboto'!important;
              @include("fw-light");
            }
     
        </style>
 <footer class="footer small px-0 py-3"  style="background-color:#0000ff!important;height:70px;color:white!important;">
    <div class="container">
        <div class="row">
        <div class="text-center">
            <a href="javascript:void(0)"  class="text-white">
            <h5 class="text-left d-xl-flex d-lg-flex d-sm-none w-100  align-items-center" style="margin-top:-0.5%;margin-left:-12%;font-family:arial;display:flex;font-size:14px;color:white!important;">
	<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-c-circle-fill" viewBox="0 0 16 16">
  <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.146 4.992c.961 0 1.641.633 1.729 1.512h1.295v-.088c-.094-1.518-1.348-2.572-3.03-2.572-2.068 0-3.269 1.377-3.269 3.638v1.073c0 2.267 1.178 3.603 3.27 3.603 1.675 0 2.93-1.02 3.029-2.467v-.093H9.875c-.088.832-.75 1.418-1.729 1.418-1.224 0-1.927-.891-1.927-2.461v-1.06c0-1.583.715-2.503 1.927-2.503"/>
</svg> <?php echo date('Y')-1; ?>- <?php echo date('Y'); ?> Sistema de Gestão Arquivos, Inc Desenvolvido pela <a href="#" target="_blank"  class="btn" style="color:white;text-decoration:none;margin-left:0%%;">PNA</a>

	</h5>
            </a>
            <?php
            if ($privacy) {
                ?> | 
                <a href="#" data-bs-toggle="modal" data-bs-target="#privacy-info">
                    <?php echo $setUp->getString("privacy"); ?>
                </a>
                <?php
            } ?>
        </div>

        <?php
        // Credits
        if ($setUp->getConfig('hide_credits') !== true) {
            $credits = $setUp->getConfig('credits');
            if ($credits) { ?>
                <div class="col-sm-6 text-sm-end">
                <?php
                if ($setUp->getConfig('credits_link')) { ?>
                    <a target="_blank" href="<?php echo $setUp->getConfig('credits_link'); ?>">
                        <?php echo $credits; ?>
                    </a>
                    <?php
                } else {
                    echo $credits;
                } ?>
                </div>
                <?php
            } else { ?>
              
                <?php
            }
        } ?>
        </div>
    </div><h5
     style="margin-top:-0.5%;margin-left:2%;font-family:arial;display:flex;font-size:14px;color:white!important;">
	&copy <?php echo date('Y')-1; ?>- <?php echo date('Y'); ?> Sistema de Gestão Arquivos, Inc Desenvolvido pela <a href="https://jf-tech.org/" target="_blank" style="color:white;text-decoration:none;">  <img src="./vfm-admin/images/fLogo.png" style="height:20px;width:20px;margin-top:-5%;"  /></a>
	</h5>
</footer>

<?php
if ($privacy) {
    echo $privacy;
}
