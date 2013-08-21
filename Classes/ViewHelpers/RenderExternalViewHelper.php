<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2011 Christian Kuhn <lolli@schwarzbu.ch>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * http://pastebin.com/5NEAmqQs
 * 
 * Render a partial from another extension in own namespace.
 *
 * <fx:renderExternal
 *         partial="Device/ProductImage"
 *         extensionName="EnetOtherExtension"
 *         arguments="{
 *             product: entry.device.product,
 *             clearing: entry.device.clearing,
 *             maxWidth: 30,
 *             maxHeight: 30
 *         }"
 * />
 *
 * @author Christian Kuhn <lolli@schwarzbu.ch>
 */
class Tx_Tev_ViewHelpers_RenderExternalViewHelper extends Tx_Fluid_ViewHelpers_RenderViewHelper
{ 
    /**
     * @var Tx_Extbase_Object_ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * Injects the object manager
     *
     * @param Tx_Extbase_Object_ObjectManagerInterface $objectManager
     * @return void
     */
    public function injectObjectManager(Tx_Extbase_Object_ObjectManagerInterface $objectManager)
    {
            $this->objectManager = $objectManager;
    }

    /**
     * Renders the content.
     *
     * @param string $extensionName Render partial of this extension
     * @param string $partial The partial to render
     * @param array $arguments Arguments to pass to the partial
     * @return string
     */
    public function render($extensionName, $partial = NULL, array $arguments = array())
    {
        // Overload arguments with own extension local settings (to pass own settings to external partial)
        $arguments = $this->loadSettingsIntoArguments($arguments);

        /** @var $request Tx_Extbase_MVC_Request */
        $request = clone $this->controllerContext->getRequest();
        $request->setControllerExtensionName($extensionName);
        $controllerContext = clone $this->controllerContext;
        $controllerContext->setRequest($request);

        $this->setPartialRootPath($controllerContext);
        $content = $this->viewHelperVariableContainer->getView()->renderPartial($partial, NULL, $arguments);
        $this->resetPartialRootPath();

        return $content;
    }

    /**
     * Set partial root path by controller context
     *
     * @param Tx_Extbase_MVC_Controller_ControllerContext $controllerContext
     * @return void
     */
    protected function setPartialRootPath(Tx_Extbase_MVC_Controller_ControllerContext $controllerContext)
    {
        $this->viewHelperVariableContainer->getView()->setPartialRootPath(
            $this->getPartialRootPath($controllerContext)
        );
    }

    /**
     * Resets the partial root path to original controller context
     *
     * @return void
     */
    protected function resetPartialRootPath()
    {
        $this->setPartialRootPath($this->controllerContext);
    }

    /**
     * @param Tx_Extbase_MVC_Controller_ControllerContext $controllerContext
     * @return mixed
     */
    protected function getPartialRootPath(Tx_Extbase_MVC_Controller_ControllerContext $controllerContext)
    {
        $partialRootPath = str_replace(
            '@packageResourcesPath',
            t3lib_extMgm::extPath($controllerContext->getRequest()->getControllerExtensionKey()) . 'Resources/',
            '@packageResourcesPath/Private/Partials'
        );
        return $partialRootPath;
    }
}
