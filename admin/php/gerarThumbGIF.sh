video=$1
saida=$2
nomeTemp=$(cat /dev/urandom | tr -dc 'a-zA-Z0-9' | fold -w 32 | head -n 1)
nomeTemp="/var/www/tct/tmp/$nomeTemp"
extv=".mp4"
exts=".gif"
extp=".png"
echo $video
echo $saida
echo $nomeTemp

duracaoTotal=`/usr/bin/ffprobe $video -show_format 2>&1 | sed -n 's/duration=//p'`
pct=$(awk -v m=$duracaoTotal 'BEGIN { print (5/m)}')
echo $duracaoTotal
echo $pct
#/usr/bin/ffmpeg -y -i $video -an -filter:v "setpts=$pct*PTS" $nomeTemp$extv
#/usr/bin/ffmpeg -y -i $nomeTemp$extv -vf palettegen $nomeTemp$extp
#/usr/bin/ffmpeg -y -i $nomeTemp$extv -i $nomeTemp$extp -filter_complex paletteuse -r 10 -s 191x108 $nomeTemp$exts
#cp $nomeTemp$exts $saida
#rm $nomeTemp$extv
#rm $nomeTemp$extp
#rm $nomeTemp$exts