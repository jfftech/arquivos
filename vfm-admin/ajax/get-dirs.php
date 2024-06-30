<?php
/**
 * VFM - veno file manager: ajax/get-dirs.php
 * Send folders to datatables
 *
 * PHP version >= 5.3
 *
 * @category  PHP
 * @package   VenoFileManager
 * @author    Nicola Franchini <support@veno.it>
 * @copyright 2013-2022 Nicola Franchini
 * @license   Exclusively sold on CodeCanyon
 * @link      http://filemanager.veno.it/
 */
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
    || (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest')
) {
    exit;
}
@set_time_limit(0);
require_once dirname(dirname(__FILE__)).'/class/class.utils.php';
require_once dirname(dirname(__FILE__)).'/class/class.setup.php';
require_once dirname(dirname(__FILE__)).'/class/class.gatekeeper.php';
require_once dirname(dirname(__FILE__)).'/class/class.location.php';

$setUp = new SetUp();
$gateKeeper = new GateKeeper();

$response = array();
$totaldata = array();
$response['recordsTotal'] = 0;
$response['recordsFiltered'] = 0;

$request = $_GET;

$getdir = isset($request['dir_b64']) ? filter_var($request['dir_b64'], FILTER_SANITIZE_SPECIAL_CHARS) : false;
$locdir = $getdir ? '../../'.base64_decode($getdir) : false;

$location = new Location($locdir);
//nomes das pastas que sao intocaveis abaixo
$pathUnToucheble=[
    "SERVIÇOS DE APOIO INSTRUMENTAL",
    "SERVIÇOS DE APOIO TECNICO",
    "ORGÃOS DE DOUTRINA E ENSINO POLICIAL",
    "UNIDADE CENTRAIS",
    "Gabinete de Comandante Geral da PNA",
    "Gabinete do 2ºs Comandante Gerais",
    "Corpo de Conselheiros",
    "Inspecção da PNA",
    "Direcção de Segurança Pública e Operações",
    "Direcção de Educação Patriótica",
    "Direcção de Comunicação Institucional e Imprensa",
    "Direcção de trânsito e Segurança Rodoviária",
    "Direcção de Pessoal e Quadros",
    "Direcção de Finanças",
    "Direcção de Telecomunicações e Tecnologias de Informação",
    "Direcção de Logística",
    "Direcção de Transportes",
    "Direcção de Infra-Estruturas e Equipamentos",
    "Direcção de Serviços de Saúde",  
    "Direcção de Administração e Serviços",
    "Direcção de Intercâmbio e Cooperação",
    "Direcção de Assessoria Juridica",
    "Direcção de Estudo e Planeamento",
    "Direcção de Doutrina e Ensino Polcial",
    "Instituto Superior de Ciências Policias e Criminais",
    "Academia da Policia",
    "Centro de Formação e Adestramento de Cavalaria e Cinotecnia",
    "Escola Prática da Policia",
    "Colégio de Policia",
    "Policia de Intervenção Rápida",
    "Policia de Guarda Fronteiras",
    "Policia Fiscal Aduaneira",
    "Policia de Segurança Pessoal e de Entidades Protocolares",
    "Policia de Segurança de Objectivos Estratégicos",
    "Direcção de Investigação de Ílicitos Penais",
    "Unidade de Aviação",
    "Comando Provincial de Luanda",
    "Comando Provincial de Cabinda",
    "Comando Provincial do Zaire",
    "Comando Provincial do Uíge",
    "Comando Provincial do Bengo",
    "Comando Provincial do Cuanza Norte",
    "Comando Provincial de Malanje",
    "Comando Provincial da Lunda Norte",
    "Comando Provincial Cuanza Sul",
    "Comando Provincial da Lunda Sul",
    "Comando Provincial Benguela",
    "Comando Provincial do Huambo",
    "Comando Provincial Bié",
    "Comando Provincial do Moxico",
    "Comando Provincial da Huíla",
    "Comando Provincial do Namibe",
    "Comando Provincial do Cuando Cubango",
    "Comando Provincial do Cunene",
    "UNIDADE TERRITORAIS",
    "Direcção de Informações Policias",
    "ESTRUTURA ORGANICA",
    "PNA",
    " SERVIÇOS DE APOIO INSTRUMENTAL",

];

$palavrasChaves=[
    "Secção",
    "Especialista",
    "Departamento"
];

if ($gateKeeper->isAccessAllowed() && $gateKeeper->isAllowed('viewdirs_enable')) {
    $fullpath = $location->getFullPath();
    $searchvalue = filter_var($request['search']['value'], FILTER_SANITIZE_SPECIAL_CHARS);

    include_once dirname(dirname(__FILE__)).'/class/class.dir.php';
    include_once dirname(dirname(__FILE__)).'/class/class.dirs.php';

    $thedirs = new Dirs($location, $fullpath, '../../');
    $getdirs = $thedirs->dirs;

    if (!is_array($getdirs)) {
        $getdirs = array();
    }

    $response ['recordsTotal'] = count($getdirs);
    $response["draw"] = isset($request['draw']) ? intval($request['draw']) : 0;

    $length = isset($request['length']) ? intval($request['length']) : 10;
    $start = isset($request['start']) ? intval($request['start']) : 0;
    $sortby = isset($request['order'][0]['column']) ? intval($request['order'][0]['column']) : 1;
    $orderdir = isset($request['order'][0]['dir']) ? $request['order'][0]['dir'] : 'desc';
    $search = strlen($searchvalue) > 1 ? $searchvalue : false;
    // Search item
    if ($search) {
        $search = Utils::unaccent($search);
        foreach ($getdirs as $key => $getdir) {
            $unaccent = Utils::unaccent(Utils::normalizeName($getdir->getNameHtml()));
            if (stripos($unaccent, $search) === false) {
                unset($getdirs[$key]);
            }
        }
    } 
    // Sort by date
    if ($sortby == 2) {
        usort(
            $getdirs, 
            function ($a, $b) {
                return $a->getModTime() - $b->getModTime();
            }
        );
    }

    // Sort by name
    if ($sortby == 1) {
        usort(
            $getdirs, 
            function ($a, $b) {
                return strnatcasecmp($a->getNameHtml(), $b->getNameHtml());
            }
        );
    }
    // Reverse sorting
    if ($orderdir == 'desc') {
        $getdirs = array_reverse($getdirs);
    }

    $alt = $setUp->getConfig('salt');
    $altone = $setUp->getConfig('session_name');

    $response ['recordsFiltered'] = count($getdirs);

    $counter = 0;
    $totcounter = 0;

    foreach ($getdirs as $key => $dir) {
        $totcounter++;
        // Start output at start paging
        if ($totcounter > $start) {
            $counter++;
            // Exit if reach length
            if ($length !== -1 && $counter > $length) {
                break;
            }

            $data = array();

            $dirname = $dir->getName();
            $normalized = Utils::normalizeName($dirname);
            $dirpath = $fullpath.$dirname;
            $dirtime = $setUp->formatModTime($dir->getModTime());
            $locationDir = urlencode($location->getDir(false, false, false, 0));
            $del = $locationDir.$dir->getNameEncoded();
            $delquery = base64_encode($del);
            $cash = md5($delquery.$alt.$altone);
            $thislink = $location->makeLink(false, null, $del);
            $thisdel = $location->makeLink(false, $del, $locationDir);
            $thisdir = urldecode($locationDir);
            $dash = md5($alt.base64_encode($thisdir.$normalized).$altone);

            if ($setUp->getConfig("show_folder_counter") === true) {
                $quanti = $dir->countContents('../../'.$location->getDir(false, false, false, 0).$dirname);
                $quantifiles = $quanti['files'];
                $quantedir = $quanti['folders'];
                $data['counter'] = '<a href="'.$thislink.'"><span class="badge rounded-pill bg-light"><i class="bi bi-folder"></i> '.$quantedir.'</span>
                <span class="badge rounded-pill bg-light"><i class="bi bi-files"></i> '.$quantifiles.'</span></a>';
            } else {
                $data['counter'] = '';
            }

            $data['folder_name'] = '<div class="relative">
            <a class="w-100" href="'.$thislink.'"><span class="icon text-center"><i class="bi bi-folder-fill"></i> '.$normalized.'</span></a>
            <span class="hover end-0"><i class="bi bi-folder-symlink"></i></span></div>';

            $data['last_change'] = $dirtime;

            // Mobile dropdown.
            if ($setUp->getConfig('download_dir_enable')
                || $gateKeeper->isAllowed('rename_dir_enable')
                || $gateKeeper->isAllowed('delete_dir_enable')
            ) {
                $data['mini_menu'] = '<div class="dropdown"><a class="round-btn btn-mini dropdown-toggle" data-bs-toggle="dropdown" href="#"><i class="bi bi-gear-wide-connected"></i></a><ul class="dropdown-menu dropdown-menu-right">';
                
                if ($setUp->getConfig("download_dir_enable") === true && $gateKeeper->isAllowed('download_enable')) {
                    $data['mini_menu'] .= '<li>
                    <a class="zipdir dropdown-item" data-zip="'.base64_encode($thisdir.$normalized).'" data-dash="'.$dash.'" data-thisname="'.$normalized.'" href="javascript:void(0)">
                    <i class="bi bi-cloud-arrow-down"></i> '.$setUp->getString("download").'</a></li>';
                }
                if ($gateKeeper->isAllowed('rename_dir_enable')) {
                    $data['mini_menu'] .= '<li>
                    <a class="rename dropdown-item" data-thisdir="'.$thisdir.'" data-oldname="'.base64_encode($dirname).'" data-thisname="'.$normalized.'" href="javascript:void(0)" >
                    <i class="bi bi-pencil-square"></i> '.$setUp->getString("rename").'</a></li>';
                }
                if ($gateKeeper->isAllowed('delete_dir_enable')) {
                    $data['mini_menu'] .= '<li><a class="del dropdown-item" data-link="'.$thisdel.'&h='.$cash.'&fa='.$delquery.'" data-name="'.$normalized.'" href="javascript:void(0)">
                    <i class="bi bi-trash"></i> '.$setUp->getString("delete").'</a></li>';
                }
                $data['mini_menu'] .= '</ul></div></td>';
            } // END mobile dropdown.
            if(array_search($normalized,$pathUnToucheble) 
            || $normalized == "SERVIÇOS DE APOIO INSTRUMENTAL" || strpos($normalized, 'Sec') === 0  || strpos($normalized, 'Depart') === 0 || strpos($normalized, 'Espe') === 0 || strpos($normalized, 'Centro') === 0 || strpos($normalized, 'Director') === 0 
             || strpos($normalized, 'Gabinete') === 0 
              || strpos($normalized, 'Motoris') === 0 
              ||  strpos($normalized, 'Chefe') === 0
               || strpos($normalized, 'Assistent') === 0 
               || strpos($normalized, 'Oficial') === 0 
               || strpos($normalized, 'Ordenação') === 0 
               ){
                            if ($setUp->getConfig("download_dir_enable") && $gateKeeper->isAllowed('download_enable')) {
                                $data['download_dir'] = '<button class="round-btn d-none btn-mini zipdir" data-zip="'.base64_encode($thisdir.$normalized).'" data-dash="'.$dash.'" data-thisname="'.$normalized.'">
                                 <i class="bi bi-cloud-download"></i></button>';
                            }
                            if ($gateKeeper->isAllowed('rename_dir_enable')) {
                                $data['rename_dir'] = '
                                <button class="round-btn btn-mini d-none rename" data-thisdir="'.$thisdir.'" data-oldname="'.base64_encode($dirname).'" data-thisname="'.$normalized.'">
                                <i class="bi bi-pencil-square"></i></button>';
                            }
                            if ($gateKeeper->isAllowed('delete_dir_enable')) {
                                $data['delete_dir'] = '<button class="round-btn d-none btn-mini del" data-name="'.$normalized.'" data-link="'.$thisdel.'&h='.$cash.'&fa='.$delquery.'">
                                <i class="bi bi-x-lg"></i></button>';
                            }}else{
                                if ($setUp->getConfig("download_dir_enable") && $gateKeeper->isAllowed('download_enable')) {
                                    $data['download_dir'] = '<button class="round-btn btn-mini zipdir" data-zip="'.base64_encode($thisdir.$normalized).'" data-dash="'.$dash.'" data-thisname="'.$normalized.'">
                                     <i class="bi bi-cloud-download"></i></button>';
                                }
                                if ($gateKeeper->isAllowed('rename_dir_enable')) {
                                    $data['rename_dir'] = '
                                    <button class="round-btn btn-mini rename" data-thisdir="'.$thisdir.'" data-oldname="'.base64_encode($dirname).'" data-thisname="'.$normalized.'">
                                    <i class="bi bi-pencil-square"></i></button>';
                                }
                                if ($gateKeeper->isAllowed('delete_dir_enable')) {
                                    $data['delete_dir'] = '<button class="round-btn btn-mini del" data-name="'.$normalized.'" data-link="'.$thisdel.'&h='.$cash.'&fa='.$delquery.'">
                                    <i class="bi bi-x-lg"></i></button>';
                                } 
                            }
                            array_push($totaldata, $data);
                        } // end service menu
                    } // END foreach dir 
                } // end allowed
                function startWith($vector,$key) {
                    $result = array();
                    foreach ($vector as $name) {
                        if (str_starts_with($name, $key) === 0) {
                            $result= true;
                        } else {
                            $result = false;
                        }
                    }
                    return $result;
                }

$response['data'] = $totaldata;

echo json_encode($response);
exit;
