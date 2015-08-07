#
# Table structure for table 'pages'.
#
# Includes additional RealURL Extbase fields.
#

CREATE TABLE pages (
    tx_tev_realurl_extbase_extension varchar(50) DEFAULT '' NOT NULL,
    tx_tev_realurl_extbase_plugin varchar(50) DEFAULT '' NOT NULL,
    tx_tev_realurl_extbase_inc_controller tinyint(4) unsigned DEFAULT '0' NOT NULL,
    tx_tev_realurl_extbase_inc_action tinyint(4) unsigned DEFAULT '0' NOT NULL,
    tx_tev_realurl_extbase_args text NOT NULL
);
