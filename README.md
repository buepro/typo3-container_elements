# TYPO3 container_elements

This [TYPO3](https://typo3.org/) extension provides elements to further structure the content area. It is powered
by the [extension container](https://extensions.typo3.org/extension/container/). Many thanks to
[b13 GmbH](https://b13.com/).

Currently the following elements are available: container, columns, registers, accordion, tile unit and card.

The extension is intended to be used together with the [bootstrap framework](https://getbootstrap.com/).

## Example contents

### Columns, tabs and accordion

The following image shows the usage from a two columns element containing a tabs element in the left column
and an accordion element in the right column. Three and four columns elements are available too.

![Two columns with a tabs and accordion element](Documentation/Images/Introduction/ColumnsTabsAccordion.jpg)

### Container and cards

The container element adds freedom in designing the layout. It might be used to group elements as well as to
enhance the functionality. In the below shown image the `Classes` field from the container element has
been set to `card-deck` and accommodates two card elements.

![Card deck container with two cards](Documentation/Images/Introduction/ContainerCards.jpg)

### Tile unit

The tile unit element can be used to create panels showing tiles.

Tiles are not yet supported by the bootstrap framework hence on bare installations won't show up as expected. To get
started using tile units the [extension pizpalue](https://extensions.typo3.org/extension/pizpalue) might be
checked out.

![Tile unit containing tile content elements](Documentation/Images/Introduction/TileUnit.jpg)

## Resources

- [Documentation from this extension](https://docs.typo3.org/p/buepro/typo3-container_elements/master/en-us/)
- [Extension at the TYPO3 extension repository](https://extensions.typo3.org/extension/container_elements/)
- [TYPO3 extension `pizpalue`](https://extensions.typo3.org/extension/pizpalue/) supports tile units.
- [Documentation from extension `container`](https://github.com/b13/container/blob/master/README.md)
