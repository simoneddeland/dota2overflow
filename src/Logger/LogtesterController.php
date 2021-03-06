<?php
namespace Anax\Logger;

/**
 * Logger controller
 *
 */
class LogtesterController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;


    /**
    * Initialize the controller.
    *
    * @return void
    */
    public function initialize()
    {
        $this->logger->timestamp("LogTesterController", "initialize");
        $this->calculator = new \Anax\Logger\CLogTesterCalculator();
        $this->calculator->setDI($this->di);
    }

    public function indexAction()
    {
        $this->logger->timestamp("LogTesterController", "indexAction", "Innan title");
        $this->theme->setTitle("Testing logger class");
        $this->calculator->calculateBigSum();
        $this->logger->timestamp("LogTesterController", "indexAction", "Efter title");
        $this->views->addString($this->logger->timeStampAsTable());
        $this->views->addString("<br>Most time consuming: " . $this->logger->mostTimeConsumingDomain());
        $this->views->addString("<br>Number of timestamps: " . $this->logger->numberOfTimestamps());
    }
}
