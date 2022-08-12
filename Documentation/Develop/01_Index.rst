.. include:: /Includes.rst.txt


.. _develop:

===========
Development
===========

Work with site
==============

Installation
------------

#. Clone the repository

   .. code-block:: bash

      git clone https://github.com/buepro/typo3-container_elements.git && cd typo3-container_elements

#. Create site

   .. code-block:: bash

      composer ddev:install

Development
-----------

Use the ddev container during development. Like this the system environment
is being respected. E.g.:

.. code-block:: bash

   ddev composer update

Uninstallation
--------------

To remove the development site use:

.. code-block:: bash

   composer ddev:uninstall


Create tests
============

Create test db
--------------

.. rst-class:: bignums

#. Clean up db structure

#. Clear the field `uc` from `be_users`

#. Export tables `be_users, pages, sys_template, tt_content` in CSV-format

#. Format CSV-Files

   -  Add table name on top of column definitions
   -  Prefix all rows except the table name row with a coma
   -  Replace `""` by `'`


Add needed extensions
---------------------

It might be needed to add the following extensions:

.. code-block:: php

   protected $coreExtensionsToLoad = [
      'impexp',
      'seo',
      'felogin',
   ];

.. code-block:: php

   protected $testExtensionsToLoad = [
      'typo3conf/ext/vhs',
      'typo3conf/ext/container',
      'typo3conf/ext/container_elements',
      'typo3conf/ext/bootstrap_package',
      'typo3conf/ext/pizpalue',
   ];
