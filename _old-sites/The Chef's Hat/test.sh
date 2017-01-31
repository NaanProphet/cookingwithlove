#!/bin/bash

## assumes the following syntax:
## sh newRecipe.sh <recipe.ysr> <typeOfDish> <recipeName>

. convertYSR.sh

YSRNAME=$1
TYPENAME=$2
NEWNAME=$3

convertYSR "$YSRNAME"