<?php
namespace TransphpormMessages;
class Module implements \Transphporm\Module {
    public function __construct() {

    }

    public function load(\Transphporm\Config $config) {
        if (!isset($_SESSION['messages'])) $_SESSION['messages'] = [];
        $headers = &$config->getHeaders();
		$functionSet = $config->getFunctionSet();

        $config->registerProperty('message', new Message);
        $functionSet->addFunction('messages', new Messages($headers));
    }
}
