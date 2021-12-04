.. include:: ../Includes.txt


.. _administration:

==============
Administration
==============

Requirements
============

============= ====================
Component     Version
============= ====================
php           >= 7.3
TYPO3         10.4.x, 11.5.x
container     >= 1.3.1
============= ====================

Installation
============

In case the extension `pizpalue` is used a static template is loaded automatically to enhance image rendering.
In case more control over embedding the template is needed, the automatic loading can be disabled in the settings
module and the static `Container elements - Pizpalue` included manually.

.. warning::
   Using this extension together with other extensions providing structure elements (e.g. gridelements or flux) might
   cause problems.

.. warning::
   When using this extension together with gridelements ensure to install this extension after gridelements.

Upgrade
=======

The following upgrade descriptions are available:

.. toctree::
   :maxdepth: 2

   02_Upgrade_3.0
