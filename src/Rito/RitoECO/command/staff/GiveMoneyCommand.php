<?php

namespace Rito\RitoECO\command\staff;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\Server;
use Rito\RitoECO\api\RitoEcoAPI;
use Rito\RitoECO\Main;
use Rito\RitoECO\Utils;

class GiveMoneyCommand extends Command{
    public function __construct()
    {
        parent::__construct("givemoney", "Permet de Give de la money !", "/givemoney", ["addmoney", "addbalance"]);
        $this->setPermission("ritoeco.perm-givemoney");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender instanceof Player){
            Utils::checkPerm($sender, "ritoeco.perm-givemoney");
            if (isset($args[0])){
                if (isset($args[1])) {
                    $money = (int)$args[1];
                    $target = Server::getInstance()->getPlayerByPrefix($args[0]);
                    if ($target instanceof Player) {
                        RitoEcoAPI::getInstance()->addMoney($target, $money);
                        $sender->sendMessage(str_replace(["{money}", "{target}"], [$money, $target->getName()], Main::getInstance()->getConfig()->get("message.cmd-addmoney.send")));
                        $target->sendMessage(str_replace(["{money}", "{staff}"], [$money, $target->getName()], Main::getInstance()->getConfig()->get("message.cmd-addmoney.result")));
                    }else{
                        $sender->sendMessage("§f§c Le joueur n'est pas en ligne.");
                    }
                }
            } else {
                $sender->sendMessage("§f§c Usage: /addmoney (joueur) (montant)");
            }
        } else {
            $sender->sendMessage("§f§c Usage: /addmoney (joueur) (montant)");
        }
    }
}