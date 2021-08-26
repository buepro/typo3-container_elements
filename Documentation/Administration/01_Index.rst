.. include:: ../Includes.txt


.. _administration:

==============
Administration
==============

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

Version 3.0.0
-------------

This version is intended to be used together with bootstrap 5. To ease transition a static template supporting
bootstrap 4 is available. To use it add `Container elements DEPRECATED - Bootstrap 4` to `Include static (from
extensions)` from the template record.
