Additions
#########

Adds some disabled features originally from Sunlight CMS 7.5.x

.. contents::

Requirements
************

- PHP 7.1+
- SunLight CMS 8

Installation
************

Copy the folder ``plugin`` and its contents to the root directory or through system administration ``Administration > Plugins > Upload new plugins``

Features
********

HCM
===

filelist
^^^^^^^^
- Lists files in a defined directory, optionally with their sizes
- Warning: or security reasons, the path to the files must not be outside the ``upload`` folder!
- Definition: ``[hcm]fosc/filelist, string $path, bool $showFileSizes[/hcm]``
- Usage: ``[hcm]fosc/filelist,"upload",true[/hcm]``
