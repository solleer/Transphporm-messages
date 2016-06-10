<?php
use Transphporm\Builder;
use TransphpormMessages\Module;
class TransphpormNl2brTest extends PHPUnit_Framework_TestCase {
    private function strip_tabs($str) {
        return trim(str_replace(["\t", "\n", "\r"], '', $str));
    }

    private function getBuilder($xml, $tss) {
        $transphporm = new Builder($xml, $tss);
        $transphporm->loadModule(new Module);
        return $transphporm;
    }

    public function testBasic() {
        $xml = "
        <html><div>Test</div></html>
        ";

        $tss = "
        html { message: 'Message1'; }
        div { repeat: messages(); content: iteration(message); }
        ";

        $transphporm = $this->getBuilder($xml, $tss);

        $this->assertEquals($this->strip_tabs('<html><div>Message1</div></html>'), $this->strip_tabs($transphporm->output()->body));
    }

    public function testMultipleMessages() {
        $xml = "
        <html><div>Test</div></html>
        ";

        $tss = "
        html:message[1] { message: 'Message1'; }
        html:message[2] { message: 'Message2'; }
        div { repeat: messages(); content: iteration(message); }
        ";

        $transphporm = $this->getBuilder($xml, $tss);

        $this->assertEquals($this->strip_tabs('<html><div>Message1</div><div>Message2</div></html>'), $this->strip_tabs($transphporm->output()->body));
    }

    public function testMessageType() {
        $xml = "
        <html><div>Test</div></html>
        ";

        $tss = "
        html:message[1] { message: 'Message1', 'info'; }
        html:message[2] { message: 'Message2', 'error'; }
        div { repeat: messages(); content: iteration(message); }
        div:attr(class) { content: iteration(type); }
        ";

        $transphporm = $this->getBuilder($xml, $tss);

        $this->assertEquals($this->strip_tabs('<html><div class="info">Message1</div><div class="error">Message2</div></html>'), $this->strip_tabs($transphporm->output()->body));
    }

    public function testMessageTypeDefault() {
        $xml = "
        <html><div>Test</div></html>
        ";

        $tss = "
        html:message[1] { message: 'Message1'; }
        html:message[2] { message: 'Message2'; }
        div { repeat: messages(); content: iteration(message); }
        div:attr(class) { content: iteration(type); }
        ";

        $transphporm = $this->getBuilder($xml, $tss);

        $this->assertEquals($this->strip_tabs('<html><div class="success">Message1</div><div class="success">Message2</div></html>'), $this->strip_tabs($transphporm->output()->body));
    }

    public function testMessageWithoutHeaders() {
        $xml = "
        <html><div>Test</div></html>
        ";

        $tss = "
        html { message: 'Message1'; }
        div { repeat: messages(); content: iteration(message); }
        ";

        $transphporm = $this->getBuilder($xml, $tss);

        $transphporm->output()->body; // This should clear the messages since no headers are set

        $tss = "div { repeat: messages(); content: iteration(message); }";

        $transphporm = $this->getBuilder($xml, $tss);

        $this->assertEquals($this->strip_tabs('<html></html>'), $this->strip_tabs($transphporm->output()->body));
    }

    public function testMessageWithHeaders() {
        $xml = "
        <html><div>Test</div></html>
        ";

        $tss = "
        html:header[location] { content: 'test'; }
        html { message: 'Message1'; }
        div { repeat: messages(); content: iteration(message); }
        ";

        $transphporm = $this->getBuilder($xml, $tss);

        $transphporm->output()->body; // This should clear the messages since no headers are set

        $tss = "div { repeat: messages(); content: iteration(message); }";

        $transphporm = $this->getBuilder($xml, $tss);

        $this->assertEquals($this->strip_tabs('<html><div>Message1</div></html>'), $this->strip_tabs($transphporm->output()->body));
    }
}
