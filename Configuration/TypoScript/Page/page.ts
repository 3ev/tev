###################################################
# Page
###################################################

# Notice:
# page object is instantiated from EXT:fluidpages/Configuration/TypoScript/setup.txt

page {
    bodyTag = <body>
    shortcutIcon = favicon.ico
}

# Remove wrappers
tt_content.stdWrap.innerWrap >
lib.parseFunc_RTE.nonTypoTagStdWrap.encapsLines.addAttributes.P.class >
lib.stdheader.stdWrap.dataWrap >
lib.stdheader.3.headerClass >
