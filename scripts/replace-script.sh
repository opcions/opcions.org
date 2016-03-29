#!/bin/bash
dir=$1 str=$2 rep=$3
while IFS= read -rd '' file; do
    sed  -i "s/$str/$rep/g" -- "$file"
    base=${file##*/} dir=${file%/*}
    [[ $base == *"$str"* ]] && mv "$file" "$dir/${base//$str/$rep}"
done < <(exec grep -ZFlR "$str" "$dir")
