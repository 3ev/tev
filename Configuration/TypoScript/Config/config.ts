###################################################
# Config
###################################################

config {
    # Disable stdwrap comments
    disablePrefixComment = 1

    # Set UTF-8
    renderCharset = utf-8

    # Set UTF-8
    metaCharset = utf-8

    # HTML5
    doctype = html5

    # Remove XHTML stuff
    xmlprologue = none

    # Set HTML language from current system language
    htmlTag_setParams = lang="{$config.language}"

    # Enable RealURL
    tx_realurl_enable = 1

    # Caching
    sendCacheHeaders = 1

    # Remove header comment
    headerComment >

    # Disable image borders
    disableImgBorderAttr = 1

    # Remove default CSS
    removeDefaultCss = 1

    # Remove default JS
    removeDefaultJS = 1

    # Concat CSS automatically
    concatenateCss = 1

    # Concat JS automatically
    concatenateJs = 1

    # Enable TypoLink across domains
    typolinkCheckRootline = 1
    typolinkEnableLinksAcrossDomains = 1
}
