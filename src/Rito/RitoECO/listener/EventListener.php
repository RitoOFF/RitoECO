<?php

namespace Rito\RitoECO\listener;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use Rito\RitoECO\api\RitoEcoAPI;

class EventListener implements Listener{
    public function onJoin(PlayerJoinEvent $event){
        if (!$event->getPlayer()->hasPlayedBefore()){
            RitoEcoAPI::getInstance()->setBaseMoney($event->getPlayer());
        }
    }
}