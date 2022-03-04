<?php

namespace App\Helpers;

use App\Models\AcessoModel;
use App\Models\ClientesModel;

class AnydeskConfig
{
    private $anydeskUserConfig = 
    [
        "ad.ui.lang" => "pt-br",
        "ad.ui.main_win.width" => "1936",
        "ad.ui.main_win.height" => "1048",
        "ad.ui.main_win.x" => "-8",
        "ad.ui.main_win.y" => "-8",
        "ad.roster.discovered.view_type" => "1",
        "ad.roster.favorites.view_type" => "2",
        "ad.roster.recent_out.view_type" => "1",
        "ad.roster.items" => "546192125,546192125,Big boss,;",
        "ad.ui.main_win.max" => "true",
        "ad.privacy.name.show" => "2",
        "ad.privacy.image.show" => "0",
        "ad.privacy.name" => "Suporte - Analista",
        "ad.privacy.bkgnd.show" => "0",
        "ad.anynet.connect_volatile_tokens" => "",
        "ad.anynet.auth_tokens" => "",
        "ad.session.touch_mode" => "",
        "ad.session.quality_preset" => "",
        "ad.audio.playback_device" => "{0.0.0.00000000}.{12303b06-2ef1-4cbd-b8a8-9e3a6709e3b2}",
        "ad.audio.transmit_mode" => "2",
        "ad.audio.playback_mode" => "1",
        "ad.audio.transmit_source" => "{0.0.0.00000000}.{12303b06-2ef1-4cbd-b8a8-9e3a6709e3b2}",
        "ad.session.lock_remote_account" => "",
        "ad.ui.address_menu_defaults" => "big:2",
        "ad.abook.view_type" => "2",
        "ad.session.local_browser_start_path" => "",
        "ad.session.remote_browser_start_path" => "",
        "ad.session.viewmode" => "",
        "ad.session.quality_adaptive" => "",
        "ad.session.show_remote_cursor" => "",
        "ad.session.follow_remote_cursor" => "",
        "ad.roster.discovered.show_all" => "true",
        "ad.roster.recent_out.show_all" => "true",
    ]; 

    function getUserConfig(){
        $acessos = (new AcessoModel("acesso"))->todosRegs();
        $clientes = new ClientesModel("clientes");
        $result = "";
        foreach ($this->anydeskUserConfig as $key => $value){
            if ($key !== "ad.roster.items"){
            echo $key . "=" . $value . "</br>";
            }else {
                foreach ($acessos as $acesso){
                    $cliente = $clientes->umReg($acesso->id_cliente);
                    $result = $result . $acesso->acesso . "," . $acesso->acesso . "," . $cliente->nome . "-" . $acesso->apelido . ",;";
                }
                echo $key . "=" . $result . "</br>";
               // echo $key . "=" .  . "</br>";
            }
        }
    }
}
