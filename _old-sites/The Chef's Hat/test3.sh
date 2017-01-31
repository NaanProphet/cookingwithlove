#!/bin/bash

# import functions
. convertYSR.sh
. cookingFunctions.sh
. stripTags.sh


# get vars YSRNAME, TYPENAME, NEWNAME
#. runIntroNoPrompt.sh
. runIntroPrompt.sh

# strip html tags (necessary for newer recipe files)
# $1 = filename to be parsed
# $2 = output filename
stripTags "$YSRNAME" ysrtemp.ysr