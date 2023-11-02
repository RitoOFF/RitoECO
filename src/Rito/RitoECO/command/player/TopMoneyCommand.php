<?php

namespace Rito\RitoECO\command\player;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use Rito\RitoECO\api\RitoEcoAPI;
use Rito\RitoECO\Main;
use Rito\RitoECO\Utils;

class TopMoneyCommand extends Command{
    public function __construct()
    {
        parent::__construct("topmoney", "Voire le top money", "/topmoney", ["topbalance"]);
        $this->setPermission("ritoeco.perm-topmoney");
    }
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender instanceof Player){
            Utils::checkPerm($sender, "ritoeco.perm-topmoney");
            $txt = "";
            $array = [];
            foreach(RitoEcoAPI::$data->getAll() as $name => $tops){
                $array[mb_strtolower($name)] = $tops;
            }
            arsort($array);
            $array = array_slice($array, 0, 10);
            $top = 1;
            foreach($array as $name => $money){
                $txt .= str_replace(["{top}", "{player}", "{money}"], [$top, $name, $money], Main::getInstance()->getConfig()->get("message.cmd-topmoney2"));
                $top++;
            }
            $sender->sendMessage(Main::getInstance()->getConfig()->get("message.cmd-topmoney1").$txt);
        }
    }
}

