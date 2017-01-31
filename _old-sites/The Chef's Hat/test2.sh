#!/bin/bash
# ALL HTML FILES
FILES="Breakfast_Smoothie.ysr"
# for loop read each file
for f in $FILES
do
INF="$f"
OUTF="$f.out.tmp"
# replace javascript
sed '/&lt;/,/&gt;/d' $INF
/bin/cp $OUTF $INF
/bin/rm -f $OUTF
done