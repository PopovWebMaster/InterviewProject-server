del C:\OSPanel\domains\en-v6\public\assets\admin\css\*.* /q
del C:\OSPanel\domains\en-v6\public\assets\admin\fonts\*.* /q
del C:\OSPanel\domains\en-v6\public\assets\admin\img\*.* /q
del C:\OSPanel\domains\en-v6\public\assets\admin\js\*.* /q
xcopy C:\OSPanel\domains\en_v6_admin\dist\assets\css C:\OSPanel\domains\en-v6\public\assets\admin\css /f /i /y /s
xcopy C:\OSPanel\domains\en_v6_admin\dist\assets\fonts C:\OSPanel\domains\en-v6\public\assets\admin\fonts /f /i /y /s
xcopy C:\OSPanel\domains\en_v6_admin\dist\assets\img C:\OSPanel\domains\en-v6\public\assets\admin\img /f /i /y /s
xcopy C:\OSPanel\domains\en_v6_admin\dist\assets\js C:\OSPanel\domains\en-v6\public\assets\admin\js /f /i /y /s

del C:\OSPanel\domains\en-v6\public\assets\css\*.* /q
del C:\OSPanel\domains\en-v6\public\assets\fonts\*.* /q
del C:\OSPanel\domains\en-v6\public\assets\img\*.* /q
del C:\OSPanel\domains\en-v6\public\assets\js\*.* /q
xcopy C:\OSPanel\domains\en-v6-client\dist\assets\css C:\OSPanel\domains\en-v6\public\assets\css /f /i /y /s
xcopy C:\OSPanel\domains\en-v6-client\dist\assets\fonts C:\OSPanel\domains\en-v6\public\assets\fonts /f /i /y /s
xcopy C:\OSPanel\domains\en-v6-client\dist\assets\img C:\OSPanel\domains\en-v6\public\assets\img /f /i /y /s
xcopy C:\OSPanel\domains\en-v6-client\dist\assets\js C:\OSPanel\domains\en-v6\public\assets\js /f /i /y /s

