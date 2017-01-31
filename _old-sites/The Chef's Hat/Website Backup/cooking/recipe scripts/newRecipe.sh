#!/bin/bash

echo -n "Enter type of new recipe with no spaces (e.g. koora): "
read -e TYPENAME
echo -n "Enter name of new recipe with no spaces: "
read -e NEWNAME

mkdir "$TYPENAME-$NEWNAME"
touch "$"$TYPENAME-$NEWNAME"/$"$TYPENAME-$NEWNAME"-directions.txt"
#touch "$"$TYPENAME-$NEWNAME"/$"$TYPENAME-$NEWNAME"-extro.txt"
touch "$"$TYPENAME-$NEWNAME"/$"$TYPENAME-$NEWNAME"-ingredients.txt"
touch "$"$TYPENAME-$NEWNAME"/$"$TYPENAME-$NEWNAME"-intro.txt"
#touch "$"$TYPENAME-$NEWNAME"/$"$TYPENAME-$NEWNAME"-ps.txt"
touch "$"$TYPENAME-$NEWNAME"/$"$TYPENAME-$NEWNAME".jpg"

echo "TITLE HERE
PITHY SUBTITLE HERE

From:
Mom
Difficulty:
Easy
Prep Time:
None
Inactive Prep Time:
(Optional)
Rating:
✓✓✓✓✓
Cooking Time:
25 mins" > $"$TYPENAME-$NEWNAME"/$"$TYPENAME-$NEWNAME"-intro.txt

echo "Ingredient 1 (english translation?)
Ingredient 2 (english translation?)
and so on..." > $"$TYPENAME-$NEWNAME"/$"$TYPENAME-$NEWNAME"-ingredients.txt

echo "Direction 1
Direction 2
...
Closing Remark (optional)" > $"$TYPENAME-$NEWNAME"/$"$TYPENAME-$NEWNAME"-directions.txt