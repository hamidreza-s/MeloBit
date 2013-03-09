echo "Main directory path: (/path/to/your/directory/)"
read maindirectory
metafile=${maindirectory}metafile.txt
count=1
for directory in ${maindirectory}* 
do
	basename=$(basename "${directory}")
	printedcount=$(printf "%02d" ${count})
	olddirectory=${directory}
	newdirectory=${maindirectory}${printedcount}

	# rename it
	mv "${olddirectory}" "${newdirectory}"
	
	# creata array
	provinces[${count}]=${newdirectory}

	# deploy metafile
	echo ${printedcount}\;${basename} >> ${metafile}

	# increment counter
	((count++))
done

provincecount=1

for provincedir in ${provinces[@]} 
do
	
	rangecount=1

	for rangedir in ${provincedir}/*
	do
		mv ${rangedir} ${provincedir}/${rangecount}

		path=${provincedir}/${rangecount}/*.txt
		metafile=${provincedir}/${rangecount}/metafile.txt
		province=$(printf "%02d" ${provincecount})
		citycount=1

		for file in ${path} 
		do
			# rename file
			basename=$(basename "${file}")
			printedcount=$(printf "%03d" ${citycount})
			code=${rangecount}${province}${printedcount}
			newbasename=${code}.txt
			oldfile=${file}
			newfile=${file/"$basename"/"$newbasename"}
			mv "${oldfile}" "${newfile}"

			# sed it
			echo "${newfile}..."
			sed -i "s/\r/,${code}/g" ${newfile}

			# deploy metafile
			echo ${code}\;${basename} >> ${metafile}
			echo "Metafile updated..."

			# increment counter
			((citycount++))
		done

	((rangecount++))

	done

	((provincecount++))
done
echo "Done successfully!"

