<?php
namespace Tev\Tev\Hook;

/**
 * Used to modify the default RealURL autoconfig, and generate fixed post vars
 * for pages from the CMS config fields.
 */
class RealUrlAutoConfigurationHook
{
    /**
     * Overrides some of the built in options that RealURL autogenerates.
     *
     * @param  array     $params
     * @param  \stdClass $reference
     * @return array
     */
    public function updateConfig($params, $reference)
    {
        $config = $params['config'];

        // init

        $config['init']['emptyUrlReturnValue'] = '/';
        $config['init']['postVarSet_failureMode'] = 'ignore';
        $config['init']['enableCHashCache'] = true;

        // fileName

        $config['fileName']['acceptHTMLsuffix'] = 0;
        $config['fileName']['index'] = [
            '.pdf' => [
                'keyValues' => [
                    'extension' => 'pdf'
                ]
            ]
        ];

        // Generate fixedPostVars

        if (!isset($config['fixedPostVars']) || !is_array($config['fixedPostVars'])) {
            $config['fixedPostVars'] = [];
        }

        $pages = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
            'uid,pid,tx_tev_realurl_extbase_extension,tx_tev_realurl_extbase_plugin,tx_tev_realurl_extbase_inc_controller,tx_tev_realurl_extbase_inc_action,tx_tev_realurl_extbase_args',
            'pages',
            'deleted = 0'
        );

        foreach ($pages as $p) {
            if ($p['tx_tev_realurl_extbase_extension'] && $p['tx_tev_realurl_extbase_plugin']) {
                $c = [];

                if ($p['tx_tev_realurl_extbase_inc_controller']) {
                    $c[] = $this->addGetVar($p, 'controller');
                }

                if ($p['tx_tev_realurl_extbase_inc_action']) {
                    $c[] = $this->addGetVar($p, 'action');
                }

                foreach (explode(',', $p['tx_tev_realurl_extbase_args']) as $arg) {
                    if (strlen($arg)) {
                        $c[] = $this->addGetVar($p, $arg);
                    }
                }

                if (!$p['tx_tev_realurl_extbase_inc_controller']) {
                    $c[] = $this->addGetVar($p, 'controller', true);
                }

                if (!$p['tx_tev_realurl_extbase_inc_action']) {
                    $c[] = $this->addGetVar($p, 'action', true);
                }

                $config['fixedPostVars'][$p['uid']] = $c;
            }
        }

        return $config;
    }

    /**
     * Create GETvar config.
     *
     * @param  array   $page   Page fields
     * @param  string  $name   Var name
     * @param  boolean $bypass Whether or not to add bypass config to the var
     * @return array
     */
    private function addGetVar($page, $name, $bypass = false)
    {
        $prefix = $this->getArgPrefix($page);

        $conf = [
            'GETvar' => $prefix . "[{$name}]"
        ];

        if ($bypass) {
            $conf['noMatch'] = 'bypass';
        }

        return $conf;
    }

    /**
     * Get the GETvar arg prefix for the given page.
     *
     * @param  array  $page Page fields
     * @return string
     */
    private function getArgPrefix($page)
    {
        return
            'tx_' .
            strtolower(str_replace('_', '', $page['tx_tev_realurl_extbase_extension'])) . '_' .
            strtolower($page['tx_tev_realurl_extbase_plugin']);
    }
}
