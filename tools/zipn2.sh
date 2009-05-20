#!/bin/sh

rm -f installn2.data n2.zip
chmod a-r tools installn2.php
zip -r installn2.data *
chmod a+r tools installn2.php
chmod 0666 installn2.php installn2.data install.php
zip -n .data n2 installn2.php installn2.data
chmod 0666 n2.zip
