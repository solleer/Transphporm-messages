<?php
namespace TransphpormMessages;
class Message implements \Transphporm\Property {
    public function run(array $values, \DomElement $element, array $rules, \Transphporm\Hook\PseudoMatcher $pseudoMatcher, array $properties = []) {
        $_SESSION['messages'][] = ["message" => $values[0], "type" => $this->getType($values)];
    }

    private function getType($values) {
        return isset($values[1]) ? $values[1] : "success";
    }
}
