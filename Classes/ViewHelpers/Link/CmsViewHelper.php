<?php
namespace Tev\Tev\ViewHelpers\Link;

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Link view helper to create links based on config from the 'link' wizard in
 * the CMS.
 */
class CmsViewHelper extends AbstractViewHelper
{
    /**
     * @see parent::initializeArguments()
     */
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('cmsOptions', 'string', 'Link options direct from the CMS link wizard field', true);
        $this->registerArgument('extraClass', 'string', 'Class');
        $this->registerArgument('title', 'string', 'Title to fallback to if not set in the CMS');
    }

    /**
     * Render the link tag.
     *
     * @return string The rendered tag
     */
    public function render()
    {
        $options = $this->parseLinkOptions();

        $html  = '<a ';
        $html .= 'href="'   . htmlentities($options['link'], ENT_COMPAT, 'UTF-8') . '" ';

        if ($options['target']) {
            $html .= 'target="' . htmlentities($options['target'], ENT_COMPAT, 'UTF-8') . '" ';
        }

        if ($options['cssClass']) {
            $html .= 'class="'  . htmlentities($options['cssClass'], ENT_COMPAT, 'UTF-8') . '" ';
        }

        if ($options['title']) {
            $html .= 'title="'  . htmlentities($options['title'], ENT_COMPAT, 'UTF-8') . '" ';
        }

        $html .= '>';
        $html .= $this->renderChildren();
        $html .= '</a>';

        return $html;
    }

    /**
     * Parse and return link options based on those set directly from the
     * helper and those set from the CMS wizard.
     *
     * @return array Parsed options (link, target, cssClass, title)
     */
    protected function parseLinkOptions()
    {
        $linkOptions = explode(' ', $this->arguments['cmsOptions']);

        if (($link = $this->parseCmsOption($linkOptions[0])) !== null) {
            if (is_numeric($link)) {
                $uriBuilder = $this->controllerContext->getUriBuilder();
                $formattedLink = $uriBuilder
                    ->setTargetPageUid($link)
                    ->setCreateAbsoluteUri(true)
                    ->build();
            } else {
                $parsedLink = parse_url($link);
                if (empty($parsedLink['scheme'])) {
                    $link = 'http://' . ltrim($link, '/');
                }
                $formattedLink = $link;
            }
        } else {
            $formattedLink = null;
        }

        return array(
            'link'     => $formattedLink,
            'target'   => $this->parseCmsOption($linkOptions[1]),
            'cssClass' =>
                $this->parseCmsOption($linkOptions[2]) .
                ($this->arguments['extraClass'] ? ' ' . $this->arguments['extraClass'] : ''),
            'title'    => $this->parseCmsOption($linkOptions[3]) ?: $this->arguments['title']
        );
    }

    /**
     * Parse an individual CMS link option.
     *
     * Will return the option value or the empty string if it's not set.
     *
     * @param string $option Link option
     * @return string Value or the empty string
     */
    private function parseCmsOption($option)
    {
        if (isset($option) && ($option !== '-')) {
            return $option;
        } else {
            return '';
        }
    }
}
