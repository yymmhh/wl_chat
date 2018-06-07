echo "开始拉取代码"
git pull;
echo "拉取完成"



echo "开始添加代码";
git add . ;
echo "添加完成"


echo -e "\033[47;34m 请输入代码注释 \033[0m" ; 
read commit

 echo $commit;


 echo -e "\033[33m 正在提交注释 \033[0m" ;
 git commit -m $commit;

 echo -e "\033[33m 正在提交代码 \033[0m" ;
 git push;

echo -e "\033[32m 提交代码成功 \033[0m" ;

