<?php

namespace Rito\RitoECO\command\player;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\Server;
use Rito\RitoECO\api\RitoEcoAPI;
use Rito\RitoECO\Main;
use Rito\RitoECO\Utils;

class PayMoneyCommand extends Command{
    public function __construct()
    {
        parent::__construct("pay", "Permet de faire un virement a un joueur !", "/pay", ["paymoney", "paybalance"]);
        $this->setPermission("ritoeco.perm-paymoney");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender instanceof Player){
            Utils::checkPerm($sender, "ritoeco.perm-paymoney");
            if (isset($args[0])){
                if (isset($args[1])) {
                    $money = (int)$args[1];
                    $target = Server::getInstance()->getPlayerByPrefix($args[0]);
                    if ($target instanceof Player) {
                        if (RitoEcoAPI::getInstance()->myMoney($sender) >= $money){
                            RitoEcoAPI::getInstance()->reduceMoney($sender, $money);
                            RitoEcoAPI::getInstance()->addMoney($target, $money);
                            $sender->sendMessage(str_replace(["{money}", "{target}"], [$money, $target->getName()], Main::getInstance()->getConfig()->get("message.cmd-paymoney.send")));
                            $target->sendMessage(str_replace(["{money}", "{donnateur}"], [$money, $target->getName()], Main::getInstance()->getConfig()->get("message.cmd-paymoney.result")));
                        }else $sender->sendMessage(Main::getInstance()->getConfig()->get("message.cmd-paymoney.nomoney"));
                    }elseif($target === $sender) {
                        $sender->sendMessage("§f§c Vous ne pouvez vous payez vous même !");
                    }else
                        $sender->sendMessage("§f§c Le joueur n'est pas en ligne.");
                }
            } else {
                $sender->sendMessage("§f§c Usage: /pay (joueur) (montant)");
            }
        } else {
            $sender->sendMessage("§f§c Usage: /pay (joueur) (montant)");
        }
    }
}