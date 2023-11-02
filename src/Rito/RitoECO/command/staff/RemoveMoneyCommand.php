<?php

namespace Rito\RitoECO\command\staff;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\Server;
use Rito\RitoECO\api\RitoEcoAPI;
use Rito\RitoECO\Main;
use Rito\RitoECO\Utils;

class RemoveMoneyCommand extends Command{
    public function __construct()
    {
        parent::__construct("removemoney", "Permet de Remove de la money !", "/removemoney", ["reducemoney", "removebalance"]);
        $this->setPermission("ritoeco.perm-removemoney");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender instanceof Player){
            Utils::checkPerm($sender, "ritoeco.perm-removemoney");
            if (isset($args[0])){
                if (isset($args[1])) {
                    $money = (int)$args[1];
                    $target = Server::getInstance()->getPlayerByPrefix($args[0]);
                    if ($target instanceof Player) {
                        RitoEcoAPI::getInstance()->reduceMoney($target, $money);
                        $sender->sendMessage(str_replace(["{money}", "{target}"], [$money, $target->getName()], Main::getInstance()->getConfig()->get("message.cmd-removemoney.send")));
                        $target->sendMessage(str_replace(["{money}", "{staff}"], [$money, $target->getName()], Main::getInstance()->getConfig()->get("message.cmd-removemoney.result")));
                    }else{
                        $sender->sendMessage("§f§c Le joueur na pas été sur le serveur ou n'est pas en ligne.");
                    }
                }
            } else {
                $sender->sendMessage("§f§c Usage: /reducemoney (joueur) (montant)");
            }
        } else {
            $sender->sendMessage("§f§c Usage: /reducemoney (joueur) (montant)");
        }
    }
}