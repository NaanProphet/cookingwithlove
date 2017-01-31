function stripTags {
	# remove common html tags
	# from http://www.eng.cam.ac.uk/help/tpl/unix/sed.html
	
	# first get rid of tags
	# then get rid of \U00a0 (the NBSP for html)
	# replace \U2019 with '
	# then replace all \n with newlines
	# then replace \" with " (used e.g. in ingredients array)
	
	
	cat "$1" | sed -e :a -e 's/<[^>]*>//g;/</N;//ba' | sed 's/\\\U00a0//g' | sed "s/\\\U2019/'/g" | sed 's_\\n_\
_g' | sed 's_\\"_"_g' > $2
}