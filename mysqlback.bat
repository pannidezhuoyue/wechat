@echo off
::设定删除几天前的备份文件
set DaysAgo=15
::设定mysqldump执行程式
set mysqldump_exe="C:\OrivonServer\MySQL\bin\mysqldump.exe"
::设定winrar执行程式
set winrar_exe="C:\Program Files\WinRAR\WinRAR.exe"
::设定备份的目录
set na_dir=e:\back_db\
::取现在的时间，格式：20150401
set now_date=%date:~0,4%%date:~5,2%%date:~8,2%
::备份数据库名字
set now_file=ots-%now_date%.sql
::备份数据库
echo mysqldump...
%mysqldump_exe% -uroot -padmin ots > %na_dir%%now_file%
::压缩备份数据库
echo winrar...
%winrar_exe% a -df %na_dir%%now_file%.zip %na_dir%%now_file%
::得到前DaysAgo天的日期
>tmp.vbs echo wscript.echo dateadd("d",-%DaysAgo%,date())
for /f "tokens=1-3 delims=-/" %%a in ('cscript //nologo tmp.vbs') do set /a y=%%a,m=100%%b,d=100%%c
del tmp.vbs
set DaysAgo_date=%y%%m:~-2%%d:~-2%
echo %DaysAgo_date%
::pause
SETLOCAL ENABLEDELAYEDEXPANSION
::循环备份目录里的*.sql文件，取出日期，比较删除指定删除日期以前的*.sql备份文件
for /r %na_dir% %%i in (*.sql) do (
	set j=%%i
	set ad_file=!j:~-16,16!
	set ad_date=!ad_file:~4,8!
	echo %%i
	if !ad_date! LEQ %DaysAgo_date% (del %%i) else echo NoDel
	ping /n 1 127.0>nul
)
::循环备份目录里的*.zip文件，取出日期，比较删除指定删除日期以前的*.zip备份文件
for /r %na_dir% %%t in (*.zip) do (
	set q=%%t
	set add_file=!q:~-20,20!
	set add_date=!add_file:~4,8!
	echo %%t
	if !add_date! LEQ %DaysAgo_date% (del %%t) else echo NoDel
	ping /n 1 127.0>nul
)
ENDLOCAL
::pause