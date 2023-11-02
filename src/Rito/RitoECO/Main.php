<?php

namespace Rito\RitoECO;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\SingletonTrait;
use Rito\RitoECO\api\RitoEcoAPI;
use Rito\RitoECO\command\player\MyMoneyCommand;
use Rito\RitoECO\command\player\PayMoneyCommand;
use Rito\RitoECO\command\player\TopMoneyCommand;
use Rito\RitoECO\command\staff\GiveMoneyCommand;
use Rito\RitoECO\command\staff\RemoveMoneyCommand;
use Rito\RitoECO\listener\EventListener;

class Main extends PluginBase{
    public static Config $config;

    use SingletonTrait;

    protected function onLoad(): void {
        self::setInstance($this);
    }


    public function onEnable(): void
    {
        $this->getResource("config.yml");
        $this->saveDefaultConfig();
        $this->getLogger()->notice("Enable -> RitoECO Plugin BY RITO | disocrd: rito.off");
        new RitoEcoAPI($this, new Config(Main::getInstance()->getDataFolder() ."RitoECO.json", Config::JSON));
        $this->getServer()->getCommandMap()->registerAll("", [
            // PLAYER
            new MyMoneyCommand(),
            new PayMoneyCommand(),
            new TopMoneyCommand(),
            // STAFF
            new GiveMoneyCommand(),
            new RemoveMoneyCommand()
        ]);
        $this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);
    }
    public function onDisable(): void
    {
        $this->getLogger()->notice("Disable -> RitoECO Plugin BY RITO | disocrd: rito.off");
    }
}