git pull;
git add . ;

echo "请输入代码的注释:"
read commit

 echo $commit;


 git commit -m $commit;

 git push;

 echo "代码提交成功!";

