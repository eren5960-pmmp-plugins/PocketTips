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

namespace Eren5960\PocketTips\provider;

use Eren5960\PocketTips\Main;
use pocketmine\Player;
use pocketmine\utils\Config;

class MangoProvider extends Provider{
    /** @var Config */
    private $config;
    /** @var int */
    private $type;
    /** @var Main */
    private $main;

    /**
     * @param Main $main
     * @param int $type
     */
    public function __construct(Main $main, int $type){
        $this->main = $main;
        $this->type = $type;
    }

    public function init(): void{
        $extension = Provider::$formats[$this->type];
        $this->config = new Config($this->main->getDataFolder() . "db_" . $extension . "." . $extension, $this->type);
    }

    /**
     * @param Player $player
     * @return int
     */
    public function getPlayerTipCount(Player $player): int{
        return (int) $this->config->get($player->getName(), 0);
    }

    /**
     * @param Player $player
     * @param int $count
     */
    public function setPlayerTipCount(Player $player, int $count): void{
        $this->config->set($player->getName(), $count);
        $this->config->save();
    }

    /**
     * @param Player $player
     */
    public function initPlayerTips(Player $player): void{
        if(!$this->config->exists($player->getName())){
            $this->setPlayerTipCount($player, 0);
        }
    }

    /**
     * @param Player $player
     * @return bool
     */
    public function canHandleTips(Player $player): bool{
        return $this->getPlayerTipCount($player) !== -1;
    }

    /**
     * @param Player $player
     */
    public function sendNextTip(Player $player): void{
        if($this->getPlayerTipCount($player) === $this->main->getTipsCount()) return;

        $this->main->sendForm($player, $this->getPlayerTipCount($player));
        $this->setPlayerTipCount($player, $this->getPlayerTipCount($player) + 1);
    }
}