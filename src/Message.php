<?php
namespace TransphpormMessages;
class Message implements \Transphporm\Property {
    public function run(array $values, \DomElement $element, array $rules, \Transphporm\Hook\PseudoMatcher $pseudoMatcher, array $properties = []) {
        if (is_array($values[0]) foreach ($values[0] as $message) $this->addMessage($message, $this->getType($values));
        else $this->addMessage($values[0], $this->getType($values));
    }
    
    private function addMessage($message, $type) {
        $_SESSION['messages'][] = ["message" => $message, "type" => $type];
    }

    private function getType($values) {
        return isset($values[1]) ? $values[1] : "success";
    }
}
