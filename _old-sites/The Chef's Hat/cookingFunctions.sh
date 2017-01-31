function convertYSR {
	cat "$1" | pl > ystemp.xml
	# optionally remove leading white space
	## cat $1 | pl | sed 's/^ *//' > ystemp.xml
}

function parseXML0 {
	# strip quotes
	cat $1 | grep $2 | sed 's/.*"\(.*\)"[^"]*$/\1/' > $3
}
function parseXML1 {
	# split at =, strip quotes, delete last character (;), remove first character (space)
	cat $1 | grep $2 | cut -d'=' -f 2 | sed 's/"//g' | sed 's/;//' | sed 's/.\(.*\)/\1/' >> $3
}
function parseXML1b {
	# split at =, strip quotes, delete last character (;), remove first character (space)
	# revision: grep only beginning of line (otherwise trouble e.g. "name")
	cat $1 | grep "^[ ]*$2" | cut -d'=' -f 2 | sed 's/"//g' | sed 's/;//' | sed 's/.\(.*\)/\1/' >> $3
}
function parseXML2 {
	# return text within quotes, replace text "\n" with newline
	cat $1 | grep $2 | sed 's/.*"\(.*\)"[^"]*$/\1/' | sed 's_\\n_\
_g' > $3
}
function parseXML2b {
	# remove HTML formatting, return text within quotes, replace "\n" with newline
	cat $1 | grep $2 | sed -e 's#<[^>]*>##g' | sed 's/.*"\(.*\)"[^"]*$/\1/' | sed 's_\\n_\
_g' > $3
}
function parseXML3 {
	# get the ingredients array, convert "\n" with newline, delete first/last lines (which only contain parentheses), return text of line #, return text b/w quotes of \"....\", remove last character (\)

# each ingredient takes 9 lines
# description -- the only entry we use -- is the 4th of each

# determine number of array elements, z, by dividing number of lines, x, by lines per ingredient, y
x=$(cat $1 | grep $2 | sed 's_\\n_\
_g' | sed '1d' | sed '$d' | wc -l)
y=9
z=$(($x / $y))

# bash 4.0 code
#for i in {4..$x..$y}
#  do
#     cat $1 | grep $2 | sed 's_\\n_\
#	_g' | sed '1d' | sed '$d' | sed -n ${i}p | sed 's/.*"\(.*\)"[^"]*$/\1/' | sed 's/\(.*\)./\1/'
# done

# improved bash loop
typeset -i i END
let END=$z i=0
while ((i<END)); do

	tempLineNum=$((9 * $i + 4))
	
	cat $1 | grep $2 | sed 's_\\n_\
	_g' | sed '1d' | sed '$d' | sed -n ${tempLineNum}p | sed 's/.*"\(.*\)"[^"]*$/\1/' | sed 's/\(.*\)./\1/' >> $3
	
    let i++
done

}
function parseXML3b {
	# updated for YummySoup 2.3.1 Exports
	# each ingredient has 7 lines, e.g.
	#	{
	#	        measurement = tsp;
	#	        method = \"salt to taste (~2-3)\";
	#	        name = salt;
	#	        quantity = 2;
	#	        randomNumber = 736;
	#	    }
		
	
	# get the ingredients array, convert "\n" with newline, delete first/last lines (which only contain parentheses), return text of line #, return text b/w quotes of \"....\", remove last character (\)

# each ingredient takes 7 lines
# description (i.e. "name") is the only entry we use -- is the 4th of each

# determine number of array elements, z
# update, version 2.3.1: based on number of "name" elements now, since empty
# columns are not exported in YSR file anymore

# take ingredientsArray, replace newlines, truncate beg. and end. brackets
cat $1 | grep $2 | sed 's_\\n_\
_g' | sed '1d' | sed '$d' > ysingrtemp.xml

INGRXML="ysingrtemp.xml"

# truncate leading whitespace so that z is a "proper" #
z=$(cat $INGRXML | grep "name" | wc -l | sed 's/^ *//')
echo "z is $z"

# bash 4.0 code
#for i in {4..$x..$y}
#  do
#     cat $1 | grep $2 | sed 's_\\n_\
#	_g' | sed '1d' | sed '$d' | sed -n ${i}p | sed 's/.*"\(.*\)"[^"]*$/\1/' | sed 's/\(.*\)./\1/'
# done


# improved bash 3.0 loop
typeset -i i END
let END=$z i=1
echo "i starts as $i"
while ((i<=END)); do
echo "i in loop is $i"
	# grep all "name" entries, get the nth line (can't use awk b/c this version doesn't support passing variables with awk -v), cut at the = sign, remove \" from beg and end (happens if ingredient is not a single word), remove ; at the end, remove leading whitespace
	cat $INGRXML | grep "name" | head -$i | tail -1 | cut -d'=' -f 2 | sed 's/\\"//g' | sed 's/;//g' | sed 's/^ *//' >> $3
	
		# take ingredientsArray, replace newlines, truncate leading brackets, return line number, strip quotes, [do something else]
	#	cat $1 | grep $2 | sed 's_\\n_\
	#	_g' | sed '1d' | sed '$d' | sed -n ${tempLineNum}p | sed 's/.*"\(.*\)"[^"]*$/\1/' | sed 's/\(.*\)./\1/' >> $3
	
    let i++
done


}