<?php

/**
 * Used to modify the default RealURL autoconfig.
 */
class Tx_Tev_Url_AutoConfigurationGenerator
{
    /**
     * Overrides some of the built in options that RealURL autogenerates.
     * 
     * @param array  $params
     * @param object $reference
     * @return array
     */
    public function updateConfig($params, $reference)
    {
        $config = $params['config'];

        // init
        $config['init']['emptyUrlReturnValue']    = '/';
        $config['init']['postVarSet_failureMode'] = 'ignore';
        $config['init']['enableCHashCache']       = false;

        // fileName
        $config['fileName']['acceptHTMLsuffix']   = 0;

        return $config;
    }
}
