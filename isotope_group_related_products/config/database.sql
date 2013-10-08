-- **********************************************************
-- *                                                        *
-- * IMPORTANT NOTE                                         *
-- *                                                        *
-- * Do not import this file manually but use the Contao    *
-- * install tool to create and maintain database tables!   *
-- *                                                        *
-- **********************************************************


--
-- Table `tl_iso_groups`
--

CREATE TABLE `tl_iso_groups` (
  `category` int(10) unsigned NOT NULL default '0',
  `products` blob NULL,
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
