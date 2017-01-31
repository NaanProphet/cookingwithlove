#!/bin/bash

# import functions
. convertYSR.sh
. cookingFunctions.sh
. stripTags.sh


# get vars YSRNAME, TYPENAME, NEWNAME
#. runIntroNoPrompt.sh
. runIntroPrompt.sh

# convert YSR to XML
# creates ystemp.xml, ystemp2.xml
convertYSR "$YSRNAME"

# strip html tags (necessary for newer recipe files)
# note: also deletes image1, image2, etc. info
# $1 = filename to be parsed
# $2 = output filename
stripTags ystemp.xml ystemp3.xml

# create directory for plaintext files
mkdir "$TYPENAME-$NEWNAME"


# Filenames
XML="ystemp.xml"

INTRO=$"$TYPENAME-$NEWNAME"/$"$TYPENAME-$NEWNAME"-intro.txt

	# Title
	parseXML1b $XML "name" $INTRO

	# Subtitle/Description
	parseXML1 $XML "recipeDescription" $INTRO
	
	# Newline
	echo "" >> $INTRO

	# From
	echo "From:" >> $INTRO
	parseXML1 $XML "attribution" $INTRO

	# Difficulty (single digit number)
	echo "Difficulty:" >> $INTRO	
	parseXML1 $XML "difficult" $INTRO

	# Cooking Time
	echo "Cooking Time:" >> $INTRO
	parseXML1 $XML "cookingTime" $INTRO

	# Inactive Prep Time
	echo "Inactive Prep Time:" >> $INTRO
	parseXML1 $XML "inactivePrepTime" $INTRO

	# Note for legacy: newline appended to end already by virtue of >>
	
DIRECTIONS=$"$TYPENAME-$NEWNAME"/$"$TYPENAME-$NEWNAME"-directions.txt

	parseXML2b $XML "directions" $DIRECTIONS
	

INGREDIENTS=$"$TYPENAME-$NEWNAME"/$"$TYPENAME-$NEWNAME"-ingredients.txt

	parseXML3b $XML "ingredients" $INGREDIENTS
