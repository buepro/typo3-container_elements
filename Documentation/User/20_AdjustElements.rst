.. include:: /Includes.rst.txt

.. _user_adjust_elements:

=========================
Adjust container elements
=========================

Information regarding special features from some container elements is given below.

.. _user_adjust_container:

Container
=========

A handy element to wrap content with a `div`-tag. Optionally an additional section wrap can be added.

A container element can be combined with card elements to define the cards layout (see `layout from bootstrap's card
component <https://getbootstrap.com/docs/4.4/components/card/#card-layout>`__). Some layouts can be selected by the
container classes value picker.

.. figure:: ../Images/User/ContainerForm.jpg
   :alt: Properties from container element

   Properties from container element

.. _user_adjust_tileUnit:

Tile unit
=========

Tile units are used to create a tile view typically showing images. Tile units aren't yet supported by the bootstrap
framework hence might not show up correctly. For the tile units to work correctly content elements might be adapted to
render with the desired tile side ratio. These content elements might be provided by an extension (e.g. the
`extension pizpalue <https://extensions.typo3.org/extension/pizpalue/>`__ provides various tile layouts for this
purpose).

Tile units might be listed or combined together. In this case it can be convenient to collect them in a container. As
well the `Frame` might need to be set to `none` in the `Appearance` tab.

.. figure:: ../Images/Introduction/TileUnit.jpg
   :width: 500px
   :alt: Tile unit

   Tile unit showing tiles

.. tip::

   A tile unit is basically a column with specific settings. You might use as well columns container elements
   (e.g. 3 Columns) and set the related parameters manually.

.. _user_adjust_card:

Card
====

The card container element can render most card layouts as outlined on the `bootstrap framework page
<https://getbootstrap.com/docs/4.4/components/card/>`__.

.. _user_card_content:

Defining content
----------------

Texts and an image can be defined through the content element's form and/or by adding any kind of content element
to the available grid containers `Content (optional)` and `Image content (optional)`.

.. figure:: ../Images/User/CardFormText.jpg
   :width: 500px
   :alt: Text tab from card

   Text and image content defined in the card form

-----------------------------------------------------------------------------------------------------------------------

.. figure:: ../Images/User/CardGrid.jpg
   :width: 500px
   :alt: Card grid in backend

   Any kind of content element to be used as image and body content

.. _user_card_container:

Using container
---------------

Cards might be grouped with container elements.

.. figure:: ../Images/User/CardsInContainer.jpg
   :width: 500px
   :alt: Cards in container

   Two cards in a container

.. _user_adjust_slider:

Slider
======

The slider container element uses the `Swiper js library <https://swiperjs.com/>`__.
The behaviour from each slider can be configured within the content element using
json:

.. code-block:: yaml

   {
       "slidesPerView": 4,
       "spaceBetween": "20px",
       "slidesPerGroup": 1,
       "loop": 0,
       "disableOnInteraction": "true",
       "autoplay": "auto",
       "breakpoints": {
           "10": {
               "slidesPerView": 1
           },
           "576": {
               "slidesPerView": 1
           },
           "768": {
               "slidesPerView": 2
           },
           "1200": {
               "slidesPerView": 3
           },
           "1400": {
               "slidesPerView": 4
           }
       }
   }
