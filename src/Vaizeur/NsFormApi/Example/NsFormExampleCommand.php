<?php

namespace Vaizeur\NsFormApi\Example;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\Translatable;
use pocketmine\permission\DefaultPermissions;
use pocketmine\player\Player;
use Vaizeur\NsFormApi\Forms\CustomForm;
use Vaizeur\NsFormApi\Forms\SimpleForm;

class NsFormExampleCommand extends Command {

    public function __construct(string $name, Translatable|string $description = "", Translatable|string|null $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
        $this->setPermission(DefaultPermissions::ROOT_USER);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): void {
        if($sender instanceof Player) {
            $this->mainForm($sender);
        }
    }

    private function mainForm(Player $player): void {
        $form = new SimpleForm(function (Player $player,mixed $value):void{
            if(is_null($value)) return;
            switch ($value){
                case 1:
                    $player->sendMessage("Button 2 !");
                    break;
                case 2:
                    $player->sendMessage("Button 3 !");
                    break;
                case "button_4":
                    $player->sendMessage("Button 4 !");
                    break;
            }
        });
        $form->setTitle("Simple Title");
        $form->addButton("Show Custom Form","button_1",SimpleForm::IMAGE_TYPE_PATH,"textures/items/diamond",function (Player $player):void{
            $this->customForm($player);
        });
        $form->addSimpleButton("Button 2"); //Label = 1
        $form->addSimpleButton("Button 3"); //Label = 2
        $form->addSimpleButton("Button 4","button_4"); //Label = "button_4"
        $form->sendToPlayer($player);

    }

    private function customForm(Player $player): void {
        $form = new CustomForm(function (Player $player,mixed $value):void{
            if(is_null($value)) return;
            $input = $value['input_label'];
        });
        $form->setTitle("Form Title");
        $form->addHeader("Custom Header !","header_label");
        $form->addLabel("Label 1");
        $form->addDivider();
        $form->addInput("Input Example","input","","input_label");
        $form->addDivider();
        $form->sendToPlayer($player);
    }
}