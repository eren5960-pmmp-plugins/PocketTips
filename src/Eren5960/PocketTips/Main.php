<?php
/**
 *  _____                    ____   ___    __     ___  
 * | ____| _ __  ___  _ __  | ___| / _ \  / /_   / _ \ 
 * |  _|  | '__|/ _ \| '_ \ |___ \| (_) || '_ \ | | | |
 * | |___ | |  |  __/| | | | ___) |\__, || (_) || |_| |
 * |_____||_|   \___||_| |_||____/   /_/  \___/  \___/ 
 * 
 * @author Eren5960
 * @link https://github.com/Eren5960
 */
declare(strict_types=1);

namespace Eren5960\PocketTips;

use Eren5960\PocketTips\form\TipsForm;
use Eren5960\PocketTips\provider\Provider;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener{
    /** @var Provider */
    private $provider;

    public function onLoad(){
        $this->saveDefaultConfig();
    }

    public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->provider = Provider::getProvider($this, (int) $this->getConfig()->get("provider-type", -1));
        $this->provider->init();
    }

    /**
     * @return Provider
     */
    public function getProvider(): Provider{
        return $this->provider;
    }

    /**
     * @return int
     */
    public function getTipsCount(): int{
        return count($this->getConfig()->get("tips", []));
    }

    /**
     * @param PlayerJoinEvent $playerJoinEvent
     */
    public function onPlayerJoin(PlayerJoinEvent $playerJoinEvent){
        $player = $playerJoinEvent->getPlayer();
        $this->getProvider()->initPlayerTips($player);

        if($this->getProvider()->canHandleTips($player)){
            $this->getProvider()->sendNextTip($player);
        }
    }

    /**
     * @param Player $player
     * @param int $tip
     */
    public function sendForm(Player $player, int $tip): void{
    	$player->sendForm(new TipsForm($this, $player, $tip));
    }
}