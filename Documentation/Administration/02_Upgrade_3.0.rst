.. include:: ../Includes.txt

.. _administration_upgrade_3.0:

========================
Upgrade to version 3.0.0
========================

This version is intended to be used together with bootstrap 5. To ease transition a static template supporting
bootstrap 4 is available. To use it add `Container elements DEPRECATED - Bootstrap 4` to `Include static (from
extensions)` from the template record.

To ease upgrading css classes for the bootstrap 5 a wizard step is available.

Breaking changes
================

Use buttons in accordion and tabs (6e4247d7)
--------------------------------------------

Description
~~~~~~~~~~~

The rendering has been adapted to be compatible with
bootstrap package (ext:bootstrap_package) 12 and
bootstrap 5. As a result the components have a different
look.

Corrective action
~~~~~~~~~~~~~~~~~

Adapt the fluid template in the site package or add the
static template `Container elements DEPRECATED -
Bootstrap 4` to the template record.

