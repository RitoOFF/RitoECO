<?php

namespace Rito\RitoECO;

use pocketmine\player\Player;

class Utils{
    public static function checkPerm(Player $player, string $perm){
        if (!$player->hasPermission($perm)){
            $player->sendMessage(Main::getInstance()->getConfig()->get("message.no-perm"));
            return  true;
        }
    }
}