# NsFormApi
NsFormApi is a modified version of the FormAPI library by jojoe77777.

This version includes support for two new elements introduced in Minecraft 1.21.70:

Header (CustomForm only)

Divider (CustomForm only)

**Installation**
Place the NsFormApi plugin in your server's plugins folder.

**New Features**
➔ **addHeader(string $text, string $label = null)**
Adds a header to a CustomForm.

➔ **addDivider()**
Adds a visual divider to separate form sections.

## Example Usage
```php
private function mainForm(Player $player): void {
    $form = new SimpleForm(function (Player $player, mixed $value): void {
        if (is_null($value)) return;
        switch ($value) {
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
    $form->addButton("Show Custom Form", "button_1", SimpleForm::IMAGE_TYPE_PATH, "textures/items/diamond", function (Player $player): void {
        $this->customForm($player);
    });
    $form->addSimpleButton("Button 2"); // Label = 1
    $form->addSimpleButton("Button 3"); // Label = 2
    $form->addSimpleButton("Button 4", "button_4"); // Label = "button_4"
    $form->sendToPlayer($player);
}

private function customForm(Player $player): void {
    $form = new CustomForm(function (Player $player, mixed $value): void {
        if (is_null($value)) return;
        $input = $value['input_label'];
    });

    $form->setTitle("Form Title");
    $form->addHeader("Custom Header !", "header_label");
    $form->addLabel("Label 1");
    $form->addDivider();
    $form->addInput("Input Example", "input", "", "input_label");
    $form->addDivider();
    $form->sendToPlayer($player);
}
```

# Credits
Original **FormAPI** by **jojoe77777**.

Modified and updated by Vaizeur for Minecraft 1.21.70 compatibility.
