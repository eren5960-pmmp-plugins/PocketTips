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

namespace Eren5960\PocketTips\form;

use pocketmine\Player;

trait TipsTrait{

    /**
     * @param string $text
     * @param Player $player
     * @return string
     */
    public function replace(string $text, Player $player): string{
        $text = str_replace(["{player}", "&"], [$player->getName(), "§"], $text);
        return $text;
    }
}