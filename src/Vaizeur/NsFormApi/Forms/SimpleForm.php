<?php

declare(strict_types = 1);

namespace Vaizeur\NsFormApi\Forms;

use pocketmine\form\FormValidationException;
use pocketmine\player\Player;

class SimpleForm extends Form {

    const IMAGE_TYPE_PATH = 0;
    const IMAGE_TYPE_URL = 1;

    /** @var string */
    private string $content = "";

    private array $labelMap = [];


    /**
     * @param callable|null $callback
     */
    public function __construct(?callable $callback = null) {
        parent::__construct($callback);
        $this->data["type"] = "form";
        $this->data["title"] = "";
        $this->data["content"] = $this->content;
        $this->data["buttons"] = [];
    }

    public function handleResponse(Player $player, $data) : void {
        $this->processData($data);
        if($data !== null && isset($this->callBackMap[$data])) {
            ($this->callBackMap[$data])($player);
            return;
        }
        $callable = $this->getCallable();
        if($callable !== null) {
            $callable($player, $data);
        }
    }

    public function processData(&$data) : void {
        if($data !== null) {
            if(!is_int($data)) {
                throw new FormValidationException("Expected an integer response, got " . gettype($data));
            }
            $count = count($this->data["buttons"]);
            if($data >= $count || $data < 0) {
                throw new FormValidationException("Button $data does not exist");
            }
            $data = $this->labelMap[$data] ?? null;
        }
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title) : self {
        $this->data["title"] = $title;
        return $this;
    }

    /* @return string */
    public function getTitle() : string {
        return $this->data["title"];
    }

    /* @return string */
    public function getContent() : string {
        return $this->data["content"];
    }

    /**
     * @param string $content
     * @return $this
     */
    public function setContent(string $content) : self {
        $this->data["content"] = $content;
        return $this;
    }

    /**
     * @param string $text
     * @param string|null $label
     * @param int $imageType
     * @param string $imagePath
     * @return $this
     */
    public function addSimpleButton(string $text, ?string $label = null,int $imageType = -1, string $imagePath = "") : self {
        $content = ["text" => $text];
        if($imageType !== -1) {
            $content["image"]["type"] = $imageType === 0 ? "path" : "url";
            $content["image"]["data"] = $imagePath;
        }
        $this->data["buttons"][] = $content;
        $this->labelMap[] = $label ?? count($this->labelMap);
        return $this;
    }

    /**
     * @param string $text
     * @param string|null $label
     * @param callable|null $callbackButton
     * @param int $imageType
     * @param string $imagePath
     * @return $this
     */
    public function addButton(string $text, ?string $label = null,int $imageType = -1, string $imagePath = "",?callable $callbackButton = null) : self {
        $this->addSimpleButton($text,$label,$imageType,$imagePath);
        if(!is_null($callbackButton)) {
            $this->callBackMap[$label] = $callbackButton;
        }
        return $this;
    }

}
