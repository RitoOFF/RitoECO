<?php

namespace Rito\RitoECO\api;

use pocketmine\player\Player;
use pocketmine\utils\Config;
use Rito\RitoECO\Main;

class RitoEcoAPI{

    /**
     * @var Main $c
     * @var Config $data
     * @var float $basecoins
     * @var RitoEcoAPI $instance
     */
    private $c;
    public static $data;
    public static $instance;

    /**
     * CoinsAPI constructor.
     * @param Main $c
     * @param Config $data
     */
    public function __construct(Main $c, Config $data){
        $this->c = $c;
        RitoEcoAPI::$data = $data;
        self::$instance = $this;
    }
    /**
     * @param Player $player
     * @param float $amount
     */

    public function setMoney(Player $player, float $amount)  {
        RitoEcoAPI::$data->set($player->getName(), $amount);
        RitoEcoAPI::$data->save();
    }

    /**
     * @param Player $player
     * @return bool|mixed
     */
    public function getMoney(Player $player){
        return RitoEcoAPI::$data->get($player);
    }

    /**
     * @param Player $player
     * @return mixed
     */

    //La base des point
    public function setBaseMoney(Player $player){
        $this->setMoney($player, Main::getInstance()->getConfig()->get("base-money"));

        return true;
    }

    /**
     * @param Player $player
     * @return bool
     */

    public function hasMoney(Player $player) : bool{
        if(RitoEcoAPI::$data->exists($player->getName())){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param Player $player
     * @return mixed
     */

    public function myMoney(Player $player){
        return RitoEcoAPI::$data->get($player->getName());
    }

    /**
     * @param Player $player
     * @param float $amount
     */

    public function addMoney(Player $player, float $amount){
        RitoEcoAPI::$data->set($player->getName(), RitoEcoAPI::$data->get($player->getName()) + $amount);
        RitoEcoAPI::$data->save();
    }

    /**
     * @param Player $player
     * @param float $amount
     */
    public function reduceMoney(Player $player, float $amount){
        RitoEcoAPI::$data->set($player->getName(), RitoEcoAPI::$data->get($player->getName()) - $amount);
        RitoEcoAPI::$data->save();
    }

    /**
     * @return RitoEcoAPI
     */

    public static function getInstance(){
        return self::$instance;
    }
}