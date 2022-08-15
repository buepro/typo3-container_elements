.. include:: /Includes.rst.txt

.. _administration_upgrade_4.0:

========================
Upgrade to version 4.0.0
========================

Breaking changes
================

Add name space prefix to content element templates (d5e328e9)
-------------------------------------------------------------

Description
~~~~~~~~~~~

Content elements share rendering definitions from
`lib.contentElement`. Extensions might take advantage from
settings defined by container_elements by referencing the
lib object
(e.g.`lib.containerContentElement =< lib.contentElement`).
As a result the template and partial root paths contain
definitions from various extensions. To prevent conflicts
templates and partials from container_elements content
elements have been prefixed with 'Ce'.

Corrective action
~~~~~~~~~~~~~~~~~

Templates or partials overriding container_elements content
element rendering need to be adapted. In most cases the
template and/or partial name has to be prefixed with `Ce`.

Drop pizpalue support (c9391184)
--------------------------------

Description
~~~~~~~~~~~

In effort to improve separation of concerns
pizpalue related adjustments have been moved
to the extension pizpalue. As a result column
flex forms as well as the partial CeColumns
have changed.

Corrective action
~~~~~~~~~~~~~~~~~

Sites not using pizpalue but making use of
pizpalue related settings need to add their
own column flex forms and CeColumns partial.
