#!/bin/sh
# This is very simple xgettext macro used to generate POT files
# it passes keywordspec implemented by php-gettext-context alongside
# user specified arguments to xgettext
xgettext --keyword="__" \
--keyword="__d:2" \
--keyword="__dc:2" \
--keyword="__p:1c,2" \
--keyword="__dp:2c,3" \
--keyword="__dcp:2c,3" \
--keyword="__n:1,2" \
--keyword="__dn:2,3" \
--keyword="__dcn:2,3" \
--keyword="__np:1c,2,3" \
--keyword="__dnp:2c,3,4" \
--keyword="__dcnp:2c,3,4" \
"$@"
