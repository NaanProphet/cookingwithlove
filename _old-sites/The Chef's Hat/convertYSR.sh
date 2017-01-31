function convertYSR {	
	
	# basic conversion
	cat "$1" | pl > ystemp.xml
	
	# remove leading white space from all rows
	# (makes it easier to parse data)
	sed 's/^ *//' ystemp.xml > ystemp2.xml
}