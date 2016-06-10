<?php
namespace TransphpormMessages;
class Messages implements \Transphporm\TSSFunction {
    private $headers;

    public function __construct(&$headers) {
        $this->headers = &$headers;
    }

    public function run(array $args, \DomElement $element) {
        $messages = $_SESSION['messages'];
        if (empty($this->headers)) unset($_SESSION['messages']);
        return $messages;
    }
}
