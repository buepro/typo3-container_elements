.. include:: ../Includes.txt


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

   composer ddev:delete
