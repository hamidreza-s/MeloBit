echo "Directory path: (/path/to/your/files/)"
read directory
echo "File extension: (csv, txt, ...)"
read extension
echo "Province code: (0 - 32)"
read province
echo "Range code: (0, 1, 2)"
read range

path=${directory}*.${extension}
metafile=${directory}metafile.txt
count=1

echo "Loading ..."

for file in ${path}
do
	# first rename file
	basename=$(basename "${file}")
	printedcount=$(printf "%03d" ${count})
	code=${range}${province}${printedcount}
	newbasename=${code}.${extension} # _${basename}
	
	oldfile=${file}
	newfile=${file/"$basename"/"$newbasename"}

	mv "${oldfile}" "${newfile}"
	((count++))	#OR count=(expr $count + 1)

	# second sed it
	echo "${newfile}..."
	sed -i "s/\r/,${code}/g" ${newfile}

	# third deploy metafile
	echo ${code}\;${basename} >> ${metafile}
	echo "Metafile updated..."
done

echo "Done successfully!"
