<?php

namespace Rito\RitoECO\command\player;

use onebone\economyapi\EconomyAPI;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\Translatable;
use pocketmine\player\Player;
use Rito\RitoECO\api\RitoEcoAPI;
use Rito\RitoECO\Main;
use Rito\RitoECO\Utils;

class MyMoneyCommand extends Command{
    public function __construct()
    {
        parent::__construct("money", "Voire votre money", "/money", ["mymoney", "balance"]);
        $this->setPermission("ritoeco.perm-mymoney");
    }
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender instanceof Player){
            Utils::checkPerm($sender, "ritoeco.perm-mymoney");
            $sender->sendMessage(str_replace(["{money}"], [RitoEcoAPI::getInstance()->myMoney($sender)], Main::getInstance()->getConfig()->get("message.cmd-mymoney")));
        }
    }
}

