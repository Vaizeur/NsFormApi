<?php

/**
 * The NsFormApi library is based on the 'FormAPI' library developed by jojo77777. Here is the GitHub link to the original library:
 * @link https://github.com/jojoe77777/FormAPI"
 */
namespace Vaizeur\NsFormApi;

use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\SingletonTrait;
use Vaizeur\NsFormApi\Example\NsFormExampleCommand;

class NsFormApi extends PluginBase {

    use SingletonTrait;

    protected function onEnable(): void {
        self::setInstance($this);
        Server::getInstance()->getCommandMap()->register("form",new NsFormExampleCommand("form"));
    }
}