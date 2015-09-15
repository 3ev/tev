<?php
namespace Tev\Tev\Log;

use TYPO3\CMS\Core\Log\LogLevel;
use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Core\Mail\MailMessage;

/**
 * Simple logger for logging mail messages.
 */
class MailLogger
{
    /**
     * Logger instance.
     *
     * @var \TYPO3\CMS\Core\Log\Logger
     */
    protected $logger;

    /**
     * @param  \TYPO3\CMS\Core\Log\LogManager $logManager
     * @return void
     */
    public function injectLogManager(LogManager $logManager)
    {
        $this->logger = $logManager->getLogger('tevmail');
    }

    /**
     * Log a mail message.
     *
     * @param  \TYPO3\CMS\Core\Mail\MailMessage $mail   Mail message
     * @param  boolean                          $result Whether or not the messag was sent successfully
     * @return void
     */
    public function logMessage(MailMessage $mail, $result = true)
    {
        $this->logger->log(
            $result ? LogLevel::INFO : LogLevel::ERROR,
            $result ? 'Email sent' : 'Email failed to send',
            [
                'from' => $mail->getFrom(),
                'to' => $mail->getTo(),
                'subject' => $mail->getSubject(),
                'body' => $mail->getBody()
            ]
        );
    }
}
