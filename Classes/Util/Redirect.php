<?php
namespace Tev\Tev\Util;

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Simple utility class to create database redirects.
 */
class Redirect
{
    /**
     * Create a RealURL redirect in the database.
     *
     * @param string $source      Source URL. No domain or protocol, just path
     * @param string $destination Destination URL. Protocol & domain allowed, or just path
     * @param int    $domain      Sys domain record UID
     */
    public static function createRedirect($source, $destination, $domain = 0)
    {
        global $TYPO3_DB;

        // Remove leading slash
        if ($source[0] === '/') {
            $source = substr($source, 1);
        }

        $row = $TYPO3_DB->exec_SELECTgetRows(
            'uid, COUNT(*) AS count',
            'tx_realurl_redirects',
            'url = ' . $TYPO3_DB->fullQuoteStr($source, 'tx_realurl_redirects') .
                ' AND domain_limit = ' . (int) $domain);

        $data = array(
            'url_hash'     => GeneralUtility::md5int($source),
            'url'          => $source,
            'destination'  => $destination,
            'has_moved'    => 1,
            'domain_limit' => (int) $domain,
            'tstamp'       => time()
        );

        if ($row[0]['count'] > 0) {
            $TYPO3_DB->exec_UPDATEquery(
                'tx_realurl_redirects',
                'uid = ' . (int) $row[0]['uid'],
                $data);
        } else {
            $TYPO3_DB->exec_INSERTquery('tx_realurl_redirects', $data);
        }
    }
}
