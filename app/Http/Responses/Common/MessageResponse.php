<?php
namespace App\Http\Responses\Common;

use App\Enums\MessageType;

class MessageResponse
{
    public MessageType $messageType;

    public string $text;

    public function __construct($messageType, string $text)
    {
        $this->messageType = $messageType;
        $this->text = $text;
    }
}
